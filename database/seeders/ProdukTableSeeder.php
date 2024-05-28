<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProdukTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::updateOrCreate(
            ['id' => 1],
            [
                'barcode' => 99,
                'nama_produk' => 'Oreo',
                'satuan_id' => 1,
                'category_id' => 1,
                'stok' => 100,
                'deskripsi' => 'ii',
                'harga_beli' => 200000,
                'harga_jual' => 300000,
                'image' => 'default.png'
            ]
        );
    }
}
