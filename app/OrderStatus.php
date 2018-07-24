<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    protected $table = 'order_status';
    protected $fillable = ['name','image','color', 'deleted'];
    public static function getOrderStatus(){
        $OrderStatus = OrderStatus::leftJoin('orders', 'order_status.id', '=', 'orders.status')
            ->groupBy('orders.status')
            ->selectRaw('orders.*, count(orders.status) as countOrderByStatus')
            ->get();
        return $OrderStatus;
    }
}
