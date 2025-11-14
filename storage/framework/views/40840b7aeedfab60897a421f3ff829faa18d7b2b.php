<div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Daftar Arsip</h2>
        <p class="mt-1 text-base text-gray-500">Kelola dan pantau semua arsip dalam sistem</p>
    </div>

    
    <div class="mt-6 flex flex-col sm:flex-row sm:flex-wrap sm:items-center gap-2 border-b border-gray-200 pb-4">
        <button wire:click.prevent="$set('status', '')" class="px-3 py-1.5 text-sm font-medium rounded-full w-full sm:w-auto justify-center <?php echo e($status == '' ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'); ?>">
            Semua Status <span class="ml-1.5 bg-gray-400 text-white rounded-full px-2 py-0.5 text-xs"><?php echo e($statusCounts['Semua']); ?></span>
        </button>
        <button wire:click.prevent="$set('status', 'Aktif')" class="px-3 py-1.5 text-sm font-medium rounded-full w-full sm:w-auto justify-center <?php echo e($status == 'Aktif' ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'); ?>">
            Aktif <span class="ml-1.5 bg-gray-400 text-white rounded-full px-2 py-0.5 text-xs"><?php echo e($statusCounts['Aktif']); ?></span>
        </button>
        <button wire:click.prevent="$set('status', 'Inaktif')" class="px-3 py-1.5 text-sm font-medium rounded-full w-full sm:w-auto justify-center <?php echo e($status == 'Inaktif' ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'); ?>">
            Inaktif <span class="ml-1.5 bg-gray-400 text-white rounded-full px-2 py-0.5 text-xs"><?php echo e($statusCounts['Inaktif']); ?></span>
        </button>
        
        <?php if(Auth::user()->role == 'Admin'): ?>
            <button wire:click.prevent="$set('status', 'Siap Dimusnahkan')" class="px-3 py-1.5 text-sm font-medium rounded-full w-full sm:w-auto justify-center <?php echo e($status == 'Siap Dimusnahkan' ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'); ?>">
                Perlu Dimusnahkan <span class="ml-1.5 bg-gray-400 text-white rounded-full px-2 py-0.5 text-xs"><?php echo e($statusCounts['Siap Dimusnahkan']); ?></span>
            </button>
        <?php endif; ?>

        <button wire:click.prevent="$set('status', 'Permanen')" class="px-3 py-1.5 text-sm font-medium rounded-full w-full sm:w-auto justify-center <?php echo e($status == 'Permanen' ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'); ?>">
            Permanen <span class="ml-1.5 bg-gray-400 text-white rounded-full px-2 py-0.5 text-xs"><?php echo e($statusCounts['Permanen']); ?></span>
        </button>
        
        <?php if(Auth::user()->role == 'Admin'): ?>
            <button wire:click.prevent="$set('status', 'Musnah')" class="px-3 py-1.5 text-sm font-medium rounded-full w-full sm:w-auto justify-center <?php echo e($status == 'Musnah' ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'); ?>">
                Musnah <span class="ml-1.5 bg-gray-400 text-white rounded-full px-2 py-0.5 text-xs"><?php echo e($statusCounts['Musnah']); ?></span>
            </button>
        <?php endif; ?>
    </div>

    
    <div class="mt-4 flex flex-col sm:flex-row sm:justify-between sm:items-center space-y-4 sm:space-y-0">
        
        <div class="flex items-center flex-wrap gap-y-2 sm:space-x-2">
            <div class="relative flex-grow sm:flex-grow-0 w-full sm:w-auto">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400"><svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg></span>
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.input','data' => ['type' => 'text','wire:model.debounce.300ms' => 'search','placeholder' => 'Cari kode atau uraian...','class' => 'pl-10 w-full']]); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => 'text','wire:model.debounce.300ms' => 'search','placeholder' => 'Cari kode atau uraian...','class' => 'pl-10 w-full']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
            </div>
            <div x-data="{ open: false }" @click.outside="open = false" class="relative w-full sm:w-auto">
                <button @click="open = !open" class="inline-flex items-center justify-center w-full px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 relative whitespace-nowrap">
                    <svg class="h-5 w-5 mr-2 -ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L13 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" /></svg>
                    Filter
                    <?php if($divisi || $tahun): ?>
                        <span class="absolute -top-1 -right-1 block h-3 w-3"><span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span><span class="relative inline-flex rounded-full h-3 w-3 bg-blue-500"></span></span>
                    <?php endif; ?>
                </button>
                <div x-show="open" x-transition style="display: none;" class="absolute z-50 mt-2 w-full sm:w-72 rounded-md shadow-lg origin-top-left">
                    <div class="rounded-md ring-1 ring-black ring-opacity-5 bg-white p-4 space-y-4">
                        <?php if(Auth::user()->role === 'Admin'): ?>
                        <div>
                            <label for="filter-divisi" class="block text-sm font-medium text-gray-700">Filter Bidang</label>
                            <select id="filter-divisi" wire:model="divisi" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 text-sm">
                                <option value="">Semua Bidang</option>
                                <?php $__currentLoopData = $allDivisi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($d->id); ?>"><?php echo e($d->nama === 'Informasi dan Komunikasi' ? 'Infokom' : $d->nama); ?></option> 
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <?php endif; ?>
                        <div>
                            <label for="filter-tahun" class="block text-sm font-medium text-gray-700">Filter Tahun</label>
                            <select id="filter-tahun" wire:model="tahun" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 text-sm">
                                <option value="">Semua Tahun</option>
                                <?php $__currentLoopData = $availableYears; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($year); ?>"><?php echo e($year); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <?php if($divisi || $tahun): ?>
                        <button wire:click="resetFilters" @click="open = false" class="w-full text-xs text-indigo-600 hover:text-indigo-900 font-medium">Reset Filter</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php if(Auth::user()->role !== 'Admin' && Auth::user()->divisi): ?>
                <div class="px-3 py-2 bg-gray-200 text-gray-600 rounded-md shadow-sm text-xs whitespace-nowrap">
                    <span>Bidang: <?php echo e(Auth::user()->divisi->nama === 'Informasi dan Komunikasi' ? 'Infokom' : Auth::user()->divisi->nama); ?></span>
                </div>
            <?php endif; ?>
        </div>
        
        
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-end gap-2">
            
            
            <?php if(count($selectedArsip) > 0): ?>
                <?php if(Auth::user()->role == 'Admin' && $status === 'Siap Dimusnahkan'): ?>
                    
                    <button @click="if (confirm('Buat Usulan Pemusnahan untuk <?php echo e(count($selectedArsip)); ?> arsip terpilih?')) { $wire.call('buatUsulanPemusnahan') }" class="flex items-center justify-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 whitespace-nowrap w-full sm:w-auto">
                        Buat Usulan Pemusnahan (<?php echo e(count($selectedArsip)); ?>)
                    </button>
                <?php elseif(Auth::user()->role == 'Arsiparis' && $status === 'Inaktif'): ?> 
                     
                     <button wire:click="buatUsulanPindah" class="flex items-center justify-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 whitespace-nowrap w-full sm:w-auto">
                        <svg class="h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-2m-4-1v8m0 0l3-3m-3 3L9 8m-5 5h2.586a1 1 0 01.707.293l2.414 2.414a1 1 0 001.414 0l2.414-2.414a1 1 0 01.707-.293H17" /></svg>
                        Buat Usulan Pindah (<?php echo e(count($selectedArsip)); ?>)
                    </button>
                <?php endif; ?>
            <?php endif; ?>
            
            
            <button wire:click="openExportModal" class="inline-flex items-center justify-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 whitespace-nowrap w-full sm:w-auto">
                <svg class="w-5 h-5 mr-2 -ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M10.75 2.75a.75.75 0 00-1.5 0v8.614L6.295 8.235a.75.75 0 10-1.09 1.03l4.25 4.5a.75.75 0 001.09 0l4.25-4.5a.75.75 0 00-1.09-1.03l-2.955 3.129V2.75z" /><path d="M3.5 12.75a.75.75 0 00-1.5 0v2.5A2.75 2.75 0 004.75 18h10.5A2.75 2.75 0 0018 15.25v-2.5a.75.75 0 00-1.5 0v2.5c0 .69-.56 1.25-1.25 1.25H4.75c-.69 0-1.25-.56-1.25-1.25v-2.5z" /></svg>
                Export
            </button>
            
            <a href="<?php echo e(route('arsip.create')); ?>" class="inline-flex items-center justify-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 whitespace-nowrap w-full sm:w-auto">
                <svg class="w-5 h-5 mr-2 -ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" /></svg>
                Tambah Arsip
            </a>
        </div>
    </div>

    <?php if(session()->has('success')): ?>
        <div class="mt-4 p-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert"><?php echo e(session('success')); ?></div>
    <?php endif; ?>
    <?php if(session()->has('error')): ?>
        <div class="mt-4 p-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert"><?php echo e(session('error')); ?></div>
    <?php endif; ?>
    
    <div class="mt-4 overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 table-fixed">
            <thead class="bg-gray-50">
                <tr>
                    
                    <?php
                        // Tampilkan checkbox jika Admin di tab 'Siap Dimusnahkan'
                        // ATAU jika Arsiparis di tab 'Inaktif'
                        $showCheckbox = (Auth::user()->role == 'Admin' && $status === 'Siap Dimusnahkan') || 
                                        (Auth::user()->role == 'Arsiparis' && $status === 'Inaktif');
                    ?>
                    <?php if($showCheckbox): ?>
                        <th class="w-12 px-4 py-3">
                            <input type="checkbox" wire:model="selectAll" class="rounded border-gray-300">
                        </th>
                    <?php endif; ?>
                    

                    <th class="w-16 px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">No.</th>
                    <th class="w-28 px-4 py-3 text-center text-sm text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <button wire:click.prevent="sortBy('nomor_berkas')" class="flex items-center space-x-1">
                            <span>NOMOR BERKAS</span>
                            <?php if($sortBy === 'nomor_berkas'): ?>
                                <?php if($sortDirection === 'asc'): ?> <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                                <?php else: ?> <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                <?php endif; ?>
                            <?php endif; ?>
                        </button>
                    </th>
                    <th class="w-28 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode Klasifikasi</th>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">
                        <button wire:click.prevent="sortBy('uraian_berkas')" class="flex items-center space-x-1">
                            <span>URAIAN BERKAS</span>
                            <?php if($sortBy === 'uraian_berkas'): ?>
                                <?php if($sortDirection === 'asc'): ?> <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                                <?php else: ?> <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                <?php endif; ?>
                            <?php endif; ?>
                        </button>
                    </th>
                    <th class="w-28 px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <button wire:click.prevent="sortBy('tanggal_arsip')" class="flex items-center space-x-1">
                            <span>TANGGAL</span>
                            <?php if($sortBy === 'tanggal_arsip'): ?>
                                <?php if($sortDirection === 'asc'): ?> 
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                                <?php else: ?> 
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                <?php endif; ?>
                            <?php endif; ?>
                        </button>
                    </th>
                    <th class="w-28 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lokasi</th>
                    <th class="w-36 px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="w-28 px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php $__empty_1 = true; $__currentLoopData = $arsips; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $arsip): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <?php if($showCheckbox): ?>
                            <td class="px-4 py-3"><input type="checkbox" wire:model="selectedArsip" value="<?php echo e($arsip->id); ?>" class="rounded border-gray-300"></td>
                        <?php endif; ?>

                        <td class="px-4 py-3 whitespace-nowrap text-center text-sm text-gray-500">
                            <?php echo e($loop->iteration + $arsips->firstItem() - 1); ?>

                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-center text-sm text-gray-800 font-medium"><?php echo e($arsip->nomor_berkas); ?></td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-800"><?php echo e($arsip->klasifikasiSurat?->kode_klasifikasi); ?></td>
                        <td class="px-4 py-3 text-sm text-gray-800 font-medium whitespace-normal break-words"><?php echo e($arsip->uraian_berkas); ?></td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-800"><?php echo e(\Carbon\Carbon::parse($arsip->tanggal_arsip)->format('d/m/Y')); ?></td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-800"><?php echo e($arsip->lokasi_penyimpanan); ?></td>
                        <td class="px-4 py-3 whitespace-nowrap text-center text-sm text-gray-800">
                            <span class="px-2.5 py-0.5 text-xs font-medium rounded-full 
                            <?php switch($arsip->status):
                                case ('Aktif'): ?> bg-blue-100 text-blue-800 <?php break; ?>
                                <?php case ('Inaktif'): ?> bg-yellow-100 text-yellow-800 <?php break; ?>
                                <?php case ('Siap Dimusnahkan'): ?> bg-red-100 text-red-800 <?php break; ?>
                                <?php case ('Diusulkan Musnah'): ?> bg-orange-100 text-orange-800 <?php break; ?>
                                <?php case ('Diusulkan Pindah'): ?> bg-purple-100 text-purple-800 <?php break; ?>
                                <?php case ('Permanen'): ?> bg-gray-200 text-gray-800 <?php break; ?>
                                <?php case ('Musnah'): ?> bg-gray-600 text-white <?php break; ?>
                            <?php endswitch; ?>"><?php echo e($arsip->status); ?></span>
                        </td>
                        
                        <td class="px-4 py-3 text-center text-sm font-medium">
                            <div class="flex justify-center items-center space-x-3">
                                <a href="<?php echo e(route('arsip.show', $arsip->id)); ?>" title="Detail"><svg class="h-5 w-5 text-gray-500 hover:text-blue-700" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z" /><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.522 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" /></svg></a>
                                <a href="<?php echo e(route('arsip.duplicate', $arsip->id)); ?>" title="Duplikat"><svg class="h-5 w-5 text-gray-500 hover:text-green-700" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M7 9a2 2 0 012-2h6a2 2 0 012 2v6a2 2 0 01-2 2H9a2 2 0 01-2-2V9z" /><path d="M5 3a2 2 0 00-2 2v6a2 2 0 002 2V5h6a2 2 0 00-2-2H5z" /></svg></a>
                                <div x-data="{ open: false }" @click.outside="open = false" class="relative">
                                    <button @click="open = !open" title="Opsi lain"><svg class="h-5 w-5 text-gray-500 hover:text-gray-700" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" /></svg></button>
                                    <div x-show="open" x-transition class="absolute z-50 right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 origin-top-right" style="display: none;">
                                        <a href="<?php echo e(route('arsip.edit', $arsip->id)); ?>" class="flex items-center space-x-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"><svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" /><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" /></svg><span>Edit</span></a>
                                        
                                        <?php if(Auth::user()->role === 'Admin'): ?>
                                        <form action="<?php echo e(route('arsip.destroy', $arsip->id)); ?>" method="POST" onsubmit="return confirm('Yakin hapus arsip ini?');">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="flex items-center space-x-2 w-full text-left px-4 py-2 text-sm text-red-700 hover:bg-red-50"><svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002 2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" /></svg><span>Hapus</span></button>
                                        </form>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="<?php echo e($showCheckbox ? '9' : '8'); ?>" class="px-6 py-4 text-center text-sm text-gray-500">Data tidak ditemukan.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        <?php echo e($arsips->links()); ?>

    </div>
    
    
    <div x-data="{
             show: <?php if ((object) ('showExportModal') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($_instance->id); ?>').entangle('<?php echo e('showExportModal'->value()); ?>')<?php echo e('showExportModal'->hasModifier('defer') ? '.defer' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($_instance->id); ?>').entangle('<?php echo e('showExportModal'); ?>')<?php endif; ?>,
             selectedExportYear: <?php if ((object) ('exportTahun') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($_instance->id); ?>').entangle('<?php echo e('exportTahun'->value()); ?>')<?php echo e('exportTahun'->hasModifier('defer') ? '.defer' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($_instance->id); ?>').entangle('<?php echo e('exportTahun'); ?>')<?php endif; ?>.defer
         }"
         x-show="show" x-cloak
         class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title-export" role="dialog" aria-modal="true">

        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" @click="show = false" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div x-show="show" x-transition
                 class="inline-block w-full max-w-md p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-lg">
                <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title-export">Pilih Periode Ekspor Arsip</h3>
                <p class="mt-2 text-sm text-gray-500">Pilih tahun dan periode arsip yang ingin Anda ekspor.</p>
                <div class="mt-4 space-y-4">
                    <div>
                        <label for="export_tahun" class="block text-sm font-medium text-gray-700">Tahun Arsip</label>
                        <select wire:model.defer="exportTahun" x-model="selectedExportYear" id="export_tahun" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">
                            <option value="semua">Semua Tahun</option>
                            <?php $__currentLoopData = $availableYears; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($year); ?>"><?php echo e($year); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['exportTahun'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div>
                        <label for="export_periode" class="block text-sm font-medium text-gray-700">Periode Ekspor</label>
                        <select wire:model.defer="exportPeriode" id="export_periode" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm"
                                :disabled="selectedExportYear === 'semua'">
                            <option value="tahunan">Tahunan</option>
                            <option value="tw1">Triwulan 1 (Jan-Mar)</option>
                            <option value="tw2">Triwulan 2 (Apr-Jun)</option>
                            <option value="tw3">Triwulan 3 (Jul-Sep)</option>
                            <option value="tw4">Triwulan 4 (Okt-Des)</option>
                        </select>
                        <p x-show="selectedExportYear === 'semua'" class="text-xs text-gray-500 mt-1" style="display: none;">Pilih tahun spesifik untuk mengaktifkan filter periode.</p>
                        <?php $__errorArgs = ['exportPeriode'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
                <div class="mt-6 sm:flex sm:flex-row-reverse">
                    <button wire:click.prevent="export" type="button" class="inline-flex justify-center w-full px-4 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-md shadow-sm hover:bg-green-700 sm:ml-3 sm:w-auto sm:text-sm">
                        Ekspor ke Excel
                    </button>
                    <button @click="show = false" type="button" class="inline-flex justify-center w-full px-4 py-2 mt-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 sm:mt-0 sm:w-auto sm:text-sm">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>
</div><?php /**PATH D:\applications\arsip-bbpom - Fitur Usul Musnah - Divisi - RevisiDemo - Revisi2 - Sibob - usulpindah\resources\views/livewire/arsip-table.blade.php ENDPATH**/ ?>