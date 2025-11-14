<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArsipFile extends Model
{
    use HasFactory;

    protected $table = 'arsip_files'; // Nama tabelnya

    protected $fillable = [ // Kolom yang boleh diisi massal
        'arsip_id',
        'path_file',
        'nama_file_original',
        'size',
    ];

    /**
     * Relasi balik ke Arsip (satu file dimiliki oleh satu arsip)
     */
    public function arsip()
    {
        return $this->belongsTo(Arsip::class);
    }
}