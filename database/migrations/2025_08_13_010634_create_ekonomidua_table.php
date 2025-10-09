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
        Schema::create('ekonomidua', function (Blueprint $table) {
            $table->id();
            $table->integer('tahun');
            $table->string('kategori');
            $table->integer('triwulansatu');
            $table->integer('triwulandua');
            $table->integer('triwulantiga');
            $table->integer('triwulanempat');
            $table->integer('tahunan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ekonomidua');
    }
};
