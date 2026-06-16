<x-app-layout>
    <div class="py-6">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-xl sm:rounded-lg border border-gray-100">
                <div class="p-8">
                    
                    <div class="mb-8">
                        <h3 class="text-2xl font-bold text-gray-800">Buat User Baru</h3>
                        <p class="text-sm text-gray-500 mt-1">Tambahkan user baru ke sistem.</p>
                        @if(Auth::user()->role == 'it_staff')
                            <p class="text-xs text-yellow-600 mt-2">⚠️ User yang Anda buat harus disetujui oleh SPV terlebih dahulu.</p>
                        @else
                            <p class="text-xs text-green-600 mt-2">✓ User yang Anda buat langsung aktif.</p>
                        @endif
                    </div>

                    @if ($errors->any())
                        <div style="background-color: #fee2e2; border: 1px solid #ef5350; color: #991b1b; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
                            <strong>❌ Terjadi kesalahan:</strong>
                            <ul class="mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('users.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Nama -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama User
                            </label>
                            <input 
                                type="text" 
                                id="name" 
                                name="name"
                                value="{{ old('name') }}"
                                required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                placeholder="Masukkan nama lengkap"
                            >
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email
                            </label>
                            <input 
                                type="email" 
                                id="email" 
                                name="email"
                                value="{{ old('email') }}"
                                required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                placeholder="nama@example.com"
                            >
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                Password
                            </label>
                            <input 
                                type="password" 
                                id="password" 
                                name="password"
                                required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                placeholder="Minimal 8 karakter"
                            >
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                Konfirmasi Password
                            </label>
                            <input 
                                type="password" 
                                id="password_confirmation" 
                                name="password_confirmation"
                                required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                placeholder="Ulangi password"
                            >
                        </div>

                        <!-- Role -->
                        <div>
                            <label for="role" class="block text-sm font-medium text-gray-700 mb-2">
                                Role
                            </label>
                            <select 
                                id="role" 
                                name="role"
                                required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                            >
                                <option value="">-- Pilih Role --</option>
                                <option value="karyawan" {{ old('role') == 'karyawan' ? 'selected' : '' }}>Karyawan Biasa</option>
                                <option value="it_staff" {{ old('role') == 'it_staff' ? 'selected' : '' }}>IT Staff</option>
                                <option value="spv" {{ old('role') == 'spv' ? 'selected' : '' }}>Supervisor (SPV)</option>
                            </select>
                        </div>

                        <!-- Buttons -->
                        <div class="flex gap-4 pt-4">
                            <button 
                                type="submit" 
                                style="background-color: #4338ca; color: white; padding: 12px 24px; border-radius: 8px; font-weight: bold; border: none; cursor: pointer; font-size: 14px;"
                            >
                                Buat User
                            </button>
                            <a 
                                href="{{ route('users.index') }}" 
                                style="background-color: #6b7280; color: white; padding: 12px 24px; border-radius: 8px; font-weight: bold; text-decoration: none; display: inline-block; font-size: 14px;"
                            >
                                Batal
                            </a>
                        </div>
                    </form>

                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div class="text-center mt-4 mb-2">
            <img src="{{ asset('images/logo.jpeg') }}" alt="Logo" class="h-14 w-auto mx-auto mb-2">
            <p class="text-xs text-gray-400">© {{ date('Y') }} <span class="font-semibold text-gray-500">Serenovr</span>. All rights reserved.</p>
        </div>

    </div>
</x-app-layout>
