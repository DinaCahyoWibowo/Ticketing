<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    /**
     * Menampilkan daftar tiket berdasarkan Role.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        if ($user->role == 'karyawan') {
            // Karyawan: Hanya lihat tiket mereka sendiri, tidak perlu summary cards
            $tickets = Ticket::where('user_id', $user->id)->latest()->get();
            return view('dashboard-karyawan', compact('tickets'));
        }

        // SPV & IT STAFF: Melihat SEMUA tiket dengan summary cards
        // KPI counts are computed from the full dataset
        $allTickets = Ticket::all();

        $totalTickets = $allTickets->count();
        $waitingTickets = $allTickets->where('status', 'waiting')->count();
        $openTickets = $allTickets->where('status', 'open')->count();
        $inProgressTickets = $allTickets->whereIn('status', ['on-progress', 'resolved'])->count();
        $closedTickets = $allTickets->where('status', 'closed')->count();
        $highPriorityTickets = $allTickets->where('priority', 'high')->count();

        // Build listing query with optional search, filter and sort
        $query = Ticket::with(['user', 'assignedUser']);

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('title', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('divisi')) {
            $query->where('divisi', $request->divisi);
        }

        $sort = $request->get('sort', 'created_at');
        $direction = $request->get('direction', 'desc');
        if (!in_array($direction, ['asc', 'desc'])) {
            $direction = 'desc';
        }

        if ($sort === 'priority') {
            // Custom ordering: high > medium > low (DB-agnostic CASE expression)
            $query->orderByRaw("(CASE WHEN priority='high' THEN 1 WHEN priority='medium' THEN 2 ELSE 3 END) {$direction}");
        } elseif (in_array($sort, ['created_at', 'status'])) {
            $query->orderBy($sort, $direction);
        } else {
            $query->latest();
        }

        $tickets = $query->get();

        $itStaffs = User::where('role', 'it_staff')->get();
        return view('dashboard', compact('tickets', 'totalTickets', 'waitingTickets', 'openTickets', 'inProgressTickets', 'closedTickets', 'highPriorityTickets', 'itStaffs'));
    }
    public function create()
    {
        return view('tickets.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'divisi' => 'required',
            'no_wa' => 'required|numeric', // validasi nomor agar hanya angka
            'priority' => 'required|in:low,medium,high'
        ]);

        Ticket::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description,
            'divisi' => $request->divisi,
            'no_wa' => $request->no_wa,
            'priority' => $request->priority,
            'status' => 'waiting',
        ]);

        return redirect()->route('dashboard')->with('success', 'Tiket berhasil dikirim!');
    }

    public function edit(Ticket $ticket)
    {
        if (Auth::user()->role !== 'spv' && Auth::id() !== $ticket->user_id) {
            return back()->with('error', 'Anda tidak memiliki akses untuk mengedit tiket ini.');
        }

        if (in_array($ticket->status, ['resolved', 'closed'])) {
            return back()->with('error', 'Tiket yang sudah selesai tidak dapat diedit.');
        }

        return view('tickets.edit', compact('ticket'));
    }

    public function update(Request $request, Ticket $ticket)
    {
        if (Auth::user()->role !== 'spv' && Auth::id() !== $ticket->user_id) {
            return back()->with('error', 'Anda tidak memiliki akses untuk mengubah tiket ini.');
        }

        if (in_array($ticket->status, ['resolved', 'closed'])) {
            return back()->with('error', 'Tiket yang sudah selesai tidak dapat diubah.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'divisi' => 'required',
            'no_wa' => 'required|numeric',
            'priority' => 'required|in:low,medium,high',
        ]);

        $ticket->update([
            'title' => $request->title,
            'description' => $request->description,
            'divisi' => $request->divisi,
            'no_wa' => $request->no_wa,
            'priority' => $request->priority,
        ]);

        return redirect()->route('dashboard')->with('success', 'Tiket berhasil diperbarui.');
    }

    public function destroy(Ticket $ticket)
    {
        if (Auth::user()->role !== 'spv' && Auth::id() !== $ticket->user_id) {
            return back()->with('error', 'Anda tidak memiliki akses untuk menghapus tiket ini.');
        }

        $ticket->delete();

        return back()->with('success', 'Tiket berhasil dihapus.');
    }

    /**
     * Fitur SPV: Menerima dan mendistribusikan tiket ke Staff IT
     */
    public function assign(Request $request, Ticket $ticket)
    {
        if (Auth::user()->role !== 'spv') {
            return back()->with('error', 'Hanya SPV yang dapat mendistribusikan tiket.');
        }

        if ($ticket->status !== 'waiting') {
            return back()->with('error', 'Hanya tiket dengan status Waiting yang dapat didistribusikan.');
        }

        $request->validate([
            'it_staff_id' => 'required|exists:users,id',
        ]);

        $ticket->update([
            'assigned_to' => $request->it_staff_id,
            'status' => 'open' // Berubah ke Open, siap untuk IT staff mulai kerjakan
        ]);

        return back()->with('success', 'Tiket berhasil didistribusikan ke Staff IT.');
    }

    /**
     * Fitur Staff IT: Mengupdate status pengerjaan
     */
    public function updateStatus(Request $request, Ticket $ticket)
    {
        $request->validate([
            'status' => 'required|in:on-progress,resolved',
        ]);

        if (in_array($ticket->status, ['resolved', 'closed'])) {
            return back()->with('error', 'Tiket sudah diselesaikan dan tidak dapat diubah lagi.');
        }

        // Proteksi: Hanya staff yang ditugaskan (atau SPV) yang bisa update
        if (Auth::user()->role == 'it_staff' && $ticket->assigned_to != Auth::id()) {
            return back()->with('error', 'Anda tidak ditugaskan untuk tiket ini.');
        }

        $ticket->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Status tiket berhasil diperbarui.');
    }

    /**
     * Fitur Karyawan: Mengkonfirmasi tiket yang sudah diresolve
     */
    public function confirmResolved(Request $request, Ticket $ticket)
    {
        // Hanya pembuat tiket yang bisa konfirmasi
        if (Auth::id() !== $ticket->user_id) {
            return back()->with('error', 'Hanya pembuat tiket yang dapat mengkonfirmasi.');
        }

        if ($ticket->status !== 'resolved') {
            return back()->with('error', 'Hanya tiket dengan status Resolved yang dapat dikonfirmasi.');
        }

        $request->validate([
            'confirmed' => 'required|boolean',
        ]);

        if ($request->confirmed) {
            // Masalah sudah benar-benar selesai
            $ticket->update(['status' => 'closed']);
            return back()->with('success', 'Tiket dikonfirmasi selesai dan ditutup.');
        } else {
            // Masalah belum selesai, kembali ke In Progress
            $ticket->update(['status' => 'on-progress']);
            return back()->with('success', 'Tiket dikembalikan ke In Progress untuk penanganan lebih lanjut.');
        }
    }

    /**
     * Tambah komentar / catatan pada tiket
     */
    public function addComment(Request $request, Ticket $ticket)
    {
        $request->validate([
            'body' => 'required|string|max:2000'
        ]);

        // Simple permission: only authenticated users can comment; more rules can be added
        $ticket->comments()->create([
            'user_id' => Auth::id(),
            'body' => $request->body,
        ]);

        return back()->with('success', 'Komentar berhasil ditambahkan.');
    }
}