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

    public function create(){
        $categories = Category::all();
        $approvedDocs = DocumentRevision::with('document')->where('status','=','Disetujui')->get();
        return view('admin.document-revisions.create',compact('categories','approvedDocs'));
    }

    public function store(Request $request){
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required',
            'rev' => 'required|array',
            'code' => 'required|string|max:30',
            'file_path' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx',
            'description' => 'required|string',
            'reason' => 'required|string|max:255',
        ]);

        dd($validated);
    }

    public function edit(DocumentRevision $documentRevision)
    {
        $statuses = ['Draft', 'Disetujui', 'Ditolak'];
        return view('admin.document-revisions.edit', compact('documentRevision', 'statuses'));
    }

    public function update(Request $request, DocumentRevision $documentRevision)
    {
        $validated = $request->validate([
            'status' => 'required|in:Draft,Disetujui,Ditolak',
            'reason' => 'required|string|max:255',
        ]);

        $documentRevision->update($validated);

        // Log to DocumentHistory
        DocumentHistory::create([
            'document_id' => $documentRevision->document_id,
            'revision_id' => $documentRevision->id,
            'action' => $validated['status'] === 'Disetujui' ? 'Approved' : 'Rejected',
            'performed_by' => Auth::id(),
            'reason' => $validated['reason'],
        ]);

        return redirect()->route('document_revision.index')->with('success', 'Revision updated successfully.');
    }
}
