<?php

namespace App\Http\Controllers;

use App\Models\DocumentHistory;
use App\Models\Document;
use App\Models\Revision;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocumentHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $documentHistoriesQuery = DocumentHistory::with(['revision.reviser', 'performer'])
        ->orderBy('created_at', 'desc');
        
        $roles = Auth::user()->roles->pluck('slug');
        if (!$roles->contains('administrator') && !$roles->contains('bagian-mutu') && !$roles->contains('pengendali-document') && !$roles->contains('kepala-puskesmas')) {
            $documentHistoriesQuery->whereHas('document', function($query) {
                $query->whereHas('uploader',function ($que){
                    $que->whereHas('roles', function($q) {
                        $q->whereIn('id', Auth::user()->roles->pluck('id'));
                    });
                });
            });
        }
        
        $documentHistories = $documentHistoriesQuery->get();

        return view('admin.document_histories.index', compact('documentHistories'));
    }

    /**
     * Display the specified resource.
     */
    public function show(DocumentHistory $documentHistory)
    {
        $reviserRole = $documentHistory->revision->reviser->roles->pluck('id');
        $userRoles = auth()->user()->roles->pluck('id');

        $rightRole = $reviserRole->intersect($userRoles)->isNotEmpty();
        if($rightRole){
            $documentHistory->load(['document', 'revision.reviser', 'performer']);

            return view('admin.document_histories.show', compact('documentHistory'));
        }

        return abort(404);
        
    }
}
