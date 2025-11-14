<div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md">
    
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Manajemen Usul Pindah</h2>
        <p class="mt-1 text-sm text-gray-500">Daftar usulan pemindahan arsip yang telah & akan diajukan ke Unit Kearsipan Tata Usaha.</p>
    </div>
    <div class="mt-6 flex flex-col sm:flex-row sm:justify-between sm:items-center space-y-4 sm:space-y-0">
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
        <div class="flex flex-col sm:flex-row sm:items-center space-y-2 sm:space-y-0 sm:space-x-2 w-full sm:w-auto">
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
                    <th scope="col" class="w-16 px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">No.</th>
                    <th scope="col" class="w-1/5 px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nomor Berita Acara</th>
                    <th scope="col" class="w-40 px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Dibuat Oleh</th>
                    <th scope="col" class="w-40 px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal Dibuat</th>
                    <th scope="col" class="w-32 px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Jumlah Arsip</th>
                    <th scope="col" class="w-48 px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                    <th scope="col" class="w-56 px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                <?php $__empty_1 = true; $__currentLoopData = $usulans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $usulan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="odd:bg-white even:bg-gray-50 align-middle">
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 text-center"><?php echo e($loop->iteration + $usulans->firstItem() - 1); ?></td>
                        <td class="px-4 py-4 text-sm font-medium text-gray-900 truncate" title="<?php echo e($usulan->nomor_ba); ?>"><?php echo e($usulan->nomor_ba); ?></td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900 truncate"><?php echo e($usulan->user->name ?? 'N/A'); ?></div>
                            <div class="text-sm text-gray-500"><?php echo e($usulan->user->divisi ? ($usulan->user->divisi->nama === 'Informasi dan Komunikasi' ? 'Infokom' : $usulan->user->divisi->nama) : 'N/A'); ?></div>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo e($usulan->created_at->isoFormat('D MMMM YYYY')); ?></td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 text-center"><?php echo e($usulan->arsips_count); ?></td>
                        <td class="px-4 py-4 whitespace-nowrap text-center text-sm font-medium">
                            <span class="inline-block w-24 px-2.5 py-1 text-xs font-medium rounded-full 
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
                        <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex justify-center items-center space-x-2">
                                <?php if($usulan->status == 'Draft'): ?>
                                    <a href="<?php echo e(route('usul-pindah.show', $usulan->id)); ?>" class="w-24 text-center px-3 py-1.5 bg-green-600 text-white text-xs font-medium rounded-md hover:bg-green-700 transition duration-150 ease-in-out" title="Lengkapi BA & Ajukan">Ajukan</a>
                                    <button type="button" onclick="konfirmasiHapusDraft(<?php echo e($usulan->id); ?>)" class="w-24 text-center px-3 py-1.5 bg-red-100 text-red-700 text-xs font-medium rounded-md hover:bg-red-200 transition duration-150 ease-in-out">Hapus</button>
                                <?php elseif($usulan->status == 'Dikembalikan'): ?>
                                    <a href="<?php echo e(route('usul-pindah.show', $usulan->id)); ?>" class="w-24 text-center px-3 py-1.5 bg-yellow-500 text-white text-xs font-medium rounded-md hover:bg-yellow-600 transition duration-150 ease-in-out">Revisi</a>
                                <?php elseif($usulan->status == 'Diajukan'): ?>
                                    <button type="button" onclick="konfirmasiBatalkanUsulan(<?php echo e($usulan->id); ?>)" class="w-24 text-center px-3 py-1.5 bg-red-100 text-red-700 text-xs font-medium rounded-md hover:bg-red-200 transition duration-150 ease-in-out">Batalkan</button>
                                    <a href="<?php echo e(route('usul-pindah.show', $usulan->id)); ?>" class="w-24 text-center px-3 py-1.5 bg-gray-200 text-gray-700 text-xs font-medium rounded-md hover:bg-gray-300 transition duration-150 ease-in-out">Lihat Detail</a>
                                <?php else: ?>
                                    <a href="<?php echo e(route('usul-pindah.show', $usulan->id)); ?>" class="w-24 text-center px-3 py-1.5 bg-gray-200 text-gray-700 text-xs font-medium rounded-md hover:bg-gray-300 transition duration-150 ease-in-out">Lihat Detail</a>
                                <?php endif; ?>
                            </div>
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
    // ================== PERBAIKAN BUG NOTIFIKASI (TAMBAHKAN INI) ==================
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
    // ==============================================================================

    // Fungsi konfirmasi (sudah benar)
    function konfirmasiHapusDraft(id) {
        Swal.fire({
            title: 'Anda Yakin?',
            text: "Draft usulan ini akan dihapus permanen dan semua arsip di dalamnya akan dikembalikan.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Hapus Draft!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                Livewire.emit('triggerHapusDraft', id);
            }
        });
    }

    function konfirmasiBatalkanUsulan(id) {
        Swal.fire({
            title: 'Anda Yakin?',
            text: "Usulan yang sudah diajukan ini akan dibatalkan dan semua arsip dikembalikan.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Batalkan Usulan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                Livewire.emit('triggerBatalkanUsulan', id);
            }
        });
    }
</script>
<?php $__env->stopPush(); ?><?php /**PATH D:\applications\arsip-bbpom - Fitur Usul Musnah - Divisi - RevisiDemo - Revisi2 - Sibob - usulpindah\resources\views/livewire/usulan-pindah-list.blade.php ENDPATH**/ ?>