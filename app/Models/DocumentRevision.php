<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

    public function reviser()
    {
        return $this->belongsTo(User::class, 'revised_by');
    }
}
