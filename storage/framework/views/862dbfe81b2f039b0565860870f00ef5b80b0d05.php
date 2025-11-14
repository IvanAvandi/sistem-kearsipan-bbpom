<div> 
     <?php $__env->slot('header', null, []); ?> 
        <?php if (isset($component)) { $__componentOriginal031b70f77448d6d2b1e9e96d77e7e66748a7c1aa = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Breadcrumbs::class, ['links' => ['Usul Pindah' => route('usul-pindah.index'), $usulan->status == 'Draft' || $usulan->status == 'Dikembalikan' ? 'Revisi Usulan' : 'Detail Usulan' => '#']]); ?>
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

    
    <div x-data="{ show: <?php if ((object) ('showUploadBaModal') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($_instance->id); ?>').entangle('<?php echo e('showUploadBaModal'->value()); ?>')<?php echo e('showUploadBaModal'->hasModifier('defer') ? '.defer' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($_instance->id); ?>').entangle('<?php echo e('showUploadBaModal'); ?>')<?php endif; ?> }" x-show="show" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title-ba" role="dialog" aria-modal="true">
        
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" @click="show = false" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div x-show="show" x-transition class="inline-block w-full max-w-lg p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-lg">
                <h3 class="text-lg font-semibold leading-6 text-gray-900" id="modal-title-ba">
                    <?php if($usulan->status == 'Dikembalikan'): ?>
                        Revisi Berita Acara
                    <?php else: ?>
                        Lengkapi Berita Acara
                    <?php endif; ?>
                </h3>
                <p class="mt-2 text-sm text-gray-500">Lengkapi detail Berita Acara (BA) untuk usulan pindah ini.</p>
                <form wire:submit.prevent="updateBA" class="mt-5 space-y-4">
                    <div>
                        <label for="nomor_ba_modal" class="block text-sm font-medium text-gray-700">Nomor Berita Acara*</label>
                        <input type="text" wire:model.defer="nomor_ba" id="nomor_ba_modal" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <?php $__errorArgs = ['nomor_ba'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs mt-1"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div>
                        <label for="tanggal_ba_modal" class="block text-sm font-medium text-gray-700">Tanggal Berita Acara*</label>
                        <input type="date" wire:model.defer="tanggal_ba" id="tanggal_ba_modal" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <?php $__errorArgs = ['tanggal_ba'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs mt-1"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div>
                        <label for="file_ba_modal" class="block text-sm font-medium text-gray-700">
                            Upload Scan BA (PDF)
                            <?php if($usulan->file_ba_path && !$file_ba): ?>
                                <a href="<?php echo e(Storage::url($usulan->file_ba_path)); ?>" target="_blank" class="ml-2 text-xs text-blue-500 hover:underline">(Lihat file terupload)</a>
                            <?php endif; ?>
                        </label>
                        <input type="file" wire:model="file_ba" id="file_ba_modal" accept=".pdf" class="block w-full mt-1 text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition duration-150 ease-in-out">
                        <div wire:loading wire:target="file_ba" class="text-sm text-gray-500 mt-1">Mengunggah...</div>
                        <?php $__errorArgs = ['file_ba'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs mt-1"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <p class="text-xs text-gray-500 mt-1">Kosongkan jika hanya mengubah nomor/tanggal BA.</p>
                    </div>
                    <div class="mt-6 pt-4 border-t border-gray-200 sm:flex sm:flex-row-reverse">
                        <button type="submit" 
                                
                                wire:loading.attr="disabled" wire:loading.class="opacity-50 cursor-wait"
                                class="inline-flex justify-center w-full px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto transition duration-150 ease-in-out">
                            <span wire:loading wire:target="updateBA">Menyimpan...</span>
                            <span wire:loading.remove wire:target="updateBA">Simpan Perubahan BA</span>
                        </button>
                        <button @click="show = false" type="button" class="inline-flex justify-center w-full px-4 py-2 mt-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto transition duration-150 ease-in-out">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex items-start space-x-5">
                        <?php
                            $iconClass = 'bg-gray-100 text-gray-600';
                            $iconSvg = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-2m-4-1v8m0 0l3-3m-3 3L9 8m-5 5h2.586a1 1 0 01.707.293l2.414 2.414a1 1 0 001.414 0l2.414-2.414a1 1 0 01.707-.293H17" />';
                            if($usulan->status == 'Selesai') { $iconClass = 'bg-green-100 text-green-600'; $iconSvg = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />'; }
                            elseif($usulan->status == 'Dikembalikan') { $iconClass = 'bg-yellow-100 text-yellow-600'; $iconSvg = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />'; }
                            elseif($usulan->status == 'Diajukan') { $iconClass = 'bg-blue-100 text-blue-600'; $iconSvg = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />'; }
                            elseif($usulan->status == 'Dibatalkan') { $iconClass = 'bg-red-100 text-red-600'; $iconSvg = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />'; }
                        ?>
                        <div class="flex-shrink-0 <?php echo e($iconClass); ?> p-3 rounded-lg">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><?php echo $iconSvg; ?></svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-900"><?php echo e($usulan->nomor_ba); ?></h2>
                            <p class="mt-1 text-sm text-gray-500">
                                Dibuat oleh: <span class="font-medium text-gray-700"><?php echo e($usulan->user->name ?? 'N/A'); ?></span>
                                (Bidang <?php echo e($usulan->user->divisi ? ($usulan->user->divisi->nama === 'Informasi dan Komunikasi' ? 'Infokom' : $usulan->user->divisi->nama) : 'N/A'); ?>)
                            </p>
                            <p class="mt-1 text-sm text-gray-500">
                                Dibuat: <span class="font-medium text-gray-700"><?php echo e($usulan->created_at->isoFormat('D MMMM YYYY, HH:mm')); ?></span>
                                <?php if($usulan->diusulkanOleh): ?>
                                    <span class="text-gray-400 mx-1">|</span>
                                    Diajukan: <span class="font-medium text-gray-700"><?php echo e($usulan->diusulkanOleh->name); ?></span>
                                    (<?php echo e($usulan->diajukan_pada->isoFormat('D MMM Y, HH:mm')); ?>)
                                <?php endif; ?>
                            </p>
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

            
            <?php if($usulan->status == 'Diajukan'): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-blue-50 border-blue-200 p-6 rounded-lg border shadow-sm h-full">
                    <h4 class="font-semibold text-blue-800 flex items-center mb-2">
                    <svg class="h-5 w-5 text-blue-500 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M10 2a6 6 0 00-6 6v3.586l-1.293 1.293a1 1 0 001.414 1.414L6 12.414V16a1 1 0 001 1h6a1 1 0 001-1v-3.586l1.293 1.293a1 1 0 001.414-1.414L14 11.586V8a6 6 0 00-6-6zm0 12a2 2 0 100-4 2 2 0 000 4z" /></svg>
                        Menunggu Review
                    </h4>
                    <p class="text-sm text-blue-900">Usulan Anda sedang di-review oleh Tata Usaha.</p>
                    <button type="button" onclick="konfirmasiBatalkan()" 
                            
                            wire:loading.attr="disabled" wire:loading.class="opacity-50 cursor-wait"
                            class="inline-flex items-center justify-center w-full px-4 py-2 mt-4 text-red-600 border border-red-600 rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-red-50 transition duration-150 ease-in-out">
                        <span wire:loading wire:target="batalkan">Membatalkan...</span>
                        <span wire:loading.remove wire:target="batalkan">Batalkan Usulan</span>
                    </button>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg h-full">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Detail Berita Acara</h3>
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <dl class="text-sm space-y-3">
                                <div class="flex justify-between"><dt class="text-sm text-gray-500">Nomor Berita Acara:</dt> <dd class="text-sm font-medium text-gray-900 text-right"><?php echo e($usulan->nomor_ba ?? '-'); ?></dd></div>
                                <div class="flex justify-between"><dt class="text-sm text-gray-500">Tanggal Berita Acara:</dt> <dd class="text-sm font-medium text-gray-900 text-right"><?php echo e($usulan->tanggal_ba ? $usulan->tanggal_ba->isoFormat('D MMM Y') : '-'); ?></dd></div>
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
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-yellow-50 border-yellow-200 p-4 rounded-lg border">
                            <h4 class="font-semibold text-yellow-800 flex items-center mb-2">
                               <svg class="h-5 w-5 text-yellow-500 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" /></svg>
                                Catatan Revisi dari Tata Usaha
                            </h4>
                            <?php if($usulan->dikembalikanOleh): ?>
                            <p class="text-sm text-yellow-800 mb-2">
                                Dikembalikan oleh: <span class="font-medium"><?php echo e($usulan->dikembalikanOleh->name); ?></span>
                                (<?php echo e($usulan->dikembalikan_pada->isoFormat('D MMM Y, HH:mm')); ?>)
                            </p>
                            <?php endif; ?>
                            <p class="text-sm text-yellow-700 italic">"<?php echo e($usulan->catatan_admin ?? 'Tidak ada catatan.'); ?>"</p>
                        </div>
                        <div class="bg-gray-50 border-gray-200 p-4 rounded-lg border">
                            <h4 class="font-semibold text-gray-700 flex items-center mb-2">
                                <svg class="h-5 w-5 text-gray-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
                                Langkah Perbaikan
                            </h4>
                            <ol class="list-decimal list-inside text-sm text-gray-600 space-y-1">
                                <li>Perbaiki atau hapus arsip didalam daftar (jika perlu).</li>
                                <li>Klik <strong>Export Daftar Arsip dibawah</strong>.</li>
                                <li>gabungkan dengan Berita Acara Pemindahan Arsip.</li>
                                <li>Klik <strong>Edit Berita Acara</strong> untuk upload file PDF baru.</li>
                                <li>Klik <strong>Ajukan Ulang</strong> untuk mengirim kembali ke unit kearsipan Tata Usaha.</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            
            <?php elseif($usulan->status == 'Draft'): ?>
             
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                     <div class="bg-gray-50 border-gray-200 p-4 rounded-lg border">
                        <h4 class="font-semibold text-blue-800 flex items-center mb-2">
                            <svg class="h-5 w-5 text-blue-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
                            Langkah Pengajuan
                        </h4>
                        <ol class="list-decimal list-inside text-sm text-gray-600 space-y-1">
                            <li>Klik <strong>Export Daftar Arsip</strong> di bawah.</li>
                            <li>Gabungkan dengan Berita Acara Pemindahan Arsip.</li>
                            <li>Klik <strong>Lengkapi Berita Acara</strong> untuk upload file PDF gabungan.</li>
                            <li>Klik <strong>Ajukan Usulan</strong> untuk mengirim ke unit kearsipan Tata Usaha.</li>
                        </ol>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            
            <?php if(in_array($usulan->status, ['Draft', 'Dikembalikan', 'Diajukan'])): ?>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                 <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4 mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Daftar Arsip yang Diusulkan (<?php echo e($arsipList->count()); ?> arsip)</h3>
                        <div class="flex items-center space-x-2">
                            <?php if(count($tempDeletedArsipIds) > 0 && in_array($usulan->status, ['Draft', 'Dikembalikan'])): ?>
                                <button wire:click="undoRemove" class="inline-flex items-center px-3 py-1 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition duration-150 ease-in-out" title="Kembalikan arsip yang baru dihapus">
                                    Batalkan Hapus (<?php echo e(count($tempDeletedArsipIds)); ?>)
                                </button>
                            <?php endif; ?>
                            <?php if(count($selectedArsip) > 0 && in_array($usulan->status, ['Draft', 'Dikembalikan'])): ?>
                                <button type="button" onclick="konfirmasiHapusArsip()" 
                                        
                                        wire:loading.attr="disabled" wire:loading.class="opacity-50 cursor-wait"
                                        class="inline-flex items-center px-3 py-1 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 transition duration-150 ease-in-out">
                                    <span wire:loading wire:target="removeSelectedArsips">Menghapus...</span>
                                    <span wire:loading.remove wire:target="removeSelectedArsips">Hapus Arsip Terpilih (<?php echo e(count($selectedArsip)); ?>)</span>
                                </button>
                            <?php endif; ?>
                            <?php if(in_array($usulan->status, ['Draft', 'Dikembalikan'])): ?>
                                <button wire:click="exportBA" class="inline-flex items-center px-3 py-1 bg-gray-200 text-gray-700 text-sm font-semibold rounded-md hover:bg-gray-300 transition duration-150 ease-in-out" title="Export daftar arsip ini untuk dilampirkan ke BA">
                                    <svg class="h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M10.75 2.75a.75.75 0 00-1.5 0v8.614L6.295 8.235a.75.75 0 10-1.09 1.03l4.25 4.5a.75.75 0 001.09 0l4.25-4.5a.75.75 0 00-1.09-1.03l-2.955 3.129V2.75z" /><path d="M3.5 12.75a.75.75 0 00-1.5 0v2.5A2.75 2.75 0 004.75 18h10.5A2.75 2.75 0 0018 15.25v-2.5a.75.75 0 00-1.5 0v2.5c0 .69-.56 1.25-1.25 1.25H4.75c-.69 0-1.25-.56-1.25-1.25v-2.5z" /></svg>
                                    EXPORT
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="mt-4 overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <?php if(in_array($usulan->status, ['Draft', 'Dikembalikan'])): ?>
                                    <th scope="col" class="w-12 px-4 py-3">
                                        <input type="checkbox" wire:model="selectAll" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                    </th>
                                    <?php endif; ?>
                                    <th scope="col" class="w-16 px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No</th>
                                    <th scope="col" class="w-1/6 px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kode Klasifikasi</th>
                                    <th scope="col" class="w-2/5 px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Uraian Berkas</th>
                                    <th scope="col" class="w-1/6 px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal Arsip</th>
                                    <th scope="col" class="w-1/6 px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="w-24 px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                <?php $__empty_1 = true; $__currentLoopData = $arsipList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $arsip): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr class="align-middle <?php echo e(in_array($arsip->id, $selectedArsip) ? 'bg-indigo-50' : 'odd:bg-white even:bg-gray-50'); ?>">
                                        <?php if(in_array($usulan->status, ['Draft', 'Dikembalikan'])): ?>
                                        <td class="px-4 py-4">
                                            <input type="checkbox" wire:model="selectedArsip" value="<?php echo e($arsip->id); ?>" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                        </td>
                                        <?php endif; ?>
                                        <td class="px-4 py-4 text-sm text-gray-500"><?php echo e($loop->iteration); ?></td>
                                        <td class="px-4 py-4 text-sm text-gray-900 whitespace-nowrap"><?php echo e($arsip->klasifikasiSurat->kode_klasifikasi ?? 'N/A'); ?></td>
                                        <td class="px-4 py-4 text-sm text-gray-900"><?php echo e($arsip->uraian_berkas); ?></td>
                                        <td class="px-4 py-4 text-sm text-center whitespace-nowrap"><?php echo e(\Carbon\Carbon::parse($arsip->tanggal_arsip)->isoFormat('D MMM Y')); ?></td>
                                        <td class="px-4 py-4 text-sm text-center">
                                            <span class="px-2.5 py-0.5 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800">
                                                Inaktif
                                            </span>
                                        </td>
                                        <td class="px-4 py-4 text-center">
                                             <a href="<?php echo e(route('arsip.show', $arsip->id)); ?>" title="Lihat Detail Arsip" class="text-gray-400 hover:text-indigo-600 transition duration-150 ease-in-out">
                                                <svg class="h-5 w-5 inline" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z" /><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.522 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" /></svg>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="<?php echo e(in_array($usulan->status, ['Draft', 'Dikembalikan']) ? '7' : '6'); ?>" class="px-6 py-10 text-center text-sm text-gray-500">
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

            
            <?php if(in_array($usulan->status, ['Draft', 'Dikembalikan'])): ?>
            <div class="grid grid-cols-1 lg:grid-cols-10 gap-6">
                
                <div class="lg:col-span-7">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg h-full">
                        <div class="p-6">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-semibold text-gray-800">Detail Berita Acara</h3>
                                <button wire:click="openUploadBaModal" class="inline-flex items-center px-3 py-1.5 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-600 transition duration-150 ease-in-out">
                                    <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" /><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" /></svg>
                                    <?php echo e($usulan->status == 'Dikembalikan' ? 'Edit Berita Acara' : 'Lengkapi Berita Acara'); ?>

                                </button>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                <dl class="text-sm space-y-3">
                                    <div class="flex justify-between"><dt class="text-sm text-gray-500">Nomor Berita Acara:</dt> <dd class="text-sm font-medium text-gray-900 text-right"><?php echo e($usulan->nomor_ba ?? '-'); ?></dd></div>
                                    <div class="flex justify-between"><dt class="text-sm text-gray-500">Tanggal Berita Acara:</dt> <dd class="text-sm font-medium text-gray-900 text-right"><?php echo e($usulan->tanggal_ba ? $usulan->tanggal_ba->isoFormat('D MMM Y') : '-'); ?></dd></div>
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
                
                <div class="lg:col-span-3">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg h-full">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Aksi Final</h3>
                            <div class="space-y-3">
                                
                                <button type="button" onclick="konfirmasiAjukanUlang()"
                                        
                                        wire:loading.attr="disabled" wire:loading.class="opacity-50 cursor-wait"
                                        class="inline-flex items-center justify-center w-full px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 transition duration-150 ease-in-out">
                                    <span wire:loading wire:target="ajukanUlang">Mengajukan...</span>
                                    <span wire:loading.remove wire:target="ajukanUlang"><?php echo e($usulan->status == 'Dikembalikan' ? 'Ajukan Ulang' : 'Ajukan Usulan'); ?></span>
                                </button>
                                
                                <?php if($usulan->status == 'Draft'): ?>
                                    <button type="button" onclick="konfirmasiHapusDraft()"
                                            
                                            wire:loading.attr="disabled" wire:loading.class="opacity-50 cursor-wait"
                                            class="inline-flex items-center justify-center w-full px-4 py-2 text-red-600 border border-red-600 rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-red-50 transition duration-150 ease-in-out">
                                        <span wire:loading wire:target="hapusDraft">Menghapus...</span>
                                        <span wire:loading.remove wire:target="hapusDraft">Hapus Draft</span>
                                    </button>
                                <?php else: ?> 
                                    <button type="button" onclick="konfirmasiBatalkan()"
                                            
                                            wire:loading.attr="disabled" wire:loading.class="opacity-50 cursor-wait"
                                            class="inline-flex items-center justify-center w-full px-4 py-2 text-red-600 border border-red-600 rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-red-50 transition duration-150 ease-in-out">
                                        <span wire:loading wire:target="batalkan">Membatalkan...</span>
                                        <span wire:loading.remove wire:target="batalkan">Batalkan Usulan</span>
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
            <?php elseif(in_array($usulan->status, ['Selesai', 'Dibatalkan'])): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <?php if($usulan->status == 'Selesai'): ?>
                <div class="bg-green-50 border-green-200 p-6 rounded-lg border shadow-sm h-full">
                    <h4 class="font-semibold text-green-800 flex items-center mb-2">
                       <svg class="h-5 w-5 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                        Usulan Disetujui
                    </h4>
                    <p class="text-sm text-green-900">Arsip telah resmi dipindahkan ke unit kearsipan Tata Usaha.</p>
                    <?php if($usulan->disetujuiOleh): ?>
                    <p class="text-sm text-green-800 mt-2">
                        Disetujui oleh: <span class="font-medium"><?php echo e($usulan->disetujuiOleh->name); ?></span>
                        (<?php echo e($usulan->disetujui_pada->isoFormat('D MMM Y, HH:mm')); ?>)
                    </p>
                    <?php endif; ?>
                </div>
                <?php elseif($usulan->status == 'Dibatalkan'): ?>
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
                <?php endif; ?>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg h-full">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Detail Berita Acara</h3>
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <dl class="text-sm space-y-3">
                                <div class="flex justify-between"><dt class="text-sm text-gray-500">Nomor Berita Acara:</dt> <dd class="text-sm font-medium text-gray-900 text-right"><?php echo e($usulan->nomor_ba ?? '-'); ?></dd></div>
                                <div class="flex justify-between"><dt class="text-sm text-gray-500">Tanggal Berita Acara:</dt> <dd class="text-sm font-medium text-gray-900 text-right"><?php echo e($usulan->tanggal_ba ? $usulan->tanggal_ba->isoFormat('D MMM Y') : '-'); ?></dd></div>
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
            
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    // Konfirmasi untuk Hapus Arsip Terpilih (dari tabel)
    function konfirmasiHapusArsip() {
        Swal.fire({
            title: 'Anda Yakin?',
            text: "Arsip yang dipilih akan dihapus dari usulan ini.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Hapus Arsip!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Ini memanggil method publik, jadi window.livewire.find('<?php echo e($_instance->id); ?>').call sudah benar
                window.livewire.find('<?php echo e($_instance->id); ?>').call('removeSelectedArsips');
            }
        });
    }

    // =================== PERBAIKAN SCRIPT DI SINI ===================
    // Konfirmasi untuk Ajukan Ulang / Ajukan Usulan
    function konfirmasiAjukanUlang() {
        Swal.fire({
            title: 'Ajukan Usulan?',
            text: "Pastikan Berita Acara (BA) sudah benar. Usulan akan dikirim ke Tata Usaha untuk ditinjau.",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#16a34a', // Hijau
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Ajukan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Ganti window.livewire.find('<?php echo e($_instance->id); ?>').call menjadi Livewire.emit
                Livewire.emit('triggerAjukanUlang');
            }
        });
    }

    // Konfirmasi untuk Hapus Draft
    function konfirmasiHapusDraft() {
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
                // Ganti window.livewire.find('<?php echo e($_instance->id); ?>').call menjadi Livewire.emit
                Livewire.emit('triggerHapusDraft');
            }
        });
    }

    // Konfirmasi untuk Batalkan Usulan (status Dikembalikan/Diajukan)
    function konfirmasiBatalkan() {
        Swal.fire({
            title: 'Anda Yakin?',
            text: "Usulan ini akan dibatalkan dan semua arsip dikembalikan.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Batalkan Usulan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Ganti window.livewire.find('<?php echo e($_instance->id); ?>').call menjadi Livewire.emit
                Livewire.emit('triggerBatalkan');
            }
        });
    }
</script>
<?php $__env->stopPush(); ?><?php /**PATH D:\applications\arsip-bbpom - Fitur Usul Musnah - Divisi - RevisiDemo - Revisi2 - Sibob - usulpindah\resources\views/livewire/usulan-pindah-show.blade.php ENDPATH**/ ?>