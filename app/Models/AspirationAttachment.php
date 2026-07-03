<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AspirationAttachment extends Model
{
    protected $fillable = [
        'aspiration_id',
        'original_name',
        'path',
        'mime_type',
        'size_bytes',
    ];

    public function aspiration(): BelongsTo
    {
        return $this->belongsTo(Aspirasi::class, 'aspiration_id');
    }
}
