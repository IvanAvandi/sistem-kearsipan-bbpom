<div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md">
    
    
    
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Daftar Pengguna</h2>
        <p class="mt-1 text-base text-gray-500">Lihat daftar pengguna, role mereka, dan arsip yang telah mereka buat di sistem ini.</p>
    </div>

    
    
    
    <div class="mt-6 flex flex-col sm:flex-row sm:justify-between sm:items-center space-y-4 sm:space-y-0">
        <div class="relative w-full sm:w-1/3">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </span>
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.input','data' => ['type' => 'text','wire:model.debounce.300ms' => 'search','placeholder' => 'Cari nama atau email...','class' => 'pl-10 w-full']]); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => 'text','wire:model.debounce.300ms' => 'search','placeholder' => 'Cari nama atau email...','class' => 'pl-10 w-full']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
        </div>

        <div class="flex flex-col sm:flex-row sm:items-center space-y-2 sm:space-y-0 sm:space-x-2 w-full sm:w-auto">
            <select wire:model="filterBidang" class="w-full sm:w-auto rounded-md shadow-sm border-gray-300 text-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                <option value="">Semua Unit Pengolah</option>
                <?php $__currentLoopData = $allDivisi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $divisi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($divisi->id); ?>">
                        <?php echo e($divisi->nama === 'Informasi dan Komunikasi' ? 'Infokom' : $divisi->nama); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>

            <select wire:model="filterStatus" class="w-full sm:w-auto rounded-md shadow-sm border-gray-300 text-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                <option value="">Semua Status</option>
                <option value="Y">Aktif</option>
                <option value="N">Tidak Aktif</option>
            </select>

            
            <button wire:click="export" 
                    class="inline-flex items-center justify-center w-full sm:w-auto px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-sm text-gray-700 shadow-sm hover:bg-gray-50">
                <svg class="w-5 h-5 mr-2 -ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M10.75 2.75a.75.75 0 00-1.5 0v8.614L6.295 8.235a.75.75 0 10-1.09 1.03l4.25 4.5a.75.75 0 001.09 0l4.25-4.5a.75.75 0 00-1.09-1.03l-2.955 3.129V2.75z" /><path d="M3.5 12.75a.75.75 0 00-1.5 0v2.5A2.75 2.75 0 004.75 18h10.5A2.75 2.75 0 0018 15.25v-2.5a.75.75 0 00-1.5 0v2.5c0 .69-.56 1.25-1.25 1.25H4.75c-.69 0-1.25-.56-1.25-1.25v-2.5z" /></svg>
                Export
            </button>
        </div>
    </div>

    
    
    
    <div class="mt-4 overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="w-16 px-4 py-3 text-left text-sm font-medium text-gray-700 uppercase tracking-wider">No.</th>
                    <th class="w-1/4 px-4 py-3 text-left text-sm font-medium text-gray-700 uppercase tracking-wider">Nama Pengguna</th>
                    <th class="w-1/4 px-4 py-3 text-left text-sm font-medium text-gray-700 uppercase tracking-wider">Email</th>
                    <th class="w-1/6 px-4 py-3 text-center text-sm font-medium text-gray-700 uppercase tracking-wider">Unit Pengolah</th>
                    <th class="w-1/6 px-4 py-3 text-center text-sm font-medium text-gray-700 uppercase tracking-wider">Role Kearsipan</th>
                    <th class="w-1/6 px-4 py-3 text-center text-sm font-medium text-gray-700 uppercase tracking-wider">Status Akun</th>
                    <th class="w-32 px-4 py-3 text-center text-sm font-medium text-gray-700 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="odd:bg-white even:bg-gray-50 align-middle">
                        <td class="px-4 py-3 whitespace-nowrap text-left text-sm text-gray-700"><?php echo e($loop->iteration + $users->firstItem() - 1); ?></td>
                        <td class="px-4 py-3 text-sm font-medium text-gray-900 whitespace-normal break-words" title="<?php echo e($user->name); ?>"><?php echo e($user->name); ?></td>
                        <td class="px-4 py-3 text-sm text-gray-700 whitespace-normal break-words" title="<?php echo e($user->email); ?>"><?php echo e($user->email ?? '-'); ?></td>
                        
                        <td class="px-4 py-3 text-center text-sm text-gray-700 whitespace-normal break-words">
                            <?php echo e($user->divisi ? ($user->divisi->nama === 'Informasi dan Komunikasi' ? 'Infokom' : $user->divisi->nama) : '(Tidak ada Unit Pengolah)'); ?>

                        </td>
                        
                        <td class="px-4 py-3 whitespace-nowrap text-center text-sm font-medium">
                            <?php if($user->role == 'Admin'): ?>
                                <span class="inline-flex justify-center items-center px-2.5 py-0.5 text-xs font-medium rounded-full w-24 bg-indigo-100 text-indigo-800">
                                    <?php echo e($user->role); ?>

                                </span>
                            <?php else: ?>
                                <span class="inline-flex justify-center items-center px-2.5 py-0.5 text-xs font-medium rounded-full w-24 bg-gray-200 text-gray-800">
                                    <?php echo e($user->role); ?>

                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-center text-sm font-medium">
                            <?php if($user->aktif == 'Y'): ?>
                                <span class="inline-flex justify-center items-center px-2.5 py-0.5 text-xs font-medium rounded-full w-24 bg-green-100 text-green-800">
                                    Aktif
                                </span>
                            <?php else: ?>
                                <span class="inline-flex justify-center items-center px-2.5 py-0.5 text-xs font-medium rounded-full w-24 bg-red-100 text-red-800">
                                    Tidak Aktif
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-center text-sm font-medium">
                            <a href="<?php echo e(route('arsip.index', ['createdBy' => $user->id])); ?>"
                               class="inline-flex items-center justify-center px-3 py-2 text-sm font-medium w-28
                                      bg-white text-gray-700 border border-gray-300 rounded-md shadow-sm
                                      hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                               title="Lihat arsip yang dibuat oleh <?php echo e($user->name); ?>">
                                Lihat Arsip
                            </a>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">Data pengguna tidak ditemukan.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    
    
    
    <div class="mt-4">
        <?php echo e($users->links()); ?>

    </div>
</div><?php /**PATH D:\MAGANG\sistem-kearsipan-bbpom\resources\views/livewire/admin/user-table.blade.php ENDPATH**/ ?>