<?php

namespace App\Http\Controllers;

use App\Order;
use App\ProductOrder;
use App\Product;
use App\WareHouse;
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
        $barDatas2       =[];

        $idUser          = Auth::user()->id;
        $orders          = Order::whereBetween('updated_at', array(new DateTime(trim($dateRes[0])), new DateTime(trim($dateRes[1]))))
            ->where('kho_id',$idUser)
            ->whereIn('status',[8,10])
            ->groupBy(DB::raw("DATE(updated_at)"))
            ->get();
        $i = 0;
        foreach($orders as $key => $order ){
            $barLabels[$i] = $order->updated_at->format('d-m-Y');
            // get All order has status #10
            $barDatas1[$i] = Order::getAllNumOrder(10,$order->updated_at->format('d-m-Y')); 
            $barDatas2[$i] = Order::getNumOrder(10,$order->updated_at->format('d-m-Y'));

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
        $order        = Order::where('kho_id',$idUser)->get();
        $numOrder     = count($order);
        $orderProduct = ProductOrder::select('product_orders.id','orders.kho_id','product_orders.price_in','product_orders.price','product_orders.num')
            ->leftJoin('orders','product_orders.order_id','=','orders.id')
            ->where('orders.kho_id',$idUser)
            ->where('orders.status','=',8)
            ->get();
        $numProduct   = count(Product::where('kho',$idUser)->get());   
        $totalPriceIn = 0;
        $totalPrice   = 0;
        foreach($orderProduct as $itemOrder){
            $totalPrice   = $totalPrice + ($itemOrder->price);
            $totalPriceIn = $totalPriceIn + ($itemOrder->num * $itemOrder->price_in);

        }
        $profit         = $totalPrice - $totalPriceIn;
        $arrOrderRemain = Order::select('users.*','orders.*','orders.id as orderID')
            ->leftjoin('users','users.id','=','orders.customer_id')
            ->where('orders.kho_id', $idUser)
            ->where('orders.type_pay', 2)
            ->where('orders.remain_pay','!=', 0)
            ->paginate(10);
        $data = [
            'numOrder'       => $numOrder,
            'totalPrice'     => $totalPrice,
            'profit'         => $profit,
            'numProduct'     => $numProduct,
            'arrOrderRemain' => $arrOrderRemain,
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
