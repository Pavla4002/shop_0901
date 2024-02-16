<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    use HasFactory;

    public function type(){
        return $this->belongsTo(Type::class);
    }

    public function product_filial_sizes(){
        return $this->hasMany(ProductFilialSize::class);
    }

    public function carts(){
        return $this->hasMany(Cart::class);
    }
}
