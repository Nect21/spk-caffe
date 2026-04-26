<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cafes', function (Blueprint $table): void {
            $table->id();
            $table->string('nama_cafe');
            $table->float('wifi_score');
            $table->float('harga_score');
            $table->float('bangunan_score');
            $table->float('luas_score');
            $table->float('jarak_score');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cafes');
    }
};
