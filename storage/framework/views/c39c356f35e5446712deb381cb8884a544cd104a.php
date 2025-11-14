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
            <div class="p-4 bg-white border-b border-gray-200">
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
                            <p class="text-xs text-gray-500">Total arsip yang inaktif.</p>
                        </div>
                    </div>
            </a>
            

            
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
        </div>

        <div class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 bg-white p-4 rounded-lg shadow-md">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Komposisi Arsip</h3>
                <div class="relative h-96">
                    <canvas id="arsipChart"></canvas>
                </div>
            </div>

            <div class="space-y-6 flex flex-col">
                
                
                
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
        </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('arsipChart').getContext('2d');
            const arsipData = <?php echo json_encode($arsipStatusStats, 15, 512) ?>;
            
            // Urutan label yang diinginkan
            const labels = ['Aktif', 'Inaktif', 'Siap Dimusnahkan', 'Diusulkan Musnah', 'Permanen', 'Musnah'];
            const data = labels.map(label => arsipData[label] || 0);

            new Chart(ctx, {
                // Tipe grafik tetap 'bar' (untuk vertikal)
                type: 'bar',
                data: {
                    labels: labels, // Menggunakan urutan label yang sudah ditentukan
                    datasets: [{
                        label: 'Jumlah Arsip',
                        data: data, // Menggunakan data yang sudah diurutkan
                        backgroundColor: [
                            'rgba(59, 130, 246, 0.8)',   // Blue (Aktif)
                            'rgba(245, 158, 11, 0.8)', // Amber (Inaktif)
                            'rgba(239, 68, 68, 0.8)',   // Red (Siap Dimusnahkan)
                            'rgba(249, 115, 22, 0.8)',  // Orange (Diusulkan Musnah)
                            'rgba(156, 163, 175, 0.8)',// Gray (Permanen)
                            'rgba(55, 65, 81, 0.8)'     // Dark Gray (Musnah)
                        ],
                        borderRadius: 4,
                        categoryPercentage: 0.5, 
                        barPercentage: 0.8
                    }]
                },
                options: {
                    indexAxis: 'x',
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return ` ${context.dataset.label}: ${context.raw}`;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false // Sembunyikan garis grid vertikal
                            }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0 // Pastikan angka di sumbu Y adalah integer
                            }
                        }
                    }
                }
            });
        });
    </script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da)): ?>
<?php $component = $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da; ?>
<?php unset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da); ?>
<?php endif; ?><?php /**PATH D:\applications\arsip-bbpom - Fitur Usul Musnah - Divisi - RevisiDemo - Revisi2 - Sibob - usulpindah\resources\views/dashboard.blade.php ENDPATH**/ ?>