<x-app-layout>
    <div class="py-6">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div style="background-color: #d1fae5; border: 1px solid #10b981; color: #065f46; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem; font-weight: bold;">
                    ✓ {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div style="background-color: #fee2e2; border: 1px solid #ef5350; color: #991b1b; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem; font-weight: bold;">
                    ✗ {{ session('error') }}
                </div>
            @endif

            <div class="bg-white shadow-xl sm:rounded-lg border border-gray-100">
                <div class="p-8">
                    
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center border-b pb-6 mb-6 gap-4">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-800">Tiket Saya</h3>
                            <p class="text-sm text-gray-500">Kelola tiket IT yang Anda buat.</p>
                        </div>

                        <a href="{{ route('tickets.create') }}" 
                           style="background-color: #4338ca !important; color: white !important; padding: 10px 20px !important; border-radius: 8px !important; font-weight: bold !important; text-decoration: none !important; display: inline-flex !important; align-items: center !important; box-shadow: 0 4px 6px rgba(0,0,0,0.1) !important;">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                            BUAT TIKET BARU
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto border-collapse">
                            <thead>
                                <tr class="bg-gray-50 text-left">
                                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">No</th>
                                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Judul</th>
                                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Divisi</th>
                                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Prioritas</th>
                                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-center">Status</th>
                                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal Buat</th>
                                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 bg-white">
                                @forelse($tickets as $key => $ticket)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $key + 1 }}</td>
                                        
                                        <td class="px-6 py-4 text-sm font-bold text-gray-900">{{ $ticket->title }}</td>

                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 py-1 bg-indigo-50 text-indigo-700 rounded text-[10px] font-black uppercase border border-indigo-100">
                                                {{ $ticket->divisi ?? '-' }}
                                            </span>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 py-1 rounded text-[10px] font-black uppercase border 
                                                {{ $ticket->priority == 'high' ? 'bg-red-100 text-red-700 border-red-200' : ($ticket->priority == 'medium' ? 'bg-yellow-100 text-yellow-700 border-yellow-200' : 'bg-green-100 text-green-700 border-green-200') }}">
                                                {{ ucfirst($ticket->priority) }}
                                            </span>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <span style="padding: 4px 12px; border-radius: 9999px; font-size: 10px; font-weight: 800; color: white; background-color: {{ $ticket->status == 'waiting' ? '#eab308' : ($ticket->status == 'open' ? '#2563eb' : ($ticket->status == 'on-progress' ? '#f97316' : ($ticket->status == 'resolved' ? '#16a34a' : '#6b7280'))) }};">
                                                {{ $ticket->status == 'waiting' ? 'WAITING' : ($ticket->status == 'open' ? 'OPEN' : ($ticket->status == 'on-progress' ? 'IN PROGRESS' : strtoupper($ticket->status))) }}
                                            </span>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $ticket->created_at->format('d M Y') }}</td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            @if($ticket->status == 'resolved')
                                                <div class="flex flex-col gap-2">
                                                    <div class="text-[10px] text-gray-500 font-bold uppercase mb-1">
                                                        Konfirmasi Penyelesaian:
                                                    </div>
                                                    <form action="{{ route('tickets.confirm', $ticket->id) }}" method="POST" class="flex gap-1">
                                                        @csrf @method('PATCH')
                                                        <input type="hidden" name="confirmed" value="1">
                                                        <button type="submit" style="background-color: #16a34a; color: white; padding: 4px 8px; border-radius: 4px; font-weight: bold; border: none; font-size: 10px;" class="hover:opacity-80">✓ SELESAI</button>
                                                    </form>
                                                    <form action="{{ route('tickets.confirm', $ticket->id) }}" method="POST" class="flex gap-1">
                                                        @csrf @method('PATCH')
                                                        <input type="hidden" name="confirmed" value="0">
                                                        <button type="submit" style="background-color: #f97316; color: white; padding: 4px 8px; border-radius: 4px; font-weight: bold; border: none; font-size: 10px;" class="hover:opacity-80">✗ BELUM</button>
                                                    </form>
                                                </div>
                                            @elseif($ticket->status !== 'closed')
                                                <div class="flex gap-2">
                                                    <a href="{{ route('tickets.edit', $ticket->id) }}" class="text-xs font-bold text-indigo-700 hover:underline px-2 py-1 bg-indigo-50 rounded">Edit</a>
                                                    <form action="{{ route('tickets.destroy', $ticket->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus tiket ini?');" style="display:inline;">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="text-xs font-bold text-red-600 hover:underline px-2 py-1 bg-red-50 rounded">Hapus</button>
                                                    </form>
                                                </div>
                                            @else
                                                <span class="px-2 py-1 bg-green-50 text-green-700 rounded text-[10px] font-bold">SELESAI</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-10 text-center text-gray-500">
                                            <p class="text-lg font-medium">Anda belum membuat tiket.</p>
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
</x-app-layout>
