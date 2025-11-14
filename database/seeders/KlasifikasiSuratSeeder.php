<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Imports\KlasifikasiImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class KlasifikasiSuratSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Kosongkan tabel terlebih dahulu untuk memastikan data bersih
        // Menggunakan DB::statement untuk menonaktifkan sementara foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('klasifikasi_surat')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Tentukan path ke file CSV Anda
        $path = database_path('seeders/csv/klasifikasi_surat.csv');

        // Gunakan class KlasifikasiImport yang sudah ada untuk membaca dan memasukkan data
        Excel::import(new KlasifikasiImport, $path);
    }
}