<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Payment extends Model
{
	protected $table = 'payment';
    protected $fillable = ['code', 'type','cate','status','price','type_pay', 'type_pay_detail', 'period_pay', 'time_pay','author_id', 'note', 'deleted'];

}
