<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
    /**
 * @var array
 */
    protected $table = 'role_user';
    protected $fillable = ['user_id', 'role_id', 'deleted'];
}
