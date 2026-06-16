<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'deskripsi',
        'jadwal_mulai',
        'status',
        'created_by',
        'it_staff_id' // Pastikan ini sudah ada di migration Anda
    ];

    /**
     * Relasi ke User sebagai Pembuat Jadwal (SPV)
     */
    public function creator()
    {
        // Maintenance dibuat oleh seorang User melalui kolom created_by
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Relasi ke User sebagai Petugas IT (Staff IT)
     */
    public function itStaff()
    {
        // Maintenance ditugaskan ke seorang User melalui kolom it_staff_id
        return $this->belongsTo(User::class, 'it_staff_id');
    }
}