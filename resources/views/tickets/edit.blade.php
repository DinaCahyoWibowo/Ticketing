<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Tiket') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (session('error'))
                        <div class="mb-4 rounded-lg bg-red-50 border border-red-200 p-4 text-sm text-red-700">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('tickets.update', $ticket) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-700">Judul Tiket</label>
                            <input type="text" name="title" id="title"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                value="{{ old('title', $ticket->title) }}" required>
                            @error('title')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                            <textarea name="description" id="description" rows="4"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>{{ old('description', $ticket->description) }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="divisi" class="block text-sm font-medium text-gray-700">Divisi</label>
                                <select name="divisi" id="divisi" required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">-- Pilih Divisi --</option>
                                    @foreach(['HRD','Marketing','Finance','Produksi','Gudang','Lainnya'] as $division)
                                        <option value="{{ $division }}" {{ old('divisi', $ticket->divisi) == $division ? 'selected' : '' }}>{{ $division }}</option>
                                    @endforeach
                                </select>
                                @error('divisi')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="no_wa" class="block text-sm font-medium text-gray-700">No. WhatsApp</label>
                                <input type="text" name="no_wa" id="no_wa" required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    value="{{ old('no_wa', $ticket->no_wa) }}">
                                @error('no_wa')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="priority" class="block text-sm font-medium text-gray-700">Prioritas</label>
                            <select name="priority" id="priority" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="low" {{ old('priority', $ticket->priority) == 'low' ? 'selected' : '' }}>Low</option>
                                <option value="medium" {{ old('priority', $ticket->priority) == 'medium' ? 'selected' : '' }}>Medium</option>
                                <option value="high" {{ old('priority', $ticket->priority) == 'high' ? 'selected' : '' }}>High</option>
                            </select>
                            @error('priority')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end gap-4">
                            <a href="{{ route('dashboard') }}" class="text-sm text-gray-600 hover:text-gray-900 underline">Batal</a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Simpan Perubahan</button>
                        </div>
                    </form>

                    <div class="mt-8">
                        <h3 class="text-lg font-bold mb-2">Komentar / Catatan</h3>

                        @if(session('success'))
                            <div class="mb-4 rounded bg-green-50 border border-green-200 p-3 text-sm text-green-700">{{ session('success') }}</div>
                        @endif

                        <div class="space-y-4">
                            @forelse($ticket->comments()->with('user')->latest()->get() as $comment)
                                <div class="p-3 border rounded bg-gray-50">
                                    <div class="flex items-center justify-between">
                                        <div class="text-sm font-bold">{{ $comment->user->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</div>
                                    </div>
                                    <div class="mt-2 text-sm text-gray-700">{{ $comment->body }}</div>
                                </div>
                            @empty
                                <div class="text-sm text-gray-500">Belum ada komentar.</div>
                            @endforelse
                        </div>

                        <form action="{{ route('tickets.comments', $ticket->id) }}" method="POST" class="mt-4">
                            @csrf
                            <label for="body" class="block text-sm font-medium text-gray-700">Tambah Komentar</label>
                            <textarea name="body" id="body" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required></textarea>
                            <div class="mt-2 flex justify-end">
                                <button type="submit" class="inline-flex items-center px-3 py-1 bg-indigo-600 text-white rounded text-sm font-semibold">Kirim</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>