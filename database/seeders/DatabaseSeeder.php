<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Branch;
use App\Models\Room;
use App\Models\Category;
use App\Models\Asset;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Akun Admin
        User::firstOrCreate(
            ['email' => 'admin@toyota.com'],
            ['name' => 'Admin Dealer', 'password' => Hash::make('password')]
        );

        // 2. Buat Kategori Standar
        $kategoriStandar = ['Elektronik', 'Furnitur', 'Kendaraan', 'Peralatan Bengkel'];
        $categories = [];
        foreach ($kategoriStandar as $namaKat) {
            $categories[] = Category::firstOrCreate(['name' => $namaKat]);
        }

        // 3. Distribusi Merata Cabang & Ruangan
        $kodeCabang = ['WML', 'WLD', 'WLS', 'TOSS', 'WLP'];
        $ruanganStandar = ['Showroom', 'Bengkel', 'Gudang Sparepart', 'Front Office', 'Lounge VIP'];

        foreach ($kodeCabang as $kode) {
            // Buat Cabangnya
            $branch = Branch::firstOrCreate(
                ['code' => $kode],
                ['name' => "Dealer Toyota $kode"]
            );

            // Buat Ruangannya untuk Cabang tersebut
            foreach ($ruanganStandar as $namaRuangan) {
                $room = Room::firstOrCreate([
                    'branch_id' => $branch->id,
                    'name' => $namaRuangan
                ]);

                // 4. Cetak 10 hingga 15 Aset secara acak per ruangan!
                $jumlahAset = rand(10, 15);

                for ($i = 0; $i < $jumlahAset; $i++) {
                    Asset::factory()->create([
                        'room_id' => $room->id,
                        'category_id' => $categories[array_rand($categories)]->id,
                    ]);
                }
            }
        }
    }
}
