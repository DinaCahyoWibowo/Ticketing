<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\MaintenanceController; // Pastikan Controller ini dibuat nanti
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check() 
        ? redirect('/dashboard') 
        : redirect('/register');
});

// Grup Route yang Membutuhkan Login (Auth)
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard Utama (Menampilkan daftar tiket sesuai role)
    Route::get('/dashboard', [TicketController::class, 'index'])->name('dashboard');

    // --- FITUR TICKETING ---
    
    // 1. Alur Karyawan: Membuat Tiket
    Route::get('/tickets/create', [TicketController::class, 'create'])->name('tickets.create');
    Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');

    // 1b. Edit / Delete Ticket
    Route::get('/tickets/{ticket}/edit', [TicketController::class, 'edit'])->name('tickets.edit');
    Route::put('/tickets/{ticket}', [TicketController::class, 'update'])->name('tickets.update');
    Route::delete('/tickets/{ticket}', [TicketController::class, 'destroy'])->name('tickets.destroy');

    // 2. Alur SPV: Mendelegasikan Tiket ke Staff IT
    Route::patch('/tickets/{ticket}/assign', [TicketController::class, 'assign'])->name('tickets.assign');

    // 3. Alur Staff IT: Mengubah Status Tiket (On-Progress/Resolved)
    Route::patch('/tickets/{ticket}/status', [TicketController::class, 'updateStatus'])->name('tickets.updateStatus');

    // 4. Alur Karyawan: Mengkonfirmasi tiket yang sudah diresolve (Confirmed/Not Confirmed)
    Route::patch('/tickets/{ticket}/confirm', [TicketController::class, 'confirmResolved'])->name('tickets.confirm');

    // Add comment/note to a ticket (all authenticated users who can view/edit will be able to comment)
    Route::post('/tickets/{ticket}/comments', [TicketController::class, 'addComment'])->name('tickets.comments');


    // --- FITUR MAINTENANCE (Menu Baru) ---

    // Route untuk Staff IT (Melihat Jadwal)
    Route::get('/maintenance', [MaintenanceController::class, 'index'])->name('maintenance.index');

    // Route untuk SPV (Membuat Jadwal)
    Route::get('/maintenance/create', [MaintenanceController::class, 'create'])->name('maintenance.create');
    Route::post('/maintenance', [MaintenanceController::class, 'store'])->name('maintenance.store');
    Route::patch('/maintenance/{maintenance}/assign', [MaintenanceController::class, 'assign'])->name('maintenance.assign');
    Route::patch('/maintenance/{maintenance}/complete', [MaintenanceController::class, 'complete'])->name('maintenance.complete');


    // --- FITUR MANAJEMEN USER (SPV & IT STAFF) ---
    Route::get('/users', [UserManagementController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserManagementController::class, 'create'])->name('users.create');
    Route::post('/users', [UserManagementController::class, 'store'])->name('users.store');
    Route::patch('/users/{id}/approve', [UserManagementController::class, 'approve'])->name('users.approve');
    Route::patch('/users/{id}/reject', [UserManagementController::class, 'reject'])->name('users.reject');


    // --- FITUR PROFILE (Bawaan Laravel Breeze) ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';