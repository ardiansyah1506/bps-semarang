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
        Schema::create('ginirasio_kemiskinan', function (Blueprint $table) {
            $table->id();
            $table->integer('tahun');
            $table->integer('penduduk_miskin');
            $table->decimal('penduduk_miskin_persen', 5, 2); // tambah presisi
            $table->integer('garis_kemiskinan');
            $table->decimal('gini_rasio', 5, 3); // presisi contoh: 0.328
            $table->integer('jumlah')->nullable(); // ✅ diperbaiki agar nullable
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::table('ginirasio_kemiskinan', function (Blueprint $table) {
        $table->integer('jumlah')->nullable()->change();
    });
    }
};
