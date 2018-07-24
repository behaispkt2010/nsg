<?php

namespace App\Http\Controllers;

use App\Notification;
use App\Order;
use App\Product;
use App\ProductOrder;
use App\User;
use App\Util;
use App\Driver;
use App\NewsCompany;
use App\WareHouse;
use DateTime;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class DashboardController extends Controller
{
    public function dashboard(Request $request){
        $data       = $request->get('data');
        $dateRes    = explode('>', $data);
        // dd($data);
        $lineLabels = [];
        $lineDatas  = [];
        $barLabels  = [];
        $barDatas1  = [];
        $barDatas2  =[];

        $orders     = Order::whereBetween('updated_at', array(new DateTime($dateRes[0]), new DateTime($dateRes[1])))
            ->whereIn('status',[8,10])
            ->groupBy(DB::raw("DATE(updated_at)"))
            ->get();
        $i=0;
        foreach($orders as $key=>$order ){
            $barLabels[$i] = $order->updated_at->format('d-m-Y');
            $barDatas1[$i] = Order::getNumOrderAdmin(8,$order->updated_at->format('d-m-Y'));
            $barDatas2[$i] = Order::getNumOrderAdmin(10,$order->updated_at->format('d-m-Y'));

            $lineLabels[$i]= $order->updated_at->format('d-m-Y');
            $lineDatas[$i] = ProductOrder::getSumPriceAdmin($order->updated_at->format('d-m-Y'));
            $i++;

        }


        $response = array(
            'status'     => 'success',
            'msg'        => 'Setting created successfully',
            'lineLabels' => $lineLabels,
            'lineDatas'  => $lineDatas,
            'barLabels'  => $barLabels,
            'barDatas1'  => $barDatas1,
            'barDatas2'  => $barDatas2,

        );
        //dd($response);
        return \Response::json($response);

    }
    public function Approval(Request $request){
        $strProductID = $request->get('pid');
        $strKhoID     = $request->get('khoid');

        $product      =  Product::find($strProductID);
        $data = [
            'status' => 1
        ];
        $product->update($data);
        $getCodeProduct = Util::ProductCode($strProductID);
        $dataNotify['keyname']              = Util::$newproductSuccess;
        $dataNotify['title']                = "Sản phẩm mới";
        $dataNotify['content']              = "Sản phẩm ".$getCodeProduct." đã được duyệt.";
        $dataNotify['author_id']            = Auth::user()->id;
        $dataNotify['orderID_or_productID'] = $strProductID;
        $dataNotify['roleview']             = $strKhoID;
        $dataNotify['link']                 = "/admin/products/".$strProductID."/edit";
        $notify                             = Notification::create($dataNotify);
        $message                            = 'OK';
        if(isset($message)) {
            $redis = Redis::connection();
            $redis->publish("messages", json_encode(array(
                "status"     => 200,
                "id"         => $strProductID,  
                "notifyID"   => $notify->id,
                "roleview"   => $strKhoID,
                "title"      => "Sản phẩm mới",
                "link"       => "/admin/products/".$strProductID."/edit",
                "content"    => "Sản phẩm ".$getCodeProduct." đã được duyệt.",
                "created_at" => date('Y-m-d H:i:s')
            )));
        }
    }
    public function ApprovalNews(Request $request){
        $strNewsID   = $request->get('newsid');
        $strAuthorID = $request->get('authorid');

        $newscompany =  NewsCompany::find($strNewsID);
        $data = [
            'status' => 1
        ];
        $newscompany->update($data);
        // $getCodeProduct = Util::ProductCode($strNewsID);
        $dataNotify['keyname']              = Util::$newscompanySuccess;
        $dataNotify['title']                = "Cơ hội mua bán mới";
        $dataNotify['content']              = "Cơ hội mua bán của bạn đã được duyệt.";
        $dataNotify['author_id']            = Auth::user()->id;
        $dataNotify['orderID_or_productID'] = $strNewsID;
        $dataNotify['roleview']             = $strAuthorID;
        $dataNotify['link']                 = '/admin/newscompany/'.$strNewsID.'/edit';
        $notify                             = Notification::create($dataNotify);
        $message                            = 'OK';
        if(isset($message)) {
            $redis = Redis::connection();
            $redis->publish("messages", json_encode(array(
                "status"     => 200,
                "id"         => $strNewsID, 
                "notifyID"   => $notify->id,
                "roleview"   => $strAuthorID,
                "title"      => "Cơ hội mua bán mới",
                "link"       => "/admin/newscompany/".$strNewsID."/edit",
                "content"    => "Cơ hội mua bán của bạn đã được duyệt.",
                "created_at" => date('Y-m-d H:i:s')
            )));
        }
    }
    public function index(){
        //echo "admin";
        $level1   = WareHouse::countLevelKho(1);
        $level2   = WareHouse::countLevelKho(2);
        $level3   = WareHouse::countLevelKho(3);
        $dungthu  = WareHouse::countStatusKho(2);
        $traphi   = WareHouse::countStatusKho(1);
        $getUsers = User::leftjoin('role_user','role_user.user_id','=','users.id')
            ->where('role_user.role_id',3)
            ->orderBy('id','DESC')
            ->get();
        $getChukho = User::leftjoin('role_user','role_user.user_id','=','users.id')
            ->where('role_user.role_id',4)
            ->orderBy('id','DESC')
            ->get();
        $getCompany = User::leftjoin('role_user','role_user.user_id','=','users.id')
            ->where('role_user.role_id',6)
            ->orderBy('id','DESC')
            ->get();
        $getStaff = User::leftjoin('role_user','role_user.user_id','=','users.id')
            ->where('role_user.role_id',5)
            ->orderBy('id','DESC')
            ->get();
        $getDriver = Driver::get();
        
        $customer           = count($getUsers);
        $chukho             = count($getChukho);
        $company            = count($getCompany);
        $staff              = count($getStaff);
        $driver             = count($getDriver);
        $countOrderFinish   = count(Order::where('status',8)->get());
        $countOrder         = count(Order::get());
        $idUser             = Auth::user()->id;
        $arrAllProductOrder = ProductOrder::select('product_orders.id','orders.kho_id','product_orders.price_in','product_orders.price','product_orders.num')
            ->leftJoin('orders','product_orders.order_id','=','orders.id')
            ->where('orders.status','=',8)
            ->get();
        $totalPriceIn       = 0;
        $totalPrice         = 0;
        /*echo "<pre>";
        print_r($arrAllProductOrder);
        echo "</pre>";
        die;*/
        foreach($arrAllProductOrder as $itemOrder){
            $totalPrice   = $totalPrice + ($itemOrder->price);
            $totalPriceIn = $totalPriceIn + ($itemOrder->num * $itemOrder->price_in);
        }
        $arrBestSellProduct        = Product::getBestSellerProduct(3);
        $arrProductWaitApproval    = Product::where('status',0)->orderBy('id','DESC')->paginate(10);
        $arrNewsCompayWaitApproval = NewsCompany::where('status',0)->orderBy('id','DESC')->paginate(10);
        //dd($arrProductWaitApproval);
        $data = [
            'countOrder'                => $countOrder,
            'arrBestSellProduct'        => $arrBestSellProduct,
            'customer'                  => $customer,
            'chukho'                    => $chukho,
            'company'                   => $company,
            'staff'                     => $staff,
            'driver'                    => $driver,
            'level1'                    => $level1,
            'level2'                    => $level2,
            'level3'                    => $level3,
            'dungthu'                   => $dungthu,
            'traphi'                    => $traphi,
            'arrProductWaitApproval'    => $arrProductWaitApproval,
            'arrNewsCompayWaitApproval' => $arrNewsCompayWaitApproval,
            'totalPrice'                => $totalPrice,
            'countOrderFinish'          => $countOrderFinish
        ];

        return view('admin.dashboard',$data);
    }

}
