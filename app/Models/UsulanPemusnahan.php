<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsulanPemusnahan extends Model
{
    use HasFactory;

    protected $table = 'usulan_pemusnahan';
    protected $guarded = ['id'];

    /**
     * Mendefinisikan tipe data untuk Carbon.
     */
    protected $casts = [
        'tanggal_usulan' => 'date',
        'tanggal_surat_usulan' => 'date', 
        'tanggal_surat_persetujuan' => 'date',
        'tanggal_pemusnahan_fisik' => 'date',
        'tanggal_bapa_diterima' => 'date',
        'tanggal_surat_penolakan' => 'date',
    ];

    /**
     * Relasi ke model User: Satu usulan dibuat oleh satu user.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Relasi ke model Arsip: Satu usulan bisa memiliki banyak arsip.
     */
    public function arsips()
    {
        return $this->belongsToMany(Arsip::class, 'arsip_usulan_pemusnahan', 'usulan_pemusnahan_id', 'arsip_id');
    }
}