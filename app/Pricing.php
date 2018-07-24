<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pricing extends Model
{
    protected $fillable = ['product_name', 'price_new', 'price_old', 'author_id','change','source', 'deleted'];
}
