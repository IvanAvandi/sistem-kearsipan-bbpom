<?php

namespace App\Imports;

use App\Models\KlasifikasiSurat;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Facades\Log; 

class KlasifikasiImport implements ToCollection, WithHeadingRow, WithValidation
{
    private $created = 0;
    private $updated = 0;
    private $unchanged = 0;
    private $skipped = 0; // Tetap simpan skipped jika ada validasi lain
    private $skippedRows = []; // Tetap simpan skipped jika ada validasi lain

    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) // Tambahkan $index untuk nomor baris
        {
            $data = [
                'nama_klasifikasi' => $row['nama_klasifikasi'] ?? null,
                'masa_aktif' => $row['masa_aktif'] ?? null,
                'masa_inaktif' => $row['masa_inaktif'] ?? null,
                'status_akhir' => $row['status_akhir'] ?? null,
                'klasifikasi_keamanan' => $row['klasifikasi_keamanan'] ?? null,
                'hak_akses' => $row['hak_akses'] ?? null,
                'unit_pengolah' => $row['unit_pengolah'] ?? null, 
            ];

            // Validasi manual sederhana (contoh: pastikan kolom wajib ada di row)
             if (empty($row['kode_klasifikasi']) || empty($data['nama_klasifikasi'])) {
                 $this->skipped++;
                 $errorMessage = "Kode atau Nama Klasifikasi kosong.";
                 $this->skippedRows[] = "Baris " . ($index + 2) . ": " . $errorMessage; // +2 karena heading row dan 0-based index
                 Log::warning("KlasifikasiImport: " . $errorMessage . " Melewati baris " . ($index + 2));
                 continue;
             }


            // Logika update/create
            $klasifikasi = KlasifikasiSurat::where('kode_klasifikasi', $row['kode_klasifikasi'])->first();

            if ($klasifikasi) {
                $isDirty = false;
                foreach ($data as $key => $value) {
                    if ($klasifikasi->{$key} != $value) {
                        $isDirty = true;
                        break;
                    }
                }

                if ($isDirty) {
                    $klasifikasi->update($data);
                    $this->updated++;
                } else {
                    $this->unchanged++;
                }
            } else {
                $data['kode_klasifikasi'] = $row['kode_klasifikasi'];
                KlasifikasiSurat::create($data);
                $this->created++;
            }
        }

        // Tampilkan pesan skip jika ada
        if ($this->skipped > 0) {
            Log::warning("KlasifikasiImport selesai: " . $this->skipped . " baris di-skip.");
            foreach ($this->skippedRows as $errorRow) {
                Log::warning(" - " . $errorRow);
            }
             // Anda bisa menampilkan ini di session flash message juga jika perlu
             // session()->flash('warning', $this->skipped . " baris di-skip saat impor. Cek log untuk detail.");
        }
    }

    public function getCreatedCount(): int { return $this->created; }
    public function getUpdatedCount(): int { return $this->updated; }
    public function getUnchangedCount(): int { return $this->unchanged; }
    public function getSkippedCount(): int { return $this->skipped; }
    public function getSkippedRows(): array { return $this->skippedRows; }

    // Aturan validasi
    public function rules(): array
    {
        return [
            'kode_klasifikasi' => 'required|string',
            'nama_klasifikasi' => 'required|string',
            'masa_aktif' => 'required|integer|min:0',
            'masa_inaktif' => 'required|integer|min:0',
            'status_akhir' => 'required|in:Musnah,Permanen',
            'klasifikasi_keamanan' => 'required|in:Biasa/Terbuka,Terbatas,Rahasia,Sangat Rahasia', 
            'hak_akses' => 'nullable|string',
            'unit_pengolah' => 'nullable|string',
        ];
    }

     // Pesan error custom (opsional)
     public function customValidationMessages()
     {
         return [
             'kode_klasifikasi.required' => 'Kolom kode_klasifikasi wajib diisi.',
             'nama_klasifikasi.required' => 'Kolom nama_klasifikasi wajib diisi.',
             'masa_aktif.required' => 'Kolom masa_aktif wajib diisi.',
             'masa_aktif.integer' => 'Kolom masa_aktif harus angka.',
             'masa_inaktif.required' => 'Kolom masa_inaktif wajib diisi.',
             'masa_inaktif.integer' => 'Kolom masa_inaktif harus angka.',
             'status_akhir.required' => 'Kolom status_akhir wajib diisi.',
             'status_akhir.in' => 'Kolom status_akhir harus Musnah atau Permanen.',
             'klasifikasi_keamanan.required' => 'Kolom klasifikasi_keamanan wajib diisi.',
             'klasifikasi_keamanan.in' => 'Nilai klasifikasi_keamanan tidak valid.',
         ];
     }
}