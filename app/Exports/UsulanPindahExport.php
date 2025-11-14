<?php

namespace App\Exports;

use App\Models\UsulanPindah;
use App\Models\Divisi;
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
 * Menangani ekspor data Usulan Pindah ke format Excel.
 * Termasuk KOP surat, judul, dan daftar arsip yang kompleks.
 */
class UsulanPindahExport implements WithEvents, WithColumnWidths
{
    protected $usulan;

    private const TABLE_HEADER_ROW = 10;
    private const DATA_START_ROW = 13;

    /**
     * @param UsulanPindah $usulan Data usulan yang akan diekspor.
     */
    public function __construct(UsulanPindah $usulan)
    {
        $this->usulan = $usulan->load(
            'user.divisi', 
            'arsips.klasifikasiSurat', 
            'arsips.uraianIsiInformasi'
        );
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
            'E' => 20, // JUMLAH (Berkas) (ex-F)
            'F' => 10, // NOMOR ITEM (ex-G)
            'G' => 35, // URAIAN INFORMASI (ex-H)
            'H' => 15, // JUMLAH (Item) (ex-I)
            'I' => 15, // TANGGAL (ex-J)
            'J' => 20, // TINGKAT PERKEMBANGAN (ex-K)
            'K' => 20, // LOKASI (ex-L)
            'L' => 10, // JENIS - BIASA (ex-M)
            'M' => 10, // JENIS - TERBATAS (ex-N)
            'N' => 10, // JENIS - RAHASIA (ex-O)
            'O' => 10, // JENIS - SGT RAHASIA (ex-P)
            'P' => 10, // RETENSI - AKTIF (ex-Q)
            'Q' => 10, // RETENSI - INAKTIF (ex-R)
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
                $lastColumn = 'R';
                
                // --- (Logika Judul & Metadata) ---
                $unitPengelolaNama = $this->usulan->user?->divisi?->nama ?? 'N/A';
                $tahunText = 'SEMUA TAHUN';
                if ($this->usulan->arsips->isNotEmpty()) {
                    $minYear = Carbon::parse($this->usulan->arsips->min('tanggal_arsip'))->format('Y');
                    $maxYear = Carbon::parse($this->usulan->arsips->max('tanggal_arsip'))->format('Y');
                    $tahunText = $minYear;
                    if ($minYear !== $maxYear) {
                        $tahunText = "{$minYear} - {$maxYear}";
                    }
                }
                $judulLaporan = "DAFTAR ARSIP INAKTIF {$tahunText}";
                
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
                    $sheet->mergeCells("E{$row}:{$lastColumn}{$row}")->setCellValue("E{$row}", $data['Nilai']);
                    if ($row === 5 || $row === 6) { $sheet->getStyle("E{$row}:{$lastColumn}{$row}")->getBorders()->getBottom()->setBorderStyle(Border::BORDER_HAIR); }
                }
                
                // --- (Header Tabel) ---
                $sheet->mergeCells("A{$r1}:E{$r1}")->setCellValue("A{$r1}", 'DAFTAR BERKAS'); // A-E
                $sheet->mergeCells("F{$r1}:R{$r1}")->setCellValue("F{$r1}", 'DAFTAR ISI'); // F-R
                $sheet->getStyle("A{$r1}:E{$r1}")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF2F5597'); // Biru
                $sheet->getStyle("F{$r1}:R{$r1}")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF548235'); // Hijau
                $sheet->getStyle("A{$r1}:R{$r1}")->getFont()->setColor(new Color(Color::COLOR_WHITE))->setBold(true)->setSize(12);
                
                $sheet->mergeCells("A{$r2}:A{$r3}")->setCellValue("A{$r2}", "NOMOR BERKAS");
                $sheet->mergeCells("B{$r2}:B{$r3}")->setCellValue("B{$r2}", "KODE\nKLASIFIKASI");
                $sheet->mergeCells("C{$r2}:C{$r3}")->setCellValue("C{$r2}", 'URAIAN BERKAS');
                $sheet->mergeCells("D{$r2}:D{$r3}")->setCellValue("D{$r2}", "KURUN\nWAKTU");
                $sheet->mergeCells("E{$r2}:E{$r3}")->setCellValue("E{$r2}", 'JUMLAH');
                $sheet->mergeCells("F{$r2}:F{$r3}")->setCellValue("F{$r2}", "NOMOR\nITEM");
                $sheet->mergeCells("G{$r2}:G{$r3}")->setCellValue("G{$r2}", 'URAIAN INFORMASI');
                $sheet->mergeCells("H{$r2}:H{$r3}")->setCellValue("H{$r2}", 'JUMLAH');
                $sheet->mergeCells("I{$r2}:I{$r3}")->setCellValue("I{$r2}", 'TANGGAL');
                $sheet->mergeCells("J{$r2}:J{$r3}")->setCellValue("J{$r2}", "TINGKAT\nPERKEMBANGAN");
                $sheet->mergeCells("K{$r2}:K{$r3}")->setCellValue("K{$r2}", 'LOKASI');
                $sheet->mergeCells("L{$r2}:O{$r2}")->setCellValue("L{$r2}", 'JENIS ARSIP');
                $sheet->setCellValue("L{$r3}", 'BIASA')->setCellValue("M{$r3}", 'TERBATAS')->setCellValue("N{$r3}", 'RAHASIA')->setCellValue("O{$r3}", "SANGAT\nRAHASIA");
                $sheet->mergeCells("P{$r2}:Q{$r2}")->setCellValue("P{$r2}", 'MASA RETENSI');
                $sheet->setCellValue("P{$r3}", 'AKTIF')->setCellValue("Q{$r3}", 'INAKTIF');
                $sheet->mergeCells("R{$r2}:R{$r3}")->setCellValue("R{$r2}", 'KETERANGAN');

                $headerRange = "A{$r2}:R{$r3}";
                $sheet->getStyle($headerRange)->getAlignment()->setWrapText(true);
                $styleArrayBiru = [ 'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF7098DA']], 'font' => ['color' => ['argb' => Color::COLOR_WHITE], 'bold' => true], 'alignment' => ['vertical' => Alignment::VERTICAL_CENTER, 'horizontal' => Alignment::HORIZONTAL_CENTER] ];
                $styleArrayHijau = [ 'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF70AD47']], 'font' => ['color' => ['argb' => Color::COLOR_WHITE], 'bold' => true], 'alignment' => ['vertical' => Alignment::VERTICAL_CENTER, 'horizontal' => Alignment::HORIZONTAL_CENTER] ];
                $sheet->getStyle("A{$r2}:E{$r3}")->applyFromArray($styleArrayBiru);
                $sheet->getStyle("F{$r2}:R{$r3}")->applyFromArray($styleArrayHijau);
                
                // --- (Pengambilan Data) ---
                $arsips = $this->usulan->arsips;
                
                // --- (Penulisan Data ke Sheet) ---
                $startRow = self::DATA_START_ROW;
                foreach ($arsips as $index => $arsip) {
                    $itemCount = $arsip->uraianIsiInformasi->count() > 0 ? $arsip->uraianIsiInformasi->count() : 1;
                    $endRow = $startRow + $itemCount - 1;

                    if ($itemCount > 1) {
                        $sheet->mergeCells("A{$startRow}:A{$endRow}");
                        $sheet->mergeCells("B{$startRow}:B{$endRow}");
                        $sheet->mergeCells("C{$startRow}:C{$endRow}");
                        $sheet->mergeCells("D{$startRow}:D{$endRow}");
                        $sheet->mergeCells("E{$startRow}:E{$endRow}");
                        $sheet->mergeCells("J{$startRow}:J{$endRow}");
                        $sheet->mergeCells("K{$startRow}:K{$endRow}");
                        $sheet->mergeCells("L{$startRow}:L{$endRow}");
                        $sheet->mergeCells("M{$startRow}:M{$endRow}");
                        $sheet->mergeCells("N{$startRow}:N{$endRow}");
                        $sheet->mergeCells("O{$startRow}:O{$endRow}");
                        $sheet->mergeCells("P{$startRow}:P{$endRow}");
                        $sheet->mergeCells("Q{$startRow}:Q{$endRow}");
                        $sheet->mergeCells("R{$startRow}:R{$endRow}");
                    }
                    
                    $sheet->setCellValue("A{$startRow}", $index + 1); // NO
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
                        // Fallback jika tidak ada uraian isi
                        $sheet->setCellValue("F{$startRow}", '1') 
                              ->setCellValue("G{$startRow}", $arsip->uraian_berkas)
                              ->setCellValue("H{$startRow}", $arsip->jumlah_berkas)
                              ->setCellValue("I{$startRow}", $arsip->tanggal_arsip ? Carbon::parse($arsip->tanggal_arsip)->format('d/m/Y') : '');
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