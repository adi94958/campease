<?php

namespace Database\Seeders;

use App\Models\Fasilitas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FasilitasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 1000; $i++) {
            Fasilitas::create([
                'nama_fasilitas' => 'Fasilitas' . sprintf('%04d', $i), // Format penomoran menjadi 'Fasilitas 0001', 'Fasilitas 0002', dst.
                'jumlah' => rand(1, 10), // Ubah rentang sesuai kebutuhan Anda
            ]);
        }
        
    }
}
