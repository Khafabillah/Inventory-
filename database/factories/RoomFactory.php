<?php

namespace Database\Factories;

use App\Models\Room;
use App\Models\Branch;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Room>
 */
class RoomFactory extends Factory
{
    protected $model = Room::class;

    protected static array $names = [
        'Showroom',
        'Bengkel',
        'Gudang Sparepart',
        'Front Office',
        'Lounge VIP',
    ];

    protected static int $index = 0;

    public function definition(): array
    {
        $name = self::$names[self::$index % count(self::$names)];
        self::$index++;

        // Prefer an existing branch; fallback to creating one.
        $branchId = Branch::inRandomOrder()->value('id') ?? Branch::factory();

        return [
            'name' => $name,
            'branch_id' => $branchId,
        ];
    }
}
