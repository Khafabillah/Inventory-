<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // 1. Relasi ke Asset (yang sudah kita buat sebelumnya)
    public function assets()
    {
        return $this->hasMany(Asset::class);
    }

    // 2. TAMBAHKAN INI: Relasi ke Branch
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
