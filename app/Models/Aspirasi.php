<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Aspirasi extends Model
{
    protected $table = 'aspirations';

    public const STATUS_RECEIVED = 'received';
    public const STATUS_VERIFIED = 'verified';
    public const STATUS_IN_REVIEW = 'in_review';
    public const STATUS_FOLLOW_UP = 'follow_up';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_NEED_DATA = 'need_data';
    public const STATUS_REJECTED = 'rejected';

    public const PRIORITY_LOW = 'low';
    public const PRIORITY_NORMAL = 'normal';
    public const PRIORITY_HIGH = 'high';
    public const PRIORITY_URGENT = 'urgent';

    protected $fillable = [
        'code',
        'name',
        'nik',
        'whatsapp',
        'email',
        'city',
        'district_village',
        'category_id',
        'title',
        'body',
        'status',
        'priority',
        'assigned_to',
        'verification_result',
        'public_response',
        'internal_note',
        'submitted_at',
        'verified_at',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'submitted_at' => 'datetime',
            'verified_at' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

    public static function statuses(): array
    {
        return [
            self::STATUS_RECEIVED => [
                'label' => 'Diterima',
                'description' => 'Aspirasi masuk dan menunggu verifikasi awal.',
            ],
            self::STATUS_VERIFIED => [
                'label' => 'Verifikasi & Klasifikasi',
                'description' => 'Aspirasi sudah diverifikasi dan diklasifikasikan admin.',
            ],
            self::STATUS_IN_REVIEW => [
                'label' => 'Telaah Internal',
                'description' => 'Aspirasi sedang ditelaah oleh tim internal.',
            ],
            self::STATUS_FOLLOW_UP => [
                'label' => 'Tindak Lanjut',
                'description' => 'Aspirasi sedang dikoordinasikan dengan pihak terkait.',
            ],
            self::STATUS_COMPLETED => [
                'label' => 'Selesai',
                'description' => 'Penanganan aspirasi telah selesai.',
            ],
            self::STATUS_NEED_DATA => [
                'label' => 'Butuh Data Tambahan',
                'description' => 'Tim membutuhkan data tambahan dari pengirim.',
            ],
            self::STATUS_REJECTED => [
                'label' => 'Ditolak',
                'description' => 'Aspirasi tidak dapat diproses lebih lanjut.',
            ],
        ];
    }

    public static function statusKeys(): array
    {
        return array_keys(self::statuses());
    }

    public static function priorities(): array
    {
        return [
            self::PRIORITY_LOW => 'Rendah',
            self::PRIORITY_NORMAL => 'Normal',
            self::PRIORITY_HIGH => 'Tinggi',
            self::PRIORITY_URGENT => 'Mendesak',
        ];
    }

    public static function priorityKeys(): array
    {
        return array_keys(self::priorities());
    }

    public static function priorityLabel(?string $priority): string
    {
        return self::priorities()[$priority] ?? 'Normal';
    }

    public static function statusLabel(?string $status): string
    {
        return self::statuses()[$status]['label'] ?? 'Tidak Diketahui';
    }

    public static function publicSteps(): array
    {
        return [
            self::STATUS_RECEIVED,
            self::STATUS_VERIFIED,
            self::STATUS_IN_REVIEW,
            self::STATUS_FOLLOW_UP,
            self::STATUS_COMPLETED,
        ];
    }

    public function statusLabelText(): string
    {
        return self::statusLabel($this->status);
    }

    public function priorityLabelText(): string
    {
        return self::priorityLabel($this->priority);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(AspirasiCategory::class, 'category_id');
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(AspirationAttachment::class, 'aspiration_id');
    }

    public function histories(): HasMany
    {
        return $this->hasMany(AspirationStatusHistory::class, 'aspiration_id')->latest('created_at');
    }

    public function scopeSearch(Builder $query, ?string $keyword): Builder
    {
        if (! $keyword) {
            return $query;
        }

        return $query->where(function (Builder $inner) use ($keyword): void {
            $inner->where('code', 'like', "%{$keyword}%")
                ->orWhere('name', 'like', "%{$keyword}%")
                ->orWhere('whatsapp', 'like', "%{$keyword}%")
                ->orWhere('title', 'like', "%{$keyword}%")
                ->orWhere('city', 'like', "%{$keyword}%");
        });
    }
}
