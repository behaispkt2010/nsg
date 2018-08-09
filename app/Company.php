<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'company';
    protected $fillable = ['user_id', 'name','address','province','district','fanpage_fb','mst','ndd','stk','image_company','quangcao','confirm','time_confirm','time_confirm_bonus','time_quangcao','time_quangcao_bonus','created_confirm','user_test','created_time_quangcao','date_end_test','time_active', 'deleted'];

    public static function getIdWareHouse($user_id){
        $company = Company::where('user_id', $user_id)->first();
        return $company->id;
    }
    public static function getCompany($limit) {
    	if($limit == 0) {
            $company = Company::get();
        }
        else{
            $company = Company::take($limit)->get();
        }
        return $company;
    }
}
