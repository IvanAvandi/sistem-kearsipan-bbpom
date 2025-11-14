<?php

namespace App\Exports;

use App\Models\KlasifikasiSurat;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class KlasifikasiExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    public function collection()
    {
        return KlasifikasiSurat::orderBy('kode_klasifikasi')->get();
    }

    public function headings(): array
    {
        return [
            'kode_klasifikasi',
            'nama_klasifikasi',
            'masa_aktif',
            'masa_inaktif',
            'status_akhir',
            'klasifikasi_keamanan',
            'hak_akses',
            'unit_pengolah',
        ];
    }

    public function map($klasifikasi): array
    {
        return [
            $klasifikasi->kode_klasifikasi,
            $klasifikasi->nama_klasifikasi,
            $klasifikasi->masa_aktif,
            $klasifikasi->masa_inaktif,
            $klasifikasi->status_akhir,
            $klasifikasi->klasifikasi_keamanan,
            $klasifikasi->hak_akses,
            $klasifikasi->unit_pengolah,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FF2F5597'],
                ],
            ],
        ];
    }
}