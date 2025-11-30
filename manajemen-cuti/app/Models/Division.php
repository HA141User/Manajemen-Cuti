<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'manager_id'];

    /**
     * Relasi: Divisi memiliki satu Manager (User).
     */
    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    /**
     * Relasi: Divisi memiliki banyak Anggota (Users).
     * INI YANG TADI HILANG DAN MENYEBABKAN ERROR.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}