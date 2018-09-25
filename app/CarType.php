<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarType extends Model
{
    protected $table = 'car_marker';
    protected $fillable = ['name', 'deleted'];
}
