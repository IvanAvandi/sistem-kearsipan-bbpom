<?php

namespace App\Http\Livewire\Admin;

use App\Models\UsulanPemusnahan;
use Illuminate\Database\Eloquent\Builder; 
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View; 
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Komponen Livewire untuk mengelola tabel daftar Usulan Pemusnahan.
 *
 * Bertanggung jawab untuk menampilkan, memfilter (berdasarkan status),
 * dan mencari (berdasarkan nomor usulan/nama pembuat) data usulan.
 * Juga menerapkan scoping data berdasarkan role/divisi pengguna.
 *
 * @package App\Http\Livewire\Admin
 */
class UsulanPemusnahanTable extends Component
{
    use WithPagination;

    /**
     * Kata kunci pencarian.
     * Terhubung ke input 'wire:model=search'.
     *
     * @var string
     */
    public $search = '';

    /**
     * Filter status usulan.
     * Terhubung ke select 'wire:model=status'.
     *
     * @var string
     */
    public $status = '';

    /**
     * Menggunakan tema pagination bawaan Tailwind.
     *
     * @var string
     */
    protected $paginationTheme = 'tailwind';

    /**
     * Hook Livewire: Dipanggil setiap kali properti $search diperbarui.
     * Mereset paginasi ke halaman pertama untuk menampilkan hasil pencarian
     * dari awal.
     *
     * @return void
     */
    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    /**
     * Hook Livewire: Dipanggil setiap kali properti $status diperbarui.
     * Mereset paginasi ke halaman pertama untuk menampilkan hasil filter
     * dari awal.
     *
     * @return void
     */
    public function updatingStatus(): void
    {
        $this->resetPage();
    }

    /**
     * Merender tampilan komponen dan mengambil data usulan dengan paginasi.
     *
     * @return \Illuminate\View\View
     */
    public function render(): View
    {
        // Memulai query dasar dengan relasi yang dibutuhkan
        /** @var \Illuminate\Database\Eloquent\Builder $query */
        $query = UsulanPemusnahan::with('user', 'arsips')
            
            // 1. Logika Pencarian
            // Mencari berdasarkan nomor usulan ATAU nama pembuat (via relasi)
            ->where(function (Builder $query) {
                $query->where('nomor_usulan', 'like', '%' . $this->search . '%')
                      ->orWhereHas('user', function (Builder $q) {
                          $q->where('name', 'like', '%' . $this->search . '%');
                      });
            });

        // 2. Scoping Data (Pembatasan Hak Akses)
        // Hanya tampilkan data milik divisi pengguna, kecuali jika pengguna adalah 'Admin'.
        $query->when(Auth::user()->role !== 'Admin', function (Builder $q) {
            $divisiId = Auth::user()->divisi_id;
            $q->whereHas('user', function (Builder $userQuery) use ($divisiId) {
                $userQuery->where('divisi_id', $divisiId);
            });
        });

        // 3. Filter Status
        // Menerapkan filter status jika $this->status tidak kosong.
        $query->when($this->status, function (Builder $q) {
            $q->where('status', $this->status);
        });

        // 4. Eksekusi Query
        // Mengambil data, mengurutkan dari yang terbaru (latest), dan paginasi 10 item.
        $usulans = $query->latest()->paginate(10);

        // Mengembalikan view dengan data yang sudah dipaginasi
        return view('livewire.admin.usulan-pemusnahan-table', [
            'usulans' => $usulans,
        ]);
    }
}