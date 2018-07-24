<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WareHouse extends Model
{
    protected $table = 'ware_houses';
    protected $fillable = ['user_id','name_company','count_view','address','province','fanpage_fb','mst','ndd','stk','level','time_upgrade_level','time_upgrade_bonus','image_kho','time_active','confirm_kho','quangcao','time_confirm_kho','time_confirm_kho_bonus','time_quangcao','time_quangcao_bonus','user_test','date_end_test','category_warehouse_id', 'deleted'];
    public static function countLevelKho($level){
        $ware = WareHouse::where('level', $level)->where('deleted', 0)->get();
        return count($ware);
    }
    public static function countStatusKho($status){
        $ware = WareHouse::where('user_test', $status)->where('deleted', 0)->get();
        return count($ware);
    }
    public static function getIdWareHouse($user_id){
        $ware = WareHouse::where('user_id', $user_id)->where('deleted', 0)->first();
        return $ware->id;
    }
    public static function checkUserTest($user_id){
        $user = User::leftjoin('ware_houses','users.id','=','ware_houses.user_id')
            ->where('users.id', $user_id)
            ->where('users.deleted', 0)
            ->get();
        /*$check = $user->user_test;*/
        return $user;
    }
    public static function getVipByCate($cateID, $limit = 0){
        $getCate          = CategoryProduct::where('parent', $cateID)->where('deleted', 0)->get();
        $arrCateProductID = array();
        foreach ($getCate as $itemgetCate) {
            if (!in_array($itemgetCate['id'], $arrCateProductID)){
                $arrCateProductID[] = $itemgetCate['id'];
            }
        }
        if($limit == 0) {
            $arrGetVipByCate = WareHouse::leftJoin('products','ware_houses.user_id','products.kho')
                ->whereIn('products.category',$arrCateProductID)
                ->where('ware_houses.level','=',3)
                ->where('ware_houses.deleted', 0)
                ->groupBy('ware_houses.id')
                ->selectRaw('ware_houses.id as idKho,ware_houses.name_company as nameKho, ware_houses.level as levelKho, ware_houses.image_kho as imageKho')
                ->get();
        }
        else{
            $arrGetVipByCate = WareHouse::leftJoin('products','ware_houses.user_id','products.kho')
                ->whereIn('products.category', $arrCateProductID)
                ->where('ware_houses.level','=', 3)
                ->where('ware_houses.deleted', 0)
                ->groupBy('ware_houses.id')
                ->selectRaw('ware_houses.id as idKho,ware_houses.name_company as nameKho, ware_houses.level as levelKho, ware_houses.image_kho as imageKho')
                ->take($limit)
                ->get();
        }
        return $arrGetVipByCate;
    }
    public static function getCateProductByID($warehouse_id){
        $newProducts = Product::leftjoin('ware_houses','ware_houses.user_id','products.kho')
            ->leftjoin('users','users.id','ware_houses.user_id')
            ->leftjoin('category_products','category_products.id','products.category')
            ->where('ware_houses.id', $warehouse_id)
            ->where('category_products.deleted', 0)
            ->selectRaw('category_products.*')
            ->orderBy('products.id',"DESC")->get();
        $arrCateProductOflWareHouse = [];
        foreach ($newProducts as $key => $itemInfoWareHouse) {
            if ( !in_array($itemInfoWareHouse->name, $arrCateProductOflWareHouse) ) {
                array_push($arrCateProductOflWareHouse, $itemInfoWareHouse->name);
            } 
        }    
        return $arrCateProductOflWareHouse;
    }
    public static function getAllWareHouseByArea($form, $to){

        $getAllWareHouse = WareHouse::leftjoin('province','province.provinceid','=','ware_houses.province')
            ->whereBetween('province.provinceid', array($from, $to))
            ->get();
        return $getAllWareHouse;

    }
    
    public static function getViewByWID ($user_id) {
        $ware_houses = WareHouse::where('user_id', $user_id)->where('deleted', 0)->get();
        foreach ($ware_houses as $item) {
            $view = $item->count_view;
        }
        return $view;
    }
}
