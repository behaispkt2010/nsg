<?php

namespace App\Http\Controllers;

use App\CategoryProduct;
use App\Product;
use App\User;
use App\WareHouse;
use App\Province;
use App\District;
use App\Order;
use App\WareHousing;
use App\WareHousingDetail;
use DateTime;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WarehousingController extends Controller
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
                    $warehousing =  WareHousing::select('input_output.*')
                                ->leftjoin('input_output_detail', 'input_output_detail.id_io', '=', 'input_output.id')
                                ->where('input_output_detail.nameproduct','LiKE','%'.$name.'%')
                                ->where('input_output.id_kho', $user_id)
                                ->where('input_output.deleted', 0)
                                ->groupBy("input_output.id")
                                ->paginate(9);
                }
                if(!empty($dateview)){
                    $dateRes = explode('>',$dateview);
                    $start = date_create($dateRes[0]);
                    $dateStart = date_format($start ,"Y-m-d H:i:s");
                    $end = date_create($dateRes[1]);
                    $dateEnd = date_format($end ,"Y-m-d") . ' 23:59:59';
                    $warehousing =  WareHousing::select('input_output.*')
                                ->leftjoin('input_output_detail', 'input_output_detail.id_io', '=', 'input_output.id')
                                ->whereBetween('input_output.created_at', array(trim($dateStart), trim($dateEnd)))
                                ->where('input_output.id_kho', $user_id)->where('input_output.deleted', 0)
                                ->groupBy(DB::raw("DATE(input_output.created_at)"))
                                ->groupBy("input_output.id")
                                ->paginate(9);
                } if(!empty($dateview) && !empty($name)) {
                    $dateRes = explode('>',$dateview);
                    $start = date_create($dateRes[0]);
                    $dateStart = date_format($start ,"Y-m-d H:i:s");
                    $end = date_create($dateRes[1]);
                    $dateEnd = date_format($end ,"Y-m-d") . ' 23:59:59';
                    $warehousing =  WareHousing::select('input_output.*')
                                ->leftjoin('input_output_detail', 'input_output_detail.id_io', '=', 'input_output.id')
                                ->whereBetween('input_output.created_at', array(trim($dateStart), trim($dateEnd)))
                                ->where('input_output.id_kho', $user_id)
                                ->where('input_output_detail.nameproduct','LiKE','%'.$name.'%')
                                ->where('input_output.deleted', 0)
                                ->groupBy(DB::raw("DATE(input_output.created_at)"))
                                ->groupBy("input_output.id")
                                ->paginate(9);
                }
            }
            else {
                $warehousing = WareHousing::select('input_output.*')
                    ->leftjoin('input_output_detail', 'input_output_detail.id_io', '=', 'input_output.id')
                    ->where('input_output.id_kho', $user_id)
                    ->orderBy('input_output.id','DESC')
                    ->groupBy("input_output.id")
                    ->where('input_output.deleted', 0)
                    ->paginate(9);
            }
        } else {
            if($request->get('name') || $request->get('dateview')){
                $name = $request->get('name');
                $dateview = $request->get('dateview');
                
                if(!empty($name)){
                    $warehousing =  WareHousing::select('input_output.*')
                                ->leftjoin('input_output_detail', 'input_output_detail.id_io', '=', 'input_output.id')
                                ->where('input_output_detail.nameproduct','LiKE','%'.$name.'%')
                                ->where('input_output.deleted', 0)
                                ->groupBy("input_output.id")
                                ->paginate(9);
                }
                if(!empty($dateview)){
                    $dateRes = explode('>',$dateview);
                    $start = date_create($dateRes[0]);
                    $dateStart = date_format($start ,"Y-m-d H:i:s");
                    $end = date_create($dateRes[1]);
                    $dateEnd = date_format($end ,"Y-m-d") . ' 23:59:59';
                    $warehousing =  WareHousing::select('input_output.*')
                                ->leftjoin('input_output_detail', 'input_output_detail.id_io', '=', 'input_output.id')
                                ->whereBetween('input_output.created_at', array(trim($dateStart), trim($dateEnd)))
                                ->where('input_output.deleted', 0)
                                ->groupBy(DB::raw("DATE(input_output.created_at)"))
                                ->groupBy("input_output.id")
                                ->paginate(9);
                } if(!empty($dateview) && !empty($name)) {
                    $dateRes = explode('>',$dateview);
                    $start = date_create($dateRes[0]);
                    $dateStart = date_format($start ,"Y-m-d H:i:s");
                    $end = date_create($dateRes[1]);
                    $dateEnd = date_format($end ,"Y-m-d") . ' 23:59:59';
                    $warehousing =  WareHousing::select('input_output.*')
                                ->leftjoin('input_output_detail', 'input_output_detail.id_io', '=', 'input_output.id')
                                ->whereBetween('input_output.created_at', array(trim($dateStart), trim($dateEnd)))
                                ->where('input_output_detail.nameproduct','LiKE','%'.$name.'%')
                                ->where('input_output.deleted', 0)
                                ->groupBy(DB::raw("DATE(input_output.created_at)"))
                                ->groupBy("input_output.id")
                                ->paginate(9);
                }
            }
            else {
                $warehousing = WareHousing::select('input_output.*')
                    ->leftjoin('input_output_detail', 'input_output_detail.id_io', '=', 'input_output.id')
                    ->orderBy('input_output.id','DESC')
                    ->groupBy("input_output.id")
                    ->where('input_output.deleted', 0)
                    ->paginate(9);
            }
        }
        $wareHouses = User::select('users.*','ware_houses.id as ware_houses_id','ware_houses.level as level')
            ->leftjoin('role_user','role_user.user_id','=','users.id')
            ->leftjoin('ware_houses','ware_houses.user_id','=','users.id')
            ->where('role_user.role_id', 4)
            ->where('users.deleted', 0)
            ->orderBy('id','DESC')
            ->get();
            // dd($wareHouses);

        $data = [
            'warehousings'  => $warehousing,
            'wareHouses'=> $wareHouses,
        ];
        return view('admin.warehousing.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $cate = !empty($request->cate) ? $request->cate : "receipt";
        $province = Province::get();
        $district = District::get();
        $wareHouses = User::select('users.*','ware_houses.id as ware_houses_id','ware_houses.level as level')
            ->leftjoin('role_user','role_user.user_id','=','users.id')
            ->leftjoin('ware_houses','ware_houses.user_id','=','users.id')
            ->where('role_user.role_id',4)
            ->orderBy('id','DESC')
            ->get();
        $strUserID = Auth::user()->id;
        if (Auth::user()->hasRole('kho')){
            $products = Product::where('kho', $strUserID)
                ->where('status', 1)
                ->get();
        }
        else {
            $products = Product::where('status', 1)->get();
        }
        if (Auth::user()->hasRole('kho')){
            $arrOrder = Order::where('kho_id', $strUserID)
                ->where('status', '<', 9)
                ->where('deleted', 0)
                ->get();
        }
        else {
            $arrOrder = Order::where('status', '<', 9)->where('deleted', 0)->get();
        }
        
        $data = [
            'cate'         => $cate,
            'products'     => $products,
            'wareHouses'   => $wareHouses,
            'province'     => $province,
            'district'     => $district,
            'arrOrder'     => $arrOrder,

        ];
        return view('admin.warehousing.edit', $data);
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
            $arrProductID     = $request->product_id;
            $arrNameProduct   = $request->nameproduct;
            $arrQuantity      = $request->quantity;
            $listID = implode(',', $arrProductID);
            
            $warehousing  = new WareHousing();
            $warehousing->cate = $request->cate;
            $warehousing->id_product = $listID;
            $warehousing->type = $request->type;
            $warehousing->order_id = $request->order_id;
            $warehousing->status = $request->status;
            $warehousing->note = $request->note;
            $warehousing->name = $request->name;
            $warehousing->email = $request->email;
            $warehousing->phone = $request->phone;
            $warehousing->id_kho = $request->id_kho;
            $warehousing->addpress = $request->addpress;
            $warehousing->provinceid = $request->t;
            $warehousing->districtid = $request->q;
            $warehousing->author_id = Auth::user()->id;
            $warehousing->save();
            $strWareHousingID       = $warehousing->id;
            $data['code'] = 'QKH-' . $warehousing->id_kho . '-' . $strWareHousingID;
            $warehousing->update($data);
            foreach ($arrProductID as $key => $ProductID) {
                if($request->status == 2) {
                    // add inventory to product
                    $arrProduct = Product::find($ProductID);
                    if($request->cate == "issue"){
                        $inventory = $arrProduct->inventory_num - $arrQuantity[$key];
                    } elseif($request->cate == "receipt") {
                        $inventory = $arrProduct->inventory_num + $arrQuantity[$key];
                    }
                    $arrProduct->inventory_num = $inventory;
                    $arrProduct->save();
                }
                // add detail
                $WareHousingDetail                = new WareHousingDetail();
                $WareHousingDetail['id_io'] = $strWareHousingID;
                $WareHousingDetail['idproduct']   = $ProductID;
                $WareHousingDetail['nameproduct']   = $arrNameProduct[$key];
                $WareHousingDetail['quantity'] = $arrQuantity[$key];
                $WareHousingDetail->save();
            }
        }
        catch(\Exception $e){
            DB::rollback();
            return redirect('admin/warehousing/')->with(['flash_level' => 'danger', 'flash_message' => 'Lưu không thành công']);
        }
            DB::commit();
            return redirect('admin/warehousing/')->with(['flash_level' => 'success', 'flash_message' => 'Lưu thành công']);
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
        $province = Province::get();
        $district = District::get();
        $wareHouses = User::select('users.*','ware_houses.id as ware_houses_id','ware_houses.level as level')
            ->leftjoin('role_user','role_user.user_id','=','users.id')
            ->leftjoin('ware_houses','ware_houses.user_id','=','users.id')
            ->where('role_user.role_id',4)
            ->orderBy('id','DESC')
            ->get();
        $strUserID = Auth::user()->id;
        if (Auth::user()->hasRole('kho')){
            $products = Product::where('kho', $strUserID)
                ->where('status', 1)
                ->get();
        }
        else {
            $products = Product::where('status', 1)->get();
        }
        $arrProduct = WareHousing::select('input_output.*','input_output_detail.*', 'products.code as productCode')
                        ->leftjoin('input_output_detail', 'input_output_detail.id_io', '=', 'input_output.id')
                        ->leftjoin('products', 'input_output_detail.idproduct', 'products.id')
                        ->where('input_output.id', $id)
                        ->get();
        foreach ($arrProduct as $key => $itemPro) {
            $cate = $itemPro->cate;
        }
        if (Auth::user()->hasRole('kho')){
            $arrOrder = Order::where('kho_id', $strUserID)
                ->where('status', '<', 9)
                ->where('deleted', 0)
                ->get();
        }
        else {
            $arrOrder = Order::where('status', '<', 9)->where('deleted', 0)->get();
        }
        $data = [
            'id'         => $id,
            'cate'       => $cate,
            'arrProduct' => $arrProduct,
            'products'   => $products,
            'arrOrder'   => $arrOrder,
            'province'   => $province,
            'district'   => $district,
            'wareHouses' => $wareHouses,
        ];
        // dd($arrProduct);
        return view('admin.warehousing.edit', $data);
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
            $arrNameProduct   = $request->nameproduct;
            $arrQuantity      = $request->quantity;
            $listID = implode(',', $arrProductID);

            $warehousing       = WareHousing::find($id);
            $statusOld         = $warehousing->status;
            $warehousing->cate = $request->cate;
            $warehousing->id_product = $listID;
            $warehousing->type = $request->type;
            $warehousing->order_id = $request->order_id;
            $warehousing->status = $request->status;
            $warehousing->note = $request->note;
            $warehousing->name = $request->name;
            $warehousing->email = $request->email;
            $warehousing->phone = $request->phone;
            $warehousing->id_kho = $request->id_kho;
            $warehousing->addpress = $request->addpress;
            $warehousing->provinceid = $request->t;
            $warehousing->districtid = $request->q;
            // $warehousing->author_id = Auth::user()->id;
            $warehousing->save();
            $strInventoryID   = $warehousing->id;
            if($statusOld != 2) {
                //remove data of inventory_detail 
                $WareHousingDetail = WareHousingDetail::where('id_io','=', $id);
                $WareHousingDetail->delete();
            }
            foreach ($arrProductID as $key => $ProductID) {
                if( $statusOld != 2 && $request->status == 2) {
                    // add inventory to product
                    $arrProduct = Product::find($ProductID);
                    if($request->cate == "issue"){
                        $inventory = $arrProduct->inventory_num - $arrQuantity[$key];
                    } elseif($request->cate == "receipt") {
                        $inventory = $arrProduct->inventory_num + $arrQuantity[$key];
                    }
                    $arrProduct->inventory_num = $inventory;
                    $arrProduct->save();
                }
                if( $statusOld == 2 && $request->status == 3) {
                    //  update inventory if cancel
                    $arrProduct = Product::find($ProductID);
                    if($request->cate == "issue"){
                        $inventory = $arrProduct->inventory_num + $arrQuantity[$key];
                    } elseif($request->cate == "receipt") {
                        $inventory = $arrProduct->inventory_num - $arrQuantity[$key];
                    }
                    $arrProduct->inventory_num = $inventory;
                    $arrProduct->save();
                }
                if($statusOld != 2) {
                    //add detail
                    $WareHousingDetail                = new WareHousingDetail();
                    $WareHousingDetail['id_io']       = $id;
                    $WareHousingDetail['idproduct']   = $ProductID;
                    $WareHousingDetail['nameproduct'] = $arrNameProduct[$key];
                    $WareHousingDetail['quantity']    = $arrQuantity[$key];
                    $WareHousingDetail->save();
                }
            }
        }
        catch(\Exception $e){
            DB::rollback();
            return redirect('admin/warehousing/')->with(['flash_level' => 'danger', 'flash_message' => 'Lưu không thành công']);
        }
            DB::commit();
            return redirect('admin/warehousing/')->with(['flash_level' => 'success', 'flash_message' => 'Lưu thành công']);
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
        $warehousing        = WareHousing::find($id);
        $warehousing_detail = WareHousingDetail::where('id_io','=', $id);
        $warehousing->update($data);
        $warehousing_detail->update($data);

        $check = WareHousing::where('id', $id)->where('deleted', 0)->get();
        $check1 = WareHousingDetail::where('id', $id)->where('deleted', 0)->get();
        if(count($check) == 0 && count($check1) == 0) {
            return redirect('admin/warehousing/')->with(['flash_level' => 'success', 'flash_message' => 'Xóa thành công']);
        }
        else{
            return redirect('admin/warehousing/')->with(['flash_level' => 'success', 'flash_message' => 'Chưa được xóa']);
        }
    }
}
