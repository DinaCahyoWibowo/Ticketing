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
    Schema::table('maintenances', function (Blueprint $table) {
        // Cek apakah kolom sudah ada untuk menghindari error duplikat
        if (!Schema::hasColumn('maintenances', 'it_staff_id')) {
            $table->unsignedBigInteger('it_staff_id')->nullable()->after('created_by');
            
            // Relasi ke tabel users
            $table->foreign('it_staff_id')->references('id')->on('users')->onDelete('set null');
        }
    });
}

public function down(): void
{
    Schema::table('maintenances', function (Blueprint $table) {
        $table->dropForeign(['it_staff_id']);
        $table->dropColumn('it_staff_id');
    });
}

};