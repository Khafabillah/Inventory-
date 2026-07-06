<?php

namespace Database\Factories;

use App\Models\Asset;
use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Asset>
 */
class AssetFactory extends Factory
{
    protected $model = Asset::class;

    protected static array $names = [
        'Komputer Kasir',
        'Sofa Tunggu',
        'Lift Mobil 2 Post',
        'Tool Kit Set',
        'AC Daikin 2 PK',
        'Meja Resepsionis',
        'Meja Kerja Staff',
        'Kulkas Mini',
        'Laptop Teknisi',
        'Printer A4',
    ];

    protected static array $conditions = [
        'Baik',
        'Kurang Baik',
        'Rusak',
    ];

    protected static int $codeCounter = 1;

    public function definition(): array
    {
        $name = self::$names[array_rand(self::$names)];
        $condition = self::$conditions[array_rand(self::$conditions)];

        return [
            // category_id dan room_id sengaja tidak diisi di sini
            // karena akan dimasukkan secara spesifik oleh DatabaseSeeder

            'name' => $name,
            'condition' => $condition,
            'image_path' => null,
            'qr_code_path' => null,

            // Generate kode unik yang cerdas (mendeteksi cabang berdasarkan room_id)
            'asset_code' => function (array $attributes) {
                // Cari relasi cabang dari room_id yang dikirim seeder
                $room = Room::with('branch')->find($attributes['room_id']);
                $branchCode = ($room && $room->branch) ? $room->branch->code : 'UNK';

                $seq = str_pad(self::$codeCounter++, 3, '0', STR_PAD_LEFT);
                return "{$branchCode}-{$seq}";
            },
        ];
    }
}
