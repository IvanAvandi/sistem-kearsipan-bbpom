<?php
namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Template;

class PusatTemplate extends Component
{
    public $search = '';
    public $kategori = '';

    public function render()
    {
        $query = Template::query();
        if ($this->search) {
            $query->where('nama_template', 'like', '%'.$this->search.'%')
                  ->orWhere('deskripsi', 'like', '%'.$this->search.'%');
        }
        if ($this->kategori) {
            $query->where('kategori', $this->kategori);
        }
        $templates = $query->orderBy('nama_template')->get();
        $kategoriList = Template::select('kategori')->distinct()->orderBy('kategori')->get();

        return view('livewire.pusat-template', compact('templates', 'kategoriList'));
    }
}