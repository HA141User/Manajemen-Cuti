<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role', // admin, user, leader, hrd
        'division_id',
        'phone',
        'address',
        'avatar',
        'annual_leave_quota',
        'join_date',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'join_date' => 'date',
        'is_active' => 'boolean',
    ];

    // RELASI

    // 1. User sebagai Anggota Divisi
    public function division()
    {
        return $this->belongsTo(Division::class, 'division_id');
    }

    // 2. User sebagai Ketua Divisi (Jika dia leader)
    public function managedDivision()
    {
        return $this->hasOne(Division::class, 'leader_id');
    }

    // 3. User sebagai Pemohon Cuti
    public function leaveRequests()
    {
        return $this->hasMany(LeaveRequest::class, 'user_id');
    }

    // 4. User sebagai Penyetuju (Leader)
    public function approvalsAsLeader()
    {
        return $this->hasMany(LeaveRequest::class, 'leader_approver_id');
    }

    // 5. User sebagai Penyetuju Final (HRD)
    public function approvalsAsHRD()
    {
        return $this->hasMany(LeaveRequest::class, 'hrd_approver_id');
    }
}