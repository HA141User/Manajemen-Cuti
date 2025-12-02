<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type', // annual, sick
        'status', // pending, approved_leader, approved_hrd, rejected
        'start_date',
        'end_date',
        'total_days',
        'reason',
        'attachment',
        'leave_address',
        'emergency_contact',
        'leader_approver_id',
        'hrd_approver_id',
        'rejection_note',
        'hrd_approval_date'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'hrd_approval_date' => 'date',
    ];

    // RELASI

    // 1. Milik siapa pengajuan ini?
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 2. Siapa Leader yang approve?
    public function leaderApprover()
    {
        return $this->belongsTo(User::class, 'leader_approver_id');
    }

    // 3. Siapa HRD yang approve?
    public function hrdApprover()
    {
        return $this->belongsTo(User::class, 'hrd_approver_id');
    }
}