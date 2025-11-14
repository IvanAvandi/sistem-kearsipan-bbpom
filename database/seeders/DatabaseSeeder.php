<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Seeder wajib yang selalu dijalankan
        $this->call([
            KlasifikasiSuratSeeder::class,
        ]);

        // Seeder data dummy yang hanya berjalan di lingkungan development
        if (App::environment('local')) {
            $this->call(DummyDataSeeder::class);
        }
    }
}