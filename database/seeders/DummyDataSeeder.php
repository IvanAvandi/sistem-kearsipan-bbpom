<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Arsip;
use App\Models\KlasifikasiSurat;
use App\Models\UraianIsiInformasi;
use App\Models\BentukNaskah;
use App\Models\Divisi;
use App\Models\LinkTerkait; 
use App\Models\UsulanPemusnahan;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // --- 1. AMBIL/BUAT DATA MASTER ---
        $divisiTU = Divisi::firstOrCreate(['id' => 2], ['nama' => 'Tata Usaha']);
        $divisiInfokom = Divisi::firstOrCreate(['id' => 6], ['nama' => 'Informasi dan Komunikasi']);
        $divisiPengujian = Divisi::firstOrCreate(['id' => 4], ['nama' => 'Pengujian']);
        $divisiPemeriksaan = Divisi::firstOrCreate(['id' => 5], ['nama' => 'Pemeriksaan']);
        $divisiPenindakan = Divisi::firstOrCreate(['id' => 3], ['nama' => 'Penindakan']);
        Divisi::firstOrCreate(['id' => 1], ['nama' => 'Balai Besar POM di Banjarbaru']);

        // Data Bentuk Naskah
        $bentukNaskahList = [
            'Surat Keputusan', 'Surat Perjanjian', 'Surat Edaran',
            'Surat Perintah/Tugas', 'Surat Dinas', 'Memorandum', 'Nota Dinas',
            'Surat Undangan', 'Berita Acara', 'Surat Keterangan', 'Surat Pengantar',
            'Pengumuman', 'Laporan', 'Telaahan Staf'
        ];
        foreach ($bentukNaskahList as $nama) {
            BentukNaskah::firstOrCreate(['nama_bentuk_naskah' => $nama]);
        }
        $bentukNaskahLaporan = BentukNaskah::where('nama_bentuk_naskah', 'Laporan')->first();
        $bentukNaskahSK = BentukNaskah::where('nama_bentuk_naskah', 'Surat Keputusan')->first();
        
        // Data Link Terkait
        LinkTerkait::firstOrCreate(['nama' => 'Website BPOM RI'], ['link_url' => 'https://pom.go.id', 'status' => 'Aktif', 'path_icon' => 'icons/bpom_ri.png']);
        LinkTerkait::firstOrCreate(['nama' => 'Cek BPOM Mobile'], ['link_url' => 'https://cekbpom.pom.go.id/', 'status' => 'Aktif', 'path_icon' => 'icons/cek_bpom.png']);
        LinkTerkait::firstOrCreate(['nama' => 'e-Registrasi Pangan'], ['link_url' => 'https://e-reg.pom.go.id/', 'status' => 'Aktif', 'path_icon' => 'icons/ereg_pangan.png']);
        LinkTerkait::firstOrCreate(['nama' => 'Notifikasi Kosmetika'], ['link_url' => 'https://notifkos.pom.go.id/', 'status' => 'Aktif', 'path_icon' => 'icons/notifkos.png']);
        LinkTerkait::firstOrCreate(['nama' => 'SIOB (Internal)'], ['link_url' => '#', 'status' => 'Aktif', 'path_icon' => 'icons/siob.png']);


        // --- 2. AMBIL PENGGUNA (DARI SIBOB DUMP) ---
        $admin = User::find(1); 
        $arsiparisTU = User::find(33);
        $arsiparisInfokom = User::find(9);
        $arsiparisPengujian = User::find(27);
        $arsiparisPemeriksaan = User::find(29);
        $arsiparisPenindakan = User::find(6);
        
        if (!$arsiparisTU || !$arsiparisInfokom || !$arsiparisPengujian || !$arsiparisPemeriksaan || !$arsiparisPenindakan) {
             $this->command->error('FATAL ERROR: Beberapa user kunci tidak ditemukan di tabel users. Seeding arsip dibatalkan.');
             return;
        }

        // --- 3. AMBIL DATA KLASIFIKASI ---
        $klasKeuangan = KlasifikasiSurat::where('kode_klasifikasi', 'KU.02.02')->first();
        $klasKepegawaian = KlasifikasiSurat::where('kode_klasifikasi', 'KP.05.02')->first();
        $klasPengadaan = KlasifikasiSurat::where('kode_klasifikasi', 'PL.01.01')->first();
        $klasHukum = KlasifikasiSurat::where('kode_klasifikasi', 'HK.04.01')->first();
        $klasUmum = KlasifikasiSurat::where('kode_klasifikasi', 'RT.08')->first();
        $klasPermanenTU = KlasifikasiSurat::where('kode_klasifikasi', 'PR.01.02')->first();
        $klasPengujian = KlasifikasiSurat::where('kode_klasifikasi', 'PP.01.01')->first();
        $klasPemeriksaan = KlasifikasiSurat::where('kode_klasifikasi', 'PW.01.01')->first();
        $klasPenindakan = KlasifikasiSurat::where('kode_klasifikasi', 'PD.03.03')->first();
        $klasInfokom = KlasifikasiSurat::where('kode_klasifikasi', 'TI.01.01')->first();

        if (!$klasKeuangan || !$klasKepegawaian || !$klasPengadaan || !$klasHukum || !$klasUmum || !$klasPermanenTU ||
            !$klasPengujian || !$klasPemeriksaan || !$klasPenindakan || !$klasInfokom) {
            $this->command->warn('Peringatan: Beberapa kode klasifikasi penting tidak ditemukan. Arsip terkait mungkin tidak dibuat.');
        }

        // --- 4. BUAT DATA ARSIP TATA USAHA (UTAMA) ---
        
        // Arsip AKTIF (Tata Usaha)
        if($klasKeuangan && $arsiparisTU){
            $arsipTU1 = Arsip::firstOrCreate(['uraian_berkas' => 'Laporan Realisasi Anggaran Jan 2025'], [
                'klasifikasi_surat_id' => $klasKeuangan->id, 'divisi_id' => $divisiTU->id, 'created_by' => $arsiparisTU->id,
                'bentuk_naskah_id' => $bentukNaskahLaporan->id, 'tanggal_arsip' => '2025-01-31', 'kurun_waktu' => '2025',
                'status' => 'Aktif', 'jumlah_berkas' => '1', 'tingkat_perkembangan' => 'Asli', 'lokasi_penyimpanan' => 'Box A-2025',
            ]);
            for ($i = 1; $i <= 5; $i++) { UraianIsiInformasi::firstOrCreate(['arsip_id' => $arsipTU1->id, 'nomor_item' => $i], ['uraian' => 'SPM Gaji dan Tunjangan ' . $i, 'tanggal' => '2025-01-' . str_pad($i*2, 2, '0', STR_PAD_LEFT), 'jumlah_lembar' => rand(2, 5)]); }
        }
        
        // Arsip AKTIF/INAKTIF/MUSNAH/SIAP DIMUSNAHKAN TU
        if($klasKepegawaian && $arsiparisTU){
            $arsipTU2 = Arsip::firstOrCreate(['uraian_berkas' => 'SK Kenaikan Pangkat Pegawai April 2025'], [
                'klasifikasi_surat_id' => $klasKepegawaian->id, 'divisi_id' => $divisiTU->id, 'created_by' => $arsiparisTU->id, 
                'bentuk_naskah_id' => $bentukNaskahSK->id, 'tanggal_arsip' => '2025-04-01', 'kurun_waktu' => '2025', 
                'status' => 'Aktif', 'jumlah_berkas' => '1', 'tingkat_perkembangan' => 'Asli', 'lokasi_penyimpanan' => 'Box B-2025',
            ]);
            for ($i = 1; $i <= 5; $i++) { UraianIsiInformasi::firstOrCreate(['arsip_id' => $arsipTU2->id, 'nomor_item' => $i], ['uraian' => 'SK Pegawai Golongan III/' . chr(96 + $i), 'tanggal' => '2025-04-01', 'jumlah_lembar' => 1]); }
        }
        if($klasPengadaan && $arsiparisTU){
            $arsipTU3 = Arsip::firstOrCreate(['uraian_berkas' => 'Dokumen Perencanaan Pengadaan ATK 2025'], [ 
                'klasifikasi_surat_id' => $klasPengadaan->id, 'divisi_id' => $divisiTU->id, 'created_by' => $arsiparisTU->id, 
                'bentuk_naskah_id' => $bentukNaskahLaporan->id, 'tanggal_arsip' => '2025-03-15', 'kurun_waktu' => '2025', 
                'status' => 'Aktif', 'jumlah_berkas' => '1', 'tingkat_perkembangan' => 'Asli', 'lokasi_penyimpanan' => 'Box C-2025',
            ]);
            for ($i = 1; $i <= 5; $i++) { UraianIsiInformasi::firstOrCreate(['arsip_id' => $arsipTU3->id, 'nomor_item' => $i], ['uraian' => 'Daftar Kebutuhan Kertas HVS ' . $i, 'tanggal' => '2025-03-10', 'jumlah_lembar' => rand(1, 3)]); }
        }
        if($klasUmum && $arsiparisTU){
            $arsipTU4 = Arsip::firstOrCreate(['uraian_berkas' => 'Laporan Keamanan & Ketertiban Kantor 2025'], [ 
                'klasifikasi_surat_id' => $klasUmum->id, 'divisi_id' => $divisiTU->id, 'created_by' => $arsiparisTU->id, 
                'bentuk_naskah_id' => $bentukNaskahLaporan->id, 'tanggal_arsip' => '2025-04-01', 'kurun_waktu' => '2025', 
                'status' => 'Aktif', 'jumlah_berkas' => '1', 'tingkat_perkembangan' => 'Asli', 'lokasi_penyimpanan' => 'Box D-2025',
            ]);
            for ($i = 1; $i <= 5; $i++) { UraianIsiInformasi::firstOrCreate(['arsip_id' => $arsipTU4->id, 'nomor_item' => $i], ['uraian' => 'Laporan Jaga Shift Malam Minggu ' . $i, 'tanggal' => '2025-04-' . str_pad($i, 2, '0', STR_PAD_LEFT), 'jumlah_lembar' => 2]); }
        }
        if($klasKeuangan && $arsiparisTU){
            $arsipTU_Inaktif = Arsip::firstOrCreate(['uraian_berkas' => 'Laporan Arus Kas 2022'], [ 
                'klasifikasi_surat_id' => $klasKeuangan->id, 'divisi_id' => $divisiTU->id, 'created_by' => $arsiparisTU->id, 
                'bentuk_naskah_id' => $bentukNaskahLaporan->id, 'tanggal_arsip' => '2022-12-31', 'kurun_waktu' => '2022', 
                'status' => 'Inaktif', 'jumlah_berkas' => '1', 'tingkat_perkembangan' => 'Asli', 'lokasi_penyimpanan' => 'Box E-2022',
            ]);
            UraianIsiInformasi::firstOrCreate(['arsip_id' => $arsipTU_Inaktif->id, 'nomor_item' => 1], ['uraian' => 'Rekapitulasi Arus Kas 2022', 'tanggal' => '2022-12-31', 'jumlah_lembar' => 10]);
        }
        if($klasPengadaan && $arsiparisTU){
            $arsipTU_Siap1 = Arsip::firstOrCreate(['uraian_berkas' => 'Dokumen Pengadaan Komputer 2018'], [ 
                'klasifikasi_surat_id' => $klasPengadaan->id, 'divisi_id' => $divisiTU->id, 'created_by' => $arsiparisTU->id, 
                'bentuk_naskah_id' => $bentukNaskahLaporan->id, 'tanggal_arsip' => '2018-03-10', 'kurun_waktu' => '2018', 
                'status' => 'Siap Dimusnahkan', 'jumlah_berkas' => '1', 'tingkat_perkembangan' => 'Asli', 'lokasi_penyimpanan' => 'Gudang-01',
            ]);
            UraianIsiInformasi::firstOrCreate(['arsip_id' => $arsipTU_Siap1->id, 'nomor_item' => 1], ['uraian' => 'Kontrak Pengadaan PC', 'tanggal' => '2018-03-10', 'jumlah_lembar' => 5]);
        }
        if($klasHukum && $arsiparisTU){
            $arsipTU_Siap2 = Arsip::firstOrCreate(['uraian_berkas' => 'Laporan Penanganan Perkara Perdata 2014'], [ 
                'klasifikasi_surat_id' => $klasHukum->id, 'divisi_id' => $divisiTU->id, 'created_by' => $arsiparisTU->id, 
                'bentuk_naskah_id' => $bentukNaskahLaporan->id, 'tanggal_arsip' => '2014-07-20', 'kurun_waktu' => '2014', 
                'status' => 'Siap Dimusnahkan', 'jumlah_berkas' => '1', 'tingkat_perkembangan' => 'Asli', 'lokasi_penyimpanan' => 'Gudang-02',
            ]);
            UraianIsiInformasi::firstOrCreate(['arsip_id' => $arsipTU_Siap2->id, 'nomor_item' => 1], ['uraian' => 'Putusan Sidang Kasus A', 'tanggal' => '2014-07-15', 'jumlah_lembar' => 20]);
        }
        if($klasKeuangan && $arsiparisTU){
            $arsipTU_Siap3 = Arsip::firstOrCreate(['uraian_berkas' => 'SPM & SP2D Tahun 2017'], [ 
                'klasifikasi_surat_id' => $klasKeuangan->id, 'divisi_id' => $divisiTU->id, 'created_by' => $arsiparisTU->id, 
                'bentuk_naskah_id' => $bentukNaskahLaporan->id, 'tanggal_arsip' => '2017-12-31', 'kurun_waktu' => '2017', 
                'status' => 'Siap Dimusnahkan', 'jumlah_berkas' => '1', 'tingkat_perkembangan' => 'Asli', 'lokasi_penyimpanan' => 'Gudang-03',
            ]);
            UraianIsiInformasi::firstOrCreate(['arsip_id' => $arsipTU_Siap3->id, 'nomor_item' => 1], ['uraian' => 'Rekap SP2D Desember 2017', 'tanggal' => '2017-12-28', 'jumlah_lembar' => 12]);
        }
        if($klasKepegawaian && $arsiparisTU){
            $arsipTU_Siap4 = Arsip::firstOrCreate(['uraian_berkas' => 'Dokumen Kenaikan Gaji Berkala 2014'], [ 
                'klasifikasi_surat_id' => $klasKepegawaian->id, 'divisi_id' => $divisiTU->id, 'created_by' => $arsiparisTU->id, 
                'bentuk_naskah_id' => $bentukNaskahSK->id, 'tanggal_arsip' => '2014-01-05', 'kurun_waktu' => '2014', 
                'status' => 'Siap Dimusnahkan', 'jumlah_berkas' => '1', 'tingkat_perkembangan' => 'Asli', 'lokasi_penyimpanan' => 'Gudang-04',
            ]);
            UraianIsiInformasi::firstOrCreate(['arsip_id' => $arsipTU_Siap4->id, 'nomor_item' => 1], ['uraian' => 'Daftar Pegawai Naik Gaji', 'tanggal' => '2014-01-05', 'jumlah_lembar' => 3]);
        }

        // Arsip DIUSULKAN MUSNAH (Tata Usaha)
        if($klasKeuangan && $arsiparisTU){
            $arsipTU_Usul = Arsip::firstOrCreate(['uraian_berkas' => 'Data Rekening Bendahara 2016'], [ 
                'klasifikasi_surat_id' => $klasKeuangan->id, 'divisi_id' => $divisiTU->id, 'created_by' => $arsiparisTU->id, 
                'tanggal_arsip' => '2016-10-10', 'kurun_waktu' => '2016', 
                'status' => 'Diusulkan Musnah', 'jumlah_berkas' => '1', 'tingkat_perkembangan' => 'Asli', 'lokasi_penyimpanan' => 'Gudang-05',
            ]);
            $usulan1 = UsulanPemusnahan::firstOrCreate(['nomor_usulan' => 'USUL/BBPOM/1/2025'],[ 
                'tanggal_usulan' => Carbon::now()->subDays(10), 'status' => 'Diajukan ke Pusat', 'created_by' => $arsiparisTU->id, 
                'nomor_surat_usulan' => 'SURAT/USUL/001',
                'tanggal_surat_usulan' => Carbon::now()->subDays(11),
                'file_surat_usulan_path' => 'contoh/surat_usulan_1.pdf'
            ]);
            $usulan1->arsips()->syncWithoutDetaching([$arsipTU_Usul->id]);
        }

        // Arsip MUSNAH (Tata Usaha)
        if($klasKeuangan && $arsiparisTU){
            $arsipTU_Musnah = Arsip::firstOrCreate(['uraian_berkas' => 'Laporan Pajak Tahunan 2015'],[ 
                'klasifikasi_surat_id' => $klasKeuangan->id, 'divisi_id' => $divisiTU->id, 'created_by' => $arsiparisTU->id, 
                'tanggal_arsip' => '2015-12-31', 'kurun_waktu' => '2015', 
                'status' => 'Musnah', 'jumlah_berkas' => '1', 'tingkat_perkembangan' => 'Asli', 'lokasi_penyimpanan' => 'Dimusnahkan',
            ]);
            $usulan2 = UsulanPemusnahan::firstOrCreate(['nomor_usulan' => 'USUL/BBPOM/2/2024'],[ 
                'tanggal_usulan' => '2024-03-15', 'status' => 'Selesai', 'created_by' => $arsiparisTU->id, 
                'nomor_surat_usulan' => 'SURAT/USUL/002',
                'tanggal_surat_usulan' => '2024-03-14',
                'file_surat_usulan_path' => 'contoh/surat_usulan_2.pdf',
                'nomor_surat_persetujuan' => 'SP/01/PST/IV/2024', 'tanggal_surat_persetujuan' => '2024-04-20', 
                'file_surat_persetujuan_path' => 'contoh/surat_persetujuan.pdf', 'tanggal_pemusnahan_fisik' => '2024-05-10', 
                'nomor_bapa_diterima' => 'BA/FINAL/001/2024', 'tanggal_bapa_diterima' => '2024-06-25', 
                'file_bapa_diterima_path' => 'contoh/bapa_final.pdf',
            ]);
            $usulan2->arsips()->syncWithoutDetaching([$arsipTU_Musnah->id]);
        }

        // Arsip PERMANEN (Tata Usaha)
        if($klasPermanenTU && $admin){
            $arsipTU_Permanen = Arsip::firstOrCreate(['uraian_berkas' => 'Dokumen Rencana Strategis BBPOM 2020-2024'], [ 
                'klasifikasi_surat_id' => $klasPermanenTU->id, 'divisi_id' => $divisiTU->id, 'created_by' => $admin->id, 
                'bentuk_naskah_id' => $bentukNaskahLaporan->id, 'tanggal_arsip' => '2020-02-10', 'kurun_waktu' => '2020-2024', 
                'status' => 'Permanen', 'jumlah_berkas' => '1', 'tingkat_perkembangan' => 'Asli', 'lokasi_penyimpanan' => 'Lemari Besi A1',
            ]);
            UraianIsiInformasi::firstOrCreate(['arsip_id' => $arsipTU_Permanen->id, 'nomor_item' => 1], ['uraian' => 'Buku Renstra 2020-2024 Final', 'tanggal' => '2020-02-10', 'jumlah_lembar' => 150]);
        }

        // --- 5. BUAT DATA ARSIP UNTUK DIVISI LAIN (AKTIF 1 & INAKTIF 1) ---
        
        // --- INFORMASI DAN KOMUNIKASI (Infokom) ---
        if($klasInfokom && $arsiparisInfokom){
            Arsip::firstOrCreate(['uraian_berkas' => 'Laporan Tata Kelola Infrastruktur TIK 2025'],[
                'klasifikasi_surat_id' => $klasInfokom->id, 'divisi_id' => $divisiInfokom->id, 'created_by' => $arsiparisInfokom->id,
                'tanggal_arsip' => '2025-01-01', 'kurun_waktu' => '2025',
                'status' => 'Aktif', 'jumlah_berkas' => '1', 'tingkat_perkembangan' => 'Asli', 'lokasi_penyimpanan' => 'Rak Info-01',
            ]);
            Arsip::firstOrCreate(['uraian_berkas' => 'Laporan Tata Kelola Infrastruktur TIK 2022'],[
                'klasifikasi_surat_id' => $klasInfokom->id, 'divisi_id' => $divisiInfokom->id, 'created_by' => $arsiparisInfokom->id,
                'tanggal_arsip' => '2022-12-31', 'kurun_waktu' => '2022',
                'status' => 'Inaktif', 'jumlah_berkas' => '1', 'tingkat_perkembangan' => 'Asli', 'lokasi_penyimpanan' => 'Rak Info-02',
            ]);
        }

        // --- PENGUJIAN ---
        if($klasPengujian && $arsiparisPengujian){
            Arsip::firstOrCreate(['uraian_berkas' => 'Laporan Pengujian Sampel Kosmetik Triwulan 1 2025'], [
                'klasifikasi_surat_id' => $klasPengujian->id, 'divisi_id' => $divisiPengujian->id, 'created_by' => $arsiparisPengujian->id,
                'bentuk_naskah_id' => $bentukNaskahLaporan->id, 'tanggal_arsip' => '2025-03-30', 'kurun_waktu' => '2025',
                'status' => 'Aktif', 'jumlah_berkas' => '5', 'tingkat_perkembangan' => 'Asli', 'lokasi_penyimpanan' => 'Rak Uji-01',
            ]);
            Arsip::firstOrCreate(['uraian_berkas' => 'Laporan Uji Banding Inter-Laboratorium 2022'],[
                'klasifikasi_surat_id' => $klasPengujian->id, 'divisi_id' => $divisiPengujian->id, 'created_by' => $arsiparisPengujian->id,
                'tanggal_arsip' => '2022-06-01', 'kurun_waktu' => '2022',
                'status' => 'Inaktif', 'jumlah_berkas' => '3', 'tingkat_perkembangan' => 'Asli', 'lokasi_penyimpanan' => 'Rak Uji-02',
            ]);
        }
        
        // --- PEMERIKSAAN ---
        if($klasPemeriksaan && $arsiparisPemeriksaan){
            Arsip::firstOrCreate(['uraian_berkas' => 'Inspeksi Sarana Produksi ONPPZA 2025'], [
                'klasifikasi_surat_id' => $klasPemeriksaan->id, 'divisi_id' => $divisiPemeriksaan->id, 'created_by' => $arsiparisPemeriksaan->id,
                'bentuk_naskah_id' => $bentukNaskahLaporan->id, 'tanggal_arsip' => '2025-02-01', 'kurun_waktu' => '2025',
                'status' => 'Aktif', 'jumlah_berkas' => '1', 'tingkat_perkembangan' => 'Copy', 'lokasi_penyimpanan' => 'Rak Pem-01',
            ]);
            Arsip::firstOrCreate(['uraian_berkas' => 'Laporan Audit Kepatuhan Sarana 2022'],[
                'klasifikasi_surat_id' => $klasPemeriksaan->id, 'divisi_id' => $divisiPemeriksaan->id, 'created_by' => $arsiparisPemeriksaan->id,
                'tanggal_arsip' => '2022-11-01', 'kurun_waktu' => '2022',
                'status' => 'Inaktif', 'jumlah_berkas' => '1', 'tingkat_perkembangan' => 'Copy', 'lokasi_penyimpanan' => 'Rak Pem-02',
            ]);
        }
        
        // --- PENINDAKAN ---
        if($klasPenindakan && $arsiparisPenindakan){
            Arsip::firstOrCreate(['uraian_berkas' => 'Data Informasi Intelijen Terbaru 2025'], [
                'klasifikasi_surat_id' => $klasPenindakan->id, 'divisi_id' => $divisiPenindakan->id, 'created_by' => $arsiparisPenindakan->id,
                'tanggal_arsip' => '2025-04-15', 'kurun_waktu' => '2025',
                'status' => 'Aktif', 'jumlah_berkas' => '1', 'tingkat_perkembangan' => 'Asli', 'lokasi_penyimpanan' => 'Gudang-07',
            ]);
            Arsip::firstOrCreate(['uraian_berkas' => 'Berkas Perkara (P21) Kasus Obat Palsu 2018'], [
                'klasifikasi_surat_id' => $klasPenindakan->id, 'divisi_id' => $divisiPenindakan->id, 'created_by' => $arsiparisPenindakan->id,
                'tanggal_arsip' => '2018-12-31', 'kurun_waktu' => '2018',
                'status' => 'Inaktif', 'jumlah_berkas' => '5', 'tingkat_perkembangan' => 'Copy', 'lokasi_penyimpanan' => 'Gudang-06',
            ]);
        }

        $this->command->info('Dummy data (termasuk Bentuk Naskah & Link Terkait) berhasil di-seed.');
    }
}