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
        Schema::create('wargas', function (Blueprint $table) {
            $table->string('NIK', 16)->primary(); // Primary Key
            $table->string('KK_ID', 16);
            $table->foreign('KK_ID')->references('KK_ID')->on('keluargas')->onDelete('cascade');
            $table->string('Nama_Lengkap');
            $table->string('Tempat_Lahir');
            $table->date('Tanggal_Lahir');
            $table->string('Jenis_Kelamin', 15); // 15 karakter cukup
            $table->string('Pekerjaan');
            $table->string('Pendidikan');
            $table->string('Status_Hubungan_Keluarga');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wargas');
    }
};
