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
        // 1. Menambahkan kolom leader_id ke tabel DIVISIONS
        Schema::table('divisions', function (Blueprint $table) {
            $table->foreignId('leader_id')->nullable()->after('description')->constrained('users')->onDelete('set null');
        });

        // 2. Menambahkan CONSTRAINT (Relasi) division_id ke tabel USERS
        // Tadi di create_users_table kita cuma buat kolomnya, sekarang kita sambungkan kawatnya.
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('division_id')->references('id')->on('divisions')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Hapus relasi di users dulu
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['division_id']);
        });

        // Hapus relasi dan kolom di divisions
        Schema::table('divisions', function (Blueprint $table) {
            $table->dropForeign(['leader_id']);
            $table->dropColumn('leader_id');
        });
    }
};