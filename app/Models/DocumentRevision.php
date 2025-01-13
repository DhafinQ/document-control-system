<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
    ];

    public function document() : BelongsTo{
        return $this->belongsTo(Document::class,'document_id');
    }

    public function reviser()
    {
        return $this->belongsTo(User::class, 'revised_by');
    }
}