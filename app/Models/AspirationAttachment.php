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
        'content',
    ];

    protected $hidden = [
        'content',
    ];

    public function aspiration(): BelongsTo
    {
        return $this->belongsTo(Aspirasi::class, 'aspiration_id');
    }

    public function hasDatabaseContent(): bool
    {
        return $this->content !== null;
    }

    public function contentBytes(): string
    {
        $decoded = base64_decode((string) $this->content, true);

        return $decoded === false ? '' : $decoded;
    }
}
