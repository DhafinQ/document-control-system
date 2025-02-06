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
use Illuminate\Support\Facades\Validator;

class DocumentRevisionController extends Controller
{

    public function index()
    {
        $documents = Document::whereHas('uploader.roles', function ($query) {
            $query->whereIn('id', auth()->user()->roles->pluck('id'));
        })->with(['uploader','latestHistory'])->get();
        return view('admin.my_document.index', compact('documents'));
    }

    public function indexApproval()
    {
        $revisionsQuery = DocumentRevision::whereIn('status', ['Draft','Disetujui'])->with(['document', 'reviser']);
        if (auth()->user()->isRole('Kepala-Puskesmas')) {
            $revisionsQuery->where(function($query) {
                $query->where('acc_content', true)
                      ->where('acc_format', true);
            })->orWhere('status', 'Disetujui');
        } elseif (auth()->user()->isRole('Bagian-Mutu')) {
            $revisionsQuery->where(function($query) {
                $query->where('acc_format', true);
            })->orWhere('status', 'Disetujui');
        } elseif ((auth()->user()->isRole('Pengendali-Dokumen'))){
            $revisionsQuery->where(function($query) {
                $query->where('acc_content', false);
            })->orWhere('status', 'Disetujui');
        }

        
        $revisions = $revisionsQuery->get();
        $roles = Auth::user()->roles->pluck('slug');
        
        $categories = Category::all();
        return view('admin.document_approve.index', compact('revisions','categories','roles'));
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

        $userRoles = Auth::user()->roles->pluck('slug');
        $roles = $userRoles->toArray();

        $data = [
            'id' => $documentRevision->id,
            'judul' => $documentRevision->document->title,
            'code' => $documentRevision->document->code,
            'category' => $documentRevision->document->category->name,
            'uploader' => $documentRevision->document->uploader->name,
            'status' => $documentRevision->status,
            'url' => route('document_revision.show-file', ['filename' => $documentRevision->file_path]),
            'acc_format' => $documentRevision->acc_format,
            'acc_content' => $documentRevision->acc_content,
            'reason' => $reason ?? '',
            'roles' => $roles
        ];

        return response()->json(['data' => $data], 200);
    }

    public function create(){
        $categories = Category::all();
        $approvedDocs = Document::where('is_active','=' ,true)
        ->whereHas('currentRevision', function ($query) {
            $query->where('status', 'Disetujui');
        })
        ->whereHas('uploader.roles', function ($query) {
            $query->whereIn('id', auth()->user()->roles->pluck('id'));
        })
        ->with('currentRevision')
        ->get();
        return view('admin.my_document.create',compact('categories','approvedDocs'));
    }

