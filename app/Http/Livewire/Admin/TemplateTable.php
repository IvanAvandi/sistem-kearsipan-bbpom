<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Template;
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination;

class TemplateTable extends Component
{
    use WithPagination;

    public $search = '';
    protected $paginationTheme = 'tailwind';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        $item = Template::find($id);
        
        // Hapus file dari storage sebelum menghapus record database
        if ($item->file_path && Storage::disk('public')->exists($item->file_path)) {
            Storage::disk('public')->delete($item->file_path);
        }

        $item->delete();
        session()->flash('success', 'Format berhasil dihapus.');
    }

    public function render()
    {
        $items = Template::where('nama_template', 'like', '%'.$this->search.'%')
            ->orWhere('kategori', 'like', '%'.$this->search.'%')
            ->orderBy('nama_template', 'asc')
            ->paginate(10);

        return view('livewire.admin.template-table', compact('items'));
    }
}