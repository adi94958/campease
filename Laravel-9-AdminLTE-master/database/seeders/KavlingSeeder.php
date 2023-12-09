<?php

namespace Database\Seeders;

use App\Models\Kavling;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KavlingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 100; $i++) {
            $harga = rand(100000, 200000);
            $harga = round($harga / 10000) * 10000; // Memastikan harga adalah kelipatan dari 10.000

            Kavling::create([
                'area_kavling' => 'Kavling ' . $i,
                'harga' => $harga,
                'status' => rand(0, 1) ? 'available' : 'booked',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
