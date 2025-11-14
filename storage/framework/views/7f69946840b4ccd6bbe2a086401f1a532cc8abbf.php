
<div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md">

    
    
    
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Manajemen Usul Pindah</h2>
        <p class="mt-1 text-base text-gray-500">Daftar usulan pemindahan arsip yang telah & akan diajukan ke Unit Kearsipan Tata Usaha.</p>
    </div>

    
    
    
    <div class="mt-6 flex flex-col sm:flex-row sm:justify-between sm:items-center space-y-2 sm:space-y-0">
        
        <div class="relative w-full sm:w-1/3">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </span>
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.input','data' => ['type' => 'text','wire:model.debounce.300ms' => 'search','placeholder' => 'Cari nomor Berita Acara...','class' => 'pl-10 w-full']]); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => 'text','wire:model.debounce.300ms' => 'search','placeholder' => 'Cari nomor Berita Acara...','class' => 'pl-10 w-full']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
        </div>
        
        <div class="flex w-full sm:w-auto">
            <select wire:model="status" class="w-full sm:w-auto rounded-md shadow-sm border-gray-300 text-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                <option value="">Semua Status</option>
                <option value="Draft">Draft</option>
                <option value="Diajukan">Diajukan</option>
                <option value="Dikembalikan">Dikembalikan (Perlu Revisi)</option>
                <option value="Selesai">Selesai (Diterima)</option>
                <option value="Dibatalkan">Dibatalkan</option>
            </select>
        </div>
    </div>

    
    
    
    <div class="mt-4 overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="w-16 px-4 py-3 text-center text-sm font-medium text-gray-700 uppercase tracking-wider">No.</th>
                    <th scope="col" class="w-48 px-4 py-3 text-left text-sm font-medium text-gray-700 uppercase tracking-wider">Nomor<br>Berita Acara</th>
                    <th scope="col" class="w-40 px-4 py-3 text-left text-sm font-medium text-gray-700 uppercase tracking-wider">Dibuat Oleh</th>
                    <th scope="col" class="w-40 px-4 py-3 text-center text-sm font-medium text-gray-700 uppercase tracking-wider">Tanggal Dibuat</th>
                    <th scope="col" class="w-32 px-4 py-3 text-center text-sm font-medium text-gray-700 uppercase tracking-wider">Jumlah Arsip</th>
                    <th scope="col" class="w-48 px-4 py-3 text-center text-sm font-medium text-gray-700 uppercase tracking-wider">Status</th>
                    <th scope="col" class="w-40 px-4 py-3 text-center text-sm font-medium text-gray-700 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            
            <tbody class="bg-white divide-y divide-gray-200">
                <?php $__empty_1 = true; $__currentLoopData = $usulans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $usulan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="odd:bg-white even:bg-gray-50 align-middle">
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700 text-center"><?php echo e($loop->iteration + $usulans->firstItem() - 1); ?></td>
                        
                        <td class="px-4 py-3 text-sm font-medium text-gray-900 text-left whitespace-normal break-words" title="<?php echo e($usulan->nomor_ba); ?>"><?php echo e($usulan->nomor_ba); ?></td>
                        
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900 truncate"><?php echo e($usulan->user->name ?? 'N/A'); ?></div>
                            <div class="text-sm text-gray-700"><?php echo e($usulan->user->divisi ? ($usulan->user->divisi->nama === 'Informasi dan Komunikasi' ? 'Infokom' : $usulan->user->divisi->nama) : 'N/A'); ?></div>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700 text-center"><?php echo e($usulan->created_at->isoFormat('D MMMM YYYY')); ?></td>

                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700 text-center"><?php echo e($usulan->arsips_count); ?></td>
                        
                        <td class="px-4 py-3 whitespace-nowrap text-center text-sm font-medium">
                            <span class="inline-flex justify-center items-center px-3 py-1 text-xs font-medium rounded-full w-36
                            <?php switch($usulan->status):
                                case ('Diajukan'): ?> bg-blue-100 text-blue-800 <?php break; ?>
                                <?php case ('Dikembalikan'): ?> bg-yellow-100 text-yellow-800 <?php break; ?>
                                <?php case ('Selesai'): ?> bg-green-100 text-green-800 <?php break; ?>
                                <?php case ('Draft'): ?> bg-gray-200 text-gray-800 <?php break; ?>
                                <?php case ('Dibatalkan'): ?> bg-red-100 text-red-800 <?php break; ?>
                                <?php default: ?> bg-gray-200 text-gray-800 <?php break; ?>
                            <?php endswitch; ?>">
                                <?php echo e($usulan->status); ?>

                            </span>
                        </td>
                        
                        <td class="px-4 py-3 whitespace-nowrap text-center text-sm font-medium">
                            <?php if($usulan->status == 'Draft'): ?>
                                <a href="<?php echo e(route('usul-pindah.show', $usulan->id)); ?>"
                                   class="inline-flex justify-center items-center px-3 py-2 text-sm font-medium w-28
                                          bg-green-600 text-white border border-transparent rounded-md shadow-sm
                                          hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    Ajukan
                                </a>
                            <?php elseif($usulan->status == 'Dikembalikan'): ?>
                                <a href="<?php echo e(route('usul-pindah.show', $usulan->id)); ?>"
                                   class="inline-flex justify-center items-center px-3 py-2 text-sm font-medium w-28
                                          bg-yellow-500 text-white border border-transparent rounded-md shadow-sm
                                          hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                    Revisi
                                </a>
                            <?php else: ?>
                                <a href="<?php echo e(route('usul-pindah.show', $usulan->id)); ?>"
                                   class="inline-flex justify-center items-center px-3 py-2 text-sm font-medium w-28
                                          bg-white text-gray-700 border border-gray-300 rounded-md shadow-sm
                                          hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Lihat Detail
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="px-6 py-10 text-center text-sm text-gray-500">
                            Anda belum pernah mengajukan usulan pindah.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    
    
    
    <div class="mt-6">
        <?php echo e($usulans->links()); ?>

    </div>
</div>




<?php $__env->startPush('scripts'); ?>
<script>
    // Tampilkan notifikasi toast dari session (setelah redirect)
    <?php if(session()->has('success')): ?>
        Swal.fire({
            title: 'Berhasil!',
            text: "<?php echo e(session('success')); ?>",
            icon: 'success',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
    <?php endif; ?>
    <?php if(session()->has('error')): ?>
        Swal.fire({
            title: 'Gagal!',
            text: "<?php echo e(session('error')); ?>",
            icon: 'error',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
    <?php endif; ?>
</script>
<?php $__env->stopPush(); ?><?php /**PATH D:\applications\arsip-bbpom - Fitur Usul Musnah - Divisi - RevisiDemo - Revisi2 - Sibob - usulpindah - Copy\resources\views/livewire/usulan-pindah-list.blade.php ENDPATH**/ ?>