<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class SidebarLink extends Component
{
    /**
     * Menandakan apakah link ini sedang aktif.
     *
     * @var bool
     */
    public $active;

    /**
     * Buat instance komponen baru.
     *
     * @param  bool  $active
     * @return void
     */
    public function __construct($active = false)
    {
        $this->active = $active;
    }

    /**
     * Dapatkan view / konten yang merepresentasikan komponen.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render(): View
    {
        return view('components.sidebar-link');
    }
}