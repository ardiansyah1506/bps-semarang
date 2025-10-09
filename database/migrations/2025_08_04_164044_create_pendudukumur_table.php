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
        Schema::create('pendudukumur', function (Blueprint $table) {
            $table->id();
            $table->integer('tahun');
            $table->string("umur");
            $table->integer("laki_laki");
            $table->integer("perempuan");
            $table->integer("jumlah");
          
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendudukumur');
    }
};
