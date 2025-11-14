<?php if (isset($component)) { $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\AppLayout::class, []); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <?php if (isset($component)) { $__componentOriginal031b70f77448d6d2b1e9e96d77e7e66748a7c1aa = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Breadcrumbs::class, ['links' => [
            'Usulan Pindah' => route('admin.usul-pindah-review.index'),
            'Detail Usulan' => '#'
            ]]); ?>
<?php $component->withName('breadcrumbs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['icon' => 'usulan_pindah']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal031b70f77448d6d2b1e9e96d77e7e66748a7c1aa)): ?>
<?php $component = $__componentOriginal031b70f77448d6d2b1e9e96d77e7e66748a7c1aa; ?>
<?php unset($__componentOriginal031b70f77448d6d2b1e9e96d77e7e66748a7c1aa); ?>
<?php endif; ?>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            
            <?php if(session()->has('success')): ?>
                <div class="p-4 text-sm text-green-700 bg-green-100 rounded-lg shadow-sm" role="alert"><?php echo e(session('success')); ?></div>
            <?php endif; ?>
            <?php if(session()->has('error')): ?>
                <div class="p-4 text-sm text-red-700 bg-red-100 rounded-lg shadow-sm" role="alert"><?php echo e(session('error')); ?></div>
            <?php endif; ?>
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.auth-validation-errors','data' => ['class' => 'mb-4','errors' => $errors]]); ?>
<?php $component->withName('auth-validation-errors'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'mb-4','errors' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

            
            
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex items-start space-x-5">
                        
                        <?php
                            $iconClass = 'bg-gray-100 text-gray-600';
                            $iconSvg = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-2m-4-1v8m0 0l3-3m-3 3L9 8m-5 5h2.586a1 1 0 01.707.293l2.414 2.414a1 1 0 001.414 0l2.414-2.414a1 1 0 01.707-.293H17" />';
                            if($usulan->status == 'Selesai') {
                                $iconClass = 'bg-green-100 text-green-600';
                                $iconSvg = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />';
                            } elseif($usulan->status == 'Dikembalikan') {
                                $iconClass = 'bg-yellow-100 text-yellow-600';
                                $iconSvg = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />';
                            } elseif($usulan->status == 'Diajukan') {
                                $iconClass = 'bg-blue-100 text-blue-600';
                                $iconSvg = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />';
                            } elseif($usulan->status == 'Dibatalkan') {
                                $iconClass = 'bg-red-100 text-red-600';
                                $iconSvg = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />';
                            }
                        ?>
                        <div class="flex-shrink-0 <?php echo e($iconClass); ?> p-3 rounded-lg">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><?php echo $iconSvg; ?></svg>
                        </div>                               
                        <div>
                            <h2 class="text-xl font-bold text-gray-900"><?php echo e($usulan->nomor_ba); ?></h2>
                            
                            <?php if($usulan->diusulkanOleh): ?>
                                <p class="mt-1 text-sm text-gray-500">
                                    Diusulkan oleh: <span class="font-medium text-gray-700"><?php echo e($usulan->diusulkanOleh->name); ?></span>
                                    (Bidang <?php echo e($usulan->user->divisi ? ($usulan->user->divisi->nama === 'Informasi dan Komunikasi' ? 'Infokom' : $usulan->user->divisi->nama) : 'N/A'); ?>)
                                </p>
                                <p class="mt-1 text-sm text-gray-500">
                                    Pada: <span class="font-medium text-gray-700"><?php echo e($usulan->diajukan_pada->isoFormat('D MMM Y, HH:mm')); ?></span>
                                </p>
                            <?php else: ?>
                                <p class="mt-1 text-sm text-gray-500">
                                    Pembuat Draft: <span class="font-medium text-gray-700"><?php echo e($usulan->user->name ?? 'N/A'); ?></span>
                                    (Bidang <?php echo e($usulan->user->divisi ? ($usulan->user->divisi->nama === 'Informasi dan Komunikasi' ? 'Infokom' : $usulan->user->divisi->nama) : 'N/A'); ?>)
                                </p>
                                <p class="mt-1 text-sm text-gray-500">
                                    Dibuat pada: <span class="font-medium text-gray-700"><?php echo e($usulan->created_at->isoFormat('D MMM Y, HH:mm')); ?></span>
                                </p>
                            <?php endif; ?>

                            <div class="mt-4">
                                <span class="px-3 py-1 text-xs font-medium rounded-full
                                <?php switch($usulan->status):
                                    case ('Diajukan'): ?> bg-blue-100 text-blue-800 <?php break; ?>
                                    <?php case ('Dikembalikan'): ?> bg-yellow-100 text-yellow-800 <?php break; ?>
                                    <?php case ('Selesai'): ?> bg-green-100 text-green-800 <?php break; ?>
                                    <?php case ('Dibatalkan'): ?> bg-red-100 text-red-800 <?php break; ?>
                                    <?php default: ?> bg-gray-200 text-gray-800 <?php break; ?>
                                <?php endswitch; ?>">
                                    Status: <?php echo e($usulan->status); ?>

                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
            
            

            <?php if($usulan->status == 'Selesai'): ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-green-50 border-green-200 p-6 rounded-lg border shadow-sm h-full">
                        <h4 class="font-semibold text-green-800 flex items-center mb-2">
                            <svg class="h-5 w-5 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                            Usulan Disetujui
                        </h4>
                        <p class="text-sm text-green-900">Arsip telah resmi diterima dan dipindahkan ke Unit Kearsipan Tata Usaha.</p>
                        <?php if($usulan->disetujuiOleh): ?>
                        <p class="text-sm text-green-800 mt-2">
                            Disetujui oleh: <span class="font-medium"><?php echo e($usulan->disetujuiOleh->name); ?></span>
                            (<?php echo e($usulan->disetujui_pada->isoFormat('D MMM Y, HH:mm')); ?>)
                        </p>
                        <?php endif; ?>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg h-full">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Detail Berita Acara</h3>
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                <dl class="text-sm space-y-3">
                                    <div class="flex justify-between"><dt class="text-sm text-gray-500">Nomor BA:</dt> <dd class="text-sm font-medium text-gray-900 text-right"><?php echo e($usulan->nomor_ba ?? '-'); ?></dd></div>
                                    <div class="flex justify-between"><dt class="text-sm text-gray-500">Tanggal BA:</dt> <dd class="text-sm font-medium text-gray-900 text-right"><?php echo e($usulan->tanggal_ba ? $usulan->tanggal_ba->isoFormat('D MMM Y') : '-'); ?></dd></div>
                                    <div class="pt-3 border-t border-gray-200">
                                        <?php if($usulan->file_ba_path): ?>
                                        <a href="<?php echo e(Storage::url($usulan->file_ba_path)); ?>" target="_blank" class="text-indigo-600 hover:underline font-medium text-sm transition duration-150 ease-in-out">Lihat Dokumen BA &rarr;</a>
                                        <?php else: ?>
                                        <span class="text-gray-500 italic text-sm">(Dokumen BA tidak diupload)</span>
                                        <?php endif; ?>
                                    </div>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

            <?php elseif($usulan->status == 'Dikembalikan'): ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-yellow-50 border-yellow-200 p-6 rounded-lg border shadow-sm h-full">
                        <h4 class="font-semibold text-yellow-800 flex items-center mb-2">
                            <svg class="h-5 w-5 text-yellow-500 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" /></svg>
                            Catatan Pengembalian
                        </h4>
                        <?php if($usulan->dikembalikanOleh): ?>
                        <p class="text-sm text-yellow-800 mb-2">
                            Dikembalikan oleh: <span class="font-medium"><?php echo e($usulan->dikembalikanOleh->name); ?></span>
                            (<?php echo e($usulan->dikembalikan_pada->isoFormat('D MMM Y, HH:mm')); ?>)
                        </p>
                        <?php endif; ?>
                        <p class="text-sm text-yellow-700 italic">"<?php echo e($usulan->catatan_admin); ?>"</p>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg h-full">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Detail Berita Acara</h3>
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                <dl class="text-sm space-y-3">
                                    <div class="flex justify-between"><dt class="text-sm text-gray-500">Nomor BA:</dt> <dd class="text-sm font-medium text-gray-900 text-right"><?php echo e($usulan->nomor_ba ?? '-'); ?></dd></div>
                                    <div class="flex justify-between"><dt class="text-sm text-gray-500">Tanggal BA:</dt> <dd class="text-sm font-medium text-gray-900 text-right"><?php echo e($usulan->tanggal_ba ? $usulan->tanggal_ba->isoFormat('D MMM Y') : '-'); ?></dd></div>
                                    <div class="pt-3 border-t border-gray-200">
                                        <?php if($usulan->file_ba_path): ?>
                                        <a href="<?php echo e(Storage::url($usulan->file_ba_path)); ?>" target="_blank" class="text-indigo-600 hover:underline font-medium text-sm transition duration-150 ease-in-out">Lihat Dokumen BA &rarr;</a>
                                        <?php else: ?>
                                        <span class="text-gray-500 italic text-sm">(Dokumen BA tidak diupload)</span>
                                        <?php endif; ?>
                                    </div>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

            <?php elseif($usulan->status == 'Dibatalkan'): ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-red-50 border-red-200 p-6 rounded-lg border shadow-sm h-full">
                        <h4 class="font-semibold text-red-800 flex items-center mb-2">
                            <svg class="h-5 w-5 text-red-500 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" /></svg>
                            Usulan Dibatalkan
                        </h4>
                        <p class="text-sm text-red-900">Usulan ini dibatalkan. Arsip dikembalikan ke status Inaktif.</p>
                        <?php if($usulan->dibatalkanOleh): ?>
                        <p class="text-sm text-red-800 mt-2">
                            Dibatalkan oleh: <span class="font-medium"><?php echo e($usulan->dibatalkanOleh->name); ?></span>
                            (<?php echo e($usulan->dibatalkan_pada->isoFormat('D MMM Y, HH:mm')); ?>)
                        </p>
                        <?php endif; ?>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg h-full">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Detail Berita Acara</h3>
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                <dl class="text-sm space-y-3">
                                    <div class="flex justify-between"><dt class="text-sm text-gray-500">Nomor BA:</dt> <dd class="text-sm font-medium text-gray-900 text-right"><?php echo e($usulan->nomor_ba ?? '-'); ?></dd></div>
                                    <div class="flex justify-between"><dt class="text-sm text-gray-500">Tanggal BA:</dt> <dd class="text-sm font-medium text-gray-900 text-right"><?php echo e($usulan->tanggal_ba ? $usulan->tanggal_ba->isoFormat('D MMM Y') : '-'); ?></dd></div>
                                    <div class="pt-3 border-t border-gray-200">
                                        <?php if($usulan->file_ba_path): ?>
                                        <a href="<?php echo e(Storage::url($usulan->file_ba_path)); ?>" target="_blank" class="text-indigo-600 hover:underline font-medium text-sm transition duration-150 ease-in-out">Lihat Dokumen BA &rarr;</a>
                                        <?php else: ?>
                                        <span class="text-gray-500 italic text-sm">(Dokumen BA tidak diupload)</span>
                                        <?php endif; ?>
                                    </div>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            
            
            
            <?php if(in_array($usulan->status, ['Diajukan', 'Dikembalikan', 'Selesai'])): ?>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">
                        <?php if($usulan->status == 'Selesai'): ?>
                            Daftar Arsip yang Telah Diterima (<?php echo e($usulan->arsips->count()); ?> arsip)
                        <?php else: ?>
                            Daftar Arsip yang Diusulkan (<?php echo e($usulan->arsips->count()); ?> arsip)
                        <?php endif; ?>
                    </h3>
                    
                    <div class="mt-4 overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="w-16 px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No</th>
                                    
                                    
                                    <th scope="col" class="w-1/6 px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nomor Berkas</th>
                                    
                                    <th scope="col" class="w-1/6 px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kode Klasifikasi</th>
                                    <th scope="col" class="w-1/2 px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Uraian Berkas</th>
                                    <th scope="col" class="w-1/6 px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal Arsip</th>
                                    <th scope="col" class="w-1/6 px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="w-24 px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                <?php $__empty_1 = true; $__currentLoopData = $usulan->arsips; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $arsip): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr class="odd:bg-white even:bg-gray-50 align-middle">
                                        <td class="px-4 py-4 text-sm text-gray-500"><?php echo e($loop->iteration); ?></td>
                                        
                                        
                                        <td class="px-4 py-4 text-sm font-medium text-gray-900 whitespace-nowrap"><?php echo e($arsip->nomor_berkas_lengkap); ?></td>

                                        <td class="px-4 py-4 text-sm text-gray-900 whitespace-nowrap"><?php echo e($arsip->klasifikasiSurat->kode_klasifikasi ?? 'N/A'); ?></td>
                                        <td class="px-4 py-4 text-sm text-gray-900"><?php echo e($arsip->uraian_berkas); ?></td>
                                        <td class="px-4 py-4 text-sm text-center whitespace-nowrap"><?php echo e(\Carbon\Carbon::parse($arsip->tanggal_arsip)->isoFormat('D MMM Y')); ?></td>
                                        
                                        
                                        <?php
                                            // Jika usulan masih dalam proses review, status di tabel harus 'Diusulkan Pindah'
                                            // Jika usulan sudah Selesai, ambil status LIVE dari arsip (Aktif/Inaktif).
                                            $displayStatus = $usulan->status === 'Selesai' ? $arsip->status : 'Diusulkan Pindah';
                                        ?>
                                        
                                        <td class="px-4 py-4 text-sm text-center whitespace-nowrap">
                                            <span class="px-2.5 py-0.5 text-xs font-medium rounded-full 
                                            <?php switch($displayStatus):
                                                case ('Aktif'): ?> bg-blue-100 text-blue-800 <?php break; ?>
                                                <?php case ('Inaktif'): ?> bg-yellow-100 text-yellow-800 <?php break; ?>
                                                <?php case ('Siap Dimusnahkan'): ?> bg-red-100 text-red-800 <?php break; ?>
                                                <?php case ('Diusulkan Pindah'): ?> bg-purple-100 text-purple-800 <?php break; ?>
                                                <?php case ('Permanen'): ?> bg-gray-200 text-gray-800 <?php break; ?>
                                                <?php default: ?> bg-gray-200 text-gray-800 <?php break; ?>
                                            <?php endswitch; ?>">
                                                <?php echo e($displayStatus); ?>

                                            </span>
                                        </td>
                                        

                                        <td class="px-4 py-4 text-center">
                                            <a href="<?php echo e(route('arsip.show', $arsip->id)); ?>" target="_blank" class="text-gray-400 hover:text-indigo-600 transition duration-150 ease-in-out" title="Lihat Detail Arsip">
                                                <svg class="w-5 h-5 mx-auto" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z" /><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.522 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" /></svg>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        
                                        <td colspan="7" class="px-6 py-10 text-center text-sm text-gray-500">
                                            Tidak ada arsip dalam usulan ini.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            
            
            
            <?php if($usulan->status == 'Diajukan'): ?>
                <div class="grid grid-cols-1 lg:grid-cols-10 gap-6">
                    <div class="lg:col-span-6">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg h-full">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">Detail Berita Acara</h3>
                                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                    <dl class="text-sm space-y-3">
                                        <div class="flex justify-between"><dt class="text-sm text-gray-500">Nomor BA:</dt> <dd class="text-sm font-medium text-gray-900 text-right"><?php echo e($usulan->nomor_ba ?? '-'); ?></dd></div>
                                        <div class="flex justify-between"><dt class="text-sm text-gray-500">Tanggal BA:</dt> <dd class="text-sm font-medium text-gray-900 text-right"><?php echo e($usulan->tanggal_ba ? $usulan->tanggal_ba->isoFormat('D MMM Y') : '-'); ?></dd></div>
                                        <div class="pt-3 border-t border-gray-200">
                                            <?php if($usulan->file_ba_path): ?>
                                            <a href="<?php echo e(Storage::url($usulan->file_ba_path)); ?>" target="_blank" class="text-indigo-600 hover:underline font-medium text-sm transition duration-150 ease-in-out">Lihat Dokumen BA &rarr;</a>
                                            <?php else: ?>
                                            <span class="text-red-500 italic text-sm">(Dokumen BA belum diupload)</span>
                                            <?php endif; ?>
                                        </div>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="lg:col-span-4">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg h-full">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">Formulir Aksi</h3>
                                <form action="<?php echo e(route('admin.usul-pindah.kembalikan', $usulan->id)); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <div>
                                        <label for="catatan_admin" class="block text-sm font-medium text-gray-700">Catatan Revisi</label>
                                        <p class="text-xs text-gray-500 mb-2">Wajib diisi jika usulan dikembalikan.</p>
                                        <textarea id="catatan_admin" name="catatan_admin" rows="3" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Tulis catatan revisi..."></textarea>
                                    </div>
                                    <div class="mt-4 flex flex-col sm:flex-row-reverse sm:space-x-3 sm:space-x-reverse space-y-2 sm:space-y-0">
                                        <button type="button" 
                                                onclick="document.getElementById('form-setujui-<?php echo e($usulan->id); ?>').submit();"
                                                class="inline-flex items-center justify-center w-full px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 transition duration-150 ease-in-out">
                                            Setujui & Terima Arsip
                                        </button>
                                        
                                        <button type="submit" 
                                                class="inline-flex items-center justify-center w-full px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-600 transition duration-150 ease-in-out">
                                            Kembalikan (Revisi)
                                        </button>
                                    </div>
                                </form>
                                <form id="form-setujui-<?php echo e($usulan->id); ?>" action="<?php echo e(route('admin.usul-pindah.setujui', $usulan->id)); ?>" method="POST" class="hidden" onsubmit="return confirm('Anda yakin ingin menyetujui usulan ini? Arsip akan dipindahkan ke Tata Usaha.')">
                                    <?php echo csrf_field(); ?>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da)): ?>
<?php $component = $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da; ?>
<?php unset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da); ?>
<?php endif; ?><?php /**PATH D:\applications\arsip-bbpom - Fitur Usul Musnah - Divisi - RevisiDemo - Revisi2 - Sibob - usulpindah - Copy\resources\views/admin/usul-pindah/show.blade.php ENDPATH**/ ?>