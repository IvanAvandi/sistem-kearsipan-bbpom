<?php

namespace App\Exports;

use App\Models\UsulanPemusnahan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;
use Carbon\Carbon;

/**
 * Menangani ekspor data Usulan Pemusnahan ke format Excel.
 * Termasuk KOP surat, judul, dan daftar arsip.
 */
class UsulMusnahExport implements 
    FromCollection, 
    WithHeadings, 
    WithMapping, 
    WithEvents, 
    ShouldAutoSize,
    WithCustomStartCell 
{
    protected $usulan;
    protected static $number = 0;

    /**
     * @param UsulanPemusnahan $usulan Data usulan yang akan diekspor.
     */
    public function __construct(UsulanPemusnahan $usulan)
    {
        $this->usulan = $usulan->load('arsips.klasifikasiSurat'); 
        self::$number = 0; 
    }

    /**
     * Menentukan sel dimulainya tabel data.
     *
     * @return string
     */
    public function startCell(): string
    {
        return 'A11'; 
    }

    /**
     * Mengambil koleksi data arsip untuk diekspor.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->usulan->arsips;
    }

    /**
     * Menentukan header kolom tabel.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'NOMOR' . "\n" . 'BERKAS',
            'KODE' . "\n" . 'KLASIFIKASI', 
            'URAIAN',
            'KURUN' . "\n" . 'WAKTU',
            'TINGKAT' . "\n" . 'PERKEMBANGAN',
            'JUMLAH' . "\n" . 'BERKAS', 
            'KETERANGAN' . "\n" . 'STATUS',
        ];
    }

    /**
     * Memetakan data dari model Arsip ke kolom Excel.
     *
     * @param mixed $arsip Model Arsip
     * @return array
     */
    public function map($arsip): array
    {
        self::$number++;
        return [
            self::$number,
            $arsip->klasifikasiSurat->kode_klasifikasi ?? '',
            $arsip->uraian_berkas,
            Carbon::parse($arsip->tanggal_arsip)->format('Y'), 
            $arsip->tingkat_perkembangan,
            $arsip->jumlah_berkas . ' ' . ($arsip->satuan_berkas ?? 'Berkas'),
            $arsip->klasifikasiSurat?->status_akhir ?? 'N/A', 
        ];
    }

    /**
     * Mendaftarkan event untuk styling (KOP, border, alignment) setelah sheet dibuat.
     *
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $lastRow = $sheet->getHighestDataRow(); 
                $lastColumn = 'G'; 
                $headerRow = 11; 
                $rightmostColumnKop = 'G'; 

                // 1. KOP SURAT
                $sheet->setCellValue('E1', 'LAMPIRAN');
                $sheet->mergeCells('E1:G1'); 
                $sheet->getStyle('E1:G1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT); 
                $sheet->getStyle('E1:G1')->getFont()->setSize(12)->setBold(true); 
                
                $sheet->setCellValue('E2', 'Surat Dinas Kepala Balai Besar Pengawas Obat dan Makanan');
                $sheet->setCellValue('E3', 'di Banjarbaru Permohonan Penilaian Arsip Usul Musnah 2025'); 
                $sheet->mergeCells('E2:' . $rightmostColumnKop . '2'); 
                $sheet->mergeCells('E3:' . $rightmostColumnKop . '3'); 
                $sheet->setCellValue('E4', 'Nomor');
                $sheet->setCellValue('E5', 'Tanggal');
                $sheet->setCellValue('F4', ':');
                $sheet->setCellValue('F5', ':');
                $sheet->mergeCells('F4:G4'); 
                $sheet->mergeCells('F5:G5'); 
                $kopRange = 'E2:G5';
                $sheet->getStyle($kopRange)->getFont()->setSize(9); 
                $sheet->getStyle('E2:E5')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle('F4:F5')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

                // 2. JUDUL UTAMA
                $tahunUsulan = Carbon::parse($this->usulan->tanggal_usulan)->format('Y');
                $startTitleRow = 7;
                $sheet->setCellValue('A' . $startTitleRow, 'DAFTAR ARSIP USUL MUSNAH');
                $sheet->setCellValue('A' . ($startTitleRow + 1), 'BALAI BESAR POM DI BANJARBARU'); 
                $sheet->setCellValue('A' . ($startTitleRow + 2), 'TAHUN ' . $tahunUsulan);
                $titleRange = 'A' . $startTitleRow . ':' . $lastColumn . ($startTitleRow + 2);
                $sheet->mergeCells('A' . $startTitleRow . ':' . $lastColumn . $startTitleRow);
                $sheet->mergeCells('A' . ($startTitleRow + 1) . ':' . $lastColumn . ($startTitleRow + 1));
                $sheet->mergeCells('A' . ($startTitleRow + 2) . ':' . $lastColumn . ($startTitleRow + 2));
                $sheet->getStyle($titleRange)->getFont()->setBold(true)->setSize(14); 
                $sheet->getStyle($titleRange)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                
                // 3. STYLE HEADER TABEL
                $headerRange = 'A' . $headerRow . ':' . $lastColumn . $headerRow;
                $sheet->getStyle($headerRange)->getAlignment()->setWrapText(true);
                $sheet->getStyle($headerRange)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getRowDimension($headerRow)->setRowHeight(30); 
                $sheet->getStyle($headerRange)->getFont()->setBold(true);
                $sheet->getStyle($headerRange)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle($headerRange)->getFill()
                      ->setFillType(Fill::FILL_SOLID)
                      ->getStartColor()->setARGB('C4C4C4'); 
                
                // 4. BORDER PADA SEMUA DATA
                $fullRange = 'A' . $headerRow . ':' . $lastColumn . $lastRow;
                $sheet->getStyle($fullRange)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

                // 5. ALIGNMENT DATA ARSIP
                $dataStartRow = $headerRow + 1;
                $centerColumns = ['A', 'B', 'D', 'E', 'F', 'G'];
                foreach ($centerColumns as $col) {
                    $sheet->getStyle($col . $dataStartRow . ':' . $col . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                }
                $sheet->getStyle('C' . $dataStartRow . ':C' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT)->setWrapText(true);
                
                // 6. PENANDA TANGAN BAWAH
                $signerRowStart = max(15, $lastRow + 3);
                $currentRow = $signerRowStart;

                $sheet->setCellValue('E' . $currentRow, 'Pimpinan Unit Kearsipan II');
                $sheet->mergeCells('E' . $currentRow . ':G' . $currentRow); 
                $currentRow++;

                $jabatanSpesifik = 'Kepala Bagian Tata Usaha,';

                $sheet->setCellValue('E' . $currentRow, $jabatanSpesifik);
                $sheet->mergeCells('E' . $currentRow . ':G' . $currentRow); 
                $currentRow++;

                $sheet->setCellValue('E' . $currentRow, 'Balai Besar Pengawas Obat dan Makanan'); 
                $sheet->mergeCells('E' . $currentRow . ':G' . $currentRow); 
                $currentRow++;
                
                $sheet->setCellValue('E' . $currentRow, 'di Banjarbaru,'); 
                $sheet->mergeCells('E' . $currentRow . ':G' . $currentRow); 

                $nameRow = $currentRow + 6; 
                
                $sheet->setCellValue('E' . $nameRow, '(......................)'); 
                $sheet->mergeCells('E' . $nameRow . ':G' . $nameRow); 
                
                $signerRange = 'E' . $signerRowStart . ':G' . $nameRow;
                $sheet->getStyle($signerRange)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('E' . $nameRow)->getFont()->setUnderline(false)->setBold(true);
                
                // 7. Lebar Kolom
                $sheet->getColumnDimension('A')->setWidth(8); 
                $sheet->getColumnDimension('B')->setWidth(18); 
                $sheet->getColumnDimension('C')->setWidth(55); 
                $sheet->getColumnDimension('D')->setWidth(10); 
                $sheet->getColumnDimension('E')->setWidth(18); 
                $sheet->getColumnDimension('F')->setWidth(15); 
                $sheet->getColumnDimension('G')->setWidth(15); 
            },
        ];
    }
}