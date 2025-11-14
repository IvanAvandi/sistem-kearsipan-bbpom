<?php

namespace App\Scopes; 

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class DivisiScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        // Cek jika pengguna login DAN rolenya bukan Admin
        if (Auth::check() && Auth::user()->role !== 'Admin') {

            // <-- PERBAIKAN: Filter berdasarkan 'divisi_id'
            $builder->where('divisi_id', Auth::user()->divisi_id);
        }

        // Jika rolenya Admin, jangan filter apa-apa (bisa lihat semua)
    }
}