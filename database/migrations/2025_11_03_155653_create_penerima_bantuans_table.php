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
        Schema::create('penerima_bantuans', function (Blueprint $table) {
            $table->id('Penerima_ID'); 
            $table->string('NIK', 16);
            $table->foreign('NIK')->references('NIK')->on('wargas')->onDelete('cascade');
            $table->unsignedBigInteger('Program_ID');
            $table->foreign('Program_ID')->references('Program_ID')->on('program_bantuans')->onDelete('cascade');
            $table->string('Status')->default('Diproses'); 
            $table->timestamps();
            $table->unique(['NIK', 'Program_ID']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penerima_bantuans');
    }
};
