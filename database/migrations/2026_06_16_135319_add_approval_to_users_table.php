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
        Schema::table('users', function (Blueprint $table) {
            // Approval workflow: it_staff requests need approval from SPV
            $table->boolean('is_approved')->default(true)->after('role'); // true by default for SPV-created users
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null')->after('is_approved'); // who created this user
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['is_approved', 'created_by']);
        });
    }
};
