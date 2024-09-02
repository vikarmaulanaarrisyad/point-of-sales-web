<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pembelian extends Model
{
    use HasFactory;
    protected $table = "pembelians";

    public function supplier()
    {
        return $this->belongsTo(Pelanggan::class, 'supplier_id', 'id');
    }
}
