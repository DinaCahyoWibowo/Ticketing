<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Tiket IT Support Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('tickets.store') }}" method="POST">
                        @csrf

                        {{-- Subjek Masalah --}}
                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-700">Subjek Masalah</label>
                            <input type="text" name="title" id="title" 
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                                placeholder="Contoh: Printer Rusak atau Email tidak bisa dibuka" required>
                            @error('title')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Deskripsi Detail --}}
                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi Detail</label>
                            <textarea name="description" id="description" rows="4" 
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                                placeholder="Ceritakan detail kendala yang Anda alami..." required></textarea>
                            @error('description')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            {{-- Input Divisi --}}
                            <div>
                                <label for="divisi" class="block text-sm font-medium text-gray-700">Divisi Anda</label>
                                <select name="divisi" id="divisi" required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">-- Pilih Divisi --</option>
                                    <option value="HRD">HRD</option>
                                    <option value="Marketing">Marketing</option>
                                    <option value="Finance">Finance</option>
                                    <option value="Produksi">Produksi</option>
                                    <option value="Gudang">Gudang</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                                @error('divisi')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Input No WhatsApp --}}
                            <div>
                                <label for="no_wa" class="block text-sm font-medium text-gray-700">No. WhatsApp (Aktif)</label>
                                <input type="text" name="no_wa" id="no_wa" required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                                    placeholder="Contoh: 628123456789">
                                @error('no_wa')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Tingkat Prioritas --}}
                        <div class="mb-4">
                            <label for="priority" class="block text-sm font-medium text-gray-700">Tingkat Prioritas</label>
                            <select name="priority" id="priority" 
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="low">Rendah (Low)</option>
                                <option value="medium" selected>Sedang (Medium)</option>
                                <option value="high">Penting (High / Urgent)</option>
                            </select>
                        </div>

                        <div class="flex items-center justify-end mt-4 gap-4">
                            <a href="{{ route('dashboard') }}" class="text-sm text-gray-600 hover:text-gray-900 underline">
                                Batal
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Kirim Tiket
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>