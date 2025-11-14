<?php if (isset($component)) { $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\AppLayout::class, []); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <?php if (isset($component)) { $__componentOriginal031b70f77448d6d2b1e9e96d77e7e66748a7c1aa = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Breadcrumbs::class, ['links' => ['Dashboard' => '#']]); ?>
<?php $component->withName('breadcrumbs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal031b70f77448d6d2b1e9e96d77e7e66748a7c1aa)): ?>
<?php $component = $__componentOriginal031b70f77448d6d2b1e9e96d77e7e66748a7c1aa; ?>
<?php unset($__componentOriginal031b70f77448d6d2b1e9e96d77e7e66748a7c1aa); ?>
<?php endif; ?>
     <?php $__env->endSlot(); ?>
        
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
        <div class="p-4 bg-white border-b border-gray-200 flex justify-between items-start">
            
            <div>
                <h3 class="text-lg font-semibold text-gray-800">
                    <?php
                        $hour = now()->hour;
                        if ($hour < 12) { echo "Selamat Pagi,"; } 
                        elseif ($hour < 15) { echo "Selamat Siang,"; } 
                        elseif ($hour < 18) { echo "Selamat Sore,"; } 
                        else { echo "Selamat Malam,"; }
                    ?>
                    <span class="font-bold"><?php echo e(Auth::user()->name); ?>!</span>
                </h3>
                <p class="mt-1 text-sm text-gray-600">Selamat datang di Sistem Informasi Kearsipan BBPOM.</p>
            </div>
            
            
            <div>
                <?php if(Auth::user()->divisi): ?>
                    <span class="px-3 py-1 text-xs font-medium text-gray-700 bg-gray-100 rounded-full border border-gray-200 whitespace-nowrap">
                        Bidang: <?php echo e(Auth::user()->divisi->nama === 'Informasi dan Komunikasi' ? 'Infokom' : Auth::user()->divisi->nama); ?>

                    </span>
                <?php endif; ?>
            </div>
        </div>
    </div>

    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <a href="<?php echo e(route('arsip.index', ['status' => 'Aktif'])); ?>" class="block p-4 bg-white rounded-lg shadow-md border-l-4 border-blue-500 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 text-blue-600">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-bold text-gray-700">Arsip Aktif</p>
                    <p class="text-2xl font-bold text-gray-800"><?php echo e($arsipAktifCount); ?></p>
                    <p class="text-xs text-gray-500">Total arsip yang digunakan.</p>
                </div>
            </div>
        </a>
        <a href="<?php echo e(route('arsip.index', ['status' => 'Inaktif'])); ?>" class="block p-4 bg-white rounded-lg shadow-md border-l-4 border-yellow-500 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100 text-yellow-600">
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" /></svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-bold text-gray-700">Arsip Inaktif</p>
                        <p class="text-2xl font-bold text-gray-800"><?php echo e($arsipInaktifCount); ?></p>
                        <?php if(Auth::user()->role === 'Admin'): ?>
                            <p class="text-xs text-gray-500">Total arsip yang inaktif.</p>
                        <?php else: ?>
                            <p class="text-xs text-gray-500">Segera usulkan pindah.</p>
                        <?php endif; ?>
                    </div>
                </div>
        </a>

        <?php if(Auth::user()->role === 'Admin'): ?>
            <a href="<?php echo e(route('arsip.index', ['status' => 'Siap Dimusnahkan'])); ?>" class="block p-4 bg-white rounded-lg shadow-md border-l-4 border-red-500 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 text-red-600">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-bold text-gray-700">Siap Dimusnahkan</p>
                            <p class="text-2xl font-bold text-gray-800"><?php echo e($siapDimusnahkanCount); ?></p>
                            <p class="text-xs text-gray-500">Menunggu diusulkan musnah.</p>
                        </div>
                    </div>
            </a>
            <a href="<?php echo e(route('arsip.index', ['status' => 'Permanen'])); ?>" class="block p-4 bg-white rounded-lg shadow-md border-l-4 border-gray-500 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-gray-100 text-gray-600">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" /></svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-bold text-gray-700">Arsip Permanen</p>
                            <p class="text-2xl font-bold text-gray-800"><?php echo e($arsipPermanenCount); ?></p>
                            <p class="text-xs text-gray-500">Arsip yang disimpan selamanya.</p>
                        </div>
                    </div>
            </a>
        <?php else: ?>
            <a href="<?php echo e(route('arsip.index', ['status' => 'Dipindahkan ke tata usaha'])); ?>" class="block p-4 bg-white rounded-lg shadow-md border-l-4 border-purple-500 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-purple-100 text-purple-600">
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.125-.504 1.125-1.125V14.25m-17.25 4.5h1.125c.621 0 1.125-.504 1.125-1.125V14.25m0 0V4.875c0-.621.504-1.125 1.125-1.125h13.5c.621 0 1.125.504 1.125 1.125V14.25m-17.25 0h17.25m-17.25 0V4.875c0-.621.504-1.125 1.125-1.125H10.5m-7.125 0h7.125" /></svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-bold text-gray-700">Arsip Dipindahkan</p>
                        <p class="text-2xl font-bold text-gray-800"><?php echo e($arsipDipindahkanCount ?? 0); ?></p>
                        <p class="text-xs text-gray-500">Total riwayat arsip Anda.</p>
                    </div>
                </div>
            </a>
            
            <a href="<?php echo e(route('usul-pindah.index')); ?>" class="block p-4 bg-white rounded-lg shadow-md border-l-4 border-cyan-500 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-cyan-100 text-cyan-600">
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-bold text-gray-700">Usulan Menunggu</p>
                        <p class="text-2xl font-bold text-gray-800"><?php echo e($usulanMenungguCount ?? 0); ?></p>
                        <p class="text-xs text-gray-500">Usulan pindah diproses.</p>
                    </div>
                </div>
            </a>
        <?php endif; ?>
    </div>

    
    <div class="mt-8 grid grid-cols-1 <?php if(Auth::user()->role === 'Admin'): ?> lg:grid-cols-3 <?php endif; ?> gap-6">
        
        
        <?php if(Auth::user()->role === 'Admin'): ?>
            
            <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Komposisi Arsip</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                    
                    <div class="md:col-span-2 relative h-64 md:h-80">
                        <canvas id="arsipChart"></canvas>
                    </div>
                    
                    <div class="md:col-span-1 space-y-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <span class="w-4 h-4 rounded-full mr-2" style="background-color: rgba(59, 130, 246, 0.8)"></span>
                                <span class="text-sm text-gray-700">Aktif</span>
                            </div>
                            <span class="text-sm font-bold text-gray-900 ml-auto"><?php echo e($arsipStatusStats['Aktif'] ?? 0); ?></span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <span class="w-4 h-4 rounded-full mr-2" style="background-color: rgba(245, 158, 11, 0.8)"></span>
                                <span class="text-sm text-gray-700">Inaktif</span>
                            </div>
                            <span class="text-sm font-bold text-gray-900 ml-auto"><?php echo e($arsipStatusStats['Inaktif'] ?? 0); ?></span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <span class="w-4 h-4 rounded-full mr-2" style="background-color: rgba(239, 68, 68, 0.8)"></span>
                                <span class="text-sm text-gray-700">Siap Musnah</span>
                            </div>
                            <span class="text-sm font-bold text-gray-900 ml-auto"><?php echo e($arsipStatusStats['Siap Dimusnahkan'] ?? 0); ?></span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <span class="w-4 h-4 rounded-full mr-2" style="background-color: rgba(249, 115, 22, 0.8)"></span>
                                <span class="text-sm text-gray-700">Diusulkan</span>
                            </div>
                            <span class="text-sm font-bold text-gray-900 ml-auto"><?php echo e($arsipStatusStats['Diusulkan Musnah'] ?? 0); ?></span>
                        </div>
                         <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <span class="w-4 h-4 rounded-full mr-2" style="background-color: rgba(156, 163, 175, 0.8)"></span>
                                <span class="text-sm text-gray-700">Permanen</span>
                            </div>
                            <span class="text-sm font-bold text-gray-900 ml-auto"><?php echo e($arsipStatusStats['Permanen'] ?? 0); ?></span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <span class="w-4 h-4 rounded-full mr-2" style="background-color: rgba(55, 65, 81, 0.8)"></span>
                                <span class="text-sm text-gray-700">Musnah</span>
                            </div>
                            <span class="text-sm font-bold text-gray-900 ml-auto"><?php echo e($arsipStatusStats['Musnah'] ?? 0); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>


        <?php if(Auth::user()->role === 'Admin'): ?>
            
            <div class="space-y-6 flex flex-col lg:col-span-1">
                
                
                <div class="bg-white p-4 rounded-lg shadow-md">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Link Terkait</h3>
                    <div class="flex flex-wrap items-center gap-4">
                        <?php $__empty_1 = true; $__currentLoopData = $linksTerkait; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <a href="<?php echo e($link->link_url); ?>" 
                                target="_blank" 
                                rel="noopener noreferrer" 
                                title="<?php echo e($link->nama); ?>"
                                class="relative flex items-center justify-center p-2 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                                
                                <img src="<?php echo e(Storage::url($link->path_icon)); ?>" alt="<?php echo e($link->nama); ?>" class="h-8 w-8 object-cover rounded-md">
                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <p class="text-sm text-gray-500">Tidak ada link terkait.</p>
                        <?php endif; ?>
                    </div>
                </div>

                
                <div class="bg-white p-4 rounded-lg shadow-md flex-1 flex flex-col" x-data="{ tab: 'aktivitas' }">
                    
                    <div class="flex border-b border-gray-200 mb-4">
                        <button 
                            @click="tab = 'aktivitas'" 
                            :class="{ 'border-indigo-500 text-indigo-600': tab === 'aktivitas', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'aktivitas' }"
                            class="flex-1 py-2 px-4 text-center text-sm font-medium border-b-2 whitespace-nowrap">
                            Aktivitas Terbaru
                        </button>
                        <button 
                            @click="tab = 'peringatan'" 
                            :class="{ 'border-indigo-500 text-indigo-600': tab === 'peringatan', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'peringatan' }"
                            class="flex-1 py-2 px-4 text-center text-sm font-medium border-b-2 whitespace-nowrap relative">
                            Peringatan
                            <?php
                                $totalPeringatan = $akanInaktifCount + $akanSiapMusnahCount + $akanPermanenCount;
                            ?>
                            <?php if($totalPeringatan > 0): ?>
                                <span class="ml-2 inline-flex items-center justify-center px-2 py-0.5 text-xs font-semibold leading-none text-white bg-red-500 rounded-full"><?php echo e($totalPeringatan); ?></span>
                            <?php endif; ?>
                        </button>
                    </div>
                    
                    <div x-show="tab === 'aktivitas'" class="flex-1" style="display: none;">
                        <ul class="divide-y divide-gray-200">
                            <?php $__empty_1 = true; $__currentLoopData = $arsipTerbaru; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $arsip): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <li class="py-2">
                                <a href="<?php echo e(route('arsip.show', $arsip->id)); ?>" class="block hover:bg-gray-50 rounded-md p-2 -m-2">
                                    <p class="text-sm font-medium text-gray-900 truncate"><?php echo e($arsip->uraian_berkas); ?></p>
                                    <p class="text-xs text-gray-500"><?php echo e($arsip->divisi->nama ?? 'Tanpa Divisi'); ?> &middot; <?php echo e($arsip->created_at->diffForHumans()); ?></p>
                                </a>
                            </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <li class="py-3 text-sm text-gray-500 text-center">Belum ada arsip yang ditambahkan.</li>
                            <?php endif; ?>
                        </ul>
                    </div>
                    
                    <div x-show="tab === 'peringatan'" class="flex-1" style="display: none;">
                        <ul class="space-y-3">
                            <li>
                                <a href="<?php echo e(route('arsip.index', ['status' => 'Aktif', 'peringatan' => 'true'])); ?>" class="flex items-center p-2 -m-2 hover:bg-gray-50 rounded-md">
                                    <div class="flex-shrink-0 flex items-center justify-center h-8 w-8 rounded-full bg-yellow-100 text-yellow-600">
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900"><?php echo e($akanInaktifCount); ?> Arsip Akan Inaktif</p>
                                        <p class="text-xs text-gray-500">Akan pindah status dalam 30 hari.</p>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="flex items-center p-2 -m-2 hover:bg-gray-50 rounded-md">
                                    <div class="flex-shrink-0 flex items-center justify-center h-8 w-8 rounded-full bg-red-100 text-red-600">
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900"><?php echo e($akanSiapMusnahCount); ?> Arsip Akan Siap Musnah</p>
                                        <p class="text-xs text-gray-500">Retensi inaktif habis dlm 30 hari.</p>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="flex items-center p-2 -m-2 hover:bg-gray-50 rounded-md">
                                    <div class="flex-shrink-0 flex items-center justify-center h-8 w-8 rounded-full bg-gray-100 text-gray-600">
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" /></svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900"><?php echo e($akanPermanenCount); ?> Arsip Akan Permanen</p>
                                        <p class="text-xs text-gray-500">Retensi inaktif habis dlm 30 hari.</p>
                                    </div>
                                </a>
                            </li>
                            <?php if($totalPeringatan == 0): ?>
                                <li class="py-3 text-sm text-gray-500 text-center">Tidak ada peringatan.</li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        
        <?php else: ?>
            
            <div class="lg:col-span-3">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                    
                    <div class="lg:col-span-1 bg-white p-4 rounded-lg shadow-md flex flex-col" x-data="{ tab: 'aktivitas' }">
                        
                        <div class="flex border-b border-gray-200 mb-4">
                            <button 
                                @click="tab = 'aktivitas'" 
                                :class="{ 'border-indigo-500 text-indigo-600': tab === 'aktivitas', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'aktivitas' }"
                                class="flex-1 py-2 px-4 text-center text-sm font-medium border-b-2 whitespace-nowrap">
                                Aktivitas Terbaru
                            </button>
                            <button 
                                @click="tab = 'peringatan'" 
                                :class="{ 'border-indigo-500 text-indigo-600': tab === 'peringatan', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'peringatan' }"
                                class="flex-1 py-2 px-4 text-center text-sm font-medium border-b-2 whitespace-nowrap relative">
                                Peringatan
                                <?php
                                    $totalPeringatan = $akanInaktifCount;
                                ?>
                                <?php if($totalPeringatan > 0): ?>
                                    <span class="ml-2 inline-flex items-center justify-center px-2 py-0.5 text-xs font-semibold leading-none text-white bg-red-500 rounded-full"><?php echo e($totalPeringatan); ?></span>
                                <?php endif; ?>
                            </button>
                        </div>
                        
                        <div x-show="tab === 'aktivitas'" class="flex-1" style="display: none;">
                            <ul class="divide-y divide-gray-200">
                                <?php $__empty_1 = true; $__currentLoopData = $arsipTerbaru; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $arsip): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <li class="py-2">
                                    <a href="<?php echo e(route('arsip.show', $arsip->id)); ?>" class="block hover:bg-gray-50 rounded-md p-2 -m-2">
                                        <p class="text-sm font-medium text-gray-900 truncate"><?php echo e($arsip->uraian_berkas); ?></p>
                                        <p class="text-xs text-gray-500"><?php echo e($arsip->divisi->nama ?? 'Tanpa Divisi'); ?> &middot; <?php echo e($arsip->created_at->diffForHumans()); ?></p>
                                    </a>
                                </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <li class="py-3 text-sm text-gray-500 text-center">Belum ada arsip yang ditambahkan.</li>
                                <?php endif; ?>
                            </ul>
                        </div>
                        
                        <div x-show="tab === 'peringatan'" class="flex-1" style="display: none;">
                            <ul class="space-y-3">
                                <li>
                                    <a href="<?php echo e(route('arsip.index', ['status' => 'Aktif', 'peringatan' => 'true'])); ?>" class="flex items-center p-2 -m-2 hover:bg-gray-50 rounded-md">
                                        <div class="flex-shrink-0 flex items-center justify-center h-8 w-8 rounded-full bg-yellow-100 text-yellow-600">
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900"><?php echo e($akanInaktifCount); ?> Arsip Akan Inaktif</p>
                                            <p class="text-xs text-gray-500">Akan pindah status dalam 30 hari.</p>
                                        </div>
                                    </a>
                                </li>
                                <?php if($totalPeringatan == 0): ?>
                                    <li class="py-3 text-sm text-gray-500 text-center">Tidak ada peringatan.</li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>

                    
                    <div class="lg:col-span-1 bg-white p-4 rounded-lg shadow-md">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Statistik Usulan Pindah</h3>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between border-b pb-2">
                                <span class="text-sm text-gray-600">Total Draft</span>
                                <span class="text-xl font-bold text-gray-900"><?php echo e($usulanDraftCount ?? 0); ?></span>
                            </div>
                            <div class="flex items-center justify-between border-b pb-2">
                                <span class="text-sm text-gray-600">Menunggu Diajukan</span>
                                <span class="text-xl font-bold text-blue-600"><?php echo e($usulanDiajukanCount ?? 0); ?></span>
                            </div>
                            <div class="flex items-center justify-between border-b pb-2">
                                <span class="text-sm text-gray-600">Perlu Revisi</span>
                                <span class="text-xl font-bold text-yellow-600"><?php echo e($usulanDikembalikanCount ?? 0); ?></span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Telah Disetujui</span>
                                <span class="text-xl font-bold text-green-600"><?php echo e($usulanSelesaiCount ?? 0); ?></span>
                            </div>
                        </div>
                    </div>

                    
                    <div class="lg:col-span-1 bg-white p-4 rounded-lg shadow-md">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Link Terkait</h3>
                        <div class="flex flex-wrap items-center gap-4">
                            <?php $__empty_1 = true; $__currentLoopData = $linksTerkait; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <a href="<?php echo e($link->link_url); ?>" 
                                    target="_blank" 
                                    rel="noopener noreferrer" 
                                    title="<?php echo e($link->nama); ?>"
                                    class="relative flex items-center justify-center p-2 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                                    
                                    <img src="<?php echo e(Storage::url($link->path_icon)); ?>" alt="<?php echo e($link->nama); ?>" class="h-8 w-8 object-cover rounded-md">
                                </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <p class="text-sm text-gray-500">Tidak ada link terkait.</p>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>
            </div>
        <?php endif; ?>
        
    </div>

    
    <?php if(Auth::user()->role === 'Admin'): ?>
    <?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const canvas = document.getElementById('arsipChart');
            if (canvas) {
                const ctx = canvas.getContext('2d');
                const arsipData = <?php echo json_encode($arsipStatusStats, 15, 512) ?>;
                
                const labels = ['Aktif', 'Inaktif', 'Siap Dimusnahkan', 'Diusulkan Musnah', 'Permanen', 'Musnah'];
                const data = labels.map(label => arsipData[label] || 0);

                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Jumlah Arsip',
                            data: data,
                            backgroundColor: [
                                'rgba(59, 130, 246, 0.8)',   // Blue (Aktif)
                                'rgba(245, 158, 11, 0.8)', // Amber (Inaktif)
                                'rgba(239, 68, 68, 0.8)',   // Red (Siap Dimusnahkan)
                                'rgba(249, 115, 22, 0.8)',  // Orange (Diusulkan Musnah)
                                'rgba(156, 163, 175, 0.8)',// Gray (Permanen)
                                'rgba(55, 65, 81, 0.8)'     // Dark Gray (Musnah)
                            ],
                            hoverOffset: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false,
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return ` ${context.label}: ${context.raw}`;
                                    }
                                }
                            },
                        },
                        cutout: '70%'
                    }
                });
            }
        });
    </script>
    <?php $__env->stopPush(); ?>
    <?php endif; ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da)): ?>
<?php $component = $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da; ?>
<?php unset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da); ?>
<?php endif; ?><?php /**PATH D:\applications\arsip-bbpom - Fitur Usul Musnah - Divisi - RevisiDemo - Revisi2 - Sibob - usulpindah - Copy\resources\views/dashboard.blade.php ENDPATH**/ ?>