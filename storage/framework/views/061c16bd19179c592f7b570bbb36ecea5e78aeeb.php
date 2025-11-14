<div class="flex flex-col h-full">
    
    
    <div class="flex-shrink-0">
        
        
        <div class="flex items-center h-16 px-3 border-b border-gray-700">
            <a href="<?php echo e(route('dashboard')); ?>" class="flex items-center flex-shrink-0">
                <img src="<?php echo e(asset('images/logo-bbpom.png')); ?>" alt="Logo BBPOM" 
                     class="w-15 h-12">
            </a>
            <div class="ml-5 overflow-hidden whitespace-nowrap" x-show="isSidebarOpen"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0">
                <h1 class="text-lg font-bold text-white tracking-widest uppercase">
                    KEARSIPAN
                </h1>
            </div>
        </div>

        
        <div class="px-4 pt-4 mt-2">
            <button @click="isSidebarOpen = !isSidebarOpen" 
                    class="w-full hidden md:flex items-center justify-start p-3 text-gray-400 rounded-md hover:bg-gray-700 hover:text-white transition-colors duration-200">
                <svg class="h-6 w-6 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
    </div>
    
    
    <nav class="mt-2 px-4 flex-grow overflow-y-auto">
        
        
        <a href="<?php echo e(route('dashboard')); ?>" class="flex items-center p-3 text-gray-400 rounded-md hover:bg-gray-700 hover:text-white transition-colors duration-200 <?php echo e(request()->routeIs('dashboard') ? 'bg-gray-700 text-white' : ''); ?>">
            <div class="flex-shrink-0">
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
            </div>
            <div class="ml-3 overflow-hidden whitespace-nowrap" x-show="isSidebarOpen">Dashboard</div>
        </a>

        
        <a href="<?php echo e(route('arsip.index')); ?>" class="mt-2 flex items-center p-3 text-gray-400 rounded-md hover:bg-gray-700 hover:text-white transition-colors duration-200 <?php echo e(request()->routeIs('arsip.*') ? 'bg-gray-700 text-white' : ''); ?>">
            <div class="flex-shrink-0">
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" /></svg>
            </div>
            <div class="ml-3 overflow-hidden whitespace-nowrap" x-show="isSidebarOpen">Daftar Arsip</div>
        </a>
        
        
        <?php if(Auth::user()->role == 'Admin'): ?>
            
            <a href="<?php echo e(route('admin.usulan-pemusnahan.index')); ?>" class="mt-2 flex items-center p-3 text-gray-400 rounded-md hover:bg-gray-700 hover:text-white transition-colors duration-200 <?php echo e(request()->routeIs('admin.usulan-pemusnahan.*') ? 'bg-gray-700 text-white' : ''); ?>">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                </div>
                <div class="ml-3 overflow-hidden whitespace-nowrap" x-show="isSidebarOpen">Usul Musnah</div>
            </a>
            
            
            <a href="<?php echo e(route('admin.usul-pindah-review.index')); ?>" class="mt-2 flex items-center p-3 text-gray-400 rounded-md hover:bg-gray-700 hover:text-white transition-colors duration-200 <?php echo e(request()->routeIs('admin.usul-pindah-review.*') || request()->routeIs('admin.usul-pindah.show') ? 'bg-gray-700 text-white' : ''); ?>">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-2m-4-1v8m0 0l3-3m-3 3L9 8m-5 5h2.586a1 1 0 01.707.293l2.414 2.414a1 1 0 001.414 0l2.414-2.414a1 1 0 01.707-.293H17" /></svg>
                </div>
                <div class="ml-3 overflow-hidden whitespace-nowrap" x-show="isSidebarOpen">Usulan Pindah</div>
            </a>
        <?php else: ?>
            
            <a href="<?php echo e(route('usul-pindah.index')); ?>" class="mt-2 flex items-center p-3 text-gray-400 rounded-md hover:bg-gray-700 hover:text-white transition-colors duration-200 <?php echo e(request()->routeIs('usul-pindah.*') ? 'bg-gray-700 text-white' : ''); ?>">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-2m-4-1v8m0 0l3-3m-3 3L9 8m-5 5h2.586a1 1 0 01.707.293l2.414 2.414a1 1 0 001.414 0l2.414-2.414a1 1 0 01.707-.293H17" /></svg>
                </div>
                <div class="ml-3 overflow-hidden whitespace-nowrap" x-show="isSidebarOpen">Usul Pindah</div>
            </a>
        <?php endif; ?>
        


        
        <a href="<?php echo e(route('pusat-template.index')); ?>" class="mt-2 flex items-center p-3 text-gray-400 rounded-md hover:bg-gray-700 hover:text-white transition-colors duration-200 <?php echo e(request()->routeIs('pusat-template.*') ? 'bg-gray-700 text-white' : ''); ?>">
            <div class="flex-shrink-0">
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" /></svg>
            </div>
            <div class="ml-3 overflow-hidden whitespace-nowrap" x-show="isSidebarOpen">Format TND</div>
        </a>

        
        <?php if(Auth::user()->role == 'Admin'): ?>
        <a href="<?php echo e(route('admin.pengaturan.index')); ?>" class="mt-2 flex items-center p-3 text-gray-400 rounded-md hover:bg-gray-700 hover:text-white transition-colors duration-200 <?php echo e(request()->routeIs(['admin.pengaturan.*', 'admin.klasifikasi.*', 'admin.bentuk-naskah.*', 'admin.link-terkait.*', 'admin.templates.*', 'admin.users.*']) ? 'bg-gray-700 text-white' : ''); ?>">
            <div class="flex-shrink-0">
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.096 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
            </div>
            <div class="ml-3 overflow-hidden whitespace-nowrap" x-show="isSidebarOpen">Pengaturan</div>
        </a>
        <?php endif; ?>
    </nav>

    
    <div class="flex-shrink-0">
        <div x-data="{ open: false }" class="relative border-t border-gray-700">
            <button @click="open = !open" class="flex items-center w-full p-5 hover:bg-gray-700 focus:outline-none">
                <div class="flex-shrink-0">
                    <div class="h-10 w-10 rounded-full bg-gray-700 flex items-center justify-center text-gray-400 font-bold">
                        <?php echo e(strtoupper(substr(Auth::user()->name, 0, 1))); ?>

                    </div>
                </div>
                <div class="ml-3 overflow-hidden whitespace-nowrap" x-show="isSidebarOpen">
                    <div class="font-medium text-base text-left text-gray-200"><?php echo e(Auth::user()->name); ?></div>
                    <div class="font-medium text-sm text-left text-gray-500"><?php echo e(Auth::user()->email); ?></div>
                </div>
            </button>

            <div x-show="open" @click.away="open = false" 
                 x-transition
                 class="absolute bottom-full mb-2 w-full bg-gray-800 rounded-md shadow-lg" style="display: none;">
                <form method="POST" action="<?php echo e(route('logout')); ?>">
                    <?php echo csrf_field(); ?>
                    <a href="<?php echo e(route('logout')); ?>"
                       onclick="event.preventDefault(); this.closest('form').submit();"
                       class="flex items-center justify-center px-4 py-3 text-sm text-gray-300 hover:bg-red-500 hover:text-white transition-colors duration-200">
                        <div class="flex-shrink-0">
                           <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                        </div>
                         <div class="ml-3 overflow-hidden whitespace-nowrap" x-show="isSidebarOpen">Logout</div>
                    </a>
                </form>
            </div>
        </div>
    </div>
</div><?php /**PATH D:\MAGANG\sistem-kearsipan-bbpom\resources\views/layouts/navigation.blade.php ENDPATH**/ ?>