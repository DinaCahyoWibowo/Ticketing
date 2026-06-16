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
    Schema::table('tickets', function (Blueprint $table) {
        // Gunakan nama kolom sesuai yang diminta Controller (divisi dan no_wa)
        $table->string('divisi')->nullable()->after('description');
        $table->string('no_wa')->nullable()->after('divisi');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            //
        });
    }
};
