<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DriverType extends Model
{
    protected $table = 'transports';
    protected $fillable = ['name', 'deleted'];
}
