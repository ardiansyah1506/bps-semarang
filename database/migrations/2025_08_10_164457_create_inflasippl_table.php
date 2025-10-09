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
        Schema::create('inflasippl', function (Blueprint $table) {
            $table->id();
            $table->integer('tahun');
            $table->string('bulan');
            $table->decimal('ihk_ppl');
            $table->decimal('inflasi_ppl');
            $table->decimal('andil_ppl');
            $table->integer('jumlah')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inflasippl');
    }
};
