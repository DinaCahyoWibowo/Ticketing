<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Logo -->
        <div class="flex justify-center mb-2">
            <img src="{{ asset('images/logo.jpeg') }}" alt="Logo" class="h-16 w-auto">
        </div>

        <!-- Nama Sistem -->
        <div class="text-center mb-1">
            <h1 class="text-xl font-bold text-gray-800">IT Support Ticketing System</h1>
        </div>

        <!-- Pesan Welcome -->
        <div class="text-center mb-6">
            <p class="text-sm text-gray-500">Silakan login untuk melaporkan kendala IT Anda</p>
        </div>

        <!-- Demo Accounts Info -->
        <div class="mb-6">
            <h3 class="text-base font-semibold text-gray-800 mb-4">📋 Akun Demo Tersedia</h3>
            <div class="space-y-3">
                <div class="flex items-center justify-between bg-gray-50 p-4 rounded">
                    <div>
                        <p class="font-medium text-gray-900">user@gmail.com</p>
                        <p class="text-sm text-gray-600">Pengguna Biasa</p>
                    </div>
                    <button type="button" onclick="demoLogin('user@gmail.com')" class="px-4 py-2 bg-cyan-600 text-red rounded hover:bg-cyan-700 font-semibold shadow-md">Apply</button>
                </div>

                <div class="flex items-center justify-between bg-gray-50 p-4 rounded">
                    <div>
                        <p class="font-medium text-gray-900">budi@gmail.com</p>
                        <p class="text-sm text-gray-600">IT Staff</p>
                    </div>
                    <button type="button" onclick="demoLogin('budi@gmail.com')" class="px-4 py-2 bg-cyan-600 text-red rounded hover:bg-cyan-700 font-semibold shadow-md">Apply</button>
                </div>

                <div class="flex items-center justify-between bg-gray-50 p-4 rounded">
                    <div>
                        <p class="font-medium text-gray-900">andi@gmail.com</p>
                        <p class="text-sm text-gray-600">IT Staff</p>
                    </div>
                    <button type="button" onclick="demoLogin('andi@gmail.com')" class="px-4 py-2 bg-cyan-600 text-red rounded hover:bg-cyan-700 font-semibold shadow-md">Apply</button>
                </div>

                <div class="flex items-center justify-between bg-gray-50 p-4 rounded">
                    <div>
                        <p class="font-medium text-gray-900">spv@gmail.com</p>
                        <p class="text-sm text-gray-600">Supervisor (SPV)</p>
                    </div>
                    <button type="button" onclick="demoLogin('spv@gmail.com')" class="px-4 py-2 bg-cyan-600 text-red rounded hover:bg-cyan-700 font-semibold shadow-md">Apply</button>
                </div>
            </div>
            <p class="text-xs text-gray-600 mt-4">💡 Password untuk semua akun: <span class="font-mono font-semibold">password</span></p>
        </div>
        <script>
            function demoLogin(email) {
                document.getElementById('email').value = email;
                document.getElementById('password').value = 'password';

                document.querySelector('form').submit();
            }
        </script>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>

        <!-- Nama Perusahaan -->
        <div class="text-center mt-6 pt-4 border-t border-gray-200">
            <p class="text-xs text-gray-400">© {{ date('Y') }} <span class="font-semibold text-gray-500">Serenovr</span>. All rights reserved.</p>
        </div>

    </form>

</x-guest-layout>