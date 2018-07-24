<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductUpdatePrice extends Model
{
    protected $fillable = ['product_id','price_in', 'price_out','number','supplier', 'deleted'];
}
