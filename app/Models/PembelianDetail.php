<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class PembelianDetail extends Model
{
    use HasFactory;

    public function produk()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class, 'pembelian_id', 'id');
    }
}
