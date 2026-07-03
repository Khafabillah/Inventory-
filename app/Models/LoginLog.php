<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginLog extends Model
{
    use HasFactory;

    protected $table = 'login_logs';

    // Cukup isi kolom yang tidak otomatis (created_at/updated_at diurus Laravel)
    protected $fillable = [
        'user_id',
        'ip_address',
        'user_agent',
    ];

    // Karena di laptop sudah ada created_at/updated_at, ini harus true
    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}