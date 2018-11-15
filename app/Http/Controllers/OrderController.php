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
    public function AjaxGetDistrictByProvinceID(Request $request){
        $id = $request->get('id');
        $arrDistrictByProvince = Order::GetRelateProvince($id);
        echo '<option value="">Chọn Huyện/Thị trấn</option>';
        foreach($arrDistrictByProvince as $item) { 
            echo '<option class="stlDistrict" value="'.$item->districtid.'">'.$item->name.'</option>';
            // echo '<div class="option" data-selectable="" data-value="'.$item->name.'">'.$item->name.'</div>';
        }
        // return \Response::json($arrDistrictByProvince);
    }
    public function AjaxLoadInfoAddress(Request $request) {
        $id      = $request->get('id');
        $type    = $request->get('type');
        $valueID = trim($request->get('valueID'));
        
        if($type == 'district') {
            $arrDistrictByProvince = Order::GetRelateProvince($id);
            $q = '<option value="">Chọn Huyện/Thị trấn</option>';
            foreach($arrDistrictByProvince as $item) { 
                $select  = '';
                if($item->districtid == $valueID) $select = 'selected';
                $q .= '<option class="" '.$select.' value="'.$item->districtid.'">'.$item->name.'</option>';
            }
            $arrProvine = Province::where('deleted', 0)->get();
            $t = '';
            foreach($arrProvine as $item) { 
                $select  = '';
                if($item->provinceid == $id) $select = 'selected';
                $t .= '<option class="" '.$select.' value="'.$item->provinceid.'">'.$item->name.'</option>';
            }
        }
        $data = [
            'q' => $q,
            't' => $t,
        ];
        return \Response::json($data);
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
        if(Auth::user()->hasRole('kho')) {
            $arrAllOrders = Order::select('orders.*','users.address','users.province','users.name','users.phone_number')
                ->leftJoin('users','orders.customer_id','=','users.id')
                ->where('orders.kho_id', $idUser)
                ->where('orders.status', $id)
                ->paginate(6);
        } else {
            $arrAllOrders = Order::select('orders.*','users.address','users.province','users.name','users.phone_number')
                ->leftJoin('users','orders.customer_id','=','users.id')
                ->where('status', $id)
                ->paginate(6);
        }

        $arrOrderByStatus = OrderStatus::where('deleted', '0')->get();
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
            // dd($q);
            if(Auth::user()->hasRole(['kho'])) {
                $arrAllOrders = Order::select('orders.*', 'users.address', 'users.province', 'users.name', 'users.phone_number')
                    ->leftjoin('users', 'orders.customer_id', '=', 'users.id')
                    ->where(function($q1)use ($q) {
                        $q1->where('users.name', 'LIKE', '%' . $q . '%')
                        ->orwhere('orders.order_code', 'LIKE', '%' . $q . '%')
                        ->orwhere('users.phone_number', 'LIKE', '%' . $q . '%');
                    })
                    ->where('orders.kho_id', $author_id)
                    ->where('orders.deleted', 0)
                    ->orderBy('orders.id','DESC')
                    ->paginate(9);
            } else {
                $arrAllOrders = Order::select('orders.*', 'users.address', 'users.province', 'users.name', 'users.phone_number')
                    ->leftJoin('users', 'orders.customer_id', '=', 'users.id')
                    ->where('orders.deleted', 0)
                    ->where(function($q1)use ($q) {
                        $q1->where('users.name', 'LIKE', '%' . $q . '%')
                        ->orwhere('orders.order_code', 'LIKE', '%' . $q . '%')
                        ->orwhere('users.phone_number', 'LIKE', '%' . $q . '%');
                    })
                    ->orderBy('id','DESC')
                    ->paginate(9);
            }
        }
        else if ( Auth::user()->hasRole(['kho']) ){
            $arrAllOrders = Order::select('orders.*', 'users.address', 'users.province', 'users.name', 'users.phone_number')
                ->leftJoin('users', 'orders.customer_id', '=', 'users.id')
                ->where('orders.deleted', 0)
                ->where('orders.kho_id', $author_id)
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
        if ( Auth::user()->hasRole(['kho']) ){
            $AllOrders        = Order::where('kho_id', $author_id)->count();
        } else {
            $AllOrders        = Order::count();
        }
        // dd($arrAllOrders);
        $arrOrderByStatus = OrderStatus::where('deleted', '0')->get();
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
            ->where('role_user.role_id', 3)
            ->where('users.idwho' , $strUserID)
            ->orderBy('id','DESC')
            ->get();
        $province = Province::get();
        $district = District::get();
        if ( Auth::user()->hasRole(['kho']) ){
            $driver = Driver::leftjoin('transports','transports.id','=','driver.type_driver')
                        ->selectRaw('driver.*')
                        ->selectRaw('transports.name as name')
                        ->where('driver.kho', $strUserID)
                        ->get();
        } else {
            $driver = Driver::leftjoin('transports','transports.id','=','driver.type_driver')
                        ->selectRaw('driver.*')
                        ->selectRaw('transports.name as name')
                        ->get();
        }
        if (Auth::user()->hasRole('kho')){
            $products = Product::where('kho',$strUserID)
                ->where('status',1)
                ->get();
        }
        else {
            $products = Product::where('status', 1)->get();
        }
        $order_status = OrderStatus::where('deleted', '0')->get();
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
            $order->id_driver                    = $request->id_driver;
            $order->name_driver                  = $request->name_driver;
            $order->phone_driver                 = $request->phone_driver;
            $order->number_license_driver        = $request->number_license_driver;
            $order->type_pay                     = $request->type_pay;
            if($request->type_pay == 2) {
                $order->received_pay             = preg_replace (array('/[^0-9]/'), array (""), $request->received_pay);
                $order->remain_pay               = preg_replace (array('/[^0-9]/'), array (""), $request->remain_pay);
            }
            $order->discount                     = preg_replace (array('/[^0-9]/'), array (""), $request->discount);
            $order->tax                          = preg_replace (array('/[^0-9]/'), array (""), $request->tax);
            $order->transport_pay                = preg_replace (array('/[^0-9]/'), array (""), $request->transport_pay);
            $order->author_id                    = Auth::user()->id;
            $order->save();
            $strOrderID                          = $order->id;
            // update order_code
            $arrWareHouse                         = User::find($order->customer_id);
            $strProvinceCode                     = \App\Util::StringExplodeProvince($arrWareHouse->province);
            $data['order_code']                  = $strProvinceCode . '-' . $order->kho_id . '-' . $strOrderID;
            $order->update($data);
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
            if ($request->get('status') == Util::$statusOrderNew) {
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
        $orderStatus  = OrderStatus::where('deleted', '0')->get();
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
            ->where('role_user.role_id', 3)
            ->where('users.idwho' , $strUserID)
            ->orderBy('id','DESC')
            ->get();
        $arrOrder = Order::leftjoin('driver','driver.id', '=', 'orders.id_driver')
                        ->leftjoin('transports', 'transports.id', '=', 'driver.type_driver')
                        ->selectRaw('orders.*')
                        ->selectRaw('transports.name as name')
                        ->where('orders.id', $id)
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
        foreach ($arrOrder as $itemOrder) {
            $status = $itemOrder['status'];
            $customer_id = $itemOrder['customer_id'];
        }
        $order_status     = OrderStatus::where('deleted', '0')->where('id', '>=', $status)->get();
        $arrCustomerOrder = User::find($customer_id);
        $arrProductOrders = ProductOrder::leftJoin('products','products.id','=','product_orders.id_product')
            ->where('order_id','=',$id)->get();
        // echo "<pre>";
        // print_r($order_status);
        // echo "</pre>";
        // dd(1);
        // die;
        $data = [
            'customer'         => $customer,
            'province'         => $province,
            'district'         => $district,
            'products'         => $products,
            'driver'           => $driver,
            'order_status'     => $order_status,
            'arrOrder'         => $arrOrder[0],
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
            $statusOld = $order->status;
            /*$arrListProductOld = ProductOrder::select('id_product')->where('order_id', '=', $id)->get();
            foreach ($arrListProductOld as $key => $value) {
                $arrTmp[] = $value->id_product;
            }
            $res = array_diff($arrProductID, $arrTmp);*/
            // dd($arrListProductOld);
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
            $data['id_driver']             = $request->id_driver;
            $data['name_driver']           = $request->name_driver;
            $data['phone_driver']          = $request->phone_driver;
            $data['number_license_driver'] = $request->number_license_driver;
            $data['type_pay']              = $request->type_pay;
            if($request->type_pay == 2) {
                $data['received_pay']      = preg_replace (array('/[^0-9]/'), array (""), $request->received_pay) + $order->received_pay;
                $data['remain_pay']        = preg_replace (array('/[^0-9]/'), array (""), $request->remain_pay);
            }
            $data['discount']              = preg_replace (array('/[^0-9]/'), array (""), $request->discount);
            $data['tax']                   = preg_replace (array('/[^0-9]/'), array (""), $request->tax);
            $data['transport_pay']         = preg_replace (array('/[^0-9]/'), array (""), $request->transport_pay);
            $data['author_id']             = Auth::user()->id;
            $order->update($data);
            $strOrderID                          = $id;
            // insert history
            $historyUpdateStatusOrder            = new HistoryUpdateStatusOrder();
            $historyUpdateStatusOrder->order_id  = $strOrderID;
            $historyUpdateStatusOrder->status    = $request->status;
            $historyUpdateStatusOrder->author_id = Auth::user()->id;
            $historyUpdateStatusOrder->save();
            if($statusOld < 7 && $request->status <= 7) {
                // get list product_order old
                $arrListProductOld = ProductOrder::where('order_id', '=', $id)->get();
                foreach ($arrListProductOld as $key => $itemProductOld) {
                    $arrProduct = Product::find($itemProductOld->id_product);
                    $invenAfter = $arrProduct['inventory_num'] + $itemProductOld->num;
                    $dataOld['inventory_num'] = $invenAfter;
                    $arrProduct->update($dataOld);
                }
                // remove list product_order old
                $product_order = ProductOrder::where('order_id','=',$id);
                $product_order->delete();
                // add again
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
            } 
            if ($request->get('status') == Util::$statusOrderFinish) {
                $arrUser                            = User::find($request->customer_id);
                $getCodeOrder                       = Util::OrderCode($id);
                $strIDChuKho                        = Auth::user()->id;
                $arrChuKho                          = User::find($kho_id);
                $dataNotify['keyname']              = Util::$orderreturn;
                $dataNotify['title']                = "Đơn hàng đã hoàn thành";
                $dataNotify['content']              = "Mã ĐH: " . $getCodeOrder . " của " . $arrUser->name . " đã hoàn thành";
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
                        "title"      => "Đơn hàng đã hoàn thành",
                        "link"       => '/admin/orders/'.$id.'/edit',
                        "content"    => "Mã ĐH: " . $getCodeOrder . " của " . $arrUser->name . "  đã hoàn thành",
                        "created_at" => date('Y-m-d H:i:s')
                    )));
                }

                $dataNotifyAdmin['keyname']              = Util::$orderreturn;
                $dataNotifyAdmin['title']                = "Đơn hàng đã hoàn thành";
                $dataNotifyAdmin['content']              = "Mã ĐH: " . $getCodeOrder . " của Chủ Kho" . $arrChuKho->name . " được Khách Hàng " . $arrUser->name . " mua đã hoàn thành";
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
                            "title"      => "Đơn hàng đã hoàn thành",
                            "link"       => '/admin/orders/'.$id.'/edit',
                            "content"    => "Mã ĐH: " . $getCodeOrder . " của Chủ Kho" . $arrChuKho->name . " được Khách Hàng " . $arrUser->name . " đã hoàn thành",
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
                $dataNotify['title']                = "Đơn hàng bị hủy";
                $dataNotify['content']              = "Mã ĐH: " . $getCodeOrder . " của " . $arrUser->name . " bị hủy";
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
                        "title"      => "Đơn hàng bị hủy",
                        "link"       => '/admin/orders/'.$id.'/edit',
                        "content"    => "Mã ĐH: " . $getCodeOrder . " của " . $arrUser->name . "  bị hủy",
                        "created_at" => date('Y-m-d H:i:s')
                    )));
                }

                $dataNotifyAdmin['keyname']              = Util::$orderreturn;
                $dataNotifyAdmin['title']                = "Đơn hàng  bị hủy";
                $dataNotifyAdmin['content']              = "Mã ĐH: " . $getCodeOrder . " của Chủ Kho" . $arrChuKho->name . " được Khách Hàng " . $arrUser->name . " mua  bị hủy";
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
                            "title"      => "Đơn hàng  bị hủy",
                            "link"       => '/admin/orders/'.$id.'/edit',
                            "content"    => "Mã ĐH: " . $getCodeOrder . " của Chủ Kho" . $arrChuKho->name . " được Khách Hàng " . $arrUser->name . " mua  bị hủy",
                            "created_at" => date('Y-m-d H:i:s')
                        )));
                    }
                }
                foreach ($arrProductID as $key => $ProductID) {
                    $ProductOrderOld               = ProductOrder::where('order_id', '=', $id)->first();
                    $productInfo                   = Product::find($ProductID);
                    $productInfo2['inventory_num'] = $productInfo->inventory_num + $arrNumberProduct[$key];
                    $productInfo->update($productInfo2);
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
        $order         = Order::destroy($id);
        $product_order = ProductOrder::where('order_id','=',$id);
        $product_order->delete();
        if((!empty($order)) && (!empty($product_order))) {
            return redirect('admin/orders/')->with(['flash_level' => 'success', 'flash_message' => 'Xóa thành công']);
        }
        else{
            return redirect('admin/orders/')->with(['flash_level' => 'success', 'flash_message' => 'Chưa được xóa']);

        }
    }
}
