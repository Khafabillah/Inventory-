<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
    ];

    /**
     * Boot function untuk menempelkan event pada model.
     */
    protected static function boot()
    {
        parent::boot();

        // Event 'creating' dieksekusi TEPAT SEBELUM data baru disimpan ke database
        static::creating(function ($category) {
            // Jika kodenya kosong (tidak diinput manual)
            if (empty($category->code)) {
                // Cari ID terakhir
                $lastCategory = self::orderBy('id', 'desc')->first();
                $nextId = $lastCategory ? $lastCategory->id + 1 : 1;

                // Set kode otomatis
                $category->code = 'KTG-' . str_pad($nextId, 3, '0', STR_PAD_LEFT);
            }
        });
    }
}
