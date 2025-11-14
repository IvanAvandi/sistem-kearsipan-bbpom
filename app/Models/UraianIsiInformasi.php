<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UraianIsiInformasi extends Model
{
    use HasFactory;
    protected $table = 'uraian_isi_informasi';
    protected $guarded = ['id'];

    public function arsip()
    {
        return $this->belongsTo(Arsip::class);
    }
}