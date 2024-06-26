<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class PenjualanDetail extends Model
{
    use HasFactory;

    public function produk()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'penjualan_id', 'id');
    }
}
