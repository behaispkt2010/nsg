<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyImage extends Model
{
    protected $table = 'company_image';
    protected $fillable = ['company_image', 'company_id', 'deleted'];
}
