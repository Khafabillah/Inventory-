<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // <-- Tambahan 1

class Asset extends Model
{
    use HasFactory, SoftDeletes; // <-- Tambahan 2

    protected $guarded = ['id'];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    // Relasi ke tabel rooms
    public function room()
    {
        return $this->belongsTo(Room::class);
    }
    // Relasi ke tabel categories
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
