<x-guest-layout>
    <x-auth-card>
        {{-- ====================================================== --}}
        {{-- == LOGO APLIKASI                                    == --}}
        {{-- ====================================================== --}}
        <x-slot name="logo">
            <a href="/">
                <img src="{{ asset('images/logo-bbpom.png') }}" alt="Logo BBPOM Kearsipan" class="w-24 h-24 mx-auto" />
            </a>
        </x-slot>

        {{-- ====================================================== --}}
        {{-- == JUDUL FORM                                       == --}}
        {{-- ====================================================== --}}
        <div class="text-center mb-6 mt-4">
            <h1 class="text-2xl font-bold text-gray-800">
                Sistem Kearsipan
            </h1>
            <p class="text-sm text-gray-500 mt-1">
                Balai Besar POM di Banjarbaru
            </p>
        </div>

        {{-- Status Sesi dan Error Validasi --}}
        <x-auth-session-status class="mb-4" :status="session('status')" />
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            {{-- ====================================================== --}}
            {{-- == INPUT FORM                                       == --}}
            {{-- ====================================================== --}}
            <div>
                <x-label for="email" :value="__('Email')" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />
                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
            </div>

            {{-- ====================================================== --}}
            {{-- == OPSI TAMBAHAN (REMEMBER & LUPA PASSWORD)         == --}}
            {{-- ====================================================== --}}
            <div class="flex items-center justify-between mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>

                {{-- PERBAIKAN: Fitur Lupa Password dinonaktifkan (dikomentari) --}}
                {{--
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                        {{ __('Lupa password?') }}
                    </a>
                @endif
                --}}
            </div>

            {{-- ====================================================== --}}
            {{-- == TOMBOL AKSI LOGIN                                == --}}
            {{-- ====================================================== --}}
            <div class="flex items-center justify-end mt-6">
                <x-button class="w-full justify-center py-3">
                    {{ __('Log in') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>