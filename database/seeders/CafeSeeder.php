<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Cafe;
use Illuminate\Database\Seeder;

final class CafeSeeder extends Seeder
{
    /**
     * Seed 5 dummy cafes (A–E) with scores matching SAW journal simulation.
     */
    public function run(): void
    {
        $cafes = [
            [
                'nama_cafe' => 'Cafe A',
                'wifi_score' => 0.8,
                'harga_score' => 0.6,
                'bangunan_score' => 0.8,
                'luas_score' => 0.6,
                'jarak_score' => 1.0,
            ],
            [
                'nama_cafe' => 'Cafe B',
                'wifi_score' => 1.0,
                'harga_score' => 0.4,
                'bangunan_score' => 0.6,
                'luas_score' => 0.8,
                'jarak_score' => 0.6,
            ],
            [
                'nama_cafe' => 'Cafe C',
                'wifi_score' => 0.6,
                'harga_score' => 0.8,
                'bangunan_score' => 0.4,
                'luas_score' => 1.0,
                'jarak_score' => 0.8,
            ],
            [
                'nama_cafe' => 'Cafe D',
                'wifi_score' => 0.4,
                'harga_score' => 1.0,
                'bangunan_score' => 1.0,
                'luas_score' => 0.4,
                'jarak_score' => 0.4,
            ],
            [
                'nama_cafe' => 'Cafe E',
                'wifi_score' => 0.6,
                'harga_score' => 0.2,
                'bangunan_score' => 0.6,
                'luas_score' => 0.8,
                'jarak_score' => 0.6,
            ],
        ];

        foreach ($cafes as $cafe) {
            Cafe::create($cafe);
        }
    }
}
