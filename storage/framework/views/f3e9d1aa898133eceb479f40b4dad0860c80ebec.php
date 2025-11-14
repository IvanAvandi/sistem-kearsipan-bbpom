<div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md">
    
    
    
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Manajemen Format Tata Naskah Dinas</h2>
        <p class="mt-1 text-base text-gray-500">Kelola Format tata naskah dinas yang dapat diunduh oleh pengguna.</p>
    </div>

    
    
    
    <div class="mt-6 flex flex-col sm:flex-row sm:justify-between sm:items-center space-y-4 sm:space-y-0">
        <div class="relative w-full sm:w-1/3">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400"><svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg></span>
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.input','data' => ['type' => 'text','wire:model.debounce.300ms' => 'search','placeholder' => 'Cari nama atau kategori...','class' => 'pl-10 w-full']]); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => 'text','wire:model.debounce.300ms' => 'search','placeholder' => 'Cari nama atau kategori...','class' => 'pl-10 w-full']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
        </div>
        
        <div class="w-full sm:w-auto">
            <a href="<?php echo e(route('admin.templates.create')); ?>" 
               class="inline-flex items-center justify-center w-full sm:w-auto px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-green-700">
                <svg class="w-5 h-5 mr-2 -ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" /></svg>
                Tambah Format TND
            </a>
        </div>
    </div>

    
    
    
    <?php if(session()->has('success')): ?>
        <div class="mt-4 p-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>
    
    
    
    
    <div class="mt-4 overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="w-16 px-4 py-3 text-center text-sm font-medium text-gray-700 uppercase tracking-wider">No.</th>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-700 uppercase tracking-wider">
                        Nama Format TND
                    </th>
                    <th class="w-48 px-4 py-3 text-left text-sm font-medium text-gray-700 uppercase tracking-wider">Kategori</th>
                    <th class="w-48 px-4 py-3 text-left text-sm font-medium text-gray-700 uppercase tracking-wider">Nama File</th>
                    <th class="w-32 px-4 py-3 text-center text-sm font-medium text-gray-700 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="odd:bg-white even:bg-gray-50 align-middle">
                        <td class="px-4 py-3 whitespace-nowrap text-center text-sm text-gray-700"><?php echo e($loop->iteration + $items->firstItem() - 1); ?></td>
                        <td class="px-4 py-3 text-sm font-medium text-gray-900 whitespace-normal break-words">
                            <?php echo e($item->nama_template); ?>

                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700"><?php echo e($item->kategori); ?></td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">
                            <a href="<?php echo e(Storage::url($item->file_path)); ?>" target="_blank" class="text-blue-500 hover:underline" title="<?php echo e($item->nama_file); ?>">
                                <?php echo e($item->nama_file); ?>

                            </a>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-center text-sm font-medium">
                            <div class="flex justify-center items-center space-x-4">
                                <a href="<?php echo e(route('admin.templates.edit', $item->id)); ?>" title="Edit" class="text-gray-500 hover:text-indigo-600">
                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" /><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" /></svg>
                                </a>
                                <button wire:click.prevent="delete(<?php echo e($item->id); ?>)" onclick="confirm('Anda yakin ingin menghapus Format ini?') || event.stopImmediatePropagation()" title="Hapus" class="text-gray-500 hover:text-red-600">
                                     <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">Belum ada format yang ditambahkan.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    
    
    
    <div class="mt-4">
        <?php echo e($items->links()); ?>

    </div>
</div><?php /**PATH D:\applications\arsip-bbpom - Fitur Usul Musnah - Divisi - RevisiDemo - Revisi2 - Sibob - usulpindah - Copy\resources\views/livewire/admin/template-table.blade.php ENDPATH**/ ?>