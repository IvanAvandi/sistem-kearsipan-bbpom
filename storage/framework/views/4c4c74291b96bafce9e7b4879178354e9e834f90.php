


<?php if($errors->any()): ?>
    <div class="mb-4 p-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
        <strong>Whoops! Terjadi kesalahan.</strong>
        <ul class="list-disc list-inside mt-1">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
<?php endif; ?>




<?php
    $user = Auth::user();
    $isAdmin = $user->role === 'Admin';
    $isDuplicating = (isset($isDuplicate) && $isDuplicate === true);

    // Definisikan variabel dengan aman menggunakan isset($arsip)
    $selectedDivisiId = old('divisi_id', isset($arsip) ? $arsip->divisi_id : ($isAdmin ? null : $user->divisi_id));
    $selectedKlasId = old('klasifikasi_surat_id', isset($arsip) ? $arsip->klasifikasi_surat_id : null);
    
    $initialJra = '';
    if ($selectedKlasId) {
        $selectedKlas = collect($klasifikasi_list)->firstWhere('id', $selectedKlasId);
        if ($selectedKlas) {
            $initialJra = "Retensi: {$selectedKlas->masa_aktif} thn Aktif, {$selectedKlas->masa_inaktif} thn Inaktif. Status Akhir: {$selectedKlas->status_akhir}";
        }
    }
    
    $existingFiles = (isset($arsip) && !$isDuplicating) ? $arsip->files : collect();
    $defaultLink = isset($arsip) ? $arsip->link_eksternal : null;
    
    // Tentukan default upload type dengan aman
    $defaultUploadType = old('upload_type', $defaultLink ? 'link' : ($existingFiles->isNotEmpty() ? 'file' : ''));
?>

<form id="arsip-form" method="POST" action="<?php echo e(isset($arsip) ? ($isDuplicating ? route('arsip.store') : route('arsip.update', $arsip->id)) : route('arsip.store')); ?>" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
    <?php if(isset($arsip) && !$isDuplicating): ?>
        <?php echo method_field('PUT'); ?>
    <?php endif; ?>

    <div class="space-y-6">
        
        
        
        <fieldset class="border p-4 rounded-md">
            <legend class="text-lg font-medium text-gray-900 px-2">Informasi Berkas</legend>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">

                <div>
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.label','data' => ['for' => 'klasifikasi_surat_id','value' => 'Kode Klasifikasi*']]); ?>
<?php $component->withName('label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'klasifikasi_surat_id','value' => 'Kode Klasifikasi*']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    <select name="klasifikasi_surat_id" id="select-klasifikasi" placeholder="Pilih atau cari kode..." required
                            class="block w-full rounded-md shadow-sm border-gray-300 mt-1">
                        <option value="">Pilih atau cari kode...</option>
                        <?php $__currentLoopData = $klasifikasi_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $klas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option
                                value="<?php echo e($klas->id); ?>"
                                <?php echo e($selectedKlasId == $klas->id ? 'selected' : ''); ?>>
                                <?php echo e($klas->kode_klasifikasi); ?> - <?php echo e($klas->nama_klasifikasi); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                     <?php $__errorArgs = ['klasifikasi_surat_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs mt-1 block"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div>
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.label','data' => ['for' => 'tanggal_arsip','value' => 'Tanggal Arsip Perhitungan JRA*']]); ?>
<?php $component->withName('label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'tanggal_arsip','value' => 'Tanggal Arsip Perhitungan JRA*']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.input','data' => ['id' => 'tanggal_arsip','class' => 'block mt-1 w-full','type' => 'date','name' => 'tanggal_arsip','value' => old('tanggal_arsip', isset($arsip) ? $arsip->tanggal_arsip : ''),'required' => true]]); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'tanggal_arsip','class' => 'block mt-1 w-full','type' => 'date','name' => 'tanggal_arsip','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('tanggal_arsip', isset($arsip) ? $arsip->tanggal_arsip : '')),'required' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                     <?php $__errorArgs = ['tanggal_arsip'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs mt-1 block"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div>
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.label','data' => ['for' => 'jra_otomatis','value' => 'Jadwal Retensi Arsip']]); ?>
<?php $component->withName('label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'jra_otomatis','value' => 'Jadwal Retensi Arsip']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    <input id="jra_otomatis" class="block mt-1 w-full bg-gray-100 rounded-md border-gray-300 shadow-sm" type="text" readonly value="<?php echo e($initialJra); ?>"/>
                </div>

                <div>
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.label','data' => ['for' => 'divisi_id','value' => 'Unit Pengolah*']]); ?>
<?php $component->withName('label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'divisi_id','value' => 'Unit Pengolah*']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    <?php if($isAdmin): ?>
                        <select name="divisi_id" id="selected_divisi_id" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" required>
                            <option value="">Pilih Unit Pengolah...</option>
                            <?php $__currentLoopData = $allDivisi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($d->id); ?>" 
                                    <?php echo e($selectedDivisiId == $d->id ? 'selected' : ''); ?>>
                                    <?php echo e($d->nama === 'Informasi dan Komunikasi' ? 'Infokom' : $d->nama); ?>

                                </option> 
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    <?php else: ?>
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.input','data' => ['type' => 'text','id' => 'divisi_nama_readonly','readonly' => true,'class' => 'block mt-1 w-full bg-gray-100 rounded-md border-gray-300','value' => ''.e($user->divisi->nama ?? 'Unit Pengolah tidak terdaftar').'']]); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => 'text','id' => 'divisi_nama_readonly','readonly' => true,'class' => 'block mt-1 w-full bg-gray-100 rounded-md border-gray-300','value' => ''.e($user->divisi->nama ?? 'Unit Pengolah tidak terdaftar').'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        <input type="hidden" id="selected_divisi_id" name="divisi_id" value="<?php echo e($selectedDivisiId); ?>">
                    <?php endif; ?>
                     <?php $__errorArgs = ['divisi_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs mt-1 block"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="md:col-span-2">
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.label','data' => ['for' => 'uraian_berkas','value' => 'Uraian Berkas*']]); ?>
<?php $component->withName('label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'uraian_berkas','value' => 'Uraian Berkas*']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    <textarea id="uraian_berkas" name="uraian_berkas" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" rows="3" required><?php echo e(old('uraian_berkas', isset($arsip) ? $arsip->uraian_berkas : '')); ?></textarea>
                    <?php $__errorArgs = ['uraian_berkas'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs mt-1 block"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div>
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.label','data' => ['for' => 'bentuk_naskah_id','value' => 'Bentuk Naskah']]); ?>
<?php $component->withName('label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'bentuk_naskah_id','value' => 'Bentuk Naskah']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    <select name="bentuk_naskah_id" id="select-bentuk-naskah" class="block mt-1 w-full rounded-md shadow-sm border-gray-300">
                        <option value="">Pilih Bentuk Naskah</option>
                        <?php $__currentLoopData = $bentuk_naskah_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bn): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($bn->id); ?>"
                                <?php echo e(old('bentuk_naskah_id', isset($arsip) ? $arsip->bentuk_naskah_id : '') == $bn->id ? 'selected' : ''); ?>>
                                <?php echo e($bn->nama_bentuk_naskah); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                     <?php $__errorArgs = ['bentuk_naskah_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs mt-1 block"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.label','data' => ['for' => 'kurun_waktu','value' => 'Kurun Waktu (Tahun)']]); ?>
<?php $component->withName('label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'kurun_waktu','value' => 'Kurun Waktu (Tahun)']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.input','data' => ['id' => 'kurun_waktu','class' => 'block mt-1 w-full','type' => 'text','name' => 'kurun_waktu','value' => old('kurun_waktu', isset($arsip) ? $arsip->kurun_waktu : ''),'pattern' => '\d{4}','title' => 'Masukkan tahun (4 digit)','placeholder' => 'YYYY']]); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'kurun_waktu','class' => 'block mt-1 w-full','type' => 'text','name' => 'kurun_waktu','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('kurun_waktu', isset($arsip) ? $arsip->kurun_waktu : '')),'pattern' => '\d{4}','title' => 'Masukkan tahun (4 digit)','placeholder' => 'YYYY']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        <?php $__errorArgs = ['kurun_waktu'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs mt-1 block"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div>
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.label','data' => ['for' => 'jumlah_berkas','value' => 'Jumlah Berkas']]); ?>
<?php $component->withName('label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'jumlah_berkas','value' => 'Jumlah Berkas']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.input','data' => ['id' => 'jumlah_berkas','class' => 'block mt-1 w-full','type' => 'text','name' => 'jumlah_berkas','value' => old('jumlah_berkas', isset($arsip) ? $arsip->jumlah_berkas : '')]]); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'jumlah_berkas','class' => 'block mt-1 w-full','type' => 'text','name' => 'jumlah_berkas','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('jumlah_berkas', isset($arsip) ? $arsip->jumlah_berkas : ''))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                         <?php $__errorArgs = ['jumlah_berkas'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs mt-1 block"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.label','data' => ['for' => 'tingkat_perkembangan','value' => 'Tingkat Perkembangan*']]); ?>
<?php $component->withName('label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'tingkat_perkembangan','value' => 'Tingkat Perkembangan*']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        <select name="tingkat_perkembangan" id="tingkat_perkembangan" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" required>
                             <option value="Asli" <?php echo e(old('tingkat_perkembangan', isset($arsip) ? $arsip->tingkat_perkembangan : 'Asli') == 'Asli' ? 'selected' : ''); ?>>Asli</option>
                             <option value="Copy" <?php echo e(old('tingkat_perkembangan', isset($arsip) ? $arsip->tingkat_perkembangan : '') == 'Copy' ? 'selected' : ''); ?>>Copy</option>
                             <option value="Softcopy" <?php echo e(old('tingkat_perkembangan', isset($arsip) ? $arsip->tingkat_perkembangan : '') == 'Softcopy' ? 'selected' : ''); ?>>Softcopy</option>
                        </select>
                         <?php $__errorArgs = ['tingkat_perkembangan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs mt-1 block"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div>
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.label','data' => ['for' => 'lokasi_penyimpanan','value' => 'Lokasi Penyimpanan*']]); ?>
<?php $component->withName('label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'lokasi_penyimpanan','value' => 'Lokasi Penyimpanan*']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.input','data' => ['id' => 'lokasi_penyimpanan','class' => 'block mt-1 w-full','type' => 'text','name' => 'lokasi_penyimpanan','value' => old('lokasi_penyimpanan', isset($arsip) ? $arsip->lokasi_penyimpanan : ''),'required' => true]]); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'lokasi_penyimpanan','class' => 'block mt-1 w-full','type' => 'text','name' => 'lokasi_penyimpanan','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('lokasi_penyimpanan', isset($arsip) ? $arsip->lokasi_penyimpanan : '')),'required' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                         <?php $__errorArgs = ['lokasi_penyimpanan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs mt-1 block"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <div>
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.label','data' => ['for' => 'keterangan_fisik','value' => 'Keterangan Fisik']]); ?>
<?php $component->withName('label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'keterangan_fisik','value' => 'Keterangan Fisik']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    <textarea id="keterangan_fisik" name="keterangan_fisik" rows="1"
                            class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                    ><?php echo e(old('keterangan_fisik', isset($arsip) ? $arsip->keterangan_fisik : '')); ?></textarea>
                     <?php $__errorArgs = ['keterangan_fisik'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs mt-1 block"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div
                    class="md:col-span-2"
                    x-data="{ uploadType: '<?php echo e($defaultUploadType); ?>' }">
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.label','data' => ['value' => 'Lampiran Berkas (Opsional)']]); ?>
<?php $component->withName('label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['value' => 'Lampiran Berkas (Opsional)']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

                    <div class="mt-2 flex flex-col sm:flex-row sm:items-center space-y-2 sm:space-y-0 sm:space-x-4">
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="upload_type" value="file" x-model="uploadType" class="form-radio h-4 w-4 text-indigo-600 transition duration-150 ease-in-out">
                            <span class="ml-2 text-sm text-gray-700">Upload File (Maks. 5 File @ 2MB)</span>
                        </label>
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="upload_type" value="link" x-model="uploadType" class="form-radio h-4 w-4 text-indigo-600 transition duration-150 ease-in-out">
                            <span class="ml-2 text-sm text-gray-700">Input Link Eksternal</span>
                        </label>
                        <button type="button"
                                x-show="uploadType !== ''"
                                @click="uploadType = ''; selectedFilesStore = []; updateFileInputAndPreview();"
                                class="sm:ml-4 px-2 py-1 bg-red-100 text-red-700 text-sm font-medium rounded hover:bg-red-200 focus:outline-none"
                                style="display: none;">
                            Batalkan Pilihan Lampiran
                        </button>
                    </div>
                     <?php $__errorArgs = ['upload_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs mt-1 block"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                    <div x-show="uploadType === 'link'" x-transition class="mt-4" style="display: none;">
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.label','data' => ['for' => 'link_eksternal','value' => 'URL Link Eksternal']]); ?>
<?php $component->withName('label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'link_eksternal','value' => 'URL Link Eksternal']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.input','data' => ['id' => 'link_eksternal','class' => 'block mt-1 w-full','type' => 'url','name' => 'link_eksternal','value' => old('link_eksternal', isset($arsip) ? $arsip->link_eksternal : ''),'placeholder' => 'Contoh: https://docs.google.com/document/d/...']]); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'link_eksternal','class' => 'block mt-1 w-full','type' => 'url','name' => 'link_eksternal','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('link_eksternal', isset($arsip) ? $arsip->link_eksternal : '')),'placeholder' => 'Contoh: https://docs.google.com/document/d/...']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        <?php if(isset($arsip) && $arsip->link_eksternal && !$isDuplicating): ?>
                            <p class="mt-1 text-xs text-gray-500">Link saat ini: <a href="<?php echo e($arsip->link_eksternal); ?>" target="_blank" class="text-blue-500 hover:underline"><?php echo e(Str::limit($arsip->link_eksternal, 50)); ?></a></p>
                        <?php endif; ?>
                         <?php $__errorArgs = ['link_eksternal'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs mt-1 block"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div x-show="uploadType === 'file'" x-transition class="mt-4" style="display: none;">
                        <input type="file"
                           name="files[]"
                           id="file_input"
                           multiple
                           accept=".pdf,.doc,.docx,.xls,.xlsx"
                           style="display: none;"
                           @change="handleFileSelect($event.target.files)"
                           :required="uploadType === 'file' && selectedFilesStore.length === 0 && <?php echo e($existingFiles->isEmpty() ? 'true' : 'false'); ?>">

                        <button type="button"
                                onclick="document.getElementById('file_input').value = null; document.getElementById('file_input').click()"
                                class="inline-flex items-center px-3 py-2 bg-white border border-gray-300 rounded-md font-semibold text-sm text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:ring focus:ring-blue-200 active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-150">
                            <svg class="w-5 h-5 mr-2 -ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                            </svg>
                            <span id="select-file-button-text">Pilih File (0 / 5)</span>
                        </button>
                        <span id="file-error-message" class="text-red-500 text-xs mt-1 sm:ml-2 block sm:inline hidden"></span>
                        <?php $__errorArgs = ['files'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs mt-1 sm:ml-2 block sm:inline"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <?php $__errorArgs = ['files.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs mt-1 sm:ml-2 block sm:inline"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                        <div id="file_preview_list" class="mt-4 border-t pt-4 hidden">
                            <p class="text-sm font-medium text-gray-700 mb-2">File Baru Dipilih:</p>
                            <ul class="space-y-2"></ul>
                        </div>
                    </div>

                    <?php if($existingFiles->isNotEmpty()): ?>
                        <div id="existing_files_list" class="mt-4 border-t pt-4">
                            <p class="text-sm font-medium text-gray-700 mb-2">File Saat Ini:</p>
                            <ul class="space-y-2">
                                <?php $__currentLoopData = $existingFiles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li id="existing-file-<?php echo e($file->id); ?>" class="flex items-center justify-between text-sm text-gray-600 bg-gray-50 p-2 rounded">
                                    <a href="<?php echo e(Storage::url($file->path_file)); ?>" target="_blank" class="hover:underline truncate" title="<?php echo e($file->nama_file_original); ?>">
                                        <?php echo e($file->nama_file_original); ?> (<?php echo e(number_format($file->size / 1024 / 1024, 2)); ?> MB)
                                    </a>
                                    <button type="button"
                                            class="remove-existing-file-btn ml-2 p-1 text-red-500 hover:text-red-700 font-bold text-lg leading-none"
                                            data-file-id="<?php echo e($file->id); ?>"
                                            title="Hapus file ini">
                                        &times;
                                    </button>
                                </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <div id="deleted_files_container" class="hidden"></div>
                </div>
            </div>
        </fieldset>

        
        
        
        <fieldset class="border p-4 rounded-md">
            <legend class="text-lg font-medium text-gray-900 px-2">Uraian Isi Informasi</legend>
            <div id="uraian-container" class="space-y-4 mt-4">
                <?php
                    $uraianItems = old('uraian_isi');
                    if (!$uraianItems && isset($arsip)) {
                        $uraianItems = $arsip->uraianIsiInformasi->toArray();
                    }
                    if (empty($uraianItems)) {
                        $uraianItems = [['nomor_item' => '1', 'uraian'=>'', 'tanggal'=>'', 'jumlah_lembar'=>'']];
                    }
                ?>
                <?php $__currentLoopData = $uraianItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $uraian): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $uraian = (object) $uraian; $uniqueKey = old('uraian_isi') ? $index : (isset($uraian->id) ? $uraian->id : 'new_'.$index); ?>
                    
                    <div class="uraian-item grid grid-cols-1 sm:grid-cols-12 gap-4 sm:items-end">
                        
                        <div class="col-span-1 sm:col-span-1">
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.label','data' => ['value' => 'No. Item']]); ?>
<?php $component->withName('label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['value' => 'No. Item']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.input','data' => ['type' => 'text','name' => 'uraian_isi['.e($uniqueKey).'][nomor_item]','class' => 'w-full no-item-input mt-1','value' => ''.e($uraian->nomor_item ?? ($loop->index + 1)).'']]); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => 'text','name' => 'uraian_isi['.e($uniqueKey).'][nomor_item]','class' => 'w-full no-item-input mt-1','value' => ''.e($uraian->nomor_item ?? ($loop->index + 1)).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        </div>
                        
                        <div class="col-span-1 sm:col-span-5">
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.label','data' => ['value' => 'Uraian*']]); ?>
<?php $component->withName('label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['value' => 'Uraian*']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            <textarea name="uraian_isi[<?php echo e($uniqueKey); ?>][uraian]" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" rows="1" required><?php echo e($uraian->uraian ?? ''); ?></textarea>
                             <?php $__errorArgs = ["uraian_isi.{$uniqueKey}.uraian"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs mt-1 block"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        
                        <div class="col-span-1 sm:col-span-2">
                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.label','data' => ['value' => 'Tanggal']]); ?>
<?php $component->withName('label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['value' => 'Tanggal']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.input','data' => ['type' => 'date','name' => 'uraian_isi['.e($uniqueKey).'][tanggal]','class' => 'w-full mt-1','value' => ''.e($uraian->tanggal ?? '').'']]); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => 'date','name' => 'uraian_isi['.e($uniqueKey).'][tanggal]','class' => 'w-full mt-1','value' => ''.e($uraian->tanggal ?? '').'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        </div>
                        
                        <div class="col-span-1 sm:col-span-2">
                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.label','data' => ['value' => 'Jumlah*']]); ?>
<?php $component->withName('label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['value' => 'Jumlah*']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.input','data' => ['type' => 'number','name' => 'uraian_isi['.e($uniqueKey).'][jumlah_lembar]','class' => 'w-full mt-1','value' => ''.e($uraian->jumlah_lembar ?? '').'','required' => true,'min' => '1']]); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => 'number','name' => 'uraian_isi['.e($uniqueKey).'][jumlah_lembar]','class' => 'w-full mt-1','value' => ''.e($uraian->jumlah_lembar ?? '').'','required' => true,'min' => '1']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                             <?php $__errorArgs = ["uraian_isi.{$uniqueKey}.jumlah_lembar"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs mt-1 block"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        
                        <div class="col-span-1 sm:col-span-2 flex space-x-2 sm:mt-5 justify-end sm:justify-start">
                             <button type="button" class="duplicate-uraian-btn p-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition" title="Duplikat Baris Ini"><svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M7 9a2 2 0 012-2h6a2 2 0 012 2v6a2 2 0 01-2 2H9a2 2 0 01-2-2V9z" /><path d="M5 3a2 2 0 00-2 2v6a2 2 0 002 2V5h6a2 2 0 00-2-2H5z" /></svg></button>
                             <button type="button" class="remove-uraian-btn p-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition" title="Hapus Baris Ini"><svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 5a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1z" clip-rule="evenodd" /></svg></button>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            
            <button type="button" id="add-uraian-btn" class="mt-4 inline-flex items-center px-3 py-2 bg-white border border-gray-300 rounded-md font-semibold text-sm text-gray-700 shadow-sm hover:bg-gray-50 transition">
                <svg class="w-5 h-5 mr-2 -ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" /></svg>
                Tambah Baris Baru
            </button>
            <?php $__errorArgs = ['uraian_isi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-2"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </fieldset>
    </div>

    
    
    
    <div class="flex flex-col-reverse sm:flex-row sm:justify-end sm:items-center mt-6 gap-3">
        <a href="<?php echo e(route('arsip.index')); ?>" class="text-sm text-gray-600 hover:text-gray-900 sm:mr-4 text-center py-2">
            Batal
        </a>
        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.button','data' => ['type' => 'submit','class' => 'w-full sm:w-auto justify-center']]); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => 'submit','class' => 'w-full sm:w-auto justify-center']); ?>
            <?php if(isset($isDuplicate) && $isDuplicate): ?> Simpan Duplikat
            <?php elseif(isset($arsip)): ?> Update Arsip
            <?php else: ?> Simpan Arsip
            <?php endif; ?>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
    </div>
</form>




<script>
    // --- Logika Multi-Upload File (Max 5 file @ 5MB) ---
    let selectedFilesStore = [];
    const MAX_FILES = 5;

    function handleFileSelect(newFiles) {
        const filesToAdd = Array.from(newFiles);
        let alertShown = false;
        const fileErrorMsg = document.getElementById('file-error-message');
        fileErrorMsg.classList.add('hidden');
        fileErrorMsg.textContent = '';

        filesToAdd.forEach(file => {
            if (file.size > 5 * 1024 * 1024) {
                 fileErrorMsg.textContent = `File "${file.name}" melebihi batas 5MB.`;
                 fileErrorMsg.classList.remove('hidden');
                 if(!alertShown) { alert(`File "${file.name}" melebihi batas 5MB dan tidak akan ditambahkan.`); alertShown = true;}
                 return;
            }
            const isDuplicate = selectedFilesStore.some(f => f.name === file.name && f.size === file.size);
            if (selectedFilesStore.length < MAX_FILES && !isDuplicate) {
                selectedFilesStore.push(file);
            } else if (selectedFilesStore.length >= MAX_FILES && !isDuplicate && !alertShown) {
                alert(`Batas maksimal ${MAX_FILES} file telah tercapai.`);
                alertShown = true;
            }
        });
        updateFileInputAndPreview();
    }

    function removeFile(index) {
        selectedFilesStore.splice(index, 1);
        updateFileInputAndPreview();
        const fileErrorMsg = document.getElementById('file-error-message');
        if(selectedFilesStore.length < MAX_FILES) {
             fileErrorMsg.classList.add('hidden');
             fileErrorMsg.textContent = '';
        }
    }

    function updateFileInputAndPreview() {
        const fileInput = document.getElementById('file_input');
        const previewList = document.getElementById('file_preview_list');
        const previewListUl = previewList.querySelector('ul');
        const selectFileBtnText = document.getElementById('select-file-button-text');

        previewListUl.innerHTML = '';
        const dataTransfer = new DataTransfer();

        if (selectedFilesStore.length === 0) {
            previewList.classList.add('hidden');
        } else {
            previewList.classList.remove('hidden');
        }

        selectedFilesStore.forEach((file, index) => {
            dataTransfer.items.add(file);
            const li = document.createElement('li');
            li.className = 'flex items-center justify-between text-sm text-gray-600 bg-blue-50 p-2 rounded';
            li.innerHTML = `
                <span class="truncate" title="${file.name}">${file.name} (${(file.size / 1024 / 1024).toFixed(2)} MB)</span>
                <button type="button"
                        class="remove-new-file-btn ml-2 p-1 text-red-500 hover:text-red-700 font-bold text-lg leading-none"
                        data-index="${index}"
                        title="Hapus file ini">
                    &times;
                </button>
            `;
            previewListUl.appendChild(li);
        });

        try {
             fileInput.files = dataTransfer.files;
        } catch (error) {
             console.error("Error setting files on input:", error);
        }
        selectFileBtnText.textContent = `Pilih File ( ${selectedFilesStore.length} / ${MAX_FILES} )`;
    }

    document.addEventListener('DOMContentLoaded', function () {
        const isAdmin = <?php echo e($isAdmin ? 'true' : 'false'); ?>;
        const selectedDivisiInput = document.getElementById('selected_divisi_id');
        const jraInput = document.getElementById('jra_otomatis');
        const fileInput = document.getElementById('file_input');
        const form = document.getElementById('arsip-form');
        const tanggalArsipInput = document.getElementById('tanggal_arsip');
        
        // --- Inisialisasi TomSelect (Searchable Dropdown) ---
        let tomSelect;
        if(typeof TomSelect !== 'undefined') {
            tomSelect = new TomSelect('#select-klasifikasi',{ create: false, sortField: { field: "text", direction: "asc" } });
        } else {
            console.warn("TomSelect library not loaded. The select field will not be searchable/customized.");
        }
        
        // --- Logika Update JRA Otomatis ---
        const updateJRA = (value) => {
             if (!value) { jraInput.value = ''; return; }
             fetch(`/api/klasifikasi/${value}`)
                 .then(response => response.ok ? response.json() : Promise.reject('Gagal memuat JRA.'))
                 .then(data => { jraInput.value = `Retensi: ${data.masa_aktif} thn Aktif, ${data.masa_inaktif} thn Inaktif. Status Akhir: ${data.status_akhir}`; })
                 .catch(error => { console.error('Fetch error:', error); jraInput.value = ''; });
         };
         if(tomSelect) {
             tomSelect.on('change', updateJRA);
             if(tomSelect.getValue()){ updateJRA(tomSelect.getValue()); }
         }

        // --- Logika Hapus File (Baru & Lama) ---
        fileInput.addEventListener('change', (e) => handleFileSelect(e.target.files));
        document.body.addEventListener('click', function(e) {
            const newFileRemoveBtn = e.target.closest('.remove-new-file-btn');
            if (newFileRemoveBtn) {
                 e.preventDefault();
                 const indexToRemove = parseInt(newFileRemoveBtn.dataset.index);
                 if (!isNaN(indexToRemove)) { removeFile(indexToRemove); }
                 return;
            }
            const existingFileRemoveBtn = e.target.closest('.remove-existing-file-btn');
            if (existingFileRemoveBtn) {
                 e.preventDefault();
                 const fileId = existingFileRemoveBtn.dataset.fileId;
                 const li = document.getElementById('existing-file-' + fileId);
                 if (li) { li.style.display = 'none'; }
                 const container = document.getElementById('deleted_files_container');
                
                 if (!container.querySelector(`input[name="delete_files[]"][value="${fileId}"]`)) {
                     const hiddenInput = document.createElement('input');
                     hiddenInput.type = 'hidden'; hiddenInput.name = 'delete_files[]'; hiddenInput.value = fileId;
                     container.appendChild(hiddenInput);
                 }
            }
        });

        // --- Logika Uraian Isi Dinamis (Tambah, Hapus, Duplikat) ---
        const uraianContainer = document.getElementById('uraian-container');
        function renumberRows() {
             const rows = uraianContainer.querySelectorAll('.uraian-item');
             rows.forEach((row, i) => {
                 const noItemInput = row.querySelector('.no-item-input');
                 if (noItemInput) noItemInput.value = i + 1;
             });
        }
        
        const createNewRow = (data = {}) => {
            const newIndex = 'new_' + Date.now();
            const newRow = document.createElement('div');
            newRow.className = 'uraian-item grid grid-cols-1 sm:grid-cols-12 gap-4 sm:items-end'; 
            newRow.innerHTML = `
                <div class="col-span-1 sm:col-span-1">
                    <label class="block font-medium text-sm text-gray-700">No. Item</label>
                    <input type="text" name="uraian_isi[${newIndex}][nomor_item]" class="w-full no-item-input mt-1 rounded-md shadow-sm border-gray-300" value="${data.nomor_item || ''}" />
                </div>
                <div class="col-span-1 sm:col-span-5">
                    <label class="block font-medium text-sm text-gray-700">Uraian*</label>
                    <textarea name="uraian_isi[${newIndex}][uraian]" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" rows="1" required>${data.uraian || ''}</textarea>
                </div>
                <div class="col-span-1 sm:col-span-2">
                    <label class="block font-medium text-sm text-gray-700">Tanggal</label>
                    <input type="date" name="uraian_isi[${newIndex}][tanggal]" class="w-full mt-1 rounded-md shadow-sm border-gray-300" value="${data.tanggal || ''}" />
                </div>
                <div class="col-span-1 sm:col-span-2">
                    <label class="block font-medium text-sm text-gray-700">Jumlah*</label>
                    <input type="number" name="uraian_isi[${newIndex}][jumlah_lembar]" class="w-full mt-1 rounded-md shadow-sm border-gray-300" value="${data.jumlah_lembar || ''}" required min="1"/>
                </div>
                <div class="col-span-1 sm:col-span-2 flex space-x-2 sm:mt-5 justify-end sm:justify-start">
                    <button type="button" class="duplicate-uraian-btn p-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition" title="Duplikat Baris Ini"><svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M7 9a2 2 0 012-2h6a2 2 0 012 2v6a2 2 0 01-2 2H9a2 2 0 01-2-2V9z" /><path d="M5 3a2 2 0 00-2 2v6a2 2 0 002 2V5h6a2 2 0 00-2-2H5z" /></svg></button>
                    <button type="button" class="remove-uraian-btn p-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition" title="Hapus Baris Ini"><svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5 10a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1z" clip-rule="evenodd" /></svg></button>
                </div>
            `;
            return newRow;
        };

        document.getElementById('add-uraian-btn').addEventListener('click', function() {
            const newRow = createNewRow({
                nomor_item: uraianContainer.querySelectorAll('.uraian-item').length + 1
            });
            uraianContainer.appendChild(newRow);
            renumberRows();
        });

        uraianContainer.addEventListener('click', function(e) {
             const removeBtn = e.target.closest('.remove-uraian-btn');
             if (removeBtn) {
                 e.preventDefault();
                 const rows = uraianContainer.querySelectorAll('.uraian-item');
                 if (rows.length > 1) {
                     removeBtn.closest('.uraian-item').remove();
                     renumberRows();
                 } else { alert('Minimal harus ada satu baris Uraian Isi Informasi.'); }
                  return;
             }

             const duplicateBtn = e.target.closest('.duplicate-uraian-btn');
             if (duplicateBtn) {
                 e.preventDefault();
                 const originalRow = duplicateBtn.closest('.uraian-item');
                 const originalData = {};
                 originalRow.querySelectorAll('input, textarea').forEach(input => {
                     const name = input.getAttribute('name');
                     const fieldMatch = name.match(/\[([^\]]+)\]$/);
                     if (fieldMatch && fieldMatch[1]) {
                         originalData[fieldMatch[1]] = input.value;
                     }
                 });

                 const newRow = createNewRow(originalData);
                 originalRow.after(newRow);
                 renumberRows();
             }
        });

        renumberRows();
    });
</script><?php /**PATH D:\applications\arsip-bbpom - Fitur Usul Musnah - Divisi - RevisiDemo - Revisi2 - Sibob - usulpindah - Copy\resources\views/arsip/_form.blade.php ENDPATH**/ ?>