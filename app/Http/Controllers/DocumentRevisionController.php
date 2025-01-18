<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Document;
use App\Models\DocumentRevision;
use App\Models\DocumentHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentRevisionController extends Controller
{
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


    public function index()
    {
        $revisions = DocumentRevision::with(['document', 'reviser'])->get();
        return view('admin.document-revisions.index', compact('revisions'));
    }

    public function indexApproval()
    {
        $revisions = DocumentRevision::where('status','=','Draft')->with(['document', 'reviser'])->get();
        return view('admin.document_approve.index', compact('revisions'));
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
                'description' => $validated['description'],
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
        $validated = $request->validate([
            'status' => 'required|in:Disetujui,Ditolak',
            'reason' => 'required|string|max:255',
        ]);
        $documentRevision->update($validated);

        if($validated['status'] === 'Disetujui'){
            $act = 'Approved';
            $documentRevision->document->update([
                'is_active' => true,
                'current_revision_id' => $documentRevision->id
            ]);
        }else{
            $act = 'Rejected';
        }

        DocumentHistory::create([
            'document_id' => $documentRevision->document_id,
            'revision_id' => $documentRevision->id,
            'action' => $act,
            'performed_by' => Auth::id(),
            'reason' => $validated['reason'],
        ]);

        return redirect()->route('document_approval.index')->with('success', 'Document updated successfully.');
    }
}
