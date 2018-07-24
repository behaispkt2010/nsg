<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $table = 'driver';
    protected $fillable = ['type_driver', 'name_driver','phone_driver','number_license_driver','kho', 'deleted'];
}
