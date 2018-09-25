<?php

namespace App\Http\Controllers;

use App\CategoryProduct;
use App\Product;
use App\User;
use App\WareHouse;
use App\Inventory;
use App\Payment;
use App\CatePayment;
use App\BankWareHouse;
use DateTime;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
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
            if($request->get('name') || $request->get('dateview')){
                $name = $request->get('name');
                $dateview = $request->get('dateview');
                
                if(!empty($name)){
                    $payment =  Payment::select('payment.*', 'bank_ware_houses.card_name as cardNameBank', 'bank_ware_houses.id as idBank', 'cate_payment.name as cateName', 'bank.name as nameBank')
                                ->leftjoin('bank_ware_houses', 'bank_ware_houses.id', 'payment.type_pay_detail')
                                ->leftjoin('cate_payment', 'cate_payment.id', 'payment.cate')
                                ->leftjoin('bank', 'bank.id', 'bank_ware_houses.bank')
                                ->where('payment.type', '=', $name)
                                ->where('payment.deleted', 0)
                                ->where('payment.author_id', $user_id)
                                ->groupBy("payment.id")
                                ->paginate(9);
                }
                if(!empty($dateview)){
                    $dateRes = explode('>',$dateview);
                    $start = date_create($dateRes[0]);
                    $dateStart = date_format($start ,"Y-m-d H:i:s");
                    $end = date_create($dateRes[1]);
                    $dateEnd = date_format($end ,"Y-m-d") . ' 23:59:59';
                    $payment =  Payment::select('payment.*', 'bank_ware_houses.card_name as cardNameBank', 'bank_ware_houses.id as idBank', 'cate_payment.name as cateName', 'bank.name as nameBank')
                                ->leftjoin('bank_ware_houses', 'bank_ware_houses.id', 'payment.type_pay_detail')
                                ->leftjoin('cate_payment', 'cate_payment.id', 'payment.cate')
                                ->leftjoin('bank', 'bank.id', 'bank_ware_houses.bank')
                                ->whereBetween('payment.created_at', array($dateStart, $dateEnd))
                                ->where('payment.author_id', $user_id)
                                ->where('payment.deleted', 0)
                                ->groupBy(DB::raw("DATE(payment.created_at)"))
                                ->groupBy("payment.id")
                                ->paginate(9);
                } if(!empty($name) && !empty($dateview)) {
                    $dateRes = explode('>',$dateview);
                    $start = date_create($dateRes[0]);
                    $dateStart = date_format($start ,"Y-m-d H:i:s");
                    $end = date_create($dateRes[1]);
                    $payment =  Payment::select('payment.*', 'bank_ware_houses.card_name as cardNameBank', 'bank_ware_houses.id as idBank', 'cate_payment.name as cateName', 'bank.name as nameBank')
                                ->leftjoin('bank_ware_houses', 'bank_ware_houses.id', 'payment.type_pay_detail')
                                ->leftjoin('cate_payment', 'cate_payment.id', 'payment.cate')
                                ->leftjoin('bank', 'bank.id', 'bank_ware_houses.bank')
                                ->whereBetween('payment.created_at', array($dateStart, $dateEnd))
                                ->where('payment.type','=', $name)
                                ->where('payment.author_id', $user_id)
                                ->where('payment.deleted', 0)
                                ->groupBy(DB::raw("DATE(payment.created_at)"))
                                ->groupBy("payment.id")
                                ->paginate(9);
                }
            }
            else {
                $payment = Payment::select('payment.*', 'bank_ware_houses.card_name as cardNameBank', 'bank_ware_houses.id as idBank', 'cate_payment.name as cateName', 'bank.name as nameBank')
                    ->leftjoin('bank_ware_houses', 'bank_ware_houses.id', 'payment.type_pay_detail')
                    ->leftjoin('cate_payment', 'cate_payment.id', 'payment.cate')
                    ->leftjoin('bank', 'bank.id', 'bank_ware_houses.bank')
                    ->where('payment.author_id', $user_id)
                    ->orderBy('payment.id','DESC')
                    ->groupBy("payment.id")
                    ->where('payment.deleted', 0)
                    ->paginate(9);
            }
        } else {
            if($request->get('name') || $request->get('dateview')){
                $name = $request->get('name');
                $dateview = $request->get('dateview');
                
                if(!empty($name)){
                    $payment =  Payment::select('payment.*', 'bank_ware_houses.card_name as cardNameBank', 'bank_ware_houses.id as idBank', 'cate_payment.name as cateName', 'bank.name as nameBank')
                                ->leftjoin('bank_ware_houses', 'bank_ware_houses.id', 'payment.type_pay_detail')
                                ->leftjoin('cate_payment', 'cate_payment.id', 'payment.cate')
                                ->leftjoin('bank', 'bank.id', 'bank_ware_houses.bank')
                                ->where('payment.type','=', $name)
                                ->where('payment.deleted', 0)
                                ->groupBy("payment.id")
                                ->paginate(9);
                }
                if(!empty($dateview)){
                    $dateRes = explode('>',$dateview);
                    $start = date_create($dateRes[0]);
                    $dateStart = date_format($start ,"Y-m-d H:i:s");
                    $end = date_create($dateRes[1]);
                    $dateEnd = date_format($end ,"Y-m-d") . ' 23:59:59';
                    $payment =  Payment::select('payment.*', 'bank_ware_houses.card_name as cardNameBank', 'bank_ware_houses.id as idBank', 'cate_payment.name as cateName', 'bank.name as nameBank')
                                ->leftjoin('bank_ware_houses', 'bank_ware_houses.id', 'payment.type_pay_detail')
                                ->leftjoin('cate_payment', 'cate_payment.id', 'payment.cate')
                                ->leftjoin('bank', 'bank.id', 'bank_ware_houses.bank')
                                ->whereBetween('payment.created_at', array($dateStart, $dateEnd))
                                ->where('payment.deleted', 0)
                                ->groupBy(DB::raw("DATE(payment.created_at)"))
                                ->groupBy("payment.id")
                                ->paginate(9);
                } if(!empty($name) && !empty($dateview)) {
                    $dateRes = explode('>',$dateview);
                    $start = date_create($dateRes[0]);
                    $dateStart = date_format($start ,"Y-m-d H:i:s");
                    $end = date_create($dateRes[1]);
                    $payment =  Payment::select('payment.*', 'bank_ware_houses.card_name as cardNameBank', 'bank_ware_houses.id as idBank', 'cate_payment.name as cateName', 'bank.name as nameBank')
                                ->leftjoin('bank_ware_houses', 'bank_ware_houses.id', 'payment.type_pay_detail')
                                ->leftjoin('cate_payment', 'cate_payment.id', 'payment.cate')
                                ->leftjoin('bank', 'bank.id', 'bank_ware_houses.bank')
                                ->whereBetween('payment.created_at', array($dateStart, $dateEnd))
                                ->where('payment.type','=', $name)
                                ->where('payment.deleted', 0)
                                ->groupBy(DB::raw("DATE(payment.created_at)"))
                                ->groupBy("payment.id")
                                ->paginate(9);
                }
            }
            else {
                $payment = Payment::select('payment.*', 'bank_ware_houses.card_name as cardNameBank', 'bank_ware_houses.id as idBank', 'cate_payment.name as cateName', 'bank.name as nameBank')
                    ->leftjoin('bank_ware_houses', 'bank_ware_houses.id', 'payment.type_pay_detail')
                    ->leftjoin('cate_payment', 'cate_payment.id', 'payment.cate')
                    ->leftjoin('bank', 'bank.id', 'bank_ware_houses.bank')
                    ->orderBy('payment.id','DESC')
                    ->groupBy("payment.id")
                    ->where('payment.deleted', 0)
                    ->paginate(9);
            }
        }
        // dd($payment);
        $data = [
            'payments'  => $payment,
        ];
        return view('admin.payment.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $type = !empty($request->type) ? $request->type : "receipt";
        $catePayment = Catepayment::where('deleted', 0)->get();
        $data = [
            'catePayment'  => $catePayment,
            'type' => $type,
        ];
        return view('admin.payment.edit', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $data              = $request->all();
            $data['price']     = preg_replace (array('/[^0-9]/'), array (""), $request->price );
            $data['author_id'] = Auth::user()->id;
            $payment           = Payment::create($data);
            $strPayID          = $payment->id;
            $data['code']      = 'SQU-' . Auth::user()->id . '-' . $strPayID;
            $payment->update($data);
        }
        catch(\Exception $e){
            DB::rollback();
            return redirect('admin/payment/')->with(['flash_level' => 'danger', 'flash_message' => 'Lưu không thành công']);
        }
            DB::commit();
            return redirect('admin/payment/')->with(['flash_level' => 'success', 'flash_message' => 'Lưu thành công']);
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
        $payment = Payment::find($id);
        $type = $payment->type;
        $catePayment = Catepayment::where('deleted', 0)->get();             
        $data = [
            'id'         => $id,
            'type'       => $type,
            'catePayment'=> $catePayment,
            'arrPayment' => $payment,
        ];
        // dd($arrProduct);
        return view('admin.payment.edit', $data);
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
            $payment           = Payment::find($id);
            $data              = $request->all();
            $data['price']     = preg_replace (array('/[^0-9]/'), array (""), $request->price );
            
            $payment->update($data);
        }
        
        catch(\Exception $e){
            DB::rollback();
            return redirect('admin/payment/')->with(['flash_level' => 'danger', 'flash_message' => 'Lưu không thành công']);
        }
            DB::commit();
            return redirect('admin/payment/')->with(['flash_level' => 'success', 'flash_message' => 'Lưu thành công']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = ['deleted' => 1];
        $inventory        = Inventory::find($id);
        $inventory_detail = InventoryDetail::where('idinventory','=', $id);
        $inventory->update($data);
        $inventory_detail->update($data);

        $check = Inventory::where('id', $id)->where('deleted', 0)->get();
        $check1 = InventoryDetail::where('id', $id)->where('deleted', 0)->get();
        if(count($check) == 0 && count($check1) == 0) {
            return redirect('admin/inventory/')->with(['flash_level' => 'success', 'flash_message' => 'Xóa thành công']);
        }
        else{
            return redirect('admin/inventory/')->with(['flash_level' => 'success', 'flash_message' => 'Chưa được xóa']);
        }
    }
    /**
     * Get type payment detail
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getListOfType(Request $request) {
        $strUserID = Auth::user()->id;
        if ( Auth::user()->hasRole(['kho']) ) {
            $arrWareId = WareHouse::select('id')->where('user_id', $strUserID)->get();
        }
        $strWareID = $arrWareId[0]['id'];

        $type_pay        = $request->get('type_pay');   
        $type_pay_detail = $request->get('type_pay_detail');
        $arrBank = BankWareHouse::where('type_pay', $type_pay)->where('ware_id', $strWareID)->where('deleted', 0)->get();
        foreach($arrBank as $item) { 
            $select  = '';
            if($item->id == $type_pay_detail) $select = 'selected';
            if($type_pay == 1) {
                echo '<option class="" '.$select.' value="'.$item->id.'">'.$item->card_name.'</option>';
            } elseif($type_pay == 2) {
                echo '<option class="" '.$select.' value="'.$item->id.'">'.$item->card_name . ' ('.$item->card_number.')</option>';
            }
            
        }
        
    }
    /**
     * Get total payment
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getTotalPayment(Request $request) {
        $data    = $request->get('data');
        $dateRes = explode('>',$data);
        $start = date_create($dateRes[0]);
        $dateStart = date_format($start ,"Y-m-d H:i:s");
        $end = date_create($dateRes[1]);
        $dateEnd = date_format($end ,"Y-m-d") . ' 23:59:59';
        $idUser  = Auth::user()->id;
        if ( Auth::user()->hasRole(['kho']) ) {
            $payment = Payment::whereBetween('created_at', array(trim($dateStart), trim($dateEnd)))
                ->where('author_id', $idUser)
                ->where('type', 'payment')
                ->whereIn('status',[1,2])
                ->selectRaw('sum(price) as price')
                ->groupBy(DB::raw("DATE(created_at)"))
                ->get();
            $receipt = Payment::whereBetween('created_at', array(trim($dateStart), trim($dateEnd)))
                ->where('author_id', $idUser)
                ->where('type', 'receipt')
                ->whereIn('status',[1,2])
                ->selectRaw('sum(price) as price')
                ->groupBy(DB::raw("DATE(created_at)"))
                ->get();
        } else {
            $payment = Payment::whereBetween('created_at', array(trim($dateStart), trim($dateEnd)))
                ->where('type', 'payment')
                ->whereIn('status',[1,2])
                ->selectRaw('sum(price) as price')
                ->groupBy(DB::raw("DATE(created_at)"))
                ->get();
            $receipt = Payment::whereBetween('created_at', array(trim($dateStart), trim($dateEnd)))
                ->where('type', 'receipt')
                ->whereIn('status',[1,2])
                ->selectRaw('sum(price) as price')
                ->groupBy(DB::raw("DATE(created_at)"))
                ->get();
        }
        $response = array(
            'status'  => 'success',
            'payment' => $payment,
            'receipt' => $receipt,
        );
        return \Response::json($response);
    }
}
