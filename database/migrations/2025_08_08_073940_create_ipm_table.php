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
        Schema::create('ipm', function (Blueprint $table) {
            $table->id();
            $table->integer('tahun');
            $table->decimal('UHH');
            $table->decimal('RLS');
            $table->decimal('HLS');
            $table->integer('Pengeluaran');
             $table->integer('jumlah')->nullable(); // ✅ diperbaiki agar nullable
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ipm');
    }
};
