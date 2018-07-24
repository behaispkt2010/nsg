<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BankWareHouse extends Model
{
    protected $fillable = ['ware_id','bank', 'province','card_number','card_name','check', 'deleted'];

    public static function getBankOfWareHouse($warehouseID) {
        $bank = BankWareHouse::select('bank_ware_houses.card_name as cardName', 'bank_ware_houses.card_number as cardNumber', 'bank.name as bankName','province.name as provinceName')
        	->leftjoin('bank','bank.id','=','bank_ware_houses.bank')
            ->leftjoin('province','province.provinceid','=','bank_ware_houses.province')
            ->where('bank_ware_houses.ware_id', $warehouseID)
            ->where('bank_ware_houses.deleted', 0)
            ->get();
        /*$bank =  BankWareHouse::where('ware_id', $warehouseID)->get(); */
        return $bank;
    }
}
