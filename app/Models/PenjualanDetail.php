<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenjualanDetail extends Model
{
    use HasFactory;

    public function produk()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
