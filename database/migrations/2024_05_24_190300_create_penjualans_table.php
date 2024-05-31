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
        Schema::create('penjualans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('karyawan_id')->nullable();
            $table->unsignedBigInteger('pelanggan_id')->nullable();
            $table->string('kode_penjualan');
            $table->integer('total_item')->default(0);
            $table->integer('total_harga')->default(0);
            $table->integer('total_bayar')->default(0);
            $table->integer('total_kembalian')->default(0);
            $table->string('bukti_bayar')->nullable();
            $table->string('catatan')->nullable();
            $table->enum('status_bayar', ['pending', 'process', 'success', 'cancel'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualans');
    }
};
