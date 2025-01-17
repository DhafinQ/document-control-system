<?php

namespace App\Http\Controllers;

use App\Models\DocumentRevision;
use App\Models\DocumentHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocumentRevisionController extends Controller
{
    public function showFile($filename)
{
    $path = storage_path("app/public/dokumen/{$filename}");

    if (file_exists($path)) {
        return response()->file($path);
    }

    abort(404, 'File not found');
}


    public function index()
    {
        $revisions = DocumentRevision::with(['document', 'reviser'])->paginate(10);
        return view('admin.document-revisions.index', compact('revisions'));
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
