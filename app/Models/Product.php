<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    public function satuan()
    {
        return $this->belongsTo(Satuan::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
