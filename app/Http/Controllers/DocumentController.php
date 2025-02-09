<?php

namespace App\Http\Controllers;

use App\Events\NewCreatedDocument;
use App\Models\Document;
use App\Models\DocumentRevision;
use App\Models\DocumentHistory;
use App\Models\Category;
use App\Models\User;
use App\Notifications\DocumentApprovalNotification;
use App\Notifications\DocumentCreatedNotification;
use Illuminate\Http\Request;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function downloadDocument($filename)
    {
        /** @var FilesystemAdapter $filesystem */
        $filesystem = Storage::disk('dokumen');

        if (!$filesystem->exists($filename)) {
            abort(404, 'File tidak ditemukan.');
        }

        // Mengunduh file menggunakan Storage::download()
        return $filesystem->download($filename);
    }

    public function showFile($filename)
    {
        if (str_ends_with($filename, '(Signed).pdf')) {
            $filePath = Storage::disk('dokumen-approved')->path($filename);

            $mimeType = mime_content_type($filePath);

            return Response::file($filePath, [
                'Content-Type' => $mimeType
            ]);
        } else if (Storage::disk('dokumen-revision')->exists($filename)) {
            $filePath = Storage::disk('dokumen-revision')->path($filename);

            $mimeType = mime_content_type($filePath);

            return Response::file($filePath, [
                'Content-Type' => $mimeType
            ]);
        }

        return abort(404);
    }

    public function getDocByCategory(Request $request)
    {
        $query = $request->input('q');
        $id = $request->input('id');
        $oldIds = $request->input('ids');
        $documents = Document::where('is_active','=' ,true)
                            ->whereHas('currentRevision', function ($query) {
                                $query->whereIn('status', ['Disetujui','Proses Revisi']);
                            })
                            ->whereHas('uploader.roles', function ($query) {
                                $query->whereIn('id', auth()->user()->roles->pluck('id'));
                            })
                            ->where('title', 'like', '%' . $query . '%')
                            ->with(['category','currentRevision']);
        
        if($id){
            $documents = $documents->where('id', '!=', $id);
        }
        if($oldIds){
            $idsArray = explode(',', $oldIds);
            $documents = $documents->whereIn('id', $idsArray);
        }

        $documents = $documents->get();

        return response()->json($documents);
    }

    public function dashboard()
    {
        $totalDocs = Document::with('revisions')->count();
        $totalApprovedDocs = DocumentRevision::with('document')->where('status', '=', 'Disetujui')->count();
        $totalDeniedDocs = DocumentRevision::with('document')->where('status', '=', 'Ditolak')->count();
        $totalRevisedDocs = DocumentRevision::with('document')->where('status', '=', 'Draft')->count();

        return view('admin.home', compact('totalDocs', 'totalApprovedDocs', 'totalDeniedDocs', 'totalRevisedDocs'));
    }

    public function index()
    {
        $documents = Document::with(['category', 'uploader', 'currentRevision'])->get();

        return view('admin.documents.index', compact('documents'));
    }

    public function indexActive()
    {
        $documents = Document::whereHas('latestRevision', function ($query) {
            $query->whereNotIn('status', ['Draft', 'Pengajuan Revisi']);
        })->with(['category', 'uploader', 'latestRevision'])->get();

        return view('admin.active_document.index', compact('documents'));
    }

    public function create()
    {
        $categories = Category::pluck('name', 'id');
        return view('admin.documents.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'code' => 'required|string|unique:documents,code|max:30',
            'category_id' => 'required|exists:categories,id',
            'file_path' => 'required|file|mimes:pdf,doc,docx,ppt,pptx|max:5120',
            'description' => 'required|string',
        ]);

        $file = $request->file('file_path');
        $fileExtension = $file->getClientOriginalExtension();
        $fileName = str_replace(['/', '\\'], '-', $validated['code']) . '_' . preg_replace('/[\/\\\?\%\*\:\|\\"\<\>\.\(\)]/', '_', $validated['title']) . '.' . $fileExtension;
        Storage::disk('dokumen-revision')->put($fileName, file_get_contents($file));

        $document = Document::create([
            'title' => $validated['title'],
            'code' => $validated['code'],
            'category_id' => $validated['category_id'],
            'uploaded_by' => Auth::id(),
            'current_revision_id' => null,
        ]);

        $revision = DocumentRevision::create([
            'document_id' => $document->id,
            'file_path' => $fileName,
            'revised_by' => Auth::id(),
            'revision_number' => 1,
            'description' => $validated['description'],
        ]);

        foreach ($validated['rev'] ?? [] as $rev) {
            $currentRevision = DocumentRevision::findOrFail($rev);

            DocumentRevision::create([
                'document_id' => $rev,
                'file_path' => $fileName,
                'revised_by' => $validated['uploaded_by'],
                'revision_number' => $currentRevision->revision_number + 1,
                'description' => $validated['description'],
            ]);
        }

        $document->update(['current_revision_id' => $revision->id]);

        DocumentHistory::create([
            'document_id' => $document->id,
            'revision_id' => $revision->id,
            'action' => 'Created',
            'performed_by' => Auth::id(),
            'reason' => null,
        ]);

        event(new NewCreatedDocument($document, 'Dokumen ' . $document->title . ' telah dibuat oleh ' . $document->uploader->name . '.'));

        // return redirect()->route('documents.index')->with('success', 'Document created successfully.');
        return redirect()->route('document_revision.index')->with('success', 'Document Created successfully.');
    }

    public function show(Document $document)
    {
        if (in_array($document->latestRevision()->first()->status, ['Draft', 'Pengajuan Revisi'])) {
            abort(404);
        }
        return view('admin.documents.show', compact('document'));
    }

    public function edit(Document $document)
    {
        $categories = Category::pluck('name', 'id');
        $users = User::pluck('name', 'id');
        return view('documents.edit', compact('document', 'categories', 'users'));
    }

    public function update(Request $request, Document $document)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'uploaded_by' => 'required|exists:users,id',
            'file_path' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx',
            'description' => 'required|string',
            'reason' => 'required|string',
        ]);

        $path = $document->currentRevision->file_path;

        // Simpan file baru jika diunggah
        if ($request->hasFile('file_path')) {
            $path = $request->file('file_path')->store('', 'dokumen');
        }

        // Buat revisi baru
        $revision = DocumentRevision::create([
            'document_id' => $document->id,
            'file_path' => $path,
            'revised_by' => $validated['uploaded_by'],
            'revision_number' => $document->currentRevision ? $document->currentRevision->revision_number + 1 : 1,
            'description' => $validated['description'],
        ]);

        // Perbarui dokumen dengan revisi saat ini
        $document->update([
            'title' => $validated['title'],
            'category_id' => $validated['category_id'],
            'uploaded_by' => $validated['uploaded_by'],
            'current_revision_id' => $revision->id,
        ]);

        // Simpan ke riwayat dokumen
        DocumentHistory::create([
            'document_id' => $document->id,
            'revision_id' => $revision->id,
            'action' => 'Revised',
            'performed_by' => $validated['uploaded_by'],
            'reason' => $validated['reason'],
        ]);

        return redirect()->route('documents.index')->with('success', 'Document updated successfully.');
    }


    public function destroy(Document $document)
    {
        $document->delete();

        return redirect()->route('documents.index')->with('success', 'Document deleted successfully.');
    }

    //Approved Notify
    public function approveDocument(Request $request, $id)
    {
        $document = Document::findOrFail($id);
        $document->status = 'Approved';
        $document->save();

        // event(new DocumentApprovalNotification($document));

        return response()->json(['message' => 'Document approved successfully']);
    }

    //Approved Notify
    public function createdDocument(Request $request, $id)
    {
        $document = Document::findOrFail($id);
        $document->status = 'Created';
        $document->save();

        event(new DocumentCreatedNotification($document));

        return response()->json(['message' => 'Document created successfully']);
    }
}
