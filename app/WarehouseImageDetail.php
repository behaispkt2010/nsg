<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WarehouseImageDetail extends Model
{
    protected $table = 'warehouse_image';
    protected $fillable = ['warehouse_detail_image', 'warehouse_id', 'deleted'];
}
