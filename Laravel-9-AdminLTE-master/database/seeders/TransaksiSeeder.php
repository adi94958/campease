<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\transaksi;
use Faker\Factory as Faker;

class TransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $namaDepan = ['John', 'Jane', 'Bob', 'Alice', 'Charlie', 'Eva', 'David', 'Grace', 'Michael', 'Olivia'];
        $namaBelakang = ['Doe', 'Smith', 'Johnson', 'Brown', 'Lee', 'Davis', 'Evans', 'White', 'Moore', 'Taylor'];

        $kavlingNumbers = range(1, 1000);
        $kavlingNumbers = array_map(function ($number) {
            return sprintf("Kavling%04d", $number);
        }, $kavlingNumbers);

        foreach (range(1, 1000) as $index) {
            Transaksi::create([
                'id' => $index,
                'nama_penyewa' => $namaDepan[array_rand($namaDepan)] . ' ' . $namaBelakang[array_rand($namaBelakang)],
                'no_handphone' => '08' . $faker->randomNumber(8),
                'tanggal_check_in' => now()->subMonth()->subDays(rand(1, 30)),
                'tanggal_check_out' => now()->addDays(rand(1, 7)),
                'area_kavling' => $kavlingNumbers[$index - 1],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
