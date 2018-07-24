<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailImageProduct extends Model
{
    protected $fillable = ['image', 'product_id', 'deleted'];
}
