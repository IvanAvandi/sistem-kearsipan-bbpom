<div class="space-y-6">
    
    
    
    <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-gray-800">Format Tata Naskah Dinas</h2>
        <p class="mt-1 text-base text-gray-500">Cari dan unduh format tata naskah dinas resmi yang berlaku.</p>
    </div>

    
    
    
    <div class="flex flex-col sm:flex-row sm:space-x-4 space-y-4 sm:space-y-0">
        <input wire:model.debounce.300ms="search" type="text" placeholder="Cari nama format tata naskah dinas..." 
               class="w-full sm:w-1/2 lg:w-1/3 rounded-md shadow-sm border-gray-300 text-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
        <select wire:model="kategori" 
                class="w-full sm:w-auto rounded-md shadow-sm border-gray-300 text-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            <option value="">Semua Kategori</option>
            <?php $__currentLoopData = $kategoriList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($kat->kategori); ?>"><?php echo e($kat->kategori); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>

    
    
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php $__empty_1 = true; $__currentLoopData = $templates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $template): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="bg-white p-4 rounded-lg shadow-md border flex flex-col justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-900"><?php echo e($template->nama_template); ?></h3>
                <p class="text-sm text-gray-500 mt-1">Kategori: <?php echo e($template->kategori); ?></p>
                <p class="text-sm text-gray-700 mt-2"><?php echo e($template->deskripsi); ?></p>
            </div>
            <a href="<?php echo e(Storage::url($template->file_path)); ?>" target="_blank" 
               class="mt-4 inline-block w-full text-center px-4 py-2 bg-indigo-600 text-white rounded-md text-sm font-semibold hover:bg-indigo-700">
                Lihat / Unduh
            </a>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="lg:col-span-3 text-center py-12 text-gray-500">
            <p class="text-base">Format tidak ditemukan.</p>
        </div>
        <?php endif; ?>
    </div>
</div><?php /**PATH D:\applications\arsip-bbpom - Fitur Usul Musnah - Divisi - RevisiDemo - Revisi2 - Sibob - usulpindah - Copy\resources\views/livewire/pusat-template.blade.php ENDPATH**/ ?>