<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Cafe extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_cafe',
        'wifi_score',
        'harga_score',
        'bangunan_score',
        'luas_score',
        'jarak_score',
    ];

    protected $casts = [
        'wifi_score' => 'float',
        'harga_score' => 'float',
        'bangunan_score' => 'float',
        'luas_score' => 'float',
        'jarak_score' => 'float',
    ];
}
