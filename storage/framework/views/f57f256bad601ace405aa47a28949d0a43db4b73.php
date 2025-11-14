
<div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md">

    
    
    
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Manajemen Usulan Pindah Arsip</h2>
        <p class="mt-1 text-base text-gray-500">Daftar usulan pemindahan arsip dari Bidang lain ke Tata Usaha.</p>
    </div>

    
    
    
    <div class="mt-6 flex flex-col sm:flex-row sm:justify-between sm:items-center space-y-4 sm:space-y-0">
        
        <div class="relative w-full sm:w-1/3">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </span>
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.input','data' => ['type' => 'text','wire:model.debounce.300ms' => 'search','placeholder' => 'Cari nomor BA atau nama...','class' => 'pl-10 w-full']]); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => 'text','wire:model.debounce.300ms' => 'search','placeholder' => 'Cari nomor BA atau nama...','class' => 'pl-10 w-full']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
        </div>

        <div class="flex flex-col sm:flex-row sm:items-center space-y-2 sm:space-y-0 sm:space-x-2 w-full sm:w-auto">
            <select wire:model="status" class="w-full sm:w-auto rounded-md shadow-sm border-gray-300 text-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                <option value="">Semua Status</option>
                <option value="Diajukan">Diajukan</option>
                <option value="Dibatalkan">Dibatalkan</option>
                <option value="Dikembalikan">Dikembalikan</option>
                <option value="Selesai">Selesai</option>
            </select>
        </div>
    </div>

    
    
    
    <?php if(session()->has('success')): ?>
        <div class="mt-4 p-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert"><?php echo e(session('success')); ?></div>
    <?php endif; ?>
    <?php if(session()->has('error')): ?>
        <div class="mt-4 p-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert"><?php echo e(session('error')); ?></div>
    <?php endif; ?>

    
    
    
    <div class="mt-4 overflow-x-auto">
        <table class="min-w-full">
            
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="w-16 px-4 py-3 text-center text-sm font-medium text-gray-700 uppercase tracking-wider">No.</th>
                    <th scope="col" class="w-48 px-4 py-3 text-left text-sm font-medium text-gray-700 uppercase tracking-wider">Nomor<br>Berita Acara</th>
                    <th scope="col" class="w-1/5 px-4 py-3 text-left text-sm font-medium text-gray-700 uppercase tracking-wider">Diusulkan Oleh (Bidang)</th>
                    <th scope="col" class="w-40 px-4 py-3 text-center text-sm font-medium text-gray-700 uppercase tracking-wider">Tanggal Diajukan</th>
                    <th scope="col" class="w-32 px-4 py-3 text-center text-sm font-medium text-gray-700 uppercase tracking-wider">Jumlah Arsip</th>
                    <th scope="col" class="w-48 px-4 py-3 text-center text-sm font-medium text-gray-700 uppercase tracking-wider">Status</th>
                    <th scope="col" class="w-32 px-4 py-3 text-center text-sm font-medium text-gray-700 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            
            <tbody class="bg-white divide-y divide-gray-200">
                
                <?php $__empty_1 = true; $__currentLoopData = $usulans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $usulan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="odd:bg-white even:bg-gray-50 align-middle">
                        
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700 text-center"><?php echo e($loop->iteration + $usulans->firstItem() - 1); ?></td>
                        
                        <td class="px-4 py-3 text-sm font-medium text-gray-900 text-left whitespace-normal break-words" title="<?php echo e($usulan->nomor_ba); ?>"><?php echo e($usulan->nomor_ba); ?></td>
                        
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900 truncate">
                                <?php echo e($usulan->diusulkanOleh->name ?? ($usulan->status == 'Draft' ? '---' : $usulan->user->name)); ?>

                            </div>
                            <div class="text-sm text-gray-700"><?php echo e($usulan->user->divisi ? ($usulan->user->divisi->nama === 'Informasi dan Komunikasi' ? 'Infokom' : $usulan->user->divisi->nama) : 'N/A'); ?></div>
                        </td>
                        
                        <td class="px-4 py-3 whitespace-nowrap text-center text-sm text-gray-700">
                            <?php if($usulan->diajukan_pada): ?>
                                <?php echo e($usulan->diajukan_pada->isoFormat('D MMMM YYYY')); ?>

                                <div class="text-sm text-gray-500">(<?php echo e($usulan->diajukan_pada->diffForHumans()); ?>)</div>
                            <?php else: ?>
                                <span class="text-gray-400 italic">Belum Diajukan</span>
                            <?php endif; ?>
                        </td>

                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700 text-center"><?php echo e($usulan->arsips_count); ?></td>
                        
                        <td class="px-4 py-3 whitespace-nowrap text-center text-sm font-medium">
                            <span class="inline-flex justify-center items-center px-3 py-1 text-xs font-medium rounded-full w-32
                            <?php switch($usulan->status):
                                case ('Diajukan'): ?> bg-blue-100 text-blue-800 <?php break; ?>
                                <?php case ('Dikembalikan'): ?> bg-yellow-100 text-yellow-800 <?php break; ?>
                                <?php case ('Selesai'): ?> bg-green-100 text-green-800 <?php break; ?>
                                <?php case ('Dibatalkan'): ?> bg-red-100 text-red-800 <?php break; ?>
                                <?php default: ?> bg-gray-200 text-gray-800 <?php break; ?>
                            <?php endswitch; ?>">
                                <?php echo e($usulan->status); ?>

                            </span>
                        </td>
                        
                        <td class="px-4 py-3 whitespace-nowrap text-center text-sm font-medium">
                            <?php if($usulan->status == 'Diajukan'): ?>
                                <a href="<?php echo e(route('admin.usul-pindah.show', $usulan->id)); ?>"
                                   class="inline-flex justify-center items-center px-3 py-2 text-sm font-medium w-28
                                          bg-indigo-600 text-white border border-transparent rounded-md shadow-sm
                                          hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Tinjau
                                </a>
                            <?php else: ?>
                                <a href="<?php echo e(route('admin.usul-pindah.show', $usulan->id)); ?>"
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
                        <td colspan="7" class="px-6 py-10 text-center text-sm text-gray-500">Tidak ada usulan pindah yang ditemukan.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    
    
    
    <div class="mt-6">
        <?php echo e($usulans->links()); ?>

    </div>
</div><?php /**PATH D:\MAGANG\sistem-kearsipan-bbpom\resources\views/livewire/admin/usulan-pindah-table.blade.php ENDPATH**/ ?>