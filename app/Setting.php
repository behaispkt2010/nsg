<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    //
    protected $fillable = ['key','value', 'deleted'];
    static public function getValue($key){
        $s = Setting::where('key',$key)->first();
        if(empty($s))
            $res='';
        else
            $res=$s->value;
        return $res;
    }
}
