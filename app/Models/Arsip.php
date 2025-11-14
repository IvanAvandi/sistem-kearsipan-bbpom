<?php

namespace App\Models;

use App\Scopes\DivisiScope; 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Divisi; 
use App\Models\ArsipFile;
use Carbon\Carbon;

class Arsip extends Model
{
    use HasFactory;
    protected $table = 'arsip';
    protected $guarded = ['id']; 

    /**
     * Menerapkan Global Scope untuk memfilter data arsip berdasarkan divisi user.
     */
    protected static function booted()
    {
        static::addGlobalScope(new DivisiScope);
    }

    /**
     * Relasi: Arsip dimiliki oleh satu Klasifikasi Surat.
     * Termasuk yang sudah di-soft delete.
     */
    public function klasifikasiSurat()
    {
        return $this->belongsTo(KlasifikasiSurat::class)->withTrashed();
    }

    /**
     * Relasi: Arsip memiliki banyak Uraian Isi Informasi.
     */
    public function uraianIsiInformasi()
    {
        return $this->hasMany(UraianIsiInformasi::class);
    }

    /**
     * Relasi: Arsip dibuat oleh satu User.
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Relasi: Arsip memiliki satu Bentuk Naskah.
     */
    public function bentukNaskah()
    {
        return $this->belongsTo(BentukNaskah::class);
    }

    /**
     * Relasi: Arsip dimiliki oleh satu Divisi (Lokasi/Pemilik saat ini).
     */
    public function divisi()
    {
        return $this->belongsTo(Divisi::class);
    }

    /**
     * Relasi Pivot: Arsip bisa ada di banyak Usulan Pemusnahan.
     */
    public function usulanPemusnahan()
    {
        return $this->belongsToMany(UsulanPemusnahan::class, 'arsip_usulan_pemusnahan', 'arsip_id', 'usulan_pemusnahan_id');
    }

    /**
     * Relasi Pivot: Arsip bisa ada di banyak Usulan Pindah.
     */
    public function usulanPindahs()
    {
        return $this->belongsToMany(UsulanPindah::class, 'arsip_usulan_pindah', 'arsip_id', 'usulan_pindah_id');
    }

    /**
     * Relasi: Arsip memiliki banyak File Lampiran.
     */
    public function files()
    {
        return $this->hasMany(ArsipFile::class);
    }
}