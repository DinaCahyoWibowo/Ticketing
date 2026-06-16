<x-app-layout>

    <div class="py-6">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div style="background-color: #d1fae5; border: 1px solid #10b981; color: #065f46; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem; font-weight: bold;">
                    Berhasil! {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow-xl sm:rounded-lg border border-gray-100">
                <div class="p-8">
                    
                    <div class="border-b pb-6 mb-6">
                        <div class="flex items-start justify-between gap-4 mb-6">
                            <div>
                                <h3 class="text-2xl font-bold text-gray-800">Daftar Tiket Antrian</h3>
                                <p class="text-sm text-gray-500">Kelola dan pantau status tiket IT di sini.</p>
                            </div>

                            @if(Auth::user()->role == 'karyawan')
                                <div class="hidden md:block">
                                    <a href="{{ route('tickets.create') }}" 
                                       style="background-color: #4338ca !important; color: white !important; padding: 10px 20px !important; border-radius: 8px !important; font-weight: bold !important; text-decoration: none !important; display: inline-flex !important; align-items: center !important; box-shadow: 0 4px 6px rgba(0,0,0,0.1) !important;">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                                        BUAT TIKET BARU
                                    </a>
                                </div>
                            @endif

                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-5 gap-4 w-full">
                            <div class="rounded-xl bg-indigo-600 p-4 text-white shadow-sm min-h-[120px]">
                                <div class="text-xs uppercase tracking-widest">Total Tickets</div>
                                <div class="mt-4 text-3xl font-bold">{{ $totalTickets ?? 0 }}</div>
                            </div>
                            <div class="rounded-xl bg-blue-600 p-4 text-white shadow-sm min-h-[120px]">
                                <div class="text-xs uppercase tracking-widest">Open Tickets</div>
                                <div class="mt-4 text-3xl font-bold">{{ $openTickets ?? 0 }}</div>
                            </div>
                            <div class="rounded-xl bg-orange-600 p-4 text-white shadow-sm min-h-[120px]">
                                <div class="text-xs uppercase tracking-widest">In Progress Tickets</div>
                                <div class="mt-4 text-3xl font-bold">{{ $inProgressTickets ?? 0 }}</div>
                            </div>
                            <div class="rounded-xl bg-purple-600 p-4 text-white shadow-sm min-h-[120px]">
                                <div class="text-xs uppercase tracking-widest">Closed Tickets</div>
                                <div class="mt-4 text-3xl font-bold">{{ $closedTickets ?? 0 }}</div>
                            </div>
                            <div class="rounded-xl bg-red-600 p-4 text-white shadow-sm min-h-[120px]">
                                <div class="text-xs uppercase tracking-widest">High Priority Tickets</div>
                                <div class="mt-4 text-3xl font-bold">{{ $highPriorityTickets ?? 0 }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Search, Filter, and Sort Controls -->
                    <div class="mb-6">
                        <form method="GET" action="{{ route('dashboard') }}" class="space-y-4">
                            <!-- Search Row -->
                            <div class="flex flex-col md:flex-row gap-4 items-end">
                                <div class="flex-1">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Cari Tiket</label>
                                    <input 
                                        type="text" 
                                        name="q" 
                                        value="{{ request('q') }}"
                                        placeholder="Cari judul atau deskripsi..."
                                        class="w-full border-gray-300 rounded-md shadow-sm py-2 px-3 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    >
                                </div>
                                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded hover:bg-indigo-700">
                                    Cari
                                </button>
                                <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-gray-300 text-gray-700 text-sm font-semibold rounded hover:bg-gray-400">
                                    Reset
                                </a>
                            </div>

                            <!-- Filter Row -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                    <select name="status" class="w-full border-gray-300 rounded-md shadow-sm py-2 px-3 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">-- Semua Status --</option>
                                        <option value="waiting" {{ request('status') === 'waiting' ? 'selected' : '' }}>Waiting</option>
                                        <option value="open" {{ request('status') === 'open' ? 'selected' : '' }}>Open</option>
                                        <option value="on-progress" {{ request('status') === 'on-progress' ? 'selected' : '' }}>On Progress</option>
                                        <option value="resolved" {{ request('status') === 'resolved' ? 'selected' : '' }}>Resolved</option>
                                        <option value="closed" {{ request('status') === 'closed' ? 'selected' : '' }}>Closed</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Prioritas</label>
                                    <select name="priority" class="w-full border-gray-300 rounded-md shadow-sm py-2 px-3 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">-- Semua Prioritas --</option>
                                        <option value="high" {{ request('priority') === 'high' ? 'selected' : '' }}>High</option>
                                        <option value="medium" {{ request('priority') === 'medium' ? 'selected' : '' }}>Medium</option>
                                        <option value="low" {{ request('priority') === 'low' ? 'selected' : '' }}>Low</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Divisi</label>
                                    <select name="divisi" class="w-full border-gray-300 rounded-md shadow-sm py-2 px-3 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">-- Semua Divisi --</option>
                                        <option value="HRD" {{ request('divisi') === 'HRD' ? 'selected' : '' }}>HRD</option>
                                        <option value="Marketing" {{ request('divisi') === 'Marketing' ? 'selected' : '' }}>Marketing</option>
                                        <option value="Finance" {{ request('divisi') === 'Finance' ? 'selected' : '' }}>Finance</option>
                                        <option value="Produksi" {{ request('divisi') === 'Produksi' ? 'selected' : '' }}>Produksi</option>
                                        <option value="Gudang" {{ request('divisi') === 'Gudang' ? 'selected' : '' }}>Gudang</option>
                                        <option value="Lainnya" {{ request('divisi') === 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Urutkan Berdasarkan</label>
                                    <select name="sort" class="w-full border-gray-300 rounded-md shadow-sm py-2 px-3 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="created_at" {{ request('sort') === 'created_at' ? 'selected' : '' }}>Tanggal Buat</option>
                                        <option value="priority" {{ request('sort') === 'priority' ? 'selected' : '' }}>Prioritas</option>
                                        <option value="status" {{ request('sort') === 'status' ? 'selected' : '' }}>Status</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Direction Toggle -->
                            <div class="flex gap-2">
                                <a href="{{ request()->fullUrlWithQuery(['direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}" 
                                   class="px-3 py-2 bg-gray-200 text-gray-700 text-xs font-semibold rounded hover:bg-gray-300">
                                    Urutan: {{ request('direction') === 'asc' ? 'Naik ⬆️' : 'Turun ⬇️' }}
                                </a>
                            </div>
                        </form>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto border-collapse">
                            <thead>
                                <tr class="bg-gray-50 text-left">
                                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">No</th>
                                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Pelapor</th>
                                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Divisi</th>
                                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">WhatsApp</th>
                                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Masalah</th>
                                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Prioritas</th>
                                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Penugasan</th>
                                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-center">Status</th>
                                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal Buat</th>
                                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 bg-white">
                                @forelse($tickets as $key => $ticket)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $key + 1 }}</td>
                                        
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                            {{ $ticket->user->name }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 py-1 bg-indigo-50 text-indigo-700 rounded text-[10px] font-black uppercase border border-indigo-100">
                                                {{ $ticket->divisi ?? '-' }}
                                            </span>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($ticket->no_wa)
                                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $ticket->no_wa) }}" 
                                                   target="_blank" 
                                                   class="inline-flex items-center px-3 py-1 bg-green-100 text-green-700 rounded-full text-[10px] font-black hover:bg-green-200 border border-green-300 transition-all">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                                                    HUBUNGI
                                                </a>
                                            @else
                                                <span class="text-xs text-gray-400 italic font-light whitespace-nowrap">Tidak ada No.</span>
                                            @endif
                                        </td>

                                        <td class="px-6 py-4 text-sm text-gray-900 font-semibold">{{ $ticket->title }}</td>

                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 py-1 rounded text-[10px] font-black uppercase border 
                                                {{ $ticket->priority == 'high' ? 'bg-red-100 text-red-700 border-red-200' : ($ticket->priority == 'medium' ? 'bg-yellow-100 text-yellow-700 border-yellow-200' : 'bg-green-100 text-green-700 border-green-200') }}">
                                                {{ ucfirst($ticket->priority) }}
                                            </span>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $ticket->assignedUser->name ?? 'Menunggu...' }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <span style="padding: 4px 12px; border-radius: 9999px; font-size: 10px; font-weight: 800; color: white; background-color: {{ $ticket->status == 'waiting' ? '#eab308' : ($ticket->status == 'open' ? '#2563eb' : ($ticket->status == 'on-progress' ? '#f97316' : ($ticket->status == 'resolved' ? '#16a34a' : '#6b7280'))) }};">
                                                {{ $ticket->status == 'waiting' ? 'WAITING' : ($ticket->status == 'open' ? 'OPEN' : ($ticket->status == 'on-progress' ? 'IN PROGRESS' : strtoupper($ticket->status))) }}
                                            </span>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $ticket->created_at->format('d M Y') }}</td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                            <div class="flex flex-col gap-2">
                                                @if(Auth::user()->role == 'spv' && $ticket->status == 'waiting')
                                                    <form action="{{ route('tickets.assign', $ticket->id) }}" method="POST" class="flex gap-2">
                                                        @csrf @method('PATCH')
                                                        <select name="it_staff_id" required class="text-xs rounded-md border-gray-300 py-1">
                                                            <option value="">Pilih Staff IT</option>
                                                            @foreach($itStaffs as $staff)
                                                                <option value="{{ $staff->id }}">{{ $staff->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        <button type="submit" style="background-color: #4338ca; color: white; padding: 4px 12px; border-radius: 6px; font-weight: bold; border: none; font-size: 10px;">Distribusi</button>
                                                    </form>
                                                @endif

                                                @if(Auth::user()->role == 'it_staff' && $ticket->assigned_to == Auth::id() && in_array($ticket->status, ['open', 'on-progress']))
                                                    <form action="{{ route('tickets.updateStatus', $ticket->id) }}" method="POST" class="flex gap-2" onsubmit="return confirmResolved(this)">
                                                        @csrf @method('PATCH')
                                                        <select name="status" class="text-xs rounded-md border-gray-300 py-1">
                                                            <option value="on-progress" {{ $ticket->status == 'on-progress' ? 'selected' : '' }}>On Progress</option>
                                                            <option value="resolved" {{ $ticket->status == 'resolved' ? 'selected' : '' }}>Resolved</option>
                                                        </select>
                                                        <button type="submit" style="background-color: #16a34a; color: white; padding: 4px 12px; border-radius: 6px; font-weight: bold; border: none; font-size: 10px;">Update</button>
                                                    </form>
                                                @elseif(Auth::user()->role == 'it_staff' && $ticket->assigned_to == Auth::id() && in_array($ticket->status, ['resolved', 'closed']))
                                                    <div class="flex items-center gap-2">
                                                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-[10px] font-bold uppercase">{{ strtoupper($ticket->status) }}</span>
                                                        <span class="text-xs text-gray-500">Tidak dapat diubah.</span>
                                                    </div>
                                                @endif

                                                @if((Auth::user()->role == 'spv' || Auth::id() == $ticket->user_id) && !in_array($ticket->status, ['resolved', 'closed']))
                                                    <div class="flex gap-2">
                                                        <a href="{{ route('tickets.edit', $ticket->id) }}" class="text-xs font-bold text-indigo-700 hover:underline">Edit</a>
                                                        <form action="{{ route('tickets.destroy', $ticket->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus tiket ini?');">
                                                            @csrf @method('DELETE')
                                                            <button type="submit" class="text-xs font-bold text-red-600 hover:underline">Hapus</button>
                                                        </form>
                                                    </div>
                                                @endif

                                                @if(Auth::user()->role != 'it_staff' || $ticket->assigned_to != Auth::id())
                                                    <div class="flex flex-col">
                                                        <span class="text-[10px] text-gray-400 uppercase font-bold">Penugasan:</span>
                                                        <span class="font-bold text-gray-700 text-sm italic">{{ $ticket->assignedUser->name ?? 'Menunggu...' }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-10 text-center text-gray-500">
                                            <p class="text-lg font-medium">Belum ada tiket yang dibuat.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

        {{-- Footer Logo & Nama Perusahaan --}}
        <div class="text-center mt-4 mb-2">
            <img src="{{ asset('images/logo.jpeg') }}" alt="Logo" class="h-14 w-auto mx-auto mb-2">
            <p class="text-xs text-gray-400">© {{ date('Y') }} <span class="font-semibold text-gray-500">Serenovr</span>. All rights reserved.</p>
        </div>

    </div>

    <script>
        function confirmResolved(form) {
            const status = form.querySelector('select[name="status"]').value;
            if (status === 'resolved') {
                return confirm('Apakah pekerjaan ini sudah benar-benar selesai?');
            }
            return true;
        }
    </script>
</x-app-layout>