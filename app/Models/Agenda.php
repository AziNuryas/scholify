<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Agenda extends Model
{
    protected $fillable = [
        'title',
        'description',
        'type',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'location',
        'created_by',
        'target_role',
        'is_active',
        'color',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
    ];

    /**
     * Relasi ke user yang membuat agenda
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scope untuk agenda yang aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope untuk agenda berdasarkan target role
     */
    public function scopeForRole($query, $role)
    {
        return $query->where(function($q) use ($role) {
            $q->where('target_role', 'semua')
              ->orWhere('target_role', $role);
        });
    }

    /**
     * Scope untuk agenda mendatang
     */
    public function scopeUpcoming($query)
    {
        return $query->where('start_date', '>=', now()->toDateString())
                     ->orWhere('end_date', '>=', now()->toDateString());
    }

    /**
     * Mendapatkan label type dalam bahasa Indonesia
     */
    public function getTypeLabelAttribute(): string
    {
        return match ($this->type) {
            'ujian' => 'Ujian',
            'uts' => 'UTS',
            'uas' => 'UAS',
            'rapat' => 'Rapat',
            'libur' => 'Libur',
            'kegiatan' => 'Kegiatan',
            'lainnya' => 'Lainnya',
            default => $this->type,
        };
    }

    /**
     * Mendapatkan warna berdasarkan type
     */
    public function getTypeColorAttribute(): string
    {
        return match ($this->type) {
            'ujian', 'uts', 'uas' => '#EF4444', // Merah
            'rapat' => '#8B5CF6',              // Ungu
            'libur' => '#10B981',              // Hijau
            'kegiatan' => '#3B82F6',           // Biru
            default => '#64748B',              // Abu-abu
        };
    }

    /**
     * Mendapatkan badge class berdasarkan type
     */
    public function getTypeBadgeClassAttribute(): string
    {
        return match ($this->type) {
            'ujian', 'uts', 'uas' => 'badge-ujian',
            'rapat' => 'badge-rapat',
            'libur' => 'badge-libur',
            'kegiatan' => 'badge-kegiatan',
            default => 'badge-lainnya',
        };
    }

    /**
     * Mendapatkan format waktu yang readable
     */
    public function getFormattedTimeAttribute(): string
    {
        if ($this->start_time && $this->end_time) {
            return substr($this->start_time, 0, 5) . ' - ' . substr($this->end_time, 0, 5);
        } elseif ($this->start_time) {
            return substr($this->start_time, 0, 5);
        }
        return 'Seharian';
    }

    /**
     * Mendapatkan format tanggal yang readable
     */
    public function getFormattedDateAttribute(): string
    {
        if ($this->end_date && $this->start_date->format('Y-m-d') != $this->end_date->format('Y-m-d')) {
            return $this->start_date->format('d M') . ' - ' . $this->end_date->format('d M Y');
        }
        return $this->start_date->format('d M Y');
    }

    /**
     * Cek apakah agenda sedang berlangsung
     */
    public function getIsOngoingAttribute(): bool
    {
        $today = now()->toDateString();
        $start = $this->start_date->format('Y-m-d');
        $end = $this->end_date ? $this->end_date->format('Y-m-d') : $start;
        
        return $today >= $start && $today <= $end;
    }
}