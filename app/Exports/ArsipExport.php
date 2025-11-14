<?php

namespace App\Exports;

use App\Models\Arsip;
use App\Models\Divisi;
use App\Scopes\DivisiScope;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Menangani ekspor data Arsip ke format Excel.
 * Termasuk KOP surat, judul, dan daftar arsip yang kompleks.
 */
class ArsipExport implements WithEvents, WithColumnWidths
{
    protected $search;
    protected $status;
    protected $divisiIdFilter;
    protected $tahun;
    protected $periode;
    protected $userDivisiId;
    
    protected $arsipDipindahStatus = 'Dipindahkan ke tata usaha';
    protected $tataUsahaDivisiId = 2;

    private const TABLE_HEADER_ROW = 10;
    private const DATA_START_ROW = 13;

    public function __construct($search, $status, $divisiIdFilter, $tahun, $periode, $userDivisiId)
    {
        $this->search = $search;
        $this->status = $status;
        $this->divisiIdFilter = $divisiIdFilter;
        $this->tahun = $tahun;
        $this->periode = $periode;
        $this->userDivisiId = $userDivisiId;
    }

    /**
     * Menentukan lebar kolom kustom.
     */
    public function columnWidths(): array
    {
        return [
            'A' => 8,  // NOMOR BERKAS (ex-No)
            'B' => 20, // KODE KLASIFIKASI (ex-C)
            'C' => 40, // URAIAN BERKAS (ex-D)
            'D' => 15, // KURUN WAKTU (ex-E)
            'E' => 20, // JUMLAH (ex-F)
            'F' => 10, // NOMOR ITEM (ex-G)
            'G' => 35, // URAIAN INFORMASI (ex-H)
            'H' => 15, // JUMLAH (ex-I)
            'I' => 15, // TANGGAL (ex-J)
            'J' => 20, // TINGKAT PERKEMBANGAN (ex-K)
            'K' => 20, // LOKASI (ex-L)
            'L' => 10, // BIASA (ex-M)
            'M' => 10, // TERBATAS (ex-N)
            'N' => 10, // RAHASIA (ex-O)
            'O' => 10, // SANGAT RAHASIA (ex-P)
            'P' => 10, // AKTIF (ex-Q)
            'Q' => 10, // INAKTIF (ex-R)
            'R' => 20, // KETERANGAN (ex-S)
        ];
    }
    
    /**
     * Mendaftarkan event untuk styling (KOP, border, alignment) setelah sheet dibuat.
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                
                $r1 = self::TABLE_HEADER_ROW;
                $r2 = self::TABLE_HEADER_ROW + 1;
                $r3 = self::TABLE_HEADER_ROW + 2;
                $lastColumn = 'R'; // Kolom terakhir sekarang R
                
                // --- (Logika Judul & Metadata Dinamis) ---
                $unitPengelolaNama = 'Semua Unit Pengolah';
                $divisiId = $this->userDivisiId ?: $this->divisiIdFilter;
                if ($divisiId) {
                    $divisi = Divisi::find($divisiId);
                    if ($divisi) $unitPengelolaNama = $divisi->nama;
                }
                $tahunText = 'SEMUA TAHUN';
                if ($this->tahun && $this->tahun !== 'semua') {
                    $tahunText = "TAHUN {$this->tahun}";
                    if ($this->periode !== 'tahunan') {
                        $periodeText = strtoupper($this->periode);
                        $tahunText = "{$periodeText} {$this->tahun}";
                    }
                }
                $judulLaporan = "DAFTAR ARSIP {$tahunText}";
                
                $sheet->mergeCells("A1:{$lastColumn}1")->setCellValue('A1', $judulLaporan);
                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
                $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $metadata = [
                    3 => ['Label' => 'Pengelola Arsip', 'Nilai' => 'Balai Besar POM di Banjarbaru'],
                    4 => ['Label' => 'Unit Kerja Unit Pengelola', 'Nilai' => $unitPengelolaNama],
                    5 => ['Label' => 'Nama Pimpinan Unit Kerja Unit Pengelola', 'Nilai' => ''],
                    6 => ['Label' => 'Jabatan Pimpinan Unit Kerja Unit Pengelola', 'Nilai' => ''],
                    7 => ['Label' => 'Alamat Unit Kerja Unit Pengelola', 'Nilai' => 'Jl. Bina Praja Utara, Kel. Palam, Kec. Cempaka, Kota Banjarbaru'],
                ];
                
                foreach ($metadata as $row => $data) {
                    $sheet->mergeCells("A{$row}:C{$row}")->setCellValue("A{$row}", $data['Label'])->getStyle("A{$row}")->getFont()->setBold(true);
                    $sheet->setCellValue("D{$row}", ':')->getStyle("D{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheet->mergeCells("E{$row}:{$lastColumn}{$row}")->setCellValue("E{$row}", $data['Nilai']); // Merge sampai R
                    if ($row === 5 || $row === 6) { $sheet->getStyle("E{$row}:{$lastColumn}{$row}")->getBorders()->getBottom()->setBorderStyle(Border::BORDER_HAIR); }
                }
                
                // --- (Header Bertingkat Disesuaikan) ---
                $sheet->mergeCells("A{$r1}:E{$r1}")->setCellValue("A{$r1}", 'DAFTAR BERKAS'); // A-E
                $sheet->mergeCells("F{$r1}:R{$r1}")->setCellValue("F{$r1}", 'DAFTAR BERKAS'); // F-R
                
                $sheet->getStyle("A{$r1}:E{$r1}")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF2F5597'); // Biru
                $sheet->getStyle("F{$r1}:R{$r1}")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF548235'); // Hijau
                $sheet->getStyle("A{$r1}:R{$r1}")->getFont()->setColor(new Color(Color::COLOR_WHITE))->setBold(true)->setSize(12);
                
                $sheet->mergeCells("A{$r2}:A{$r3}")->setCellValue("A{$r2}", "NOMOR BERKAS"); // Kolom A
                $sheet->mergeCells("B{$r2}:B{$r3}")->setCellValue("B{$r2}", "KODE\nKLASIFIKASI"); // Kolom B
                $sheet->mergeCells("C{$r2}:C{$r3}")->setCellValue("C{$r2}", 'URAIAN BERKAS'); // Kolom C
                $sheet->mergeCells("D{$r2}:D{$r3}")->setCellValue("D{$r2}", "KURUN\nWAKTU"); // Kolom D
                $sheet->mergeCells("E{$r2}:E{$r3}")->setCellValue("E{$r2}", 'JUMLAH'); // Kolom E
                $sheet->mergeCells("F{$r2}:F{$r3}")->setCellValue("F{$r2}", "NOMOR\nITEM"); // Kolom F
                $sheet->mergeCells("G{$r2}:G{$r3}")->setCellValue("G{$r2}", 'URAIAN INFORMASI'); // Kolom G
                $sheet->mergeCells("H{$r2}:H{$r3}")->setCellValue("H{$r2}", 'JUMLAH'); // Kolom H
                $sheet->mergeCells("I{$r2}:I{$r3}")->setCellValue("I{$r2}", 'TANGGAL'); // Kolom I
                $sheet->mergeCells("J{$r2}:J{$r3}")->setCellValue("J{$r2}", "TINGKAT\nPERKEMBANGAN"); // Kolom J
                $sheet->mergeCells("K{$r2}:K{$r3}")->setCellValue("K{$r2}", 'LOKASI'); // Kolom K
                
                $sheet->mergeCells("L{$r2}:O{$r2}")->setCellValue("L{$r2}", 'JENIS ARSIP'); // L-O
                $sheet->setCellValue("L{$r3}", 'BIASA')->setCellValue("M{$r3}", 'TERBATAS')->setCellValue("N{$r3}", 'RAHASIA')->setCellValue("O{$r3}", "SANGAT\nRAHASIA");
                
                $sheet->mergeCells("P{$r2}:Q{$r2}")->setCellValue("P{$r2}", 'MASA RETENSI'); // P-Q
                $sheet->setCellValue("P{$r3}", 'AKTIF')->setCellValue("Q{$r3}", 'INAKTIF');
                $sheet->mergeCells("R{$r2}:R{$r3}")->setCellValue("R{$r2}", 'KETERANGAN'); // Kolom R
                
                $headerRange = "A{$r2}:R{$r3}"; // Range sampai R
                $sheet->getStyle($headerRange)->getAlignment()->setWrapText(true);   

                $styleArrayBiru = [ 'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF7098DA']], 'font' => ['color' => ['argb' => Color::COLOR_WHITE], 'bold' => true], 'alignment' => ['vertical' => Alignment::VERTICAL_CENTER, 'horizontal' => Alignment::HORIZONTAL_CENTER] ];
                $styleArrayHijau = [ 'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF70AD47']], 'font' => ['color' => ['argb' => Color::COLOR_WHITE], 'bold' => true], 'alignment' => ['vertical' => Alignment::VERTICAL_CENTER, 'horizontal' => Alignment::HORIZONTAL_CENTER] ];
                
                $sheet->getStyle("A{$r2}:E{$r3}")->applyFromArray($styleArrayBiru); // Range A-E
                $sheet->getStyle("F{$r2}:R{$r3}")->applyFromArray($styleArrayHijau); // Range F-R
                
                // --- (Pengambilan Data) ---
                $query = Arsip::with([
                            'klasifikasiSurat' => fn($q) => $q->withTrashed(), 
                            'uraianIsiInformasi', 
                            'divisi',
                        ])
                       ->when($this->search, function ($q) {
                            $q->where('uraian_berkas', 'like', '%' . $this->search . '%')
                              ->orWhereHas('klasifikasiSurat', fn($qs) => $qs->where('kode_klasifikasi', 'like', '%' . $this->search . '%')->withTrashed());
                       });

                if ($this->userDivisiId) { 
                    if ($this->status === $this->arsipDipindahStatus) {
                        $query->withoutGlobalScope(DivisiScope::class);
                        $query->where('divisi_id', $this->tataUsahaDivisiId);
                        $query->where('created_by', $this->userDivisiId); 
                    } else {
                        $query->when($this->status, fn($q) => $q->where('status', $this->status));
                    }
                } else {
                    $query->when($this->divisiIdFilter, fn($q) => $q->where('divisi_id', $this->divisiIdFilter));
                    $query->when($this->status, fn($q) => $q->where('status', $this->status));
                }

                if ($this->tahun && $this->tahun !== 'semua') {
                     if ($this->periode !== 'tahunan') {
                         $startMonth = 1; $endMonth = 3;
                         if ($this->periode === 'tw2') { $startMonth = 4; $endMonth = 6; }
                         elseif ($this->periode === 'tw3') { $startMonth = 7; $endMonth = 9; }
                         elseif ($this->periode === 'tw4') { $startMonth = 10; $endMonth = 12; }
                         $startDate = Carbon::create($this->tahun, $startMonth, 1)->startOfMonth();
                         $endDate = Carbon::create($this->tahun, $endMonth, 1)->endOfMonth();
                         $query->whereBetween('tanggal_arsip', [$startDate, $endDate]);
                     } else {
                         $query->whereYear('tanggal_arsip', $this->tahun);
                     }
                }
                
                $arsips = $query->orderBy('divisi_id', 'asc')
                                ->orderBy(DB::raw('YEAR(tanggal_arsip)'), 'asc') 
                                ->get();
                
                // --- (Penulisan Data ke Sheet) ---
                $startRow = self::DATA_START_ROW;
                $rowNumber = 1;
                foreach ($arsips as $arsip) {
                    $itemCount = $arsip->uraianIsiInformasi->count() > 0 ? $arsip->uraianIsiInformasi->count() : 1;
                    $endRow = $startRow + $itemCount - 1;

                    if ($itemCount > 1) {
                        $sheet->mergeCells("A{$startRow}:A{$endRow}") // Nomor Berkas
                              ->mergeCells("B{$startRow}:B{$endRow}") // Kode
                              ->mergeCells("C{$startRow}:C{$endRow}") // Uraian Berkas
                              ->mergeCells("D{$startRow}:D{$endRow}") // Kurun
                              ->mergeCells("E{$startRow}:E{$endRow}") // Jumlah
                              ->mergeCells("J{$startRow}:J{$endRow}") // Tingkat Perkembangan
                              ->mergeCells("K{$startRow}:K{$endRow}") // Lokasi
                              ->mergeCells("L{$startRow}:L{$endRow}") // Biasa
                              ->mergeCells("M{$startRow}:M{$endRow}") // Terbatas
                              ->mergeCells("N{$startRow}:N{$endRow}") // Rahasia
                              ->mergeCells("O{$startRow}:O{$endRow}") // S. Rahasia
                              ->mergeCells("P{$startRow}:P{$endRow}") // Aktif
                              ->mergeCells("Q{$startRow}:Q{$endRow}") // Inaktif
                              ->mergeCells("R{$startRow}:R{$endRow}"); // Keterangan
                    }
                    
                    $sheet->setCellValue("A{$startRow}", $rowNumber++);
                    $sheet->setCellValue("B{$startRow}", $arsip->klasifikasiSurat?->kode_klasifikasi);
                    $sheet->setCellValue("C{$startRow}", $arsip->uraian_berkas);
                    $sheet->setCellValue("D{$startRow}", $arsip->kurun_waktu);
                    $sheet->setCellValue("E{$startRow}", $arsip->jumlah_berkas);
                    $sheet->setCellValue("J{$startRow}", $arsip->tingkat_perkembangan);
                    $sheet->setCellValue("K{$startRow}", $arsip->lokasi_penyimpanan);

                    switch ($arsip->klasifikasiSurat?->klasifikasi_keamanan) {
                        case 'Biasa/Terbuka': $sheet->setCellValue("L{$startRow}", '√'); break;
                        case 'Terbatas': $sheet->setCellValue("M{$startRow}", '√'); break;
                        case 'Rahasia': $sheet->setCellValue("N{$startRow}", '√'); break;
                        case 'Sangat Rahasia': $sheet->setCellValue("O{$startRow}", '√'); break;
                    }
                    
                    $sheet->setCellValue("P{$startRow}", $arsip->klasifikasiSurat?->masa_aktif);
                    $sheet->setCellValue("Q{$startRow}", $arsip->klasifikasiSurat?->masa_inaktif);
                    $sheet->setCellValue("R{$startRow}", $arsip->keterangan_fisik);
                    
                    if ($arsip->uraianIsiInformasi->count() > 0) {
                        $uraianRow = $startRow;
                        foreach($arsip->uraianIsiInformasi as $uraian) {
                            $sheet->setCellValue("F{$uraianRow}", $uraian->nomor_item)
                                  ->setCellValue("G{$uraianRow}", $uraian->uraian)
                                  ->setCellValue("H{$uraianRow}", $uraian->jumlah_lembar)
                                  ->setCellValue("I{$uraianRow}", $uraian->tanggal ? Carbon::parse($uraian->tanggal)->format('d/m/Y') : '');
                            $uraianRow++;
                        }
                    } else {
                        $sheet->setCellValue("F{$startRow}", '')->setCellValue("G{$startRow}", '')->setCellValue("H{$startRow}", '')->setCellValue("I{$startRow}", '');
                    }
                    
                    $startRow = $endRow + 1;
                }

                // --- (Styling Final) ---
                $tableEndRow = $startRow - 1;
                if ($tableEndRow >= self::DATA_START_ROW) {
                    $tableRange = "A{$r1}:R{$tableEndRow}";
                    $sheet->getStyle($tableRange)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                    $sheet->getStyle($tableRange)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    
                    $sheet->getStyle("C".self::DATA_START_ROW.":C".$tableEndRow)->getAlignment()->setWrapText(true)->setHorizontal(Alignment::HORIZONTAL_LEFT);
                    $sheet->getStyle("G".self::DATA_START_ROW.":G".$tableEndRow)->getAlignment()->setWrapText(true)->setHorizontal(Alignment::HORIZONTAL_LEFT);
                    
                    $sheet->getStyle($tableRange)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
                }
            },
        ];
    }
}