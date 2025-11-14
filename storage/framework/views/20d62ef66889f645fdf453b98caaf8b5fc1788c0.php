
<div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md">

    
    
    
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Manajemen Usulan Pemusnahan</h2>
        <p class="mt-1 text-base text-gray-500">Pantau dan kelola semua usulan pemusnahan arsip dari draft hingga selesai.</p>
    </div>

    
    
    
    <div class="mt-6 flex flex-col sm:flex-row sm:justify-between sm:items-center space-y-2 sm:space-y-0">

        
        <div class="flex flex-col sm:flex-row sm:items-center space-y-2 sm:space-y-0 sm:space-x-2 w-full sm:w-auto">
            <div class="relative w-full sm:w-64">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </span>
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.input','data' => ['type' => 'text','wire:model.debounce.300ms' => 'search','placeholder' => 'Cari nomor usulan/nama...','class' => 'pl-10 w-full']]); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => 'text','wire:model.debounce.300ms' => 'search','placeholder' => 'Cari nomor usulan/nama...','class' => 'pl-10 w-full']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
            </div>
        </div>
        
        
        <div class="flex justify-end w-full sm:w-auto">
            <select wire:model="status" class="w-full sm:w-auto rounded-md shadow-sm border-gray-300 text-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                <option value="">Semua Status</option>
                <option value="Draft">Draft</option>
                <option value="Diajukan ke Pusat">Diajukan ke Pusat</option>
                <option value="Musnah, Menunggu BA">Menunggu Berita Acara</option>
                <option value="Selesai">Selesai</option>
                <option value="Dibatalkan">Dibatalkan</option>
                <option value="Ditolak">Ditolak</option>
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
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="w-16 px-4 py-3 text-left text-sm font-medium text-gray-700 uppercase tracking-wider">No</th>
                    <th scope="col" class="w-1/3 px-4 py-3 text-left text-sm font-medium text-gray-700 uppercase tracking-wider">Nomor Usulan</th>
                    <th scope="col" class="w-1/4 px-4 py-3 text-left text-sm font-medium text-gray-700 uppercase tracking-wider">Dibuat Oleh</th>
                    <th scope="col" class="w-1/4 px-4 py-3 text-left text-sm font-medium text-gray-700 uppercase tracking-wider">Tanggal Dibuat</th>
                    <th scope="col" class="w-32 px-4 py-3 text-center text-sm font-medium text-gray-700 uppercase tracking-wider">Jumlah Arsip</th>
                    <th scope="col" class="w-40 px-4 py-3 text-center text-sm font-medium text-gray-700 uppercase tracking-wider">Status</th>
                    <th scope="col" class="w-32 px-4 py-3 text-center text-sm font-medium text-gray-700 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                
                
                <?php $__empty_1 = true; $__currentLoopData = $usulans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $usulan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="odd:bg-white even:bg-gray-50 align-middle">
                        
                        
                        <td class="px-4 py-3 text-sm text-gray-700"><?php echo e($loop->iteration + $usulans->firstItem() - 1); ?></td>
                        
                        <td class="px-4 py-3 text-sm text-gray-900 font-medium whitespace-normal break-words" title="<?php echo e($usulan->nomor_usulan); ?>"><?php echo e($usulan->nomor_usulan); ?></td>
                        
                        
                        <td class="px-4 py-3 text-sm text-gray-700 whitespace-nowrap"><?php echo e($usulan->user->name ?? 'N/A'); ?></td> 
                        
                        
                        <td class="px-4 py-3 text-sm text-gray-700 whitespace-nowrap"><?php echo e($usulan->created_at->isoFormat('D MMMM YYYY')); ?></td>
                        
                        
                        <td class="px-4 py-3 text-sm text-gray-700 text-center whitespace-nowrap"><?php echo e($usulan->arsips->count()); ?></td>
                        
                        <td class="px-4 py-3 text-sm text-center whitespace-nowrap">
                            <span class="inline-flex justify-center items-center px-3 py-1 text-xs font-medium rounded-full w-36
                            <?php switch($usulan->status):
                                case ('Draft'): ?> bg-gray-200 text-gray-800 <?php break; ?>
                                <?php case ('Diajukan ke Pusat'): ?> bg-blue-100 text-blue-800 <?php break; ?>
                                <?php case ('Musnah, Menunggu BA'): ?> bg-yellow-100 text-yellow-800 <?php break; ?>
                                <?php case ('Selesai'): ?> bg-green-100 text-green-800 <?php break; ?>
                                <?php case ('Dibatalkan'): ?> bg-red-100 text-red-800 <?php break; ?> 
                                <?php case ('Ditolak'): ?> bg-red-100 text-red-800 <?php break; ?>
                                <?php default: ?> bg-gray-200 text-gray-800 <?php break; ?>
                            <?php endswitch; ?>">
                                <?php echo e($usulan->status); ?>

                            </span>
                        </td>
                        
                        <td class="px-4 py-3 text-center whitespace-nowrap">
                            <a href="<?php echo e(route('admin.usulan-pemusnahan.show', $usulan->id)); ?>" 
                               class="inline-flex items-center px-3 py-2 text-sm font-medium
                                      bg-white text-gray-700 border border-gray-300 rounded-md shadow-sm
                                      hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Lihat Detail
                            </a>
                        </td>
                    </tr>
                
                
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">Data usulan pemusnahan tidak ditemukan.</td></tr>
                <?php endif; ?>
                
            </tbody>
        </table>
    </div>

    
    
    
    <div class="mt-4">
        <?php echo e($usulans->links()); ?>

    </div>

</div><?php /**PATH D:\applications\arsip-bbpom - Fitur Usul Musnah - Divisi - RevisiDemo - Revisi2 - Sibob - usulpindah - Copy\resources\views/livewire/admin/usulan-pemusnahan-table.blade.php ENDPATH**/ ?>