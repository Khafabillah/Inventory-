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

        // Daftar nama barang acak untuk bypass Factory
        $namaBarang = ['Komputer Kasir', 'Sofa Tunggu', 'Meja Resepsionis', 'Tool Kit Set', 'AC Daikin 2 PK'];
        $kondisiBarang = ['Baik', 'Kurang Baik', 'Rusak'];

        foreach ($kodeCabang as $kode) {
            $branch = Branch::firstOrCreate(
                ['code' => $kode],
                ['name' => "Dealer Toyota $kode"]
            );

            // Counter khusus per cabang agar urut sempurna (001, 002, 003...)
            $branchCounter = 1;

            foreach ($ruanganStandar as $namaRuangan) {
                $room = Room::firstOrCreate([
                    'branch_id' => $branch->id,
                    'name' => $namaRuangan
                ]);

                $jumlahAset = rand(10, 15);

                for ($i = 0; $i < $jumlahAset; $i++) {
                    // Generate kode (Contoh: WML-001)
                    $seq = str_pad($branchCounter++, 3, '0', STR_PAD_LEFT);
                    $assetCode = "{$branch->code}-{$seq}";

                    // Buat aset LANGSUNG tanpa memanggil Factory
                    Asset::create([
                        'room_id' => $room->id,
                        'category_id' => $categories[array_rand($categories)]->id,
                        'asset_code' => $assetCode,
                        'name' => $namaBarang[array_rand($namaBarang)],
                        'condition' => $kondisiBarang[array_rand($kondisiBarang)],
                    ]);
                }
            }
        }
    }
}
