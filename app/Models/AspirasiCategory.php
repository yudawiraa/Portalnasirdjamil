<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AspirasiCategory extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function aspirations(): HasMany
    {
        return $this->hasMany(Aspirasi::class, 'category_id');
    }
}
