<?php

namespace App\Http\Controllers;

use App\Models\DocumentHistory;
use App\Models\Document;
use App\Models\Revision;
use App\Models\User;
use Illuminate\Http\Request;

class DocumentHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $documentHistories = DocumentHistory::with(['document', 'revision.reviser', 'performer'])->paginate(10);

        return view('admin.document_histories.index', compact('documentHistories'));
    }

    /**
     * Display the specified resource.
     */
    public function show(DocumentHistory $documentHistory)
    {
        $documentHistory->load(['document', 'revision.reviser', 'performer']);

        return view('admin.document_histories.show', compact('documentHistory'));
    }
}
