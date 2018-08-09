<?php

namespace App\Http\Controllers;

use App\District;
use App\HistoryUpdateStatusOrder;
use App\Notification;
use App\Order;
use App\OrderStatus;
use App\Product;
use App\ProductOrder;
use App\Province;
use App\User;
use App\Util;
use App\Driver;
use App\WareHouse;
use DateTime;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\CreateOrderRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function AjaxGetDistrictByProvince(Request $request){
        $name = $request->get('name');
        $arrDistrictByProvince = Order::GetRelateProvince($name);
        return \Response::json($arrDistrictByProvince);
        /*foreach($arrDistrictByProvince as $DistrictByProvince){
            echo "<option value='$DistrictByProvince->name'>$DistrictByProvince->name</option>";
        }*/
    }
    public function AjaxLoadInfoAddress(Request $request) {
        $id      = $request->get('id');
        $type    = $request->get('type');
        $valueID = $request->get('valueID');
        
        if($type == 'district') {
            $arrDistrictByProvince = Order::GetRelateProvince($id);
            echo '<option value="">Chọn Huyện/Thị trấn</option>';
            foreach($arrDistrictByProvince as $item) { 
                $select  = '';
                if($item->districtid == $valueID) $select = 'selected';
                echo '<option class="" '.$select.' value="'.$item->districtid.'">'.$item->name.'</option>';
            }
        }
        /*elseif($type == 'village') {
            $arrVillageByDistrict = Village::GetRelateDistrict($id);
            echo '<option value="">Chọn Phường/Xã</option>';
            foreach($arrVillageByDistrict as $item) { 
                $select  = '';
                if($item->villageid == $valueID) $select = 'selected';
                echo '<option class=""'. $select .' value="'.$item->villageid.'">'.$item->name.'</option>';
            }
        }*/
    }
    public function getOrderByStatus($id){
        $idUser = Auth::user()->id;
        if(Auth::user()->hasRole('kho')) {
            $AllOrders = Order::where('kho_id', $idUser)->count();
        }
        else {
            $AllOrders = Order::count();
        }
        $arrAllOrders = Order::select('orders.*','users.address','users.province','users.name','users.phone_number')
            ->leftJoin('users','orders.customer_id','=','users.id')
            ->where('status', $id)
            ->paginate(6);
        $arrOrderByStatus = OrderStatus::get();
        $data = [
            'arrAllOrders'     => $arrAllOrders,
            'arrOrderByStatus' => $arrOrderByStatus,
            'allOrders'        => $AllOrders,
            'select'           => $id,
        ];

        return view('admin.orders.index',$data);
    }
    public function index(Request $request)
    {
        $author_id = Auth::user()->id;
        if($request->get('q')){
            $q = $request->get('q');
            if(Auth::user()->hasRole(['kho'])) {
                $arrAllOrders = Order::select('orders.*', 'users.address', 'users.province', 'users.name', 'users.phone_number')
                    ->leftJoin('users', 'orders.customer_id', '=', 'users.id')
                    ->where('kho_id', $author_id)
                    ->where('orders.deleted', 0)
                    ->where('users.name', 'LIKE', '%' . $q . '%')
                    ->orwhere('users.phone_number', 'LIKE', '%' . $q . '%')
                    ->orderBy('id','DESC')
                    ->paginate(9);
            }
            else {
                $arrAllOrders = Order::select('orders.*', 'users.address', 'users.province', 'users.name', 'users.phone_number')
                    ->leftJoin('users', 'orders.customer_id', '=', 'users.id')
                    ->where('orders.deleted', 0)
                    ->where('users.name', 'LIKE', '%' . $q . '%')
                    ->orwhere('users.phone_number', 'LIKE', '%' . $q . '%')
                    ->orderBy('id','DESC')
                    ->paginate(9);
            }

        }
        else if ( Auth::user()->hasRole(['kho']) ){
            $arrAllOrders = Order::select('orders.*', 'users.address', 'users.province', 'users.name', 'users.phone_number')
                ->leftJoin('users', 'orders.customer_id', '=', 'users.id')
                ->where('orders.deleted', 0)
                ->where('kho_id', $author_id)
                ->orderBy('id','DESC')
                ->paginate(9);
        }
        else {
            $arrAllOrders = Order::select('orders.*', 'users.address', 'users.province', 'users.name', 'users.phone_number')
                ->leftJoin('users', 'orders.customer_id', '=', 'users.id')
                ->where('orders.deleted', 0)
                ->orderBy('id','DESC')
                ->paginate(9);
        }
        // dd($arrAllOrders);
            $AllOrders        = Order::count();
            $arrOrderByStatus = OrderStatus::get();
            $data = [
                'arrAllOrders'     => $arrAllOrders,
                'arrOrderByStatus' => $arrOrderByStatus,
                'allOrders'        => $AllOrders,
                'select'           => '99',
            ];
        return view('admin.orders.index',$data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $strUserID = Auth::user()->id;
        $customer  = User::leftjoin('role_user','role_user.user_id','=','users.id')
            ->where('role_user.role_id',3)
            ->orderBy('id','DESC')
            ->get();
        $province = Province::get();
        $district = District::get();
        if ( Auth::user()->hasRole(['kho']) ){
            $driver = Driver::where('kho', $strUserID)->get();
        } else {
            $driver = Driver::get();
        }
        if (Auth::user()->hasRole('kho')){
            $products = Product::where('kho',$strUserID)
                ->where('status',1)
                ->get();
        }
        else {
            $products = Product::where('status',1)->get();
        }
        $order_status = OrderStatus::get();
        $data = [
            'customer'     => $customer,
            'province'     => $province,
            'district'     => $district,
            'products'     => $products,
            'driver'       => $driver,
            'order_status' => $order_status,

        ];
        //dd($products);
        return view('admin.orders.edit',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateOrderRequest $request)
    {
        DB::beginTransaction();
        try {
            $arrProductID     = $request->product_id;
            $arrNumberProduct = $request->product_number;
            $arrPriceTotal    = $request->pricetotal;

            $order  = new Order();

            $kho_id = Order::checkKhoByIdProduct($arrProductID);
            if($kho_id == -1){
                return redirect('admin/orders/create/')->with(['flash_level' => 'danger', 'flash_message' => 'Các sản phẩm trong đơn hàng không cùng kho']);
            }
            else {
                $order->kho_id = $kho_id;
            }

            $order->time_order                   = $request->time_order;
            $order->status                       = $request->status;
            $order->customer_id                  = $request->customer_id;
            $order->note                         = $request->note;
            $order->type_driver                  = $request->type_driver;
            $order->name_driver                  = $request->name_driver;
            $order->phone_driver                 = $request->phone_driver;
            $order->number_license_driver        = $request->number_license_driver;
            $order->type_pay                     = $request->type_pay;
            $order->received_pay                 = $request->received_pay;
            $order->remain_pay                   = $request->remain_pay;
            $order->author_id                    = Auth::user()->id;
            $order->save();
            $strOrderID                          = $order->id;
            // insert history
            $historyUpdateStatusOrder            = new HistoryUpdateStatusOrder();
            $historyUpdateStatusOrder->order_id  = $strOrderID;
            $historyUpdateStatusOrder->status    = $request->status;
            $historyUpdateStatusOrder->author_id = Auth::user()->id;
            $historyUpdateStatusOrder->save();


            foreach ($arrProductID as $key => $ProductID) {
                $ProductOrder1                = new ProductOrder();
                $productInfo                  = Product::find($ProductID);
                $ProductOrder1['id_product']  = $ProductID;
                $ProductOrder1['order_id']    = $strOrderID;
                $ProductOrder1['price_in']    = $productInfo->price_in;
                $ProductOrder1['price']       = $productInfo->price_out * $arrNumberProduct[$key];
                $ProductOrder1['num']         = $arrNumberProduct[$key];
                $ProductOrder1['name']        = $productInfo->title;
                $ProductOrder1->save();
                $productInfo['inventory_num'] = $productInfo->inventory_num - $arrNumberProduct[$key];
                $productInfo->save();
            }
            if ($request->get('status') == Util::$statusOrderFail) {
                $arrUser                            = User::find($request->customer_id);
                $getCodeOrder                       = Util::OrderCode($strOrderID);
                $dataNotify['keyname']              = Util::$ordernew;
                $dataNotify['title']                = "Đơn hàng mới";
                $dataNotify['content']              = "Mã ĐH: " . $getCodeOrder . " của " . $arrUser->name;
                $dataNotify['author_id']            = Auth::user()->id;
                $dataNotify['orderID_or_productID'] = $strOrderID;
                $dataNotify['link']                 = '/admin/orders/'.$strOrderID.'/edit';
                foreach (Util::getIdUserOfRole(Util::$roleviewAdmin) as $itemUser) {
                    $dataNotify['roleview'] = $itemUser;
                    $notify                 = Notification::create($dataNotify);
                    $message                = 'OK';
                    if(isset($message)) {
                        $redis = Redis::connection();
                        $redis->publish("messages", json_encode(array(
                            "status"     => 200,
                            "id"         => $strOrderID,  
                            "notifyID"   => $notify->id,
                            "roleview"   => $itemUser,
                            "title"      => "Đơn hàng mới",
                            "link"       => '/admin/orders/'.$strOrderID.'/edit',
                            "content"    => "Mã ĐH: " . $getCodeOrder . " của " . $arrUser->name,
                            "created_at" => date('Y-m-d H:i:s')
                        )));
                    }
                }
            }
//            DB::table('product_orders')->insert($ProductOrder);
        }
        catch(\Exception $e){

            DB::rollback();
            return redirect('admin/orders/')->with(['flash_level' => 'danger', 'flash_message' => 'Lưu không thành công']);

        }

            DB::commit();
            return redirect('admin/orders/')->with(['flash_level' => 'success', 'flash_message' => 'Lưu thành công']);

    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order        = Order::where('id',$id)->first();

        $customer     = User::where('id', $order->customer_id)->first();
        $productOrder = ProductOrder::select('product_orders.*', 'products.code', 'products.title', 'products.price_out')
            ->leftJoin('products', 'product_orders.id_product', 'products.id')
            ->where('product_orders.order_id', $order->id)->get();
        $orderStatus  = OrderStatus::get();
        $historyOrder = HistoryUpdateStatusOrder::select('history_update_status_order.*','order_status.*','users.name as username','users.id as userid')
            ->leftJoin('order_status','history_update_status_order.status','=','order_status.id')
            ->leftJoin('users','users.id','=','history_update_status_order.author_id')
            ->where('history_update_status_order.order_id',$id)
            ->orderBy('history_update_status_order.id','DESC')
            ->get();
        //dd($historyOrder);
        $data = [
            "order"        => $order,
            "customer"     => $customer,
            "productOrder" => $productOrder,
            "orderStatus"  => $orderStatus,
            "historyOrder" => $historyOrder,
        ];
        return view('admin.orders.showorder', $data);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $strUserID = Auth::user()->id;
        $customer  = User::leftjoin('role_user','role_user.user_id','=','users.id')
            ->where('role_user.role_id',3)
            ->orderBy('id','DESC')
            ->get();
        $arrOrder = Order::find($id);
        $province = Province::get();
        $district = District::get();
        $driver   = Driver::get();
        if (Auth::user()->hasRole('kho')){
            $products = Product::where('kho',$strUserID)
                ->where('status',1)
                ->get();
        }
        else {
            $products = Product::where('status',1)->get();
        }
        $order_status     = OrderStatus::get();
        $arrCustomerOrder = User::find($arrOrder->customer_id);
        $arrProductOrders = ProductOrder::leftJoin('products','products.id','=','product_orders.id_product')
            ->where('order_id','=',$id)->get();
        /*echo "<pre>";
        print_r($arrOrder);
        echo "</pre>";
        die;*/
        $data = [
            'customer'         => $customer,
            'province'         => $province,
            'district'         => $district,
            'products'         => $products,
            'driver'           => $driver,
            'order_status'     => $order_status,
            'arrOrder'         => $arrOrder,
            'arrCustomerOrder' => $arrCustomerOrder,
            'arrProductOrders' => $arrProductOrders,
            'id'               => $id
        ];
        // dd($arrProductOrders);
        return view('admin.orders.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        DB::beginTransaction();
        try {
            $arrProductID     = $request->product_id;
            $arrNumberProduct = $request->product_number;
            $arrPriceTotal    = $request->pricetotal;
            $order            = Order::find($id);
            $kho_id           = Order::checkKhoByIdProduct($arrProductID);
//            dd($kho_id);

            if($kho_id == -1){
                return redirect("admin/orders/$id/edit/")->with(['flash_level' => 'danger', 'flash_message' => 'Các sản phẩm trong đơn hàng không cùng kho']);
            }
            else {
                $order->kho_id = $kho_id;
            }
            $data['time_order']            = $request->time_order;
            $data['status']                = $request->status;
            $data['customer_id']           = $request->customer_id;
            $data['note']                  = $request->note;
            $data['type_driver']           = $request->type_driver;
            $data['name_driver']           = $request->name_driver;
            $data['phone_driver']          = $request->phone_driver;
            $data['number_license_driver'] = $request->number_license_driver;
            $data['type_pay']              = $request->type_pay;
            $data['received_pay']          = $request->received_pay + $order->received_pay;
            $data['remain_pay']            = $request->remain_pay;
            $data['author_id']             = Auth::user()->id;
            $order->update($data);
            /*if (!empty($id)) {
                DB::table('product_orders')->where('order_id', '=', $id)->delete();
            }*/
            $strOrderID                          = $id;
            // insert history
            $historyUpdateStatusOrder            = new HistoryUpdateStatusOrder();
            $historyUpdateStatusOrder->order_id  = $strOrderID;
            $historyUpdateStatusOrder->status    = $request->status;
            $historyUpdateStatusOrder->author_id = Auth::user()->id;
            $historyUpdateStatusOrder->save();


            foreach ($arrProductID as $key => $ProductID) {
                $ProductOrderOld             = ProductOrder::where('order_id', '=', $id)->first();
                $productInfo                 = Product::find($ProductID);
                $ProductOrder1['id_product'] = $ProductID;
                $ProductOrder1['order_id']   = $strOrderID;
                $ProductOrder1['price_in']   = $productInfo->price_in;
                $ProductOrder1['price']      = $productInfo->price_out * $arrNumberProduct[$key];
                $ProductOrder1['num']        = $arrNumberProduct[$key];
                $ProductOrder1['name']       = $productInfo->title;


                if ($ProductOrderOld->num != $arrNumberProduct[$key]) {
                    $productInfo['inventory_num'] = $productInfo->inventory_num - $arrNumberProduct[$key] + $ProductOrderOld->num;
                } else {
                    $productInfo['inventory_num'] = $arrNumberProduct[$key];
                }

                $productInfo->save();

                $ProductOrderOld->update($ProductOrder1);
            }
            if ($request->get('status') == Util::$statusOrderFail) {
                $arrUser                            = User::find($request->customer_id);
                $getCodeOrder                       = Util::OrderCode($id);
                $strIDChuKho                        = Auth::user()->id;
                $arrChuKho                          = User::find($kho_id);
                $dataNotify['keyname']              = Util::$orderfail;
                $dataNotify['title']                = "Đơn hàng bị lỗi";
                $dataNotify['content']              = "Mã ĐH: " . $getCodeOrder . " của " . $arrUser->name . " bị lỗi";
                $dataNotify['author_id']            = Auth::user()->id;
                $dataNotify['roleview']             = $kho_id;
                $dataNotify['orderID_or_productID'] = $id;
                $dataNotify['link']                 = '/admin/orders/'.$id.'/edit';
                
                $notify  = Notification::firstOrCreate($dataNotify);
                $message = 'OK';
                if(isset($message)) {
                    $redis = Redis::connection();
                    $redis->publish("messages", json_encode(array(
                        "status"     => 200,
                        "id"         => $id, 
                        "roleview"   => $kho_id, 
                        "notifyID"   => $notify->id,
                        "title"      => "Đơn hàng bị lỗi",
                        "link"       => '/admin/orders/'.$id.'/edit',
                        "content"    => "Mã ĐH: " . $getCodeOrder . " của " . $arrUser->name . " bị lỗi",
                        "created_at" => date('Y-m-d H:i:s')
                    )));
                }

                $dataNotifyAdmin['keyname']              = Util::$orderfail;
                $dataNotifyAdmin['title']                = "Đơn hàng bị lỗi";
                $dataNotifyAdmin['content']              = "Mã ĐH: " . $getCodeOrder . " của Chủ Kho" . $arrChuKho->name . " được Khách Hàng " . $arrUser->name . " mua đang bị lỗi";
                $dataNotifyAdmin['author_id']            = Auth::user()->id;
                $dataNotifyAdmin['orderID_or_productID'] = $id;
                $dataNotifyAdmin['link']                 = '/admin/orders/'.$id.'/edit';

                foreach (Util::getIdUserOfRole(Util::$roleviewAdmin) as $itemUser) {
                    $dataNotifyAdmin['roleview'] = $itemUser;
                    $notify = Notification::firstOrCreate($dataNotifyAdmin);
                    $message = 'OK';
                    if(isset($message)) {
                        $redis = Redis::connection();
                        $redis->publish("messages", json_encode(array(
                            "status"     => 200,
                            "id"         => $id,  
                            "notifyID"   => $notify->id,
                            "roleview"   => $itemUser,
                            "title"      => "Đơn hàng bị lỗi",
                            "link"       => '/admin/orders/'.$id.'/edit',
                            "content"    => "Mã ĐH: " . $getCodeOrder . " của Chủ Kho" . $arrChuKho->name . " được Khách Hàng " . $arrUser->name . " mua đang bị lỗi",
                            "created_at" => date('Y-m-d H:i:s')
                        )));
                    }
                }

            }
            elseif ($request->get('status') == Util::$statusOrderReturn) {
                $arrUser                            = User::find($request->customer_id);
                $getCodeOrder                       = Util::OrderCode($id);
                $strIDChuKho                        = Auth::user()->id;
                $arrChuKho                          = User::find($kho_id);
                $dataNotify['keyname']              = Util::$orderreturn;
                $dataNotify['title']                = "Đơn hàng sắp trả về kho";
                $dataNotify['content']              = "Mã ĐH: " . $getCodeOrder . " của " . $arrUser->name . " sắp trả về kho";
                $dataNotify['author_id']            = Auth::user()->id;
                $dataNotify['roleview']             = $kho_id;
                $dataNotify['orderID_or_productID'] = $id;
                $dataNotify['link']                 = '/admin/orders/'.$id.'/edit';
                $notify                             = Notification::firstOrCreate($dataNotify);
                $message                            = 'OK';
                if(isset($message)) {
                    $redis = Redis::connection();
                    $redis->publish("messages", json_encode(array(
                        "status"     => 200,
                        "id"         => $id,  
                        "notifyID"   => $notify->id,
                        "roleview"   => $kho_id,
                        "title"      => "Đơn hàng sắp trả về kho",
                        "link"       => '/admin/orders/'.$id.'/edit',
                        "content"    => "Mã ĐH: " . $getCodeOrder . " của " . $arrUser->name . " sắp trả về kho",
                        "created_at" => date('Y-m-d H:i:s')
                    )));
                }

                $dataNotifyAdmin['keyname']              = Util::$orderreturn;
                $dataNotifyAdmin['title']                = "Đơn hàng sắp trả về kho";
                $dataNotifyAdmin['content']              = "Mã ĐH: " . $getCodeOrder . " của Chủ Kho" . $arrChuKho->name . " được Khách Hàng " . $arrUser->name . " mua sắp trả về kho";
                $dataNotifyAdmin['author_id']            = Auth::user()->id;
                $dataNotifyAdmin['orderID_or_productID'] = $id;
                $dataNotifyAdmin['link']                 = '/admin/orders/'.$id.'/edit';
                foreach (Util::getIdUserOfRole(Util::$roleviewAdmin) as $itemUser) {
                    $dataNotifyAdmin['roleview'] = $itemUser;
                    $notify = Notification::firstOrCreate($dataNotifyAdmin);
                    $message = 'OK';
                    if(isset($message)) {
                        $redis = Redis::connection();
                        $redis->publish("messages", json_encode(array(
                            "status"     => 200,
                            "id"         => $id,  
                            "notifyID"   => $notify->id,
                            "roleview"   => $itemUser,
                            "title"      => "Đơn hàng sắp trả về kho",
                            "link"       => '/admin/orders/'.$id.'/edit',
                            "content"    => "Mã ĐH: " . $getCodeOrder . " của Chủ Kho" . $arrChuKho->name . " được Khách Hàng " . $arrUser->name . " mua sắp trả về kho",
                            "created_at" => date('Y-m-d H:i:s')
                        )));
                    }
                }
            }
//            DB::table('product_orders')->insert($ProductOrder);
        }
        catch(\Exception $e){

                DB::rollback();
                return redirect('admin/orders/')->with(['flash_level' => 'danger', 'flash_message' => 'Lưu không thành công']);

            }

            DB::commit();
        return redirect('admin/orders/')->with(['flash_level' => 'success', 'flash_message' => 'Lưu thành công']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order         =  Order::destroy($id);
        $product_order = ProductOrder::where('order_id','=',$id);
        $product_order->delete();
        if((!empty($order)) && (!empty($product_order))) {
            return redirect('admin/orders/')->with(['flash_level' => 'success', 'flash_message' => 'Xóa thành công']);
        }
        else{
            return redirect('admin/orders/')->with(['flash_level' => 'success', 'flash_message' => 'Không thể xóa thể xóa']);

        }
    }
}
