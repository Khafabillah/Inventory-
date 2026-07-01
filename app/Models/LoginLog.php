<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginLog extends Model
{
    use HasFactory;

    // Menentukan nama tabel secara eksplisit karena kamu buat manual di Heidi
    protected $table = 'login_logs';

    // KUNCI UTAMA: Mengizinkan kolom-kolom ini diisi secara massal
    protected $fillable = [
        'user_id',
        'ip_address',
        'user_agent',
    ];

    public $timestamps = true;

    // Relasi balik ke User (Bermanfaat untuk Audit Trail nanti)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
