<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Zizaco\Entrust\EntrustPermission;


class Permission extends EntrustPermission
{
    //

    /**
     * @var array
     */
    protected $fillable = ['name', 'display_name', 'description','route', 'deleted'];

    /**
     * @param $roleName
     *
     * @return bool
     */
    public function hasRole($roleName)
    {
        foreach($this->roles as $role)
        {
            if($role->name == $roleName)
            {
                return true;
            }
        }
        return false;
    }
}
