<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WareHousingDetail extends Model
{
	protected $table = 'input_output_detail';
    protected $fillable = ['id_io', 'idproduct','nameproduct', 'quantity', 'deleted'];

}
