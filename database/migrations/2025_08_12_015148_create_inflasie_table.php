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
        Schema::create('inflasie', function (Blueprint $table) {
            $table->id();
            $table->integer('tahun');
            $table->string('bulan', 20);
            $table->string('kategori');
            $table->decimal('ihk', 8, 2)->nullable();
            $table->decimal('inflasi_komulatif', 5, 2)->nullable(); // Assuming 'inflasi_kom
            $table->decimal('andil', 5, 2)->nullable(); // Assuming 'andil' is a decimal with 2 decimal placess
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inflasie');
    }
};
