<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Jadwal Maintenance Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 shadow-sm sm:rounded-lg border">
                <form action="{{ route('maintenance.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block font-bold mb-2">Judul Maintenance</label>
                        <input type="text" name="judul" required class="w-full border-gray-300 rounded-lg shadow-sm">
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold mb-2">Deskripsi Detail</label>
                        <textarea name="deskripsi" rows="4" required class="w-full border-gray-300 rounded-lg shadow-sm"></textarea>
                    </div>

                    <div class="mb-6">
                        <label class="block font-bold mb-2">Tanggal & Waktu Mulai</label>
                        <input type="datetime-local" name="jadwal_mulai" required class="w-full border-gray-300 rounded-lg shadow-sm">
                    </div>

                    <div class="flex justify-end gap-3">
                        <a href="{{ route('maintenance.index') }}" class="px-4 py-2 text-gray-600">Batal</a>
                        <button type="submit" style="background-color: #059669; color: white; padding: 10px 25px; border-radius: 8px; font-weight: bold; border: none; cursor: pointer;">
                            Simpan & Publikasikan Jadwal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>