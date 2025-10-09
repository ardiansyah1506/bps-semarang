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
        Schema::create('pendudukjateng', function (Blueprint $table) {
            $table->id();
            $table->integer('tahun');
            $table->string('provinsi');
            $table->integer('jumlahwarga');
            $table->integer('pria');
            $table->integer('wanita');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendudukjateng');
    }
};
