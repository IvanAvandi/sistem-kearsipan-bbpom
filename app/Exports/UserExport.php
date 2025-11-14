<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

/**
 * Menangani ekspor data Pengguna ke format Excel.
 */
class UserExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $users;
    protected static $number = 0;

    /**
     * @param Collection $users Koleksi data pengguna yang sudah difilter.
     */
    public function __construct(Collection $users)
    {
        $this->users = $users;
        self::$number = 0;
    }

    /**
     * Mengambil koleksi data pengguna.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->users;
    }

    /**
     * Menentukan header kolom tabel.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'NO',
            'NAMA PENGGUNA',
            'EMAIL',
            'UNIT PENGOLAH (BIDANG)',
            'ROLE KEARSIPAN',
            'STATUS AKUN',
        ];
    }

    /**
     * Memetakan data dari model User ke kolom Excel.
     *
     * @param mixed $user Model User
     * @return array
     */
    public function map($user): array
    {
        self::$number++;
        
        $unitPengolah = $user->divisi ? ($user->divisi->nama === 'Informasi dan Komunikasi' ? 'Infokom' : $user->divisi->nama) : '(Tidak ada Unit Pengolah)';
        $statusAkun = ($user->aktif == 'Y') ? 'Aktif' : 'Tidak Aktif';

        return [
            self::$number,
            $user->name,
            $user->email,
            $unitPengolah,
            $user->role,
            $statusAkun,
        ];
    }

    /**
     * Menerapkan style (styling) pada sheet Excel.
     *
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        // Style untuk Header (Baris 1)
        $sheet->getStyle('A1:F1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['argb' => 'FFFFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF4F46E5'],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ]
        ]);

        // Style untuk Border
        $lastRow = $this->users->count() + 1; // +1 untuk header
        $sheet->getStyle("A1:F{$lastRow}")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        // Alignment untuk data
        $sheet->getStyle("A2:A{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("D2:F{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("B2:C{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

        return [];
    }
}