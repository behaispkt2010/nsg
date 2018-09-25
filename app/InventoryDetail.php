<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InventoryDetail extends Model
{
	protected $table = 'inventory_detail';
    protected $fillable = ['idinventory','nameproduct', 'idproduct', 'inventory_num','inventory_real', 'deleted'];

}
