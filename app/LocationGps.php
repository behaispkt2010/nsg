<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LocationGps extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_user', 'maps_maplat', 'maps_maplng', 'maps_link','address', 'description','name', 'deleted'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];
}
