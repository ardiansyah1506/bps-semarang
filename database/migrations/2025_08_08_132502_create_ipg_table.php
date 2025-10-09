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
        Schema::create('ipg', function (Blueprint $table) {
            $table->id();
            $table->integer('tahun');
            $table->decimal('UHH_Pria');
            $table->decimal('UHH_Wanita');
            $table->decimal('RLS_Pria');
            $table->decimal('RLS_Wanita');
            $table->decimal('HLS_Pria');
            $table->decimal('HLS_Wanita');
            $table->integer('Pengeluaran_Pria');
            $table->integer('Pengeluaran_Wanita');
            $table->integer('jumlah')->nullable(); // ✅ diperbaiki agar nullable
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ipg');
    }
};
