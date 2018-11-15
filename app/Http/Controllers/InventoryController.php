<?php

namespace App\Http\Controllers;

use App\CategoryProduct;
use App\Product;
use App\User;
use App\WareHouse;
use App\Inventory;
use App\InventoryDetail;
use DateTime;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
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
                $dateRes = explode('>',$dateview);
                $start = date_create($dateRes[0]);
                $dateStart = date_format($start ,"Y-m-d H:i:s");
                $end = date_create($dateRes[1]);
                $dateEnd = date_format($end ,"Y-m-d") . ' 23:59:59';
                if(!empty($name)){
                    $inventory =  Inventory::select('inventory.*')
                                ->leftjoin('inventory_detail', 'inventory_detail.idinventory', '=', 'inventory.id')
                                ->where('inventory_detail.nameproduct','LiKE','%'.$name.'%')
                                ->where('inventory.id_kho', $user_id)
                                ->where('inventory.deleted', 0)
                                ->groupBy("inventory.id")
                                ->paginate(9);
                }
                if(!empty($dateview)){
                    $inventory =  Inventory::select('inventory.*')
                                ->leftjoin('inventory_detail', 'inventory_detail.idinventory', '=', 'inventory.id')
                                ->whereBetween('inventory.created_at', array($dateStart, $dateEnd))
                                ->where('inventory.id_kho', $user_id)->where('inventory.deleted', 0)
                                ->groupBy(DB::raw("DATE(inventory.created_at)"))
                                ->groupBy("inventory.id")
                                ->paginate(9);
                }
            }
            else {
                $inventory = Inventory::select('inventory.*')
                    ->leftjoin('inventory_detail', 'inventory_detail.idinventory', '=', 'inventory.id')
                    ->where('inventory.id_kho', $user_id)
                    ->orderBy('inventory.id','DESC')
                    ->groupBy("inventory.id")
                    ->where('inventory.deleted', 0)
                    ->paginate(9);
            }
        } else {
            if($request->get('name') || $request->get('dateview')){
                $name = $request->get('name');
                $dateview = $request->get('dateview');
                $dateRes = explode('>',$dateview);
                $start = date_create($dateRes[0]);
                $dateStart = date_format($start ,"Y-m-d H:i:s");
                $end = date_create($dateRes[1]);
                $dateEnd = date_format($end ,"Y-m-d") . ' 23:59:59';
                if(!empty($name)){
                    $inventory =  Inventory::select('inventory.*')
                                ->leftjoin('inventory_detail', 'inventory_detail.idinventory', '=', 'inventory.id')
                                ->where('inventory_detail.nameproduct','LiKE','%'.$name.'%')
                                ->where('inventory.deleted', 0)
                                ->groupBy("inventory.id")
                                ->paginate(9);
                }
                if(!empty($dateview)){
                    $inventory =  Inventory::select('inventory.*')
                                ->leftjoin('inventory_detail', 'inventory_detail.idinventory', '=', 'inventory.id')
                                ->whereBetween('inventory.created_at', array($dateStart, $dateEnd))
                                ->where('inventory.deleted', 0)
                                ->groupBy(DB::raw("DATE(inventory.created_at)"))
                                ->groupBy("inventory.id")
                                ->paginate(9);
                }
            }
            else {
                $inventory = Inventory::select('inventory.*')
                    ->leftjoin('inventory_detail', 'inventory_detail.idinventory', '=', 'inventory.id')
                    ->orderBy('inventory.id','DESC')
                    ->groupBy("inventory.id")
                    ->where('inventory.deleted', 0)
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
            'inventorys'  => $inventory,
            'wareHouses'=> $wareHouses,
        ];
        return view('admin.inventory.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
        $data = [
            'products'     => $products,
            'wareHouses'   => $wareHouses,

        ];
        return view('admin.inventory.edit', $data);
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
            $arrInventoryNum  = $request->inventory_num;
            $arrInventoryReal = $request->inventory_real;
            
            $listID = implode(',', $arrProductID);
            $inventory  = new Inventory();
            $inventory->id_product = $listID;
            $inventory->status = $request->status;
            $inventory->note   = $request->note;
            $inventory->id_kho = $request->id_kho;
            $inventory->author_id = Auth::user()->id;
            $inventory->save();
            $strInventoryID           = $inventory->id;
            $data['code'] = 'QLK-' . $inventory->id_kho . '-' . $strInventoryID;
            $inventory->update($data);
            foreach ($arrProductID as $key => $ProductID) {
                // update product
                if($request->status == 2) { // hòan thành
                    // add inventory to product
                    $arrProduct = Product::find($ProductID);
                    $inventory = $arrInventoryReal[$key];
                    $arrProduct->inventory_num = $inventory;
                    $arrProduct->save();
                }
                // add detail
                $InventoryDetail                = new InventoryDetail();
                $InventoryDetail['idinventory'] = $strInventoryID;
                $InventoryDetail['idproduct']   = $ProductID;
                $InventoryDetail['nameproduct']   = $arrNameProduct[$key];
                $InventoryDetail['inventory_num'] = $arrInventoryNum[$key];
                $InventoryDetail['inventory_real'] = $arrInventoryReal[$key];
                $InventoryDetail->save();
            }
        }
        catch(\Exception $e){
            DB::rollback();
            return redirect('admin/inventory/create')->with(['flash_level' => 'danger', 'flash_message' => 'Lưu không thành công']);
        }
            DB::commit();
            return redirect('admin/inventory/')->with(['flash_level' => 'success', 'flash_message' => 'Lưu thành công']);
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
        $arrProduct = Inventory::select('inventory.*','inventory_detail.*', 'products.code as productCode')
                        ->leftjoin('inventory_detail', 'inventory_detail.idinventory', '=', 'inventory.id')
                        ->leftjoin('products', 'inventory_detail.idproduct', 'products.id')
                        ->where('inventory.id', $id)
                        ->get();
        foreach ($arrProduct as $key => $value) {
            $code = $value['code'];
        }                
        $data = [
            'id'         => $id,
            'code'       => $code,
            'arrProduct' => $arrProduct,
            'products'   => $products,
            'wareHouses' => $wareHouses,

        ];
        // dd($arrProduct);
        return view('admin.inventory.edit', $data);
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
            $arrInventoryNum  = $request->inventory_num;
            $arrInventoryReal = $request->inventory_real;
            $listID = implode(',', $arrProductID);

            $inventory        = Inventory::find($id);
            $statusOld        = $inventory->status;
            $inventory->id_product = $listID;
            $inventory->status = $request->status;
            $inventory->note   = $request->note;
            $inventory->id_kho = $request->id_kho;
            $inventory->author_id = Auth::user()->id;
            $inventory->save();
            $strInventoryID   = $inventory->id;
            if($statusOld != 2) {
                //remove data of inventory_detail 
                $inventory_detail = InventoryDetail::where('idinventory','=', $id);
                $inventory_detail->delete();
            }
            foreach ($arrProductID as $key => $ProductID) {
                if( $statusOld != 2 && $request->status == 2) { // hòan thành
                    // add inventory to product
                    $arrProduct = Product::find($ProductID);
                    $inventory = $arrInventoryReal[$key];
                    $arrProduct->inventory_num = $inventory;
                    $arrProduct->save();
                }
                if($statusOld != 2) {
                    // add detail
                    $InventoryDetail                = new InventoryDetail();
                    $InventoryDetail['idinventory'] = $id;
                    $InventoryDetail['idproduct']   = $ProductID;
                    $InventoryDetail['nameproduct']   = $arrNameProduct[$key];
                    $InventoryDetail['inventory_num'] = $arrInventoryNum[$key];
                    $InventoryDetail['inventory_real'] = $arrInventoryReal[$key];
                    $InventoryDetail->save();
                }
            }
        }
        catch(\Exception $e){
            DB::rollback();
            return redirect('admin/inventory/')->with(['flash_level' => 'danger', 'flash_message' => 'Lưu không thành công']);
        }
            DB::commit();
            return redirect('admin/inventory/')->with(['flash_level' => 'success', 'flash_message' => 'Lưu thành công']);
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
        
        $check1 = InventoryDetail::where('idinventory', $id)->where('deleted', 0)->get();
        if(count($check) == 0 && count($check1) == 0) {
            return redirect('admin/inventory/')->with(['flash_level' => 'success', 'flash_message' => 'Xóa thành công']);
        }
        else{
            return redirect('admin/inventory/')->with(['flash_level' => 'danger', 'flash_message' => 'Chưa được xóa']);
        }
    }
}
