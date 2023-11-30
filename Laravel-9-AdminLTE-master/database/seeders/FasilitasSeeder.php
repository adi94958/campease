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
        for ($i = 1; $i <= 100; $i++) {
            Fasilitas::create([
                'nama_fasilitas' => 'Fasilitas ' . $i,
                'jumlah' => rand(1, 10), // Ubah rentang sesuai kebutuhan Anda
            ]);
        }
    }
}
