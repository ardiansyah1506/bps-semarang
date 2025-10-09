<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('gini_rasio', function (Blueprint $table) {
            $table->id();
            $table->integer('tahun');
            $table->string('kecamatan');
            $table->decimal('nilai_gini_rasio', 5, 3);
            $table->string('kategori_ketimpangan');
            $table->decimal('pendapatan_per_kapita', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gini_rasio');
    }
}; 