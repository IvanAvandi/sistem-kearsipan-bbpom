<?php
namespace App\Http\Livewire\Admin; 

use Livewire\Component;
use App\Models\KlasifikasiSurat;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\KlasifikasiImport;
use App\Exports\KlasifikasiExport;

class KlasifikasiTable extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $search = '';
    public $file_import;
    public $showImportModal = false;

    protected $paginationTheme = 'tailwind';
    
    public function updatingSearch() { $this->resetPage(); }

    public function delete($id)
    {
        $item = KlasifikasiSurat::find($id);
        
        if ($item) {
            // Langsung panggil delete(), ini akan mengisi kolom deleted_at
            $item->delete(); 
            session()->flash('success', 'Data berhasil dihapus.'); 
        } else {
             session()->flash('error', 'Data tidak ditemukan.');
        }
    }

    public function export()
    {
        return Excel::download(new KlasifikasiExport, 'data-master-klasifikasi.xlsx');
    }

    public function openImportModal()
    {
        $this->resetErrorBag(); 
        $this->reset('file_import');
        $this->showImportModal = true;
    }
    
    public function import()
    {
        $this->validate([
            'file_import' => 'required|mimes:xlsx,csv'
        ]);

        try {
            $import = new KlasifikasiImport; 
            Excel::import($import, $this->file_import);
            
            $created = $import->getCreatedCount();
            $updated = $import->getUpdatedCount();
            $unchanged = $import->getUnchangedCount();
            $skipped = $import->getSkippedCount(); 

            $this->showImportModal = false;
            
            $message = "Impor berhasil! {$created} data ditambahkan, {$updated} data diperbarui, {$unchanged} data tidak berubah.";
            if ($skipped > 0) {
                 $message .= " {$skipped} baris dilewati karena Divisi tidak cocok (cek log/pesan sebelumnya).";
            }
             session()->flash('success', $message);

        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
             $failures = $e->failures();
             session()->flash('import_errors', $failures);
        } catch (\Exception $e) { 
            session()->flash('error', 'Terjadi kesalahan saat proses impor: ' . $e->getMessage());
             $this->showImportModal = false; 
        }
    }

    public function render()
    {
        $items = KlasifikasiSurat::where(function($query) { 
                $query->where('kode_klasifikasi', 'like', '%'.$this->search.'%')
                      ->orWhere('nama_klasifikasi', 'like', '%'.$this->search.'%');
            })
            ->orderBy('kode_klasifikasi', 'asc')
            ->paginate(10);
            
        return view('livewire.admin.klasifikasi-table', compact('items')); 
    }
}