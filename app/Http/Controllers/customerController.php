<?php

namespace App\Http\Controllers;

use App\Order;
use App\Province;
use App\User;
use App\Role;
use App\ProductOrder;
use App\Util;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Http\Requests;

class customerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user_id = Auth::user()->id;
        if ( Auth::user()->hasRole(['kho']) ) {
            if($request->get('q')){
                $q     = $request->get('q');
                $users = User::leftjoin('role_user','role_user.user_id','=','users.id')
                    ->where('role_user.role_id',3)
                    ->where('users.deleted', 0)
                    ->where('users.idwho', $user_id)
                    ->where('name','LIKE','%'.$q.'%')
                    ->orwhere('id','LIKE','%'.$q.'%')
                    ->orwhere('phone_number','LIKE','%'.$q.'%')->paginate(9);
            }
            else {
                $users = User::leftjoin('role_user','role_user.user_id','=','users.id')
                    ->where('role_user.role_id',3)
                    ->where('users.deleted', 0)
                    ->where('users.idwho', $user_id)
                    ->orderBy('id','DESC')
                    ->paginate(9);
            }
        } else {
            if($request->get('q')){
                $q     = $request->get('q');
                $users = User::leftjoin('role_user','role_user.user_id','=','users.id')
                    ->where('role_user.role_id',3)
                    ->where('users.deleted', 0)
                    ->where('name','LIKE','%'.$q.'%')
                    ->orwhere('id','LIKE','%'.$q.'%')
                    ->orwhere('phone_number','LIKE','%'.$q.'%')->paginate(9);
            }
            else {
                $users = User::leftjoin('role_user','role_user.user_id','=','users.id')
                    ->where('role_user.role_id',3)
                    ->where('users.deleted', 0)
                    ->orderBy('id','DESC')
                    ->paginate(9);
            }
        }
        $data = [
            'users'=>$users,
            'type' => 'users',
        ];
        return view('admin.customers.index',$data);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $province = Province::get();
        $roles    = Role::get();
        // dd($roles);
        $data = [
            'role'     => "customer",
            'roles'    => $roles,
            'province' => $province,
        ];
        return view('admin.customers.edit',$data);
    }
    public function show($id)
    {
        $history = Order::leftjoin('product_orders','orders.id','=','product_orders.order_id')
            ->leftjoin('users','orders.customer_id','=','users.id')
            ->selectRaw('users.*, users.name as customer_name')
            ->selectRaw('orders.*')
            ->selectRaw('product_orders.*, product_orders.name as product_orders_name')
            ->where('orders.customer_id',$id)
            ->orderBy('orders.time_order','DESC')
            ->limit(10)
            ->get();
        $customer_name = "";
        foreach ($history as $itemHistory) {
            $customer_name = $itemHistory->customer_name;
        }
        $data = [
            'customer_name' => $customer_name,
            'history'       => $history,
            'id'            => $id,
        ];
        return view('admin.customers.history', $data);

    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request) {
        
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $roles    = Role::get();
        $user     = User::find($id);
        $roleUser = DB::table('role_user')
            ->where('user_id',$id)->first();
        $province = Province::get();
        $totalPrice = 0;
        $totalRemain = 0;
        $arrOrder = Order::where('customer_id', $id)->get();
        // dd($arrOrder);
        $countOrder = 0;
        foreach ($arrOrder as $itemOrder) {
            if($itemOrder['status'] == 9) {
                $totalPrice += ProductOrder::getSumOrder($itemOrder->id);
                $countOrder++;
            }
            if($itemOrder['status'] == 9 && $itemOrder['status_pay'] == 2) // đặt cọc thanh toán sau
            {
                $totalRemain += $itemOrder['remain_pay'] ;
            }
        }
        $data     = [
            'id'       => $id,
            'roles'    => $roles,
            'user'     => $user,
            'roleUser' => $roleUser,
            'province' => $province,
            'countOrder' => $countOrder,
            'totalPrice' => $totalPrice,
            'totalRemain' => $totalRemain,
        ];
        // dd($data);
        return view('admin.customers.edit', $data);
    }

}
