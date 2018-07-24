<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryWarehouse extends Model
{
    protected $table = 'category_warehouse';
    protected $fillable = ['category_warehouse_name', 'deleted'];
}
