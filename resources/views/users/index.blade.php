<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
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
                            <h3 class="text-2xl font-bold text-gray-800">Manajemen User</h3>
                            <p class="text-sm text-gray-500">Kelola dan atur user sistem.</p>
                        </div>

                        @if(in_array(Auth::user()->role, ['spv', 'it_staff']))
                            <a href="{{ route('users.create') }}" 
                               style="background-color: #4338ca !important; color: white !important; padding: 10px 20px !important; border-radius: 8px !important; font-weight: bold !important; text-decoration: none !important; display: inline-flex !important; align-items: center !important; box-shadow: 0 4px 6px rgba(0,0,0,0.1) !important;">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                                BUAT USER BARU
                            </a>
                        @endif
                    </div>

                    <!-- IT Staff: User yang Dibuat (dengan status) -->
                    @if(Auth::user()->role == 'it_staff' && count($myCreatedUsers) > 0)
                        <div class="mb-8 p-4 bg-blue-50 border-2 border-blue-200 rounded-lg">
                            <h4 class="text-lg font-bold text-blue-900 mb-4">📋 User yang Saya Buat</h4>
                            <div class="overflow-x-auto">
                                <table class="min-w-full table-auto border-collapse">
                                    <thead>
                                        <tr class="bg-blue-100 text-left">
                                            <th class="px-6 py-4 text-xs font-bold text-blue-900 uppercase tracking-wider">Nama</th>
                                            <th class="px-6 py-4 text-xs font-bold text-blue-900 uppercase tracking-wider">Email</th>
                                            <th class="px-6 py-4 text-xs font-bold text-blue-900 uppercase tracking-wider">Role</th>
                                            <th class="px-6 py-4 text-xs font-bold text-blue-900 uppercase tracking-wider">Status</th>
                                            <th class="px-6 py-4 text-xs font-bold text-blue-900 uppercase tracking-wider">Tanggal Dibuat</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-blue-100 bg-white">
                                        @foreach($myCreatedUsers as $user)
                                            <tr class="hover:bg-blue-50 transition">
                                                <td class="px-6 py-4 whitespace-nowrap font-bold text-gray-900">{{ $user->name }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $user->email }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="px-2 py-1 
                                                        @if($user->role == 'spv') bg-red-100 text-red-700
                                                        @elseif($user->role == 'it_staff') bg-blue-100 text-blue-700
                                                        @else bg-green-100 text-green-700
                                                        @endif
                                                        rounded text-[10px] font-black uppercase border 
                                                        @if($user->role == 'spv') border-red-200
                                                        @elseif($user->role == 'it_staff') border-blue-200
                                                        @else border-green-200
                                                        @endif">
                                                        {{ $user->role }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    @if($user->is_approved)
                                                        <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-[10px] font-bold uppercase border border-green-300">
                                                            ✓ Disetujui
                                                        </span>
                                                    @else
                                                        <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-[10px] font-bold uppercase border border-yellow-300">
                                                            ⏳ Menunggu Approval
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                                    {{ $user->created_at->format('d M Y, H:i') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif

                    <!-- IT Staff: No created users message -->
                    @if(Auth::user()->role == 'it_staff' && count($myCreatedUsers) == 0)
                        <div class="mb-8 p-4 bg-gray-50 border-2 border-gray-200 rounded-lg">
                            <p class="text-gray-600 italic">Anda belum membuat user baru.</p>
                        </div>
                    @endif

                    <!-- Pending Approvals (SPV Only) -->
                    @if(Auth::user()->role == 'spv' && count($pendingUsers) > 0)
                        <div class="mb-8 p-4 bg-yellow-50 border-2 border-yellow-200 rounded-lg">
                            <h4 class="text-lg font-bold text-yellow-900 mb-4">⏳ User Menunggu Persetujuan</h4>
                            <div class="overflow-x-auto">
                                <table class="min-w-full table-auto border-collapse">
                                    <thead>
                                        <tr class="bg-yellow-100 text-left">
                                            <th class="px-6 py-4 text-xs font-bold text-yellow-900 uppercase tracking-wider">Nama</th>
                                            <th class="px-6 py-4 text-xs font-bold text-yellow-900 uppercase tracking-wider">Email</th>
                                            <th class="px-6 py-4 text-xs font-bold text-yellow-900 uppercase tracking-wider">Role</th>
                                            <th class="px-6 py-4 text-xs font-bold text-yellow-900 uppercase tracking-wider">Dibuat Oleh</th>
                                            <th class="px-6 py-4 text-xs font-bold text-yellow-900 uppercase tracking-wider">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-yellow-100 bg-white">
                                        @foreach($pendingUsers as $user)
                                            <tr class="hover:bg-yellow-50 transition">
                                                <td class="px-6 py-4 whitespace-nowrap font-bold text-gray-900">{{ $user->name }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $user->email }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-[10px] font-black uppercase border border-blue-200">
                                                        {{ $user->role }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                                    {{ $user->creator->name ?? '-' }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm flex gap-2">
                                                    <form action="{{ route('users.approve', $user->id) }}" method="POST" style="display:inline;">
                                                        @csrf @method('PATCH')
                                                        <button type="submit" style="background-color: #16a34a; color: white; padding: 6px 12px; border-radius: 6px; font-weight: bold; border: none; font-size: 11px; cursor: pointer;">
                                                            Setujui
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('users.reject', $user->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menolak user ini?');">
                                                        @csrf @method('PATCH')
                                                        <button type="submit" style="background-color: #dc2626; color: white; padding: 6px 12px; border-radius: 6px; font-weight: bold; border: none; font-size: 11px; cursor: pointer;">
                                                            Tolak
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif

                    <!-- Approved Users -->
                    <div>
                        <h4 class="text-lg font-bold text-gray-800 mb-4">✓ User Aktif</h4>
                        <div class="overflow-x-auto">
                            <table class="min-w-full table-auto border-collapse">
                                <thead>
                                    <tr class="bg-gray-50 text-left">
                                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">No</th>
                                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Nama</th>
                                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Email</th>
                                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Role</th>
                                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 bg-white">
                                    @forelse($approvedUsers as $key => $user)
                                        <tr class="hover:bg-gray-50 transition">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $key + 1 }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap font-bold text-gray-900">{{ $user->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $user->email }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 py-1 
                                                    @if($user->role == 'spv') bg-red-100 text-red-700
                                                    @elseif($user->role == 'it_staff') bg-blue-100 text-blue-700
                                                    @else bg-green-100 text-green-700
                                                    @endif
                                                    rounded text-[10px] font-black uppercase border 
                                                    @if($user->role == 'spv') border-red-200
                                                    @elseif($user->role == 'it_staff') border-blue-200
                                                    @else border-green-200
                                                    @endif">
                                                    {{ $user->role }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-[10px] font-black uppercase border border-green-200">
                                                    Aktif
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                                                <p class="text-lg font-medium">Belum ada user yang dibuat.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

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
