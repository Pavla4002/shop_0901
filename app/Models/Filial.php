<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filial extends Model
{
    use HasFactory;
    public function orders(){
        return $this->hasMany(Order::class);
    }
    public function subtypes(){
        return $this->hasMany(Subtype::class);
    }
    public function product_filial_sizes(){
        return $this->hasMany(ProductFilialSize::class);
    }
}
