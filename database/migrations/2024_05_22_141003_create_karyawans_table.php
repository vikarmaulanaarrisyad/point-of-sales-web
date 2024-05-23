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
        Schema::create('karyawans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('jabatan_id');
            $table->string('nama_karyawan');
            $table->string('nik_karyawan');
            $table->string('tempat_lahir');
            $table->date('tgl_lahir_karyawan');
            $table->enum('jenis_kelamin_karyawan', ['Laki-laki', 'Perempuan']);
            $table->string('no_telp_karyawan');
            $table->text('alamat_karyawan');
            $table->integer('target_penjualan_bulan')->default(0);
            $table->integer('target_penjualan_harian')->default(0);
            $table->string('photo')->default('default.png');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('jabatan_id')->references('id')->on('jabatans')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('karyawans');
    }
};
