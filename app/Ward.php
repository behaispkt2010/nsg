<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    protected $fillable = ['provinceid', 'branch','cardNumber','nameUser', 'deleted'];
}
