<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\transaksi;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

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

        $kavlingNumbers = range(1, 1000);
        $kavlingNumbers = array_map(function ($number) {
            return sprintf("Kavling%04d", $number);
        }, $kavlingNumbers);

        foreach (range(1, 1000) as $index) {
            $harga = DB::table('data_kavling')
                ->where('area_kavling', $kavlingNumbers[$index - 1])
                ->value('harga');

            // Calculate the number of days between check-in and check-out
            $checkIn = now()->subMonth()->subDays(rand(1, 20));
            $checkOut = now()->addDays(rand(1, 7));
            $numberOfDays = $checkOut->diffInDays($checkIn);

            // Calculate the harga by multiplying with the number of days
            $totalHarga = $harga * $numberOfDays;

            Transaksi::create([
                'id' => $index,
                'nama_penyewa' => $faker->name,
                'no_handphone' => '085' . $faker->randomNumber(9),
                'tanggal_check_in' => $checkIn,
                'tanggal_check_out' => $checkOut,
                'area_kavling' => $kavlingNumbers[$index - 1],
                'harga' => $totalHarga,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
