<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $table = 'driver';
    protected $fillable = ['type_driver', 'name_driver','phone_driver','phone_driver2','email','number_license_driver','kho', 'deleted', 'address', 'province', 'district', 'identity', 'image_identity', 'carmarker', 'image_car'];
}
