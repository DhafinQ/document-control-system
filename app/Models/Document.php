<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Document extends Model
{
    protected $table = 'documents';
    protected $fillable = [
        'title',
        'code',
        'category_id',
        'uploaded_by',
        'is_active',
        'current_revision_id',
    ];

    public function revisions()
    {
        return $this->hasMany(DocumentRevision::class);
    }

    public function currentRevision()
    {
        return $this->belongsTo(DocumentRevision::class, 'current_revision_id');
    }
    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function category() : BelongsTo {
        return $this->belongsTo(Category::class, 'category_id');
    }

}
