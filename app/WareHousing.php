<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Warehousing extends Model
{
	protected $table = 'input_output';
    protected $fillable = ['order_id', 'code','type', 'cate','id_product','id_kho', 'quantity','status','note','name','phone','email','addpress','provinceid','districtid','author_id', 'deleted'];

}
