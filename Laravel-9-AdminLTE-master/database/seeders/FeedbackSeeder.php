<?php

namespace Database\Seeders;

use App\Models\Feedback;
use Illuminate\Database\Seeder;

class FeedbackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 1000; $i++) {
            Feedback::create([
                'id_pengirim' => $i, // Ganti 50 dengan jumlah pengirim yang ada di database
                'isi_feedback' => "Feedback ke-" . $i,
                'rating' => rand(1, 5),
            ]);
        }
    }
}
