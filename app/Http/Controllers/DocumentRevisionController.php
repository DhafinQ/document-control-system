<?php

namespace App\Http\Controllers;

use App\Events\NewApprovalDocument;
use App\Events\NewCreatedDocument;
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
        } elseif ((auth()->user()->isRole('Pengendali-Dokumen'))){
            $revisionsQuery->where('acc_content', false)->where('acc_format', false);
        } elseif((auth()->user()->isRole('Administrator'))){
            $revisionsQuery->where(function ($query) {
                $query->where('acc_content', false)
                      ->orWhere('acc_format', false);
            });
        }

        $revisions = $revisionsQuery->get();

        $categories = Category::all();
        return view('admin.document_approve.index', compact('revisions','categories'));
    }

    public function getDoc(Request $req){
        $documentRevision = DocumentRevision::with('document')->with('reviser')->findOrFail($req->id);
        if (!$documentRevision) {
            return response()->json(['message' => 'Document not found'], 404);
        }
        $history = DocumentHistory::with('revision')
                    ->where('document_id',$documentRevision->document->id)
                    ->where('revision_id',$documentRevision->id)
                    ->where('performed_by',$documentRevision->reviser->id)
                    ->where('action','Revised')
                    ->first();
        
        $reason = $history['reason'] ?? '';

        $data = [
            'id' => $documentRevision->id,
            'judul' => $documentRevision->document->title,
            'code' => $documentRevision->document->code,
            'category' => $documentRevision->document->category->name,
            'uploader' => $documentRevision->document->uploader->name,
            'url' => route('document_revision.show-file', ['filename' => $documentRevision->file_path]),
            'acc_format' => $documentRevision->acc_format,
            'acc_content' => $documentRevision->acc_content,
            'reason' => $reason ?? ''
        ];

        return response()->json(['data' => $data], 200);
    }

    public function create(){
        $categories = Category::all();
        $approvedDocs = Document::where('is_active','=' ,true)
        ->whereHas('currentRevision', function ($query) {
            $query->where('status', 'Disetujui');
        })
        ->with('currentRevision')
        ->get();
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
            'revised_doc' => $validated['rev']
        ]);

        foreach ($validated['rev'] ?? [] as $rev) {
            $doc = Document::findOrFail($rev);
            $doc->currentRevision->update([
                'status' => 'Proses Revisi'
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

        event(new NewCreatedDocument($document,'Dokumen ' . $document->title . ' telah dibuat oleh ' . $document->uploader->name . '.'));

        return redirect()->route('document_revision.index')->with('success', 'Document Updated successfully.');
    }

    public function edit(DocumentRevision $documentRevision)
    {
        if($documentRevision->status === 'Disetujui' || $documentRevision->status === 'Pengajuan Revisi'){
            $reason = $documentRevision->status === 'Pengajuan Revisi' ? DocumentHistory::with('revision')->where('document_id',$documentRevision->document->id)->where('revision_id',$documentRevision->id)->where('action','Rejected')->first()->reason:'';
            $approvedDocs = Document::where('is_active',true)
            ->whereHas('currentRevision', function ($query) {
                $query->where('status', 'Disetujui');
            })
            ->where('id', '!=', $documentRevision->document_id)
            ->with('currentRevision')
            ->get();
            $categories = Category::all();
            return view('admin.document-revisions.edit', compact('documentRevision', 'categories','approvedDocs','reason'));
        }else{
            return abort(404);
        }
    }

    public function editApproval(DocumentRevision $documentRevision)
    {
        $approvedDocs = Document::where('is_active','=' ,true)
        ->whereHas('currentRevision', function ($query) {
            $query->where('status', 'Disetujui');
        })
        ->where('id', '!=', $documentRevision->document_id)
        ->with('currentRevision')
        ->get();
        $categories = Category::all();
        return view('admin.document_approve.edit', compact('documentRevision', 'categories','approvedDocs'));
    }

    public function update(Request $request, DocumentRevision $documentRevision)
    {
        $rules = [
            'title' => 'required|string|max:255',
            'category_id' => 'required',
            'rev' => 'nullable|array',
            'code' => 'required|string|max:30',
            'file_path' => 'required|file|mimes:pdf,doc,docx,ppt,pptx',
            'description' => 'required|string',
        ];

        if($documentRevision->status !== 'Pengajuan Revisi'){
            $rules['reason'] = 'required|string|max:255';
        }

        $validated = $request->validate($rules);

        $file = $request->file('file_path');
        $fileName = uniqid() . '_' . $file->getClientOriginalName();
        Storage::disk('dokumen')->put($fileName, file_get_contents($file));

        $documentRevision->update([
            'status' => 'Proses Revisi'
        ]);

        $currentRevDoc = $documentRevision->revised_doc;
        if ($currentRevDoc) {
            // Get the new values to add
            $newValues = array_diff($validated['rev'] ?? [], $currentRevDoc);

            if (!empty($newValues)) {
                $currentRevDoc = array_merge($currentRevDoc, $newValues);
            }
        }
        
        if(empty($currentRevDoc)){
            $currentRevDoc = null;
        }
        
        DocumentRevision::create([
            'document_id' => $documentRevision->document_id,
            'file_path' => $fileName,
            'revised_by' => Auth::id(),
            'revision_number' => $documentRevision->revision_number+1,
            'description' => $validated['description'],
            'revised_doc' => $currentRevDoc ?? $validated['rev'] ?? null
        ]);

        $documentRevision->document->update([
            'title' => $validated['title'],
            'code' => $validated['code'],
            'category_id' => $validated['category_id'],
        ]);

        foreach ($validated['rev'] ?? [] as $rev) {
            $doc = Document::findOrFail($rev);
            $doc->currentRevision->update([
                'status' => 'Proses Revisi'
            ]);
        }

        // Log to DocumentHistory
        DocumentHistory::create([
            'document_id' => $documentRevision->document_id,
            'revision_id' => $documentRevision->id,
            'action' => 'Revised',
            'performed_by' => Auth::id(),
            'reason' => $validated['reason'] ?? null,
        ]);

        event(new NewCreatedDocument($documentRevision->document,'Dokumen ' . $documentRevision->document->title . ' telah direvisi oleh ' . $documentRevision->document->uploader->name . '.'));

        return redirect()->route('document_revision.index')->with('success', 'Revision updated successfully.');
    }

    public function updateApproval(Request $request, DocumentRevision $documentRevision)
    {
        $rules = [
            'status' => 'required|in:Disetujui,Pengajuan Revisi,Draft',
            'reason' => 'required_if:status,Pengajuan Revisi|string|max:255',
        ];

        if (auth()->user()->isRole('Administrator')) {
            $rules['acc_format'] = 'required_if:acc_content,false|boolean';
            $rules['acc_content'] = 'required_if:acc_format,false|boolean';
        }

        $validated = $request->validate($rules);
        
        $data = [
            'status' => $validated['status'],
            'acc_format' => $validated['status'] == 'Pengajuan Revisi' ? false : (auth()->user()->isRole('Pengendali-Dokumen') ? true : $validated['acc_format'] ?? $documentRevision->acc_format),
            'acc_content' => $validated['status'] == 'Pengajuan Revisi' ? false : (auth()->user()->isRole('Bagian-Mutu') ? true : $validated['acc_content'] ?? $documentRevision->acc_content),
        ];
        
        $documentRevision->update($data);

        $act = match($validated['status']) {
            'Disetujui' => 'Approved',
            'Draft' => 'Approved',
            default => 'Rejected',
        };
        
        // Check role kepala puskesmas
        $disetujuiKepPus = $validated['status'] === 'Disetujui' && auth()->user()->isRole('Kepala-Puskesmas');

        if ($disetujuiKepPus) {
            $documentRevision->document->update([
                'is_active' => true,
                'current_revision_id' => $documentRevision->id,
            ]);

            // Change status to Expired
            foreach($documentRevision->revisedDocument() as $doc){
                $doc->currentRevision->update([
                    'status' => 'Expired'
                ]);
                $doc->update([
                    'is_active' => false,
                    'current_revision_id' => $documentRevision->id
                ]);
            }

            for($i=1;$i<$documentRevision->revision_number;$i++){
                $rev = DocumentRevision::with('document')->where('document_id',$documentRevision->document_id)
                                ->where('revision_number',$i)->first();
                $rev->update([
                    'status' => 'Expired'
                ]);
            }
            event(new NewApprovalDocument($documentRevision->document,[1,5],
                    'Dokumen '. $documentRevision->document->title . ' Telah Disepakati.',
                    route('documents.show',['document' => $documentRevision->document]))
            );
        }

        DocumentHistory::create([
            'document_id' => $documentRevision->document_id,
            'revision_id' => $documentRevision->id,
            'action' => $act,
            'performed_by' => Auth::id(),
            'reason' => $validated['reason'] ?? null,
        ]);

        // For Notification
        $message = 'Dokumen ' . $documentRevision->document->title . ' Menunggu Persetujuan.';
        $link = route('document_approval.index');
        if($documentRevision->acc_format && !$documentRevision->acc_content){
            event(new NewApprovalDocument($documentRevision->document,[1,3],$message,$link));
        }else if(!$documentRevision->acc_format && $documentRevision->acc_content){
            event(new NewApprovalDocument($documentRevision->document,[1,2],$message,$link));
        }else if($documentRevision->acc_format && $documentRevision->acc_content && $validated['status'] !== 'Disetujui'){
            event(new NewApprovalDocument($documentRevision->document,[4],$message,$link));
        }else if(!$disetujuiKepPus){
            $message = 'Dokumen ' . $documentRevision->document->title . ' Membutuhkan Revisi.';
            $link = route('document_revision.edit',['documentRevision' => $documentRevision->id]);
            event(new NewApprovalDocument($documentRevision->document,[1,5],$message,$link));
        }
        

        return redirect()->route('document_approval.index')->with('success', 'Document updated successfully.');
    }
}
