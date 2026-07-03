<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AspirationStatusHistory extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'aspiration_id',
        'from_status',
        'to_status',
        'note',
        'changed_by',
        'created_at',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
        ];
    }

    public function aspiration(): BelongsTo
    {
        return $this->belongsTo(Aspirasi::class, 'aspiration_id');
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
