<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // <-- IMPORT SoftDeletes

class KlasifikasiSurat extends Model
{
    use HasFactory, SoftDeletes; 

    protected $table = 'klasifikasi_surat';
    protected $guarded = ['id'];

    // Kolom `deleted_at` otomatis ditangani oleh trait

    public function arsips()
    {
        return $this->hasMany(Arsip::class);
    }

}