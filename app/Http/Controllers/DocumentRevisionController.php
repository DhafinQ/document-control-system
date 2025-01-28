<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Document;
use App\Models\DocumentRevision;
use App\Models\DocumentHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentRevisionController extends Controller
{

    public function index()
    {
        $revisions = DocumentRevision::with(['document', 'reviser'])->get();
        return view('admin.document-revisions.index', compact('revisions'));
    }

    public function indexApproval()
    {
        $revisionsQuery = DocumentRevision::where('status', 'Draft')->with(['document', 'reviser']);

        if (auth()->user()->isRole('Kepala-Puskesmas')) {
            $revisionsQuery->where('acc_content', true)->where('acc_format', true);
        } elseif (auth()->user()->isRole('Bagian-Mutu')) {
            $revisionsQuery->where('acc_content', false)->where('acc_format', true);
        } else {
            $revisionsQuery->where('acc_content', false)->where('acc_format', false);
        }

        $revisions = $revisionsQuery->get();

        $categories = Category::all();
        return view('admin.document_approve.index', compact('revisions','categories'));
    }

    public function getDoc(Request $req){
        $documentRevision = DocumentRevision::findOrFail($req->id);
        if (!$documentRevision) {
            return response()->json(['message' => 'Document not found'], 404);
        }
        
        $data = [
            'id' => $documentRevision->id,
            'judul' => $documentRevision->document->title,
            'code' => $documentRevision->document->code,
            'category' => $documentRevision->document->category->name,
            'uploader' => $documentRevision->document->uploader->name,
            'url' => route('document_revision.show-file', ['filename' => $documentRevision->file_path]),
            'acc_format' => $documentRevision->acc_format,
            'acc_content' => $documentRevision->acc_content,
        ];

        return response()->json(['data' => $data], 200);
    }

    public function create(){
        $categories = Category::all();
        $approvedDocs = Document::where('is_active','=' ,true)
        ->with('currentRevision')->get();
        return view('admin.document-revisions.create',compact('categories','approvedDocs'));
    }

    public function store(Request $request){
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required',
            'rev' => 'required|array',
            'code' => 'required|string|max:30',
            'file_path' => 'required|file|mimes:pdf,doc,docx,ppt,pptx',
            'description' => 'required|string',
            'reason' => 'required|string|max:255',
        ]);


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

        foreach ($validated['rev'] ?? [] as $rev) {
            $currentRevision = DocumentRevision::findOrFail($rev);
            $newRev = DocumentRevision::create([
                'document_id' => $currentRevision->document_id,
                'file_path' => $fileName,
                'revised_by' => Auth::id(),
                'revision_number' => $currentRevision->revision_number+1,
                // Here
                // 'description' => $validated['description'],
                'description' => $currentRevision->description,
            ]);

            DocumentHistory::create([
                'document_id' => $currentRevision->document_id,
                'revision_id' => $currentRevision->id,
                'action' => 'Revised',
                'performed_by' => Auth::id(),
                'reason' => $validated['reason'],
            ]);
        }

        $document->update(['current_revision_id' => $revision->id]);

        DocumentHistory::create([
            'document_id' => $document->id,
            'revision_id' => $revision->id,
            'action' => 'Created',
            'performed_by' => Auth::id(),
            'reason' => $validated['reason'],
        ]);

        return redirect()->route('document_revision.index')->with('success', 'Document Updated successfully.');
    }

    public function edit(DocumentRevision $documentRevision)
    {
        $approvedDocs = Document::where('is_active','=' ,true)
        ->with('currentRevision')->where('id','!=',$documentRevision->document_id)->with('revisions')->get();
        $categories = Category::all();
        return view('admin.document-revisions.edit', compact('documentRevision', 'categories','approvedDocs'));
    }

    public function editApproval(DocumentRevision $documentRevision)
    {
        $approvedDocs = Document::where('is_active','=' ,true)
        ->with('currentRevision')->where('id','!=',$documentRevision->document_id)->with('revisions')->get();
        $categories = Category::all();
        return view('admin.document_approve.edit', compact('documentRevision', 'categories','approvedDocs'));
    }

    public function update(Request $request, DocumentRevision $documentRevision)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required',
            'rev' => 'nullable|array',
            'code' => 'required|string|max:30',
            'file_path' => 'required|file|mimes:pdf,doc,docx,ppt,pptx',
            'description' => 'required|string',
            'reason' => 'required|string|max:255',
        ]);


        $file = $request->file('file_path');
        $fileName = uniqid() . '_' . $file->getClientOriginalName();
        Storage::disk('dokumen')->put($fileName, file_get_contents($file));


        $document = Document::findOrFail($documentRevision->document_id);
        $newRev = DocumentRevision::create([
            'document_id' => $document->id,
            'file_path' => $fileName,
            'revised_by' => Auth::id(),
            'revision_number' => $documentRevision->revision_number+1,
            'description' => $validated['description'],
        ]);

        $document->update([
            'title' => $validated['title'],
            'code' => $validated['code'],
            'category_id' => $validated['category_id'],
        ]);

        foreach ($validated['rev'] ?? [] as $rev) {
            $currentRevision = DocumentRevision::findOrFail($rev);
            DocumentRevision::create([
                'document_id' => $currentRevision->document->id,
                'file_path' => $fileName,
                'revised_by' => Auth::id(),
                'revision_number' => $currentRevision->revision_number+1,
                'description' => $validated['description'],
            ]);
        }

        // Log to DocumentHistory
        DocumentHistory::create([
            'document_id' => $documentRevision->document_id,
            'revision_id' => $documentRevision->id,
            'action' => 'Revised',
            'performed_by' => Auth::id(),
            'reason' => $validated['reason'],
        ]);

        return redirect()->route('document_revision.index')->with('success', 'Revision updated successfully.');
    }

    public function updateApproval(Request $request, DocumentRevision $documentRevision)
    {
        $rules = [
            'status' => 'required|in:Disetujui,Pengajuan Revisi,Ditolak,Draft',
            'reason' => 'required_if:status,Pengajuan Revisi|required_if:status,Ditolak|string|max:255',
        ];

        if (auth()->user()->isRole('Administrator')) {
            $rules['acc_format'] = 'required|boolean';
            $rules['acc_content'] = 'required|boolean';
        }

        $validated = $request->validate($rules);
        
        $data = [
            'status' => $validated['status'],
            'acc_format' => ($validated['status'] == "Ditolak" || $validated['status'] == 'Pengajuan Revisi') ? false : (auth()->user()->isRole('Pengendali-Dokumen') ? true : $validated['acc_format'] ?? $documentRevision->acc_format),
            'acc_content' => ($validated['status'] == "Ditolak" || $validated['status'] == 'Pengajuan Revisi') ? false : (auth()->user()->isRole('Bagian-Mutu') ? true : $validated['acc_content'] ?? $documentRevision->acc_content),
        ];
        
        $documentRevision->update($data);

        $act = match($validated['status']) {
            'Disetujui' => 'Approved',
            'Draft' => 'Approved',
            default => 'Rejected',
        };
        
        if ($validated['status'] === 'Disetujui') {
            $documentRevision->document->update([
                'is_active' => true,
                'current_revision_id' => $documentRevision->id,
            ]);
        }

        DocumentHistory::create([
            'document_id' => $documentRevision->document_id,
            'revision_id' => $documentRevision->id,
            'action' => $act,
            'performed_by' => Auth::id(),
            'reason' => $validated['reason'] ?? null,
        ]);
        

        return redirect()->route('document_approval.index')->with('success', 'Document updated successfully.');
    }
}
