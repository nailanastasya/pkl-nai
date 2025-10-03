<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function customerProducts()
    {
        return $this->hasMany(CustomerProduct::class);
    }

    protected $fillable = ['product_name', 'product_type'];
}
