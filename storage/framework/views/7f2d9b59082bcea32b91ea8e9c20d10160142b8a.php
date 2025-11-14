<?php if (isset($component)) { $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\AppLayout::class, []); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <?php if (isset($component)) { $__componentOriginal031b70f77448d6d2b1e9e96d77e7e66748a7c1aa = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Breadcrumbs::class, ['links' => [
            'Pengaturan' => route('admin.pengaturan.index'), 
            'Link Terkait' => route('admin.link-terkait.index')
        ]]); ?>
<?php $component->withName('breadcrumbs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal031b70f77448d6d2b1e9e96d77e7e66748a7c1aa)): ?>
<?php $component = $__componentOriginal031b70f77448d6d2b1e9e96d77e7e66748a7c1aa; ?>
<?php unset($__componentOriginal031b70f77448d6d2b1e9e96d77e7e66748a7c1aa); ?>
<?php endif; ?>
     <?php $__env->endSlot(); ?>


            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('admin.link-terkait-table', [])->html();
} elseif ($_instance->childHasBeenRendered('rkyYSl4')) {
    $componentId = $_instance->getRenderedChildComponentId('rkyYSl4');
    $componentTag = $_instance->getRenderedChildComponentTagName('rkyYSl4');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('rkyYSl4');
} else {
    $response = \Livewire\Livewire::mount('admin.link-terkait-table', []);
    $html = $response->html();
    $_instance->logRenderedChild('rkyYSl4', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                </div>
            </div>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da)): ?>
<?php $component = $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da; ?>
<?php unset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da); ?>
<?php endif; ?><?php /**PATH D:\applications\arsip-bbpom - Fitur Usul Musnah - Divisi - RevisiDemo - Revisi2 - Sibob - usulpindah - Copy\resources\views/admin/link-terkait/index.blade.php ENDPATH**/ ?>