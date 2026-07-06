<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

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
