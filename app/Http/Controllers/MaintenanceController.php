<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Maintenance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaintenanceController extends Controller
{
    /**
     * Tampilkan Daftar Maintenance
     */
    public function index()
    {
        $user = Auth::user();

        if (!in_array($user->role, ['it_staff', 'spv'])) {
            abort(403);
        }

        $query = Maintenance::with(['creator', 'itStaff'])->latest();

        if ($user->role === 'it_staff') {
            $query->where('it_staff_id', $user->id);
        }

        $maintenances = $query->get();
        $staff_it = User::where('role', 'it_staff')->get();

        return view('maintenance.index', compact('maintenances', 'staff_it'));
    }

    /**
     * Form Buat Maintenance (Hanya SPV)
     */
    public function create()
    {
        if (Auth::user()->role !== 'spv') {
            abort(403);
        }
        return view('maintenance.create');
    }

    /**
     * Simpan Jadwal Baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul'        => 'required|string|max:255',
            'deskripsi'    => 'required',
            'jadwal_mulai' => 'required|date',
        ]);

        Maintenance::create([
            'judul'        => $request->judul,
            'deskripsi'    => $request->deskripsi,
            'jadwal_mulai' => $request->jadwal_mulai,
            'created_by'   => Auth::id(),
            'status'       => 'scheduled',
        ]);

        return redirect()->route('maintenance.index')->with('success', 'Jadwal maintenance berhasil dibuat.');
    }

    /**
     * SPV Mendelegasikan ke Staff IT
     */
    public function assign(Request $request, $id)
    {
        $request->validate([
            'it_staff_id' => 'required|exists:users,id',
        ]);

        $maintenance = Maintenance::findOrFail($id);

        $maintenance->update([
            'it_staff_id' => $request->it_staff_id,
            'status'      => 'assigned',
        ]);

        return redirect()->route('maintenance.index')->with('success', 'Tugas berhasil didelegasikan ke Petugas IT.');
    }

    /**
     * Staff IT Mengonfirmasi Selesai
     */
    public function complete($id)
    {
        $maintenance = Maintenance::findOrFail($id);

        if (Auth::user()->role !== 'it_staff' || $maintenance->it_staff_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki otoritas untuk menyelesaikan tugas ini.');
        }

        $maintenance->update([
            'status' => 'completed'
        ]);

        return back()->with('success', 'Status maintenance diperbarui menjadi Selesai.');
    }
}