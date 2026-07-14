<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AssetDummySeeder extends Seeder
{
    public function run(): void
    {
        $rooms = \App\Models\Room::all();
        $categories = \App\Models\Category::all();

        foreach ($rooms as $room) {
            // Setiap ruangan kita isi 5-10 aset saja supaya tidak terlalu penuh
            \App\Models\Asset::factory(rand(5, 10))->create([
                'room_id' => $room->id,
                'category_id' => $categories->random()->id,
            ]);
        }
    }
}
