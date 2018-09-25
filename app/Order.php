<?php

namespace App;

use App\Util;

use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    protected $table = 'orders';
    protected $fillable = ['order_code', 'time_order','status','customer_id','note','status_pay','type_pay','received_pay','remain_pay','type_driver','name_driver','phone_driver','number_license_driver','discount','tax','transport_pay','author_id', 'deleted'];
    public  static function getKhoProduct($id){
        $product = Product::select('kho')->where('id', $id)->where('deleted', 0)->first();
        return $product->kho;
    }
    public static function checkKhoByIdProduct($ArrayId){
        $tmpKho = Order::getKhoProduct($ArrayId[0]);

        foreach($ArrayId as $id){
            $kho = Order::getKhoProduct($id);

            if($kho != $tmpKho ){
//                dd($kho);
                return -1;
            }
            else{
                $tmpKho= $kho;

            }
        }
        return $tmpKho;
    }
    public static function getNumOrder($status,$date){
        $idUser = Auth::user()->id;

        $orders = Order::where('kho_id', $idUser)
            ->where('deleted', 0)
            ->where('status', $status)
            ->where(DB::raw("(DATE_FORMAT(updated_at,'%d-%m-%Y'))"), $date)
            ->get();
        return count($orders);

    }
    public static function getAllNumOrder($status, $date){
        $idUser = Auth::user()->id;

        $orders = Order::where('kho_id', $idUser)
            ->where('deleted', 0)
            ->whereNotIn('status', [$status])
            ->where(DB::raw("(DATE_FORMAT(updated_at,'%d-%m-%Y'))"), $date)
            ->get();
        return count($orders);
    }
    public static function getNumOrderAdmin($status,$date){

        $orders = Order::where('status',$status)
            ->where(DB::raw("(DATE_FORMAT(updated_at,'%d-%m-%Y'))"), $date)
            ->get();
        return count($orders);

        }
    public static function getNumOrderByStatus($status){
        $idUser = Auth::user()->id;

        $orders = Order::where('status', $status)
            ->where('deleted', 0)
            ->get();
        if(empty($orders)) $num = 0;
        else $num = count($orders);
        return $num;

        }
    public static function getSumPrice(){
        $orderProducts = ProductOrder::select('product_orders.price','product_orders.num','product_orders.updated_at')
            ->leftJoin('orders','product_orders.order_id','=','orders.id')
            ->get();
        $res = 0;
        foreach($orderProducts as $orderProduct){
            $res = $res + $orderProduct->price * $orderProduct->num;
        }
        return $res;

    }
    public static function getInfoOrder($status,$type=0){
        $idUser            = Auth::user()->id;
        $statusOrderReturn = Util::$statusOrderReturn;
        if(Auth::user()->hasRole('kho')) {
            if ($type == 1) {
                $orderProducts = ProductOrder::select('product_orders.price', 'product_orders.num')
                    ->leftJoin('orders', 'product_orders.order_id', '=', 'orders.id')
                    ->where('orders.kho_id', $idUser)
                    ->where('orders.deleted', 0)
                    ->where('orders.status', '<>', $status)
                    ->where('orders.status', '<>', $statusOrderReturn)
                    ->get();
            } else {
                $orderProducts = ProductOrder::select('product_orders.price', 'product_orders.num')
                    ->leftJoin('orders', 'product_orders.order_id', '=', 'orders.id')
                    ->where('orders.kho_id', $idUser)
                    ->where('orders.deleted', 0)
                    ->where('orders.status', $status)
                    ->get();
            }
        }
        else {
            if ($type == 1) {
                $orderProducts = ProductOrder::select('product_orders.price', 'product_orders.num')
                    ->leftJoin('orders', 'product_orders.order_id', '=', 'orders.id')
                    ->where('orders.status', '<>', $status)
                    ->where('orders.deleted', 0)
                    ->where('orders.status', '<>', $statusOrderReturn)
                    ->get();
            } else {
                $orderProducts = ProductOrder::select('product_orders.price', 'product_orders.num')
                    ->leftJoin('orders', 'product_orders.order_id', '=', 'orders.id')
                    ->where('orders.deleted', 0)
                    ->where('orders.status', $status)
                    ->get();
            }
        }
        //dd($orderProducts);
        $price = 0;
        $count = 0;
        if(!empty($orderProducts)){
        foreach($orderProducts as $orderProduct){
            $price = $price + ($orderProduct->price);
            }
          $count = count($orderProducts);
        }

        $data = [
            "price" => $price,
            "count" => $count

        ];

        return $data;
    }
    public static function GetRelateProvince ($provinceID) {
        // $province = Province::where('provinceid', $provinceName)->get();
        // foreach ($province as $itemProvince) {
        //     $provinceID = $itemProvince->provinceid;
        // }
        $district = District::where('provinceid', $provinceID)->get();
        return $district;
    }

}
