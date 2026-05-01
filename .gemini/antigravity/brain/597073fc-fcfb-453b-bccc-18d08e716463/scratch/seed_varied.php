<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Cafe;

Cafe::truncate();

Cafe::create([
    'nama_cafe' => 'Cafe X (Benefit Max)', 
    'wifi_score' => 1.0, 
    'harga_score' => 1.0, 
    'bangunan_score' => 1.0, 
    'luas_score' => 1.0, 
    'jarak_score' => 1.0
]);

Cafe::create([
    'nama_cafe' => 'Cafe Y (Balanced)', 
    'wifi_score' => 0.6, 
    'harga_score' => 0.4, 
    'bangunan_score' => 0.4, 
    'luas_score' => 0.6, 
    'jarak_score' => 0.6
]);

Cafe::create([
    'nama_cafe' => 'Cafe Z (Cost Min)', 
    'wifi_score' => 0.4, 
    'harga_score' => 0.2, 
    'bangunan_score' => 0.2, 
    'luas_score' => 0.4, 
    'jarak_score' => 0.4
]);

Cafe::create([
    'nama_cafe' => 'Cafe W (Mixed)', 
    'wifi_score' => 0.8, 
    'harga_score' => 0.8, 
    'bangunan_score' => 0.2, 
    'luas_score' => 0.2, 
    'jarak_score' => 0.8
]);

echo "Seeded cafes successfully.\n";