    public function store(Request $request){
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required',
            'rev' => 'required|array',
            'code' => 'required|string|unique:documents,code|max:30',
            'file_path' => 'required|file|mimes:pdf,doc,docx,ppt,pptx',
            'description' => 'required|string',
            'reason' => 'required|string|max:255',
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

    public function show(DocumentRevision $documentRevision){
        if($documentRevision->checkUploaderRoles()){
            return view('admin.my_document.show',compact('documentRevision'));
        }

        abort(404);
    }

    public function edit(DocumentRevision $documentRevision)
    {
       $rightRole = $documentRevision->checkUploaderRoles();
        if(($documentRevision->status === 'Disetujui' || $documentRevision->status === 'Pengajuan Revisi') && $rightRole){
            $reason = $documentRevision->status === 'Pengajuan Revisi' ? DocumentHistory::with('revision')->where('document_id',$documentRevision->document->id)->where('revision_id',$documentRevision->id)->where('action','Rejected')->first()->reason:'';
            $approvedDocs = Document::where('is_active',true)
            ->whereHas('currentRevision', function ($query) {
                $query->where('status', 'Disetujui');
            })
            ->where('id', '!=', $documentRevision->document_id)
            ->with('currentRevision')
            ->get();
            $categories = Category::all();
            return view('admin.my_document.edit', compact('documentRevision', 'categories','approvedDocs','reason'));
        }else{
            return abort(404);
        }
    }

    public function editApproval(DocumentRevision $documentRevision)
    {
        if($documentRevision->status === 'Draft' && $documentRevision->acc_format && $documentRevision->acc_content && auth()->user()->isRole('kepala-puskesmas')){
            $document = $documentRevision->document;
            return view('admin.document_approve.edit', compact('document','documentRevision'));
        }

        return abort(404);
    }

    public function update(Request $request, DocumentRevision $documentRevision)
    {
        $rules = [
            'title' => 'required|string|max:255',
            'category_id' => 'required',
            'rev' => 'nullable|array',
            'code' => 'required|string|unique:documents,code,'.$documentRevision->document->id.'|max:30',
            'file_path' => 'required|file|mimes:pdf,doc,docx,ppt,pptx',
            'description' => 'required|string',
        ];

        if($documentRevision->status !== 'Pengajuan Revisi'){
            $rules['reason'] = 'required|string|max:255';
        }

        $validated = $request->validate($rules);

        $file = $request->file('file_path');
        $fileExtension = $file->getClientOriginalExtension();
        $fileName = str_replace(['/', '\\'], '-', $validated['code']) . '_' . preg_replace('/[\/\\\?\%\*\:\|\\"\<\>\.\(\)]/', '_', $validated['title']) . '.' . $fileExtension;
        if (Storage::disk('dokumen-revision')->exists($documentRevision->file_path)){
            Storage::disk('dokumen-revision')->delete($documentRevision->file_path);
        }
        Storage::disk('dokumen-revision')->put($fileName, file_get_contents($file));
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
            'file' => 'required_if:status,Disetujui|file|mimes:pdf,doc,docx,ppt,pptx',
        ];

        if (auth()->user()->isRole('Administrator')) {
            $rules['acc_format'] = 'boolean';
            $rules['acc_content'] = 'boolean';
        }
        
        $validator = Validator::make($request->all(), $rules);
        
        $validator->after(function ($validator) use ($request) {
            if (auth()->user()->isRole('Administrator')) {
                if ($request->input('acc_format') == false && $request->input('acc_content') == false && $request->input('reason') === '') {
                    $validator->errors()->add('acc_format', 'Either acc_format or acc_content must be true.');
                    $validator->errors()->add('acc_content', 'Either acc_format or acc_content must be true.');
                }
            }
        });
        
        $validated = $validator->validate();
        
        $data = [
            'status' => $validated['status'],
            'acc_format' => $validated['status'] == 'Pengajuan Revisi' ? false : (auth()->user()->isRole('Pengendali-Dokumen') ? true : $validated['acc_format'] ?? $documentRevision->acc_format),
            'acc_content' => $validated['status'] == 'engajuan Revisi' ? false : (auth()->user()->isRole('Bagian-Mutu') ? true : $validated['acc_content'] ?? $documentRevision->acc_content),
        ];

        $documentRevision->update($data);

        $act = match($validated['status']) {
            'Disetujui' => 'Approved',
            'Draft' => 'Approved',
            default => 'Rejected',
        };
        
        // Check role kepala puskesmas
        $disetujuiKepPus = $validated['status'] === 'Disetujui' && auth()->user()->isRole('Kepala-Puskesmas');

        $revisorRoles = $documentRevision->reviser->roles->pluck('id')->toArray();
        $roles = [1];
        $roles = array_merge($roles, $revisorRoles);
        
        // Remove duplicates, if needed
        $roles = array_unique($roles);

        if ($disetujuiKepPus) {
            
            $file = $request->file('file');
            $fileExtension = $file->getClientOriginalExtension();
            $fileName = str_replace(['/', '\\'], '-', $documentRevision->document->code) . '_' . preg_replace('/[\/\\\?\%\*\:\|\\"\<\>\.\(\)]/', '_', $documentRevision->document->title) . '_(Signed)' . '.' . $fileExtension;
            Storage::disk('dokumen-approved')->put($fileName, file_get_contents($file));
            if (Storage::disk('dokumen-revision')->exists($documentRevision->file_path)){
                Storage::disk('dokumen-revision')->delete($documentRevision->file_path);
            }

            $documentRevision->update([
                'file_path' => $fileName
            ]);

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

            event(new NewApprovalDocument($documentRevision->document,$roles,
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
            event(new NewApprovalDocument($documentRevision->document,$roles,$message,$link));
        }
        

        return redirect()->route('document_approval.index')->with('success', 'Document updated successfully.');
    }
}
