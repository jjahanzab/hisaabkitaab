<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'slug', 'category_id', 'name', 'price', 'quantity', 'description', 'manufacturer', 'supplier', 'product_code', 'pic', 'status'
    ];
}
