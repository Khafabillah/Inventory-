<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    protected $model = Category::class;

    protected static array $names = [
        'Elektronik',
        'Furniture',
        'Alat Bengkel (SST)',
        'Kendaraan Operasional',
    ];

    protected static int $index = 0;

    public function definition(): array
    {
        $name = self::$names[self::$index % count(self::$names)];
        self::$index++;

        return [
            'name' => $name,
        ];
    }
}
