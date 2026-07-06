<?php

namespace Database\Factories;

use App\Models\Branch;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Branch>
 */
class BranchFactory extends Factory
{
    protected $model = Branch::class;

    protected static array $items = [
        ['code' => 'WML', 'name' => 'Toyota WML'],
        ['code' => 'WLD', 'name' => 'Toyota Wijaya Dago'],
        ['code' => 'WLS', 'name' => 'Toyota WLS'],
        ['code' => 'TOSS', 'name' => 'Toyota TOSS'],
        ['code' => 'WLP', 'name' => 'Toyota WLP'],
    ];

    protected static int $index = 0;

    public function definition(): array
    {
        $item = self::$items[self::$index % count(self::$items)];
        self::$index++;

        return [
            'code' => $item['code'],
            'name' => $item['name'],
        ];
    }
}
