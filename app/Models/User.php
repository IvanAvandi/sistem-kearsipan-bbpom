<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Divisi;  

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Tentukan tabel secara eksplisit agar 100% aman
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     * Disesuaikan agar cocok dengan Seeder dan tabel SIBOB.
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'divisi_id',
        // Kolom SIBOB untuk seeder
        'no_pegawai',
        'username',
        'tgl_lhr',
        'jabatan_id',
        'status',
        'aktif',
        'deskjob',
        'namanogelar',
        'agama',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'tgl_lhr' => 'date', 
    ];

    public function arsips()
    {
        return $this->hasMany(Arsip::class, 'created_by');
    }

    // Relasi ke Bidang (Divisi)
    public function divisi()
    {
        return $this->belongsTo(Divisi::class, 'divisi_id');
    }

    // =================================================================
    // ATRIBUT ROLE DINAMIS (Sintaks Laravel 8)
    // =================================================================
    /**
     * Membuat atribut 'role' secara dinamis (Accessor Laravel 8).
     * Nama fungsi HARUS getRoleAttribute
     *
     * @param  mixed  $value
     * @return string
     */
    public function getRoleAttribute($value)
    {

        
        //  ID 'Tata Usaha' adalah 2
        $tataUsahaDivisiId = 2; 

        if ($this->divisi_id == $tataUsahaDivisiId) {
            return 'Admin';
        } else {
            return 'Arsiparis';
        }
    }
}