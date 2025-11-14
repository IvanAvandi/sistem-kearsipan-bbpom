<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <title><?php echo e(config('app.name', 'Laravel')); ?></title>

        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">
        <?php echo \Livewire\Livewire::styles(); ?>


        <script src="<?php echo e(asset('js/app.js')); ?>" defer></script>
        <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
        
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    </head>
    <body class="font-sans antialiased">
        
        <div x-data="{ isSidebarOpen: window.innerWidth >= 768 }" class="flex h-screen bg-gray-100">
            
            <div x-show="isSidebarOpen" @click="isSidebarOpen = false" class="fixed inset-0 z-10 bg-black opacity-50 md:hidden" style="display: none;"></div>
            
            <aside 
                class="fixed z-20 h-full w-64 overflow-y-auto bg-gray-800 transition-all duration-300 -translate-x-full 
                       md:relative md:translate-x-0 md:flex-shrink-0"
                :class="{ 
                    'translate-x-0': isSidebarOpen,
                    'md:w-64': isSidebarOpen,
                    'md:w-20': !isSidebarOpen
                }">
                <?php echo $__env->make('layouts.navigation', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </aside>
            
            <div class="flex flex-col flex-1 w-full overflow-hidden">
                
                <header class="flex items-center justify-between h-16 p-4 bg-white border-b-2 border-gray-200">
                    
                    <button @click="isSidebarOpen = !isSidebarOpen" class="text-gray-500 md:hidden">
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    <div class="flex-1 ml-4 md:ml-0">
                        <?php echo e($header); ?>

                    </div>
                </header>

                <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100">
                    <div class="px-6 py-6">
                        <?php echo e($slot); ?>

                    </div>
                </main>
            </div>
        </div>
        
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <?php echo \Livewire\Livewire::scripts(); ?>

        
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        
        
        <script>
            window.addEventListener('swal:alert', event => {
                Swal.fire({
                    title: event.detail.title,
                    text: event.detail.text,
                    icon: event.detail.type,
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
            });
        </script>
        
        
        <?php echo $__env->yieldPushContent('scripts'); ?>
        
    </body>
</html><?php /**PATH D:\MAGANG\sistem-kearsipan-bbpom\resources\views/layouts/app.blade.php ENDPATH**/ ?>