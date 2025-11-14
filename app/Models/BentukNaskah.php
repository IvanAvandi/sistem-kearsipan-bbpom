<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BentukNaskah extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

        public function arsips()
    {
        return $this->hasMany(Arsip::class);
    }
}