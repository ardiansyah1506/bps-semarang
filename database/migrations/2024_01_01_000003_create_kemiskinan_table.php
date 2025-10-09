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
        Schema::create('kemiskinan', function (Blueprint $table) {
            $table->id();
            $table->integer('tahun');
            $table->string('kecamatan');
            $table->integer('jumlah_penduduk_miskin');
            $table->decimal('persentase_penduduk_miskin', 5, 2);
            $table->decimal('garis_kemiskinan', 15, 2);
            $table->decimal('indeks_kedalaman_kemiskinan', 5, 2);
            $table->decimal('indeks_keparahan_kemiskinan', 5, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kemiskinan');
    }
}; 