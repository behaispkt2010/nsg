<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Catepayment extends Model
{
	protected $table = 'cate_payment';
    protected $fillable = ['name', 'type', 'deleted'];

}
