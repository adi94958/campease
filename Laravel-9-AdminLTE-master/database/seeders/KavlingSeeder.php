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
        for ($i = 1; $i <= 1000; $i++) {
            $harga = rand(100000, 200000);
            $harga = round($harga / 10000) * 10000; // Memastikan harga adalah kelipatan dari 10.000
        
            $formatted_number = sprintf('%04d', $i); // Mengonversi nomor menjadi format '0001', '0002', dst.
        
            $area_kavling = 'Kavling' . $formatted_number; // Menyusun nama kavling dengan format 'cavling0001', 'cavling0002', dst.
        
            Kavling::create([
                'area_kavling' => $area_kavling,
                'harga' => $harga,
                'status' => rand(0, 1) ? 'Available' : 'Booked',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
    }
}
