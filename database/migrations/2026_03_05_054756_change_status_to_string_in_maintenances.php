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
        // Mengubah status dari ENUM menjadi STRING agar mau menerima kata 'assigned'
        $table->string('status')->default('scheduled')->change();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('maintenances', function (Blueprint $table) {
            //
        });
    }
};
