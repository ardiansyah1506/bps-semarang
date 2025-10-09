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
        Schema::create('tenaga_kerjadua', function (Blueprint $table) {
            $table->id();
            $table->integer('tahun');
            $table->integer('bekerja_pria');
            $table->integer('bekerja_wanita');
            $table->integer('pengangguran_pria');
            $table->integer('pengangguran_wanita');
            $table->integer('sekolah_pria');
            $table->integer('sekolah_wanita');
            $table->integer('rt_pria');
            $table->integer('rt_wanita');
            $table->integer('lainnya_pria');
            $table->integer('lainnya_wanita');
            $table->integer('jumlah');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenaga_kerjadua');
    }
};
