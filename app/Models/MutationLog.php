<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MutationLog extends Model
{
    protected $table = 'mutation_logs';

    protected $fillable = [
        'asset_id',
        'user_id',
        'old_room_id',
        'new_room_id',
        'description',
        'mutation_date',
        'action',
    ];

    public function asset()
    {
        // <-- Tambahan withTrashed() di ujung relasi
        return $this->belongsTo(Asset::class, 'asset_id')->withTrashed();
    }

    public function fromRoom()
    {
        return $this->belongsTo(Room::class, 'old_room_id');
    }

    public function toRoom()
    {
        return $this->belongsTo(Room::class, 'new_room_id');
    }

    // Relasi ke tabel Users (Siapa yang melakukan mutasi?)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
