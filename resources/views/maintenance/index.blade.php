<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Jadwal Maintenance Sistem') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Alert Success --}}
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg shadow-sm flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="font-bold">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-100">
                {{-- HEADER DAFTAR AGENDA & TOMBOL TAMBAH --}}
                <div class="mb-6 flex justify-between items-center border-b pb-4">
                    <h3 class="text-lg font-bold text-gray-700 uppercase tracking-tight">Daftar Agenda Maintenance</h3>
                    
                    @if(Auth::user()->role == 'spv')
                        <a href="{{ route('maintenance.create') }}" 
                           class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md">
                            + Tambah Jadwal Baru
                        </a>
                    @endif
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full border-separate border-spacing-0">
                        <thead>
                            <tr class="bg-gray-50 text-left text-gray-600 uppercase text-xs tracking-wider">
                                <th class="border-b border-t border-l px-6 py-4 font-bold">Judul Agenda</th>
                                <th class="border-b border-t px-6 py-4 font-bold">Waktu Pelaksanaan</th>
                                <th class="border-b border-t px-6 py-4 font-bold">Dibuat Oleh</th>
                                <th class="border-b border-t px-6 py-4 font-bold">Petugas IT Support</th>
                                <th class="border-b border-t px-6 py-4 font-bold text-center">Status</th>
                                <th class="border-b border-t border-r px-6 py-4 font-bold text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700 divide-y divide-gray-100">
                            @forelse($maintenances as $item)
                                @php
                                    $isOverdue = \Carbon\Carbon::parse($item->jadwal_mulai)->isPast() && $item->status != 'completed';
                                @endphp
                                <tr class="hover:bg-gray-50 transition {{ $isOverdue ? 'bg-red-50/50' : '' }}">
                                    <td class="px-6 py-4 font-semibold {{ $isOverdue ? 'text-red-700' : 'text-gray-900' }}">
                                        {{ $item->judul }}
                                        @if($isOverdue)
                                            <span class="block text-[10px] uppercase font-black text-red-600 italic mt-1 tracking-tighter">⚠️ Jadwal Terlewati</span>
                                        @endif
                                    </td>
                                    
                                    <td class="px-6 py-4 text-sm">
                                        <div class="flex items-center {{ $isOverdue ? 'text-red-600 font-bold' : 'text-gray-600' }}">
                                            <svg class="w-4 h-4 mr-2 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            {{ \Carbon\Carbon::parse($item->jadwal_mulai)->format('d M Y, H:i') }}
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 text-xs font-medium text-gray-500">
                                        {{ $item->creator->name ?? 'System' }}
                                    </td>

                                    <td class="px-6 py-4">
                                        @if($item->itStaff)
                                            <div class="flex items-center">
                                                <div class="w-2 h-2 rounded-full bg-indigo-500 mr-2"></div>
                                                <span class="text-sm text-indigo-800 font-bold uppercase tracking-tight">{{ $item->itStaff->name }}</span>
                                            </div>
                                        @else
                                            <span class="text-xs text-gray-400 italic">Belum ditentukan</span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        @php
                                            $colorClass = match($item->status) {
                                                'completed' => 'bg-green-100 text-green-800 border-green-200',
                                                'assigned' => 'bg-blue-100 text-blue-800 border-blue-200',
                                                default => 'bg-orange-100 text-orange-800 border-orange-200',
                                            };
                                            if($isOverdue) $colorClass = 'bg-red-200 text-red-900 border-red-300 shadow-sm';
                                        @endphp
                                        <span class="px-3 py-1 rounded-full text-[10px] font-black border {{ $colorClass }}">
                                            {{ strtoupper($item->status) }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        @if(Auth::user()->role == 'it_staff' && $item->it_staff_id == Auth::id() && $item->status == 'assigned')
                                            <form action="{{ route('maintenance.complete', $item->id) }}" method="POST">
                                                @csrf @method('PATCH')
                                                <button type="submit" 
                                                        onclick="return confirm('Konfirmasi bahwa maintenance telah selesai?')"
                                                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow-md text-[10px] font-black transition-all active:scale-95 uppercase">
                                                    ✔ Selesaikan
                                                </button>
                                            </form>
                                        @elseif(Auth::user()->role == 'spv' && $item->status == 'scheduled')
                                            <form action="{{ route('maintenance.assign', $item->id) }}" method="POST">
                                                @csrf @method('PATCH')
                                                <select name="it_staff_id" required onchange="this.form.submit()" 
                                                        class="text-[10px] rounded border-gray-300 py-1 px-2 focus:ring-indigo-500 shadow-sm cursor-pointer hover:border-indigo-400 font-bold uppercase">
                                                    <option value="">Tugaskan Ke...</option>
                                                    @foreach($staff_it as $it)
                                                        <option value="{{ $it->id }}">{{ $it->name }}</option>
                                                    @endforeach
                                                </select>
                                            </form>
                                        @elseif($item->status == 'completed')
                                            <span class="inline-flex items-center text-green-600 font-black text-[10px] uppercase">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                                Selesai
                                            </span>
                                        @else
                                            <span class="text-gray-300 italic text-xs">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-20 text-center text-gray-400 italic font-medium bg-gray-50/30">
                                        Tidak ada jadwal maintenance yang terdaftar saat ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>