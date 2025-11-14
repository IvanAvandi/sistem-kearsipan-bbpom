<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

class UsulanPindah extends Model
{
    use HasFactory;

    protected $table = 'usulan_pindahs';

    protected $fillable = [
        'user_id', // Dibuat oleh
        'status',
        'nomor_ba',
        'tanggal_ba',
        'file_ba_path',
        'catatan_admin',
        
        // Audit Trail
        'diajukan_pada',
        'diusulkan_oleh_id',
        'dikembalikan_pada',
        'dikembalikan_oleh_id',
        'disetujui_pada',
        'disetujui_oleh_id',
        'dibatalkan_pada',
        'dibatalkan_oleh_id',
    ];

    protected $casts = [
        'tanggal_ba' => 'date',
        'diajukan_pada' => 'datetime',
        'dikembalikan_pada' => 'datetime',
        'disetujui_pada' => 'datetime',
        'dibatalkan_pada' => 'datetime',
    ];

    /**
     * Relasi ke User (Pembuat Usulan / Dibuat Oleh)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi ke Arsip (Daftar Arsip yang diusulkan)
     */
    public function arsips(): BelongsToMany
    {
        return $this->belongsToMany(Arsip::class, 'arsip_usulan_pindah');
    }

    /**
     * Relasi ke User (Yang Mengusulkan)
     */
    public function diusulkanOleh(): BelongsTo
    {
        return $this->belongsTo(User::class, 'diusulkan_oleh_id');
    }

    /**
     * Relasi ke User (Yang Mengembalikan)
     */
    public function dikembalikanOleh(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dikembalikan_oleh_id');
    }

    /**
     * Relasi ke User (Yang Menyetujui)
     */
    public function disetujuiOleh(): BelongsTo
    {
        return $this->belongsTo(User::class, 'disetujui_oleh_id');
    }

    /**
     * Relasi ke User (Yang Membatalkan)
     */
    public function dibatalkanOleh(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dibatalkan_oleh_id');
    }
}