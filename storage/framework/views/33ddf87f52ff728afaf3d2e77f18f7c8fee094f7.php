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
        
        
        <div class="flex justify-end w-full sm:w-auto">
            <?php if(Auth::user()->role !== 'Admin' && Auth::user()->divisi): ?>
                <div class="px-3 py-2 bg-gray-200 text-gray-600 rounded-md shadow-sm text-xs whitespace-nowrap">
                    <span>Bidang: <?php echo e(Auth::user()->divisi->nama === 'Informasi dan Komunikasi' ? 'Infokom' : Auth::user()->divisi->nama); ?></span>
                </div>
            <?php endif; ?>
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
                    
                    <th class="w-16 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No.</th>
                    <th class="w-1/5 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nomor Usulan</th> 
                    <th class="w-40 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Dibuat</th>
                    <th class="w-1/5 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dibuat Oleh</th> 
                    <th class="w-32 px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Arsip</th>                    
                    <th class="w-32 px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="w-40 px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th> 
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php $__empty_1 = true; $__currentLoopData = $usulans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $usulan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="px-4 py-3 whitespace-nowrap text-left text-sm text-gray-500"><?php echo e($loop->iteration + $usulans->firstItem() - 1); ?></td>
                        
                        <td class="px-4 py-3 text-sm text-gray-800 font-medium whitespace-normal break-words" title="<?php echo e($usulan->nomor_usulan); ?>"><?php echo e($usulan->nomor_usulan); ?></td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500"><?php echo e($usulan->created_at->isoFormat('D MMMM YYYY')); ?></td>
                        <td class="px-4 py-3 text-sm text-gray-500"><?php echo e($usulan->user->name ?? 'N/A'); ?></td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 text-center"><?php echo e($usulan->arsips->count()); ?></td>
                        <td class="px-4 py-3 whitespace-nowrap text-center text-sm text-gray-500">
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
                                <?php echo e($usulan->status); ?>

                            </span>
                        </td>
                        
                        <td class="px-4 py-3 whitespace-nowrap text-center text-sm font-medium">
                            <div class="flex justify-center items-center space-x-2">
                                <?php if($usulan->status == 'Draft'): ?>
                                    <a href="<?php echo e(route('admin.usulan-pemusnahan.cetak-excel', $usulan->id)); ?>" target="_blank" class="px-3 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-md hover:bg-green-200" title="Cetak Daftar Usulan">Cetak</a>
                                    <button wire:click.prevent="ajukan(<?php echo e($usulan->id); ?>)" 
                                            onclick="confirm('Apakah Anda yakin ingin mengajukan usulan ini ke Pusat?') || event.stopImmediatePropagation()"
                                            class="px-3 py-1 bg-indigo-600 text-white text-xs font-semibold rounded-md hover:bg-indigo-700">Ajukan</button>
                                    <button wire:click.prevent="hapusDraft(<?php echo e($usulan->id); ?>)"
                                            onclick="confirm('Yakin ingin menghapus draf ini? Arsip akan dikembalikan.') || event.stopImmediatePropagation()"
                                            class="px-3 py-1 bg-red-100 text-red-700 text-xs font-semibold rounded-md hover:bg-red-200">Hapus</button>
                                <?php elseif($usulan->status == 'Diajukan ke Pusat'): ?>
                                    <button wire:click.prevent="openLaksanakanModal(<?php echo e($usulan->id); ?>)" class="px-3 py-1 bg-indigo-600 text-white text-xs font-semibold rounded-md hover:bg-indigo-700">Musnahkan</button>
                                    <a href="<?php echo e(route('admin.usulan-pemusnahan.show', $usulan->id)); ?>" class="px-3 py-1 bg-gray-200 text-gray-700 text-xs font-semibold rounded-md hover:bg-gray-300">Lihat Detail</a>
                                    <div x-data="{ open: false }" @click.outside="open = false" class="relative">
                                        <button @click="open = !open" class="px-2 py-1 text-gray-500 hover:text-gray-700 rounded-md focus:outline-none" title="Opsi lain"><svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" /></svg></button>
                                        <div x-show="open" x-transition class="absolute z-10 right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 origin-top-right" style="display: none;">
                                            <a href="#" wire:click.prevent="openTolakModal(<?php echo e($usulan->id); ?>)" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Catat Penolakan</a>
                                            <a href="#" wire:click.prevent="batalkanUsulan(<?php echo e($usulan->id); ?>)" onclick="confirm('Yakin ingin membatalkan usulan ini? Arsip akan dikembalikan.') || event.stopImmediatePropagation()" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">Batalkan Usulan</a>
                                        </div>
                                    </div>
                                <?php elseif($usulan->status == 'Musnah, Menunggu BA'): ?>
                                    <button wire:click.prevent="openArsipkanBapaModal(<?php echo e($usulan->id); ?>)" class="px-3 py-1 bg-green-600 text-white text-xs font-semibold rounded-md hover:bg-green-700">Arsipkan BA</button>
                                    <a href="<?php echo e(route('admin.usulan-pemusnahan.show', $usulan->id)); ?>" class="px-3 py-1 bg-gray-200 text-gray-700 text-xs font-semibold rounded-md hover:bg-gray-300">Lihat Detail</a>
                                <?php elseif(in_array($usulan->status, ['Selesai', 'Dibatalkan', 'Ditolak'])): ?>
                                    <a href="<?php echo e(route('admin.usulan-pemusnahan.show', $usulan->id)); ?>" class="px-3 py-1 bg-gray-200 text-gray-700 text-xs font-semibold rounded-md hover:bg-gray-300">Lihat Detail</a>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">Data usulan pemusnahan tidak ditemukan.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="mt-4"><?php echo e($usulans->links()); ?></div>

    
    <div x-data="{ show: <?php if ((object) ('showLaksanakanModal') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($_instance->id); ?>').entangle('<?php echo e('showLaksanakanModal'->value()); ?>')<?php echo e('showLaksanakanModal'->hasModifier('defer') ? '.defer' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($_instance->id); ?>').entangle('<?php echo e('showLaksanakanModal'); ?>')<?php endif; ?> }" x-show="show" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" @click="show = false" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div x-show="show" x-transition class="inline-block w-full max-w-lg p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-lg">
                <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">Pencatatan Pelaksanaan Pemusnahan</h3>
                <p class="mt-2 text-sm text-gray-500">Lengkapi data Surat Persetujuan dari Pusat dan tanggal pemusnahan fisik.</p>
                <form wire:submit.prevent="laksanakanPemusnahan" class="mt-4 space-y-4">
                    <div>
                        <label for="nomor_surat_persetujuan" class="block text-sm font-medium text-gray-700">Nomor Surat Persetujuan*</label>
                        <input type="text" wire:model.defer="nomor_surat_persetujuan" id="nomor_surat_persetujuan" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">
                        <?php $__errorArgs = ['nomor_surat_persetujuan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div>
                        <label for="tanggal_surat_persetujuan" class="block text-sm font-medium text-gray-700">Tanggal Surat Persetujuan*</label>
                        <input type="date" wire:model.defer="tanggal_surat_persetujuan" id="tanggal_surat_persetujuan" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">
                        <?php $__errorArgs = ['tanggal_surat_persetujuan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div>
                        <label for="tanggal_pemusnahan_fisik" class="block text-sm font-medium text-gray-700">Tanggal Pemusnahan Fisik*</label>
                        <input type="date" wire:model.defer="tanggal_pemusnahan_fisik" id="tanggal_pemusnahan_fisik" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">
                        <?php $__errorArgs = ['tanggal_pemusnahan_fisik'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div>
                        <label for="file_surat_persetujuan" class="block text-sm font-medium text-gray-700">Upload Scan Surat Persetujuan (PDF)</label>
                        <input type="file" wire:model="file_surat_persetujuan" id="file_surat_persetujuan" accept=".pdf" class="block w-full mt-1 text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        <div wire:loading wire:target="file_surat_persetujuan">Mengunggah...</div>
                        <?php $__errorArgs = ['file_surat_persetujuan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="mt-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 sm:ml-3 sm:w-auto sm:text-sm">
                            Simpan & Konfirmasi
                        </button>
                        <button @click="show = false" type="button" class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 sm:mt-0 sm:w-auto sm:text-sm">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    
    <div x-data="{ show: <?php if ((object) ('showArsipkanBapaModal') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($_instance->id); ?>').entangle('<?php echo e('showArsipkanBapaModal'->value()); ?>')<?php echo e('showArsipkanBapaModal'->hasModifier('defer') ? '.defer' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($_instance->id); ?>').entangle('<?php echo e('showArsipkanBapaModal'); ?>')<?php endif; ?> }" x-show="show" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title-bapa" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" @click="show = false" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div x-show="show" x-transition class="inline-block w-full max-w-lg p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-lg">
                <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title-bapa">Arsipkan Berita Acara</h3>
                <p class="mt-2 text-sm text-gray-500">Unggah Berita Acara yang diterima dari Pusat untuk menutup proses.</p>
                <form wire:submit.prevent="arsipkanBapaFinal" class="mt-4 space-y-4">
                    <div>
                        <label for="nomor_bapa_diterima" class="block text-sm font-medium text-gray-700">Nomor Berita Acara*</label>
                        <input type="text" wire:model.defer="nomor_bapa_diterima" id="nomor_bapa_diterima" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">
                        <?php $__errorArgs = ['nomor_bapa_diterima'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div>
                        <label for="tanggal_bapa_diterima" class="block text-sm font-medium text-gray-700">Tanggal Berita Acara*</label>
                        <input type="date" wire:model.defer="tanggal_bapa_diterima" id="tanggal_bapa_diterima" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">
                        <?php $__errorArgs = ['tanggal_bapa_diterima'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div>
                        <label for="file_bapa_diterima" class="block text-sm font-medium text-gray-700">Upload Scan Berita Acara (PDF)</label>
                        <input type="file" wire:model="file_bapa_diterima" id="file_bapa_diterima" accept=".pdf" class="block w-full mt-1 text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        <div wire:loading wire:target="file_bapa_diterima">Mengunggah...</div>
                        <?php $__errorArgs = ['file_bapa_diterima'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="mt-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-green-600 border border-transparent rounded-md shadow-sm hover:bg-green-700 sm:ml-3 sm:w-auto sm:text-sm">
                            Simpan & Selesaikan
                        </button>
                        <button @click="show = false" type="button" class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 sm:mt-0 sm:w-auto sm:text-sm">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    
    <?php if($showTolakModal): ?>
    <div x-data="{ show: <?php if ((object) ('showTolakModal') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($_instance->id); ?>').entangle('<?php echo e('showTolakModal'->value()); ?>')<?php echo e('showTolakModal'->hasModifier('defer') ? '.defer' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($_instance->id); ?>').entangle('<?php echo e('showTolakModal'); ?>')<?php endif; ?> }" x-show="show" x-cloak class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="show" x-transition class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" @click="show = false"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
            <div x-show="show" x-transition class="inline-block w-full max-w-lg p-6 my-8 overflow-hidden text-left align-middle transform bg-white shadow-xl rounded-lg">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Catat Penolakan Usulan</h3>
                <p class="mt-2 text-sm text-gray-500">Lengkapi data surat penolakan resmi dari Pusat.</p>
                <form wire:submit.prevent="tolakUsulan" class="mt-4 space-y-4">
                    <div>
                        <label for="nomor_surat_penolakan" class="block text-sm font-medium text-gray-700">Nomor Surat Penolakan*</label>
                        <input type="text" wire:model.defer="nomor_surat_penolakan" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">
                        <?php $__errorArgs = ['nomor_surat_penolakan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div>
                        <label for="tanggal_surat_penolakan" class="block text-sm font-medium text-gray-700">Tanggal Surat Penolakan*</label>
                        <input type="date" wire:model.defer="tanggal_surat_penolakan" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">
                        <?php $__errorArgs = ['tanggal_surat_penolakan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div>
                        <label for="file_surat_penolakan" class="block text-sm font-medium text-gray-700">Upload Scan Surat Penolakan (PDF)</label>
                        <input type="file" wire:model="file_surat_penolakan" id="file_surat_penolakan" accept=".pdf" class="block w-full mt-1 text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        <div wire:loading wire:target="file_surat_penolakan">Mengunggah...</div>
                        <?php $__errorArgs = ['file_surat_penolakan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div>
                        <label for="catatan_penolakan" class="block text-sm font-medium text-gray-700">Catatan (Opsional)</label>
                        <textarea wire:model.defer="catatan_penolakan" rows="3" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm"></textarea>
                    </div>
                    <div class="mt-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-red-600 border border-transparent rounded-md shadow-sm hover:bg-red-700 sm:ml-3 sm:w-auto sm:text-sm">
                            Simpan Penolakan
                        </button>
                        <button @click="show = false" type="button" class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 sm:mt-0 sm:w-auto sm:text-sm">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div><?php /**PATH D:\applications\arsip-bbpom - Fitur Usul Musnah - Divisi - RevisiDemo - Revisi2 - Sibob - usulpindah\resources\views/livewire/admin/usulan-pemusnahan-table.blade.php ENDPATH**/ ?>