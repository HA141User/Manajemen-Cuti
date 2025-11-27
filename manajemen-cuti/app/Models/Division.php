<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'manager_id',
    ];

    // --- RELASI ---

    // 1. Divisi dipimpin oleh satu Manager (User)
    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    // 2. Divisi memiliki banyak Anggota (User)
    public function members()
    {
        return $this->hasMany(User::class, 'division_id');
    }
}