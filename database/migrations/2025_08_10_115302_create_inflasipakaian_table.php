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
        Schema::create('inflasipakaian', function (Blueprint $table) {
            $table->id();
            $table->integer('tahun');
            $table->string('bulan');
            $table->decimal('ihk_pakaian');
            $table->decimal('inflasi_pakaian');
            $table->decimal('andil_pakaian');
            $table->integer('jumlah')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inflasipakaian');
    }
};
