<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends Model
{
    use HasFactory;

    /**
     * Daftar kolom yang boleh diisi (Mass Assignment)
     */
    protected $fillable = [
        'user_id', 
        'title', 
        'description', 
        'status', 
        'priority',
        'assigned_to',
        'no_wa',  // Kolom baru untuk integrasi WhatsApp
        'divisi', // Kolom baru untuk informasi departemen
    ];

    /**
     * Relasi: Mendapatkan user yang membuat tiket (Karyawan)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi: Mendapatkan staff IT yang ditugaskan (Delegasi)
     */
    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Relasi: Komentar / catatan untuk tiket
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}