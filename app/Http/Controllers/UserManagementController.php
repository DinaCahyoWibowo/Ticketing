<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    /**
     * Menampilkan daftar user dan user yang menunggu approval
     */
    public function index()
    {
        $user = Auth::user();

        // Hanya SPV dan IT Staff yang bisa akses halaman ini
        if (!in_array($user->role, ['spv', 'it_staff'])) {
            return back()->with('error', 'Anda tidak memiliki akses untuk mengelola user.');
        }

        if ($user->role == 'spv') {
            // SPV: Lihat semua user dan user yang menunggu approval
            $approvedUsers = User::where('is_approved', true)->latest()->get();
            $pendingUsers = User::where('is_approved', false)->latest()->get();
            $myCreatedUsers = collect(); // SPV tidak perlu melihat daftar ini
        } else {
            // IT Staff: Lihat user yang sudah diapprove + user yang dia buat (pending/approved)
            $approvedUsers = User::where('is_approved', true)->latest()->get();
            $pendingUsers = collect();
            $myCreatedUsers = User::where('created_by', $user->id)->latest()->get(); // User yang dibuat IT Staff ini
        }

        return view('users.index', compact('approvedUsers', 'pendingUsers', 'myCreatedUsers'));
    }

    /**
     * Menampilkan form untuk membuat user baru
     */
    public function create()
    {
        $user = Auth::user();

        // Hanya SPV dan IT Staff yang bisa membuat user
        if (!in_array($user->role, ['spv', 'it_staff'])) {
            return back()->with('error', 'Anda tidak memiliki akses untuk membuat user.');
        }

        return view('users.create');
    }

    /**
     * Menyimpan user baru ke database
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        // Hanya SPV dan IT Staff yang bisa membuat user
        if (!in_array($user->role, ['spv', 'it_staff'])) {
            return back()->with('error', 'Anda tidak memiliki akses untuk membuat user.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'role' => 'required|in:karyawan,it_staff,spv',
        ]);

        // Tentukan is_approved berdasarkan role pembuat
        $isApproved = ($user->role === 'spv'); // SPV bisa langsung approve, IT Staff tidak

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'is_approved' => $isApproved,
            'created_by' => $user->id,
        ]);

        $message = $isApproved 
            ? 'User berhasil dibuat!' 
            : 'User berhasil dibuat dan menunggu approval dari SPV.';

        return redirect()->route('users.index')->with('success', $message);
    }

    /**
     * Approve user yang dibuat oleh IT Staff (hanya SPV)
     */
    public function approve($id)
    {
        $user = Auth::user();

        // Hanya SPV yang bisa approve
        if ($user->role !== 'spv') {
            return back()->with('error', 'Hanya SPV yang dapat menyetujui user.');
        }

        $userToApprove = User::findOrFail($id);

        // Cek apakah user sudah diapprove
        if ($userToApprove->is_approved) {
            return back()->with('error', 'User ini sudah diapprove.');
        }

        $userToApprove->update(['is_approved' => true]);

        return back()->with('success', "User '{$userToApprove->name}' berhasil diapprove.");
    }

    /**
     * Reject user yang dibuat oleh IT Staff (hanya SPV)
     */
    public function reject($id)
    {
        $user = Auth::user();

        // Hanya SPV yang bisa reject
        if ($user->role !== 'spv') {
            return back()->with('error', 'Hanya SPV yang dapat menolak user.');
        }

        $userToReject = User::findOrFail($id);

        // Cek apakah user sudah diapprove
        if ($userToReject->is_approved) {
            return back()->with('error', 'User ini sudah diapprove, tidak dapat ditolak.');
        }

        // Hapus user yang ditolak
        $userName = $userToReject->name;
        $userToReject->delete();

        return back()->with('success', "User '{$userName}' berhasil ditolak dan dihapus.");
    }
}
