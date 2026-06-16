<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            // User yang membuat tiket (Karyawan)
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
            
            $table->string('title');
            $table->text('description');
            
            // Status disesuaikan dengan alur kerja delegasi
            $table->enum('status', ['waiting', 'open', 'on-progress', 'resolved', 'closed'])->default('waiting');
            $table->enum('priority', ['low', 'medium', 'high'])->default('low');

            // --- PENAMBAHAN KOLOM DELEGASI ---
            // assigned_to menghubungkan ke tabel users (ID Staff IT yang ditugaskan)
            // nullable() karena saat tiket dibuat, belum ada staff yang ditugaskan
            $table->foreignId('assigned_to')->nullable()->constrained('users')->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};