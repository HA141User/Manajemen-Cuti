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
        'leader_id'
    ];

    // RELASI

    // 1. Divisi punya satu Ketua
    public function leader()
    {
        return $this->belongsTo(User::class, 'leader_id');
    }

    // 2. Divisi punya banyak Anggota
    public function members()
    {
        return $this->hasMany(User::class, 'division_id');
    }
}