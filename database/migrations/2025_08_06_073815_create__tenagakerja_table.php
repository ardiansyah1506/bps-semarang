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
        Schema::create('_tenagakerja', function (Blueprint $table) {
            $table->id();
            $table->integer('tahun');
            $table->integer('bekerja_laki_laki');
            $table->integer('bekerja_perempuan');
            $table->integer('pengangguran_laki_laki')->nullable();
            $table->integer('pengangguran_perempuan')->nullable();
            $table->string('tpak');
            $table->string('tkk');
            $table->string('tpt');
            $table->integer('jumlah');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('_tenagakerja');
    }
};
