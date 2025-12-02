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
        Schema::create('leave_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Pemohon
            
            // Jenis Cuti
            $table->enum('type', ['annual', 'sick']); 
            
            // Status Approval (State Machine)
            // pending: Menunggu respon Leader
            // approved_leader: Leader setuju, lanjut ke HRD
            // approved_hrd: Final (Disetujui)
            // rejected: Ditolak (oleh Leader atau HRD)
            $table->enum('status', ['pending', 'approved_leader', 'approved_hrd', 'rejected'])->default('pending');

            $table->date('start_date');
            $table->date('end_date');
            $table->integer('total_days'); // Hasil kalkulasi hari kerja
            $table->text('reason'); // Alasan cuti
            
            // Data Tambahan
            $table->string('attachment')->nullable(); // Surat Dokter (Path file)
            $table->text('leave_address')->nullable(); // Alamat saat cuti
            $table->string('emergency_contact')->nullable(); // Nomor darurat

            // Approval Tracking
            $table->foreignId('leader_approver_id')->nullable()->constrained('users'); // Siapa leader yg approve
            $table->foreignId('hrd_approver_id')->nullable()->constrained('users'); // Siapa HRD yg approve
            
            $table->text('rejection_note')->nullable(); // Alasan penolakan (Wajib jika reject)
            $table->date('hrd_approval_date')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_requests');
    }
};