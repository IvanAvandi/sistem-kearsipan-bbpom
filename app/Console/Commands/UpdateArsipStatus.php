<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Arsip;
use Carbon\Carbon;

class UpdateArsipStatus extends Command
{
    protected $signature = 'arsip:update-status';
    protected $description = 'Memperbarui status arsip dari Aktif ke Inaktif, dan Inaktif ke Siap Dimusnahkan/Permanen sesuai JRA';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->info('Memulai proses pembaruan status arsip...');
        
        // Definisikan ID Divisi Tata Usaha (Unit Kearsipan)
        $tataUsahaDivisiId = 2;

        // 1. Proses Arsip Aktif -> Inaktif
        // (Berlaku untuk SEMUA Divisi)
        $toInactive = Arsip::where('status', 'Aktif')
            ->whereHas('klasifikasiSurat', function ($query) {
                $query->whereRaw('ADDDATE(arsip.tanggal_arsip, INTERVAL masa_aktif YEAR) <= ?', [Carbon::now()]);
            })
            ->get();

        foreach ($toInactive as $arsip) {
            $arsip->status = 'Inaktif';
            $arsip->save();
            $this->line("Arsip ID: {$arsip->id} ('{$arsip->uraian_berkas}') diubah menjadi Inaktif.");
        }
        $this->info(count($toInactive) . ' arsip diubah menjadi Inaktif.');

        // 2. Proses Arsip Inaktif -> Siap Dimusnahkan
        // (HANYA berlaku untuk arsip yang sudah dimiliki Tata Usaha)
        $toDestroy = Arsip::where('status', 'Inaktif')
            ->where('divisi_id', $tataUsahaDivisiId)
            ->whereHas('klasifikasiSurat', function ($query) {
                $query->where('status_akhir', 'Musnah')
                      ->whereRaw('ADDDATE(arsip.tanggal_arsip, INTERVAL (masa_aktif + masa_inaktif) YEAR) <= ?', [Carbon::now()]);
            })
            ->get();

        foreach ($toDestroy as $arsip) {
            $arsip->status = 'Siap Dimusnahkan';
            $arsip->save();
             $this->line("Arsip ID: {$arsip->id} ('{$arsip->uraian_berkas}') diubah menjadi Siap Dimusnahkan.");
        }
        
        // ================== PERBAIKAN SINTAKS ==================
        $this->info(count($toDestroy) . ' arsip diubah menjadi Siap Dimusnahkan.');
        // =======================================================

        // 3. Proses Arsip Inaktif -> Permanen
        // (HANYA berlaku untuk arsip yang sudah dimiliki Tata Usaha)
        $toPermanent = Arsip::where('status', 'Inaktif')
            ->where('divisi_id', $tataUsahaDivisiId)
            ->whereHas('klasifikasiSurat', function ($query) {
                $query->where('status_akhir', 'Permanen')
                      ->whereRaw('ADDDATE(arsip.tanggal_arsip, INTERVAL (masa_aktif + masa_inaktif) YEAR) <= ?', [Carbon::now()]);
            })
            ->get();

        foreach ($toPermanent as $arsip) {
            $arsip->status = 'Permanen';
            $arsip->save();
            $this->line("Arsip ID: {$arsip->id} ('{$arsip->uraian_berkas}') diubah menjadi Permanen.");
        }
        
        // ================== PERBAIKAN SINTAKS ==================
        $this->info(count($toPermanent) . ' arsip diubah menjadi Permanen.');
        // =======================================================

        
        // ================== PERBAIKAN SINTAKS ==================
        $this->info('Proses pembaruan status arsip selesai.');
        // =======================================================
        return 0;
    }
}