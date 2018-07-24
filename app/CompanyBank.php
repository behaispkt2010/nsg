<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyBank extends Model
{
	protected $table = 'company_bank';
    protected $fillable = ['company_id','bank', 'province','card_number','card_name','check', 'deleted'];
}
