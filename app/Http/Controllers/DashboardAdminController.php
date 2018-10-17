<?php

namespace App\Http\Controllers;

use App\Order;
use App\User;
use App\ProductOrder;
use App\Product;
use App\WareHouse;
use App\Util;
use App\Payment;
use DateTime;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardAdminController extends Controller
{
    public function getdashboard(Request $request){
        $data    = $request->get('data');
        $dateRes = explode('>',$data);
        //dd($dateRes);
        $lineLabels      = [];
        $lineDatasProfit = [];
        $lineDatas       = [];
        $barLabels       = [];
        $barDatas1       = [];
        $barDatas2       = [];

        $idUser          = Auth::user()->id;
        $orders          = Order::whereBetween('updated_at', array(new DateTime(trim($dateRes[0])), new DateTime(trim($dateRes[1]))))
            ->where('kho_id',$idUser)
            ->whereIn('status',[9,10])
            ->groupBy(DB::raw("DATE(updated_at)"))
            ->get();
        $i = 0;

        foreach($orders as $order ){
            $barLabels[$i] = $order->updated_at->format('d-m-Y');
            // get All order has status #10
            $barDatas1[$i] = Order::getNumOrder(9, $order->updated_at->format('d-m-Y')); 
            $barDatas2[$i] = Order::getNumOrder(10, $order->updated_at->format('d-m-Y'));
            // dd($barDatas2[$i]);
            $lineLabels[$i]= $order->updated_at->format('d-m-Y');
            $lineDatas[$i] = ProductOrder::getSumPrice($order->updated_at->format('d-m-Y'));
            $lineDatasProfit[$i] = ProductOrder::getSumPriceProfit($order->updated_at->format('d-m-Y'));
            $i++;

        }

        $response = array(
            'status'          => 'success',
            'msg'             => 'Setting created successfully',
            'lineLabels'      => $lineLabels,
            'lineDatas'       => $lineDatas,
            'barLabels'       => $barLabels,
            'barDatas1'       => $barDatas1,
            'barDatas2'       => $barDatas2,
            'lineDatasProfit' => $lineDatasProfit,
        );
        // dd($response);
        return \Response::json($response);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $idUser       = Auth::user()->id; 
        $order        = Order::where('kho_id', $idUser)->get();
        $numOrder     = count($order);
        $arrOrder = Order::where('kho_id', $idUser)
                    ->where('status','=', Util::$statusOrderFinish)
                    ->get();
        $numProduct   = count(Product::where('kho', $idUser)->get());   
        $totalPrice   = 0;
        foreach($arrOrder as $itemOrder){
            // echo $itemOrder->id;
            // echo "<br>";
            $totalPrice = $totalPrice + ProductOrder::getSumOrder($itemOrder->id);
            // $totalPrice   = $totalPrice + ($itemOrder->price);
        }
        $totalPrice = $totalPrice + Payment::getMoneyCommission($idUser);
        $arrOrderRemain = Order::select('users.*','orders.*','orders.id as orderID')
            ->leftjoin('users','users.id','=','orders.customer_id')
            ->where('orders.kho_id', $idUser)
            ->where('orders.type_pay', 2)
            ->where('orders.remain_pay','!=', 0)
            ->paginate(10);
        $strCustomerOfWareHouse = User::where('idwho', $idUser)->where('deleted', 0)->count();
        $data = [
            'numOrder'       => $numOrder,
            'totalPrice'     => $totalPrice,
            'numProduct'     => $numProduct,
            'arrOrderRemain' => $arrOrderRemain,
            'strCustomerOfWareHouse' => $strCustomerOfWareHouse,
        ];
        return view('admin.dashboard-admin',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
