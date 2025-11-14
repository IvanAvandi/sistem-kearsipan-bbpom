<?php if (isset($component)) { $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\AppLayout::class, []); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <?php if (isset($component)) { $__componentOriginal031b70f77448d6d2b1e9e96d77e7e66748a7c1aa = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Breadcrumbs::class, ['links' => [
            'Usul Musnah' => route('admin.usulan-pemusnahan.index'),
            'Detail Usulan' => '#'
        ]]); ?>
<?php $component->withName('breadcrumbs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['icon' => 'musnah']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal031b70f77448d6d2b1e9e96d77e7e66748a7c1aa)): ?>
<?php $component = $__componentOriginal031b70f77448d6d2b1e9e96d77e7e66748a7c1aa; ?>
<?php unset($__componentOriginal031b70f77448d6d2b1e9e96d77e7e66748a7c1aa); ?>
<?php endif; ?>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex items-start space-x-4">
                        
                        <?php $statusIconClass = 'bg-gray-100 text-gray-600'; $statusIconSvg = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.79 4 4s-1.79 4-4 4c-1.742 0-3.223-.835-3.772-2H2" />'; ?>
                        <?php if($usulan->status == 'Selesai'): ?>
                             <?php $statusIconClass = 'bg-green-100 text-green-600'; $statusIconSvg = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />'; ?>
                        <?php elseif(in_array($usulan->status, ['Dibatalkan', 'Ditolak'])): ?>
                             <?php $statusIconClass = 'bg-red-100 text-red-600'; $statusIconSvg = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />'; ?>
                        <?php elseif($usulan->status == 'Musnah, Menunggu BA'): ?>
                             <?php $statusIconClass = 'bg-yellow-100 text-yellow-600'; $statusIconSvg = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />'; ?>
                         <?php elseif($usulan->status == 'Diajukan ke Pusat'): ?>
                             <?php $statusIconClass = 'bg-blue-100 text-blue-600'; $statusIconSvg = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />'; ?>
                        <?php endif; ?>
                        <div class="flex-shrink-0 <?php echo e($statusIconClass); ?> p-3 rounded-lg">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><?php echo $statusIconSvg; ?></svg>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900"><?php echo e($usulan->nomor_usulan); ?></h2>
                            <p class="mt-1 text-sm text-gray-500">
                                Dibuat oleh <span class="font-medium text-gray-700"><?php echo e($usulan->user->name ?? 'N/A'); ?></span> 
                                pada <?php echo e(\Carbon\Carbon::parse($usulan->tanggal_usulan)->isoFormat('D MMMM YYYY')); ?>

                            </p>
                            <div class="mt-2">
                                <span class="px-2.5 py-0.5 text-xs font-medium rounded-full
                                <?php switch($usulan->status):
                                    case ('Draft'): ?> bg-gray-200 text-gray-800 <?php break; ?>
                                    <?php case ('Diajukan ke Pusat'): ?> bg-blue-100 text-blue-800 <?php break; ?>
                                    <?php case ('Musnah, Menunggu BA'): ?> bg-yellow-100 text-yellow-800 <?php break; ?>
                                    <?php case ('Selesai'): ?> bg-green-100 text-green-800 <?php break; ?>
                                    <?php case ('Dibatalkan'): ?> bg-red-100 text-red-800 <?php break; ?>
                                    <?php case ('Ditolak'): ?> bg-red-100 text-red-800 <?php break; ?>
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
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Timeline & Dokumen Bukti</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            
                            <div class="bg-gray-50 p-4 rounded-lg border">
                                <h4 class="font-semibold text-gray-700 flex items-center">
                                    <svg class="h-5 w-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    Surat Persetujuan
                                </h4>
                                <dl class="mt-3 text-sm space-y-2">
                                    <div class="flex justify-between"><dt class="text-gray-500">Nomor:</dt> <dd class="text-gray-800 font-medium text-right"><?php echo e($usulan->nomor_surat_persetujuan ?? '-'); ?></dd></div>
                                    <div class="flex justify-between"><dt class="text-gray-500">Tanggal:</dt> <dd class="text-gray-800 text-right"><?php echo e($usulan->tanggal_surat_persetujuan ? \Carbon\Carbon::parse($usulan->tanggal_surat_persetujuan)->isoFormat('D MMM Y') : '-'); ?></dd></div>
                                    <?php if($usulan->file_surat_persetujuan_path): ?>
                                    <div class="pt-2 border-t"><a href="<?php echo e(Storage::url($usulan->file_surat_persetujuan_path)); ?>" target="_blank" class="text-indigo-600 hover:underline font-medium">Lihat Dokumen &rarr;</a></div>
                                    <?php else: ?>
                                    <div class="pt-2 border-t"><span class="text-gray-500 italic">(Dokumen tidak diupload)</span></div>
                                    <?php endif; ?>
                                </dl>
                            </div>
                            
                            <div class="bg-gray-50 p-4 rounded-lg border">
                                <h4 class="font-semibold text-gray-700 flex items-center">
                                    <svg class="h-5 w-5 text-red-500 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                                    Pemusnahan Fisik
                                </h4>
                                <dl class="mt-3 text-sm space-y-2">
                                    <div class="flex justify-between"><dt class="text-gray-500">Status:</dt> <dd class="text-gray-800 font-medium text-right">Telah Dilaksanakan</dd></div>
                                    <div class="flex justify-between"><dt class="text-gray-500">Tanggal:</dt> <dd class="text-gray-800 text-right"><?php echo e($usulan->tanggal_pemusnahan_fisik ? \Carbon\Carbon::parse($usulan->tanggal_pemusnahan_fisik)->isoFormat('D MMM Y') : '-'); ?></dd></div>
                                </dl>
                            </div>
                            
                            <div class="bg-gray-50 p-4 rounded-lg border">
                                <h4 class="font-semibold text-gray-700 flex items-center">
                                    <svg class="h-5 w-5 text-blue-500 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M4 4a2 2 0 012-2h4.586A2 2 0 0113 3.414L16.586 7A2 2 0 0118 8.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" /></svg>
                                    Berita Acara
                                </h4>
                                 <dl class="mt-3 text-sm space-y-2">
                                    <div class="flex justify-between"><dt class="text-gray-500">Nomor:</dt> <dd class="text-gray-800 font-medium text-right"><?php echo e($usulan->nomor_bapa_diterima ?? '-'); ?></dd></div>
                                    <div class="flex justify-between"><dt class="text-gray-500">Tanggal:</dt> <dd class="text-gray-800 text-right"><?php echo e($usulan->tanggal_bapa_diterima ? \Carbon\Carbon::parse($usulan->tanggal_bapa_diterima)->isoFormat('D MMM Y') : '-'); ?></dd></div>
                                    <?php if($usulan->file_bapa_diterima_path): ?>
                                    <div class="pt-2 border-t"><a href="<?php echo e(Storage::url($usulan->file_bapa_diterima_path)); ?>" target="_blank" class="text-indigo-600 hover:underline font-medium">Lihat Dokumen &rarr;</a></div>
                                    <?php else: ?>
                                    <div class="pt-2 border-t"><span class="text-gray-500 italic">(Dokumen tidak diupload)</span></div>
                                    <?php endif; ?>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

            
            <?php elseif($usulan->status == 'Musnah, Menunggu BA'): ?>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Detail Pemusnahan</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            
                            <div class="bg-gray-50 p-4 rounded-lg border">
                                <h4 class="font-semibold text-gray-700 flex items-center">
                                    <svg class="h-5 w-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    Surat Persetujuan
                                </h4>
                                <dl class="mt-3 text-sm space-y-2">
                                    <div class="flex justify-between"><dt class="text-gray-500">Nomor:</dt> <dd class="text-gray-800 font-medium text-right"><?php echo e($usulan->nomor_surat_persetujuan ?? '-'); ?></dd></div>
                                    <div class="flex justify-between"><dt class="text-gray-500">Tanggal:</dt> <dd class="text-gray-800 text-right"><?php echo e($usulan->tanggal_surat_persetujuan ? \Carbon\Carbon::parse($usulan->tanggal_surat_persetujuan)->isoFormat('D MMM Y') : '-'); ?></dd></div>
                                    <?php if($usulan->file_surat_persetujuan_path): ?>
                                    <div class="pt-2 border-t"><a href="<?php echo e(Storage::url($usulan->file_surat_persetujuan_path)); ?>" target="_blank" class="text-indigo-600 hover:underline font-medium">Lihat Dokumen &rarr;</a></div>
                                     <?php else: ?>
                                    <div class="pt-2 border-t"><span class="text-gray-500 italic">(Dokumen tidak diupload)</span></div>
                                    <?php endif; ?>
                                </dl>
                            </div>
                            
                            <div class="bg-gray-50 p-4 rounded-lg border">
                                <h4 class="font-semibold text-gray-700 flex items-center">
                                    <svg class="h-5 w-5 text-red-500 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                                    Pemusnahan Fisik
                                </h4>
                                <dl class="mt-3 text-sm space-y-2">
                                    <div class="flex justify-between"><dt class="text-gray-500">Status:</dt> <dd class="text-gray-800 font-medium text-right">Telah Dilaksanakan</dd></div>
                                    <div class="flex justify-between"><dt class="text-gray-500">Tanggal:</dt> <dd class="text-gray-800 text-right"><?php echo e($usulan->tanggal_pemusnahan_fisik ? \Carbon\Carbon::parse($usulan->tanggal_pemusnahan_fisik)->isoFormat('D MMM Y') : '-'); ?></dd></div>
                                </dl>
                            </div>
                            
                            <div class="bg-gray-50 p-4 rounded-lg border">
                                <h4 class="font-semibold text-gray-700 flex items-center">
                                    <svg class="h-5 w-5 text-gray-400 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M4 4a2 2 0 012-2h4.586A2 2 0 0113 3.414L16.586 7A2 2 0 0118 8.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" /></svg>
                                    Berita Acara
                                </h4>
                                 <dl class="mt-3 text-sm space-y-2">
                                    <div class="flex justify-between"><dt class="text-gray-500">Nomor:</dt> <dd class="text-gray-800 font-medium text-right">-</dd></div>
                                    <div class="flex justify-between"><dt class="text-gray-500">Tanggal:</dt> <dd class="text-gray-800 text-right">-</dd></div>
                                    <div class="pt-2 border-t"><span class="text-gray-500 italic">(Belum Diarsip)</span></div>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

            <?php elseif($usulan->status == 'Ditolak'): ?>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <svg class="h-5 w-5 text-red-500 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" /></svg>
                            Detail Penolakan dari Pusat
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <div class="bg-gray-50 p-4 rounded-lg border">
                                <h4 class="font-semibold text-gray-700 flex items-center mb-3">
                                    <svg class="h-5 w-5 text-gray-500 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M4 4a2 2 0 012-2h4.586A2 2 0 0113 3.414L16.586 7A2 2 0 0118 8.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" /></svg>
                                    Dokumen Penolakan
                                </h4>
                                <dl class="text-sm space-y-2">
                                    <div class="flex justify-between"><dt class="text-gray-500">Nomor:</dt> <dd class="text-gray-800 font-medium text-right"><?php echo e($usulan->nomor_surat_penolakan ?? '-'); ?></dd></div>
                                    <div class="flex justify-between"><dt class="text-gray-500">Tanggal:</dt> <dd class="text-gray-800 text-right"><?php echo e($usulan->tanggal_surat_penolakan ? \Carbon\Carbon::parse($usulan->tanggal_surat_penolakan)->isoFormat('D MMM Y') : '-'); ?></dd></div>
                                    <?php if($usulan->file_surat_penolakan_path): ?>
                                    <div class="pt-2 border-t"><a href="<?php echo e(Storage::url($usulan->file_surat_penolakan_path)); ?>" target="_blank" class="text-indigo-600 hover:underline font-medium">Lihat Bukti &rarr;</a></div>
                                    <?php else: ?>
                                    <div class="pt-2 border-t"><span class="text-gray-500 italic">(Dokumen tidak diupload)</span></div>
                                    <?php endif; ?>
                                </dl>
                            </div>
                            
                            <div class="bg-gray-50 p-4 rounded-lg border">
                                <h4 class="font-semibold text-gray-700 flex items-center mb-3">
                                   <svg class="h-5 w-5 text-gray-500 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" /></svg>
                                    Catatan
                                </h4>
                                <?php if($usulan->catatan_penolakan): ?>
                                    <p class="text-sm text-gray-800 italic">"<?php echo e($usulan->catatan_penolakan); ?>"</p>
                                <?php else: ?>
                                    <p class="text-sm text-gray-500 italic">(Tidak ada catatan)</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

            <?php elseif($usulan->status == 'Dibatalkan'): ?>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100">
                            <svg class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                        </div>
                        <h3 class="mt-2 text-lg font-medium text-gray-900">Usulan Dibatalkan</h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Proses usulan ini telah dibatalkan. Semua arsip yang terhubung telah dikembalikan ke status "Siap Dimusnahkan".
                        </p>
                    </div>
                </div>
            <?php endif; ?>


            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                 <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Daftar Arsip dalam Usulan Ini (<?php echo e($usulan->arsips->count()); ?> arsip)</h3>
                    <div class="mt-4 overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Kode Klasifikasi</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Uraian Berkas</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Arsip</th>
                                    <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Status</th>
                                    <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php $__currentLoopData = $usulan->arsips; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $arsip): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="px-4 py-3 text-sm text-gray-500"><?php echo e($loop->iteration); ?></td>
                                        
                                        <td class="px-4 py-3 text-sm text-gray-900"><?php echo e($arsip->klasifikasiSurat()->withTrashed()->first()?->kode_klasifikasi ?? ''); ?></td>
                                        <td class="px-4 py-3 text-sm text-gray-900"><?php echo e($arsip->uraian_berkas); ?></td>
                                        <td class="px-4 py-3 text-sm text-gray-900"><?php echo e(\Carbon\Carbon::parse($arsip->tanggal_arsip)->isoFormat('D MMMM Y')); ?></td>
                                        <td class="px-4 py-3 text-sm text-center">
                                            <span class="px-2.5 py-0.5 text-xs font-medium rounded-full
                                            <?php if($arsip->status == 'Siap Dimusnahkan'): ?> bg-yellow-100 text-yellow-800
                                            <?php elseif($arsip->status == 'Musnah'): ?> bg-gray-600 text-white
                                            <?php else: ?> bg-orange-100 text-orange-800
                                            <?php endif; ?>">
                                                <?php echo e($arsip->status); ?>

                                            </span>
                                        </td>
                                        <td class="px-3 py-3 text-center align-top">
                                            <a href="<?php echo e(route('arsip.show', $arsip->id)); ?>" 
                                                class="text-gray-500 hover:text-blue-700"
                                                title="Lihat Detail Arsip">
                                                <svg class="w-5 h-5 mx-auto" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z" /><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.522 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" /></svg>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                 </div>
            </div>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da)): ?>
<?php $component = $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da; ?>
<?php unset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da); ?>
<?php endif; ?><?php /**PATH D:\applications\arsip-bbpom - Fitur Usul Musnah - Divisi - RevisiDemo - Revisi2 - Sibob - usulpindah\resources\views/usulan-pemusnahan/show.blade.php ENDPATH**/ ?>