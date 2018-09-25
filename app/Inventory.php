<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Inventory extends Model
{
	protected $table = 'inventory';
    protected $fillable = ['code', 'id_product','status','id_kho','note','author_id', 'deleted'];

}
