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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('barcode')->nullable();
            $table->string('nama_produk');
            $table->unsignedBigInteger('satuan_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->string('deskripsi');
            $table->integer('stok')->default(0);
            $table->integer('harga_beli')->default(0);
            $table->integer('harga_jual')->default(0);
            $table->string('image')->nullable()->default('produk.png');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
