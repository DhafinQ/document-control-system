<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

//
class DocumentHistory extends Model
{
    protected $table = 'document_history';
    protected $fillable = [
        'document_id',
        'revision_id',
        'action',
        'performed_by',
        'reason',
    ];

    public $timestamps = false;

    public function document() : BelongsTo {
        return $this->belongsTo(Document::class,'document_id');
    }

    public function revision() : BelongsTo {
        return $this->belongsTo(DocumentRevision::class, 'revision_id');
    }

    public function performer() : BelongsTo {
        return $this->belongsTo(User::class,'performed_by');
    }
}
