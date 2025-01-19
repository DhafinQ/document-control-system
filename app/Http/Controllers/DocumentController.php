<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentRevision;
use App\Models\DocumentHistory;
use App\Models\Category;
use App\Models\User;
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
        if (Storage::disk('dokumen')->exists($filename)) {
            $filePath = Storage::disk('dokumen')->path($filename);
            
            $mimeType = mime_content_type($filePath);

            return Response::file($filePath, [
                'Content-Type' => $mimeType
            ]);
        }

        abort(404, 'File not found');
    }

    public function dashboard(){
        $totalDocs = Document::with('revisions')->count();
        $totalApprovedDocs = DocumentRevision::with('document')->where('status','=','Disetujui')->count();
        $totalDeniedDocs = DocumentRevision::with('document')->where('status','=','Ditolak')->count();
        $totalRevisedDocs = DocumentRevision::with('document')->where('status','=','Draft')->count();

        return view('admin.home',compact('totalDocs','totalApprovedDocs','totalDeniedDocs','totalRevisedDocs'));
    }

    public function index()
    {
        $documents = Document::with(['category', 'uploader', 'currentRevision'])->get();

        return view('admin.documents.index', compact('documents'));
    }

    public function indexActive()
    {
        $documents = Document::with(['category', 'uploader', 'currentRevision'])->where('is_active','=',true)->get();

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
            'code' => 'required|string|max:30',
            'category_id' => 'required|exists:categories,id',
            'file_path' => 'required|file|mimes:pdf,doc,docx,ppt,pptx|max:5120',
            'description' => 'required|string',
        ]);

        // $path = $request->file('file_path')->store('', 'dokumen');
        $file = $request->file('file_path');
        $fileName = uniqid() . '_' . $file->getClientOriginalName();
        Storage::disk('dokumen')->put($fileName, file_get_contents($file));

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

        // foreach ($validated['rev'] ?? [] as $rev) {
        //     $currentRevision = DocumentRevision::findOrFail($rev);

        //     DocumentRevision::create([
        //         'document_id' => $rev,
        //         'file_path' => $path,
        //         'revised_by' => $validated['uploaded_by'],
        //         'revision_number' => $currentRevision->revision_number + 1,
        //         'description' => $validated['description'],
        //     ]);
        // }

        $document->update(['current_revision_id' => $revision->id]);

        DocumentHistory::create([
            'document_id' => $document->id,
            'revision_id' => $revision->id,
            'action' => 'Created',
            'performed_by' => Auth::id(),
            'reason' => null,
        ]);

        // return redirect()->route('documents.index')->with('success', 'Document created successfully.');
        return redirect()->route('document_revision.index')->with('success', 'Document Created successfully.');

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
}
