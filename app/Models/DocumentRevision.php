<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DocumentRevision extends Model
{
    protected $table = 'document_revisions';
    protected $fillable = [
        'document_id',
        'file_path',
        'revised_by',
        'revision_number',
        'status',
        'description',
        'acc_format',
        'acc_content',
        'revised_doc'
    ];
    protected $casts = [
        'revised_doc' => 'array',
    ];

    public function document() : BelongsTo{
        return $this->belongsTo(Document::class,'document_id');
    }

    public function revisedDocument() {
        $documentIds = $this->revised_doc ?? [];
        return Document::whereIn('id', $documentIds)->get();
    }

    public function latestRevision(){
        return $this->where('document_id', $this->document->id)
        ->orderBy('revision_number', 'desc')
        ->first();
    }

    public function histories() : HasMany{
        return $this->hasMany(DocumentHistory::class,'revision_id');
    }

    public function accFormat(){
        return $this->histories()->whereHas('performer.roles', function ($query) {
            $query->whereIn('name', ['Pengendali Dokumen','Administrator'])->where('action','Approved');
        })->first();
    }

    public function accContent(){
        return $this->histories()->whereHas('performer.roles', function ($query) {
            $query->whereIn('name', ['Bagian Mutu','Administrator'])->where('action','Approved');
        })->first();
    }

    public function accKepalaPuskesmas(){
        return $this->histories()->whereHas('performer.roles', function ($query) {
            $query->where('name', 'Kepala Puskesmas')->where('action','Approved');
        })->first();
    }

    public function reviser()
    {
        return $this->belongsTo(User::class, 'revised_by');
    }
}
