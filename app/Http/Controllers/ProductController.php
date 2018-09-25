<?php

namespace App\Http\Controllers;

use App\CategoryProduct;
use App\DetailImageProduct;
use App\Http\Requests\ProductRequest;
use App\Notification;
use App\Product;
use App\ProductUpdatePrice;
use App\User;
use App\WareHouse;
use App\ProductOrder;
use App\Util;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class ProductController extends Controller
{

    /**
     * ajax update
     */
    public function UpdateProductAjax(Request $request)
    {
        $id                 = $request->get('id');
        $product            =  Product::find($id);
        $data['product_id'] = $id;
        $data['price_in']   = $request->get('price_in');
        $data['number']     = $request->get('number');
        if(empty($request->get('supplier'))) {
            $supplier = "none";
        }
        else{
            $supplier = $request->get('supplier');
        }
        $data['supplier']       = $supplier;
        ProductUpdatePrice::create($data);
        $data1['price_in']      = $request->get('price_in');
        $data1['inventory_num'] = $data['number'] + $product->inventory_num;
        $product->update($data1);
        $response = array(
            'status' => 'success',
            'msg' => 'Setting created successfully',
        );
        return \Response::json($response);
    }
    /**
     * ajax update
     */
    public function UpdateProductHistoryInput(Request $request)
    {
        $id                 = $request->get('id');
        $historyID          = $request->get('historyid');
        $numberold          = $request->get('numberold');
        $product            =  Product::find($id);
        $productprice       =  ProductUpdatePrice::find($historyID);
        $data['product_id'] = $id;
        $data['price_in']   = $request->get('price_in');
        $data['number']     = $request->get('number');
        if(empty($request->get('supplier'))) {
            $supplier = "none";
        }
        else{
            $supplier = $request->get('supplier');
        }
        $data['supplier']       = $supplier;
        $productprice->update($data);
        $data1['price_in']      = $request->get('price_in');
        $data1['inventory_num'] = $data['number'] + $product->inventory_num-$numberold;
        $product->update($data1);
        $response = array(
            'status' => 'success',
            'msg' => 'Setting created successfully',
        );
        return \Response::json($response);
    }

    public function checkProductAjax(Request $request)
    {
        $id                     = $request->get('id');
        $product                = Product::find($id);
        $data1['inventory_num'] = $request->get('num');
        $data1['id']            = $request->get('id');
        $product->update($data1);
        $response = array(
            'status' => 'success',
            'msg' => 'Setting created successfully',
        );
        return \Response::json($response);
    }
    public function AjaxGetProduct(Request $request){
        $id       = $request->get('id');
        $product  = Product::find($id);
        $response = array(
            'image'         => $product->image,
            'name'          => $product->title,
            'price'         => $product->price_out,
            'code'          => $product->code,
            'inventory_num' => $product->inventory_num,
        );
        return \Response::json($response);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->get('name') || $request->get('kho')|| $request->get('category')){
            $name     = $request->get('name');
            $kho      = $request->get('kho');
            $cate     = $request->get('category');
            $product1 = Product::query();
            if(!empty($name)){
                if(!Auth::user()->hasRole('kho'))
                    $product1 =  $product1->where('title','LiKE','%'.$name.'%')->where('deleted', 0);
                else {
                    $product1 =  $product1->where('title','LiKE','%'.$name.'%')->where('deleted', 0)->where('kho', Auth::user()->id);
                }
            }
            if(!empty($cate)){
                if(!Auth::user()->hasRole('kho'))
                    $product1 =  $product1->where('category',$cate)->where('deleted', 0);
                else {
                    $product1 =  $product1->where('category',$cate)->where('deleted', 0)->where('kho',Auth::user()->id);
                }
            }
            if(!empty($kho)){
                if(!Auth::user()->hasRole('kho'))
                    $product1 =  $product1->where('kho',$kho)->where('deleted', 0);
                else {
                    $product1 =  $product1->where('kho',Auth::user()->id)->where('deleted', 0);
                }
            }
            $product = $product1->paginate(9);
        }
        else if(!Auth::user()->hasRole('kho')) {
            $product = Product::orderBy('id', 'DESC')
                ->where('deleted', 0)
                ->paginate(9);
        }
        else {
            $product = Product::orderBy('id','DESC')
                ->where('deleted', 0)
                ->where('kho', Auth::user()->id)
                ->paginate(9);
        }
        $category = CategoryProduct::where('disable',0)->get();
        $wareHouses = User::select('users.*','ware_houses.id as ware_houses_id','ware_houses.level as level')
            ->leftjoin('role_user','role_user.user_id','=','users.id')
            ->leftjoin('ware_houses','ware_houses.user_id','=','users.id')
            ->where('role_user.role_id',4)
            ->orderBy('id','DESC')
            ->get();
        $data = [
            'product'   => $product,
            'wareHouses'=> $wareHouses,
            'category'  => $category,
            'type'      => 'products',
        ];
        return view('admin.products.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category   = CategoryProduct::where('disable',0)->get();
        $wareHouses = User::select('users.*','ware_houses.id as ware_houses_id','ware_houses.level as level')
            ->leftjoin('role_user','role_user.user_id','=','users.id')
            ->leftjoin('ware_houses','ware_houses.user_id','=','users.id')
            ->where('role_user.role_id',4)
            ->orderBy('id','DESC')
            ->get();
        $data = [
            'category'   => $category,
            'wareHouses' => $wareHouses
        ];
        return view('admin.products.edit',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $strKho                   = $request->get('kho');
        $countProductOfKhoByLevel = Product::checkCountProductByLevelKho($strKho);
        if ($countProductOfKhoByLevel == 1) {
            $today   = date("Y-m-d_H-i-s");
            $product = new Product;
            $data    = $request->all();
            if(!empty(Auth::user()->id)) {
                $data['author_id'] = Auth::user()->id;
            }
            else{
                $data['author_id'] = 1;
            }

            if ($request->hasFile('image')) {
                $data['image']  = Util::saveFile($request->file('image'), '');
            }

            if (!empty($request->get('slug_seo'))) {
                $data['slug']  = Util::builtSlug($request->get('slug_seo'));
            }
            else{
                $data['slug']  = Util::builtSlug($request->get('title'));
            }
            $checkSlug = Product::where('slug', $data['slug'])->count();
            if($checkSlug != 0){
                $data['slug'] =  $data['slug'].'-'.$today;
            }
            $data['price_sale']      = $request->get('price_sale');

            $product1                = Product::create($data);
            
            $data['code']            = Util::ProductCode($product1->id);
            $product1->update($data);

            $dataPrice['product_id'] = $product1->id;
            $dataPrice['price_in']   = $request->get('price_in');
            $dataPrice['price_out']  = $request->get('price_out');
            $dataPrice['price_sale'] = $request->get('price_sale');
            $dataPrice['supplier']   = "create";
            $dataPrice['number']     = $request->get('inventory_num');
            ProductUpdatePrice::create($dataPrice);

            $userID = Auth::user()->id;
            if (Auth::user()->hasRole('kho')) {
                $getCodeKho                         = Util::UserCode($userID);
                $dataNotify['keyname']              = Util::$newproduct;
                $dataNotify['title']                = "Sản phẩm mới";
                $dataNotify['content']              = "Chủ kho ".$getCodeKho." vừa đăng sản phẩm mới.";
                $dataNotify['author_id']            = $userID;
                $dataNotify['orderID_or_productID'] = $product1->id;
                $dataNotify['link']                 = '/admin/products/'.$product1->id.'/edit';
                foreach (Util::getIdUserOfRole(Util::$roleviewAdmin) as $itemUser) {
                    $dataNotify['roleview'] = $itemUser;
                    $notify                 = Notification::create($dataNotify);
                    $message                = 'OK';
                    if(isset($message)) {
                        $redis = Redis::connection();
                        $redis->publish("messages", json_encode(array(
                            "status"     => 200,
                            "id"         => $product1->id,  
                            "notifyID"   => $notify->id,
                            "roleview"   => $itemUser,
                            "title"      => "Sản phẩm mới",
                            "link"       => "/admin/products/".$product1->id."/edit",
                            "content"    => "Chủ kho ".$getCodeKho." vừa đăng sản phẩm mới.",
                            "created_at" => date('Y-m-d H:i:s')
                        )));
                    }
                }
            }

            $dataImage['product_id']=$product1->id;
            if(!empty($request->file('image_detail'))) {
                foreach ($request->file('image_detail') as $image_detail) {
                    $imageDetail = new DetailImageProduct();
                    $dataImage['image'] = Util::saveFile($image_detail, '');
                    DetailImageProduct::create($dataImage);
                }
            }
            return redirect('admin/products/')->with(['flash_level' => 'success', 'flash_message' => 'Tạo thành công']);
        }
        else {
            return redirect('admin/products/')->with(['flash_level' => 'danger', 'flash_message' => 'Đã quá số sản phẩm cho phép, vui lòng nâng cấp kho để có thể đăng nhiều sản phẩm !!!']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $product = Product::find($id);
        $data    = [
            'id'      => $id,
            'product' => $product,
        ];
        return view('admin.products.edit',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   $category    = CategoryProduct::where('disable',0)->get();
        $product     = Product::find($id);
        $detailImage = DetailImageProduct::where('product_id',$id)->get();
        $wareHouses  = User::select('users.*','ware_houses.id as ware_houses_id','ware_houses.level as level')
            ->leftjoin('role_user','role_user.user_id','=','users.id')
            ->leftjoin('ware_houses','ware_houses.user_id','=','users.id')
            ->where('role_user.role_id',4)
            ->orderBy('id','DESC')
            ->get();
        $data=[
            'id'          => $id,
            'product'     => $product,
            'category'    => $category,
            'detailImage' => $detailImage,
            'wareHouses'  => $wareHouses
        ];
        //dd($wareHouses);
        return view('admin.products.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $id)
    {
        $today   = date("Y-m-d_H-i-s");
        $data    = $request->all();
        $product =  Product::find($id);
        if(!empty(Auth::user()->id)) {
            $data['author_id'] = Auth::user()->id;
        }
        else{
            $data['author_id'] = 1;
        }

        if ($request->hasFile('image')) {
            $data['image']  = Util::saveFile($request->file('image'), '');
        }
        if ($request->get('slug_seo')!="") {
            $data['slug']  = Util::builtSlug($request->get('slug_seo'));
        }
        else{
            $data['slug']  = Util::builtSlug($request->get('title'));
        }
        $checkSlug = Product::where('slug', $data['slug'])->count();
        if($checkSlug != 0){
            $data['slug'] =  $data['slug'].'-'.$today;
        }
        if (($product->status == 0) && $request->get('status') == 1){
            $getCodeProduct                     = Util::ProductCode($product->id);
            $dataNotify['keyname']              = Util::$newproductSuccess;
            $dataNotify['title']                = "Sản phẩm mới";
            $dataNotify['content']              = "Sản phẩm ".$getCodeProduct." đã được duyệt.";
            $dataNotify['author_id']            = Auth::user()->id;
            $dataNotify['orderID_or_productID'] = $product->id;
            $dataNotify['roleview']             = $product->kho;
            $dataNotify['link']                 = '/admin/products/'.$product->id.'/edit';
            $notify                             = Notification::create($dataNotify);
            $message                            = 'OK';
            if(isset($message)) {
                $redis = Redis::connection();
                $redis->publish("messages", json_encode(array(
                    "status"     => 200,
                    "id"         => $product->id, 
                    "roleview"   => $product->kho, 
                    "notifyID"   => $notify->id,
                    "title"      => "Sản phẩm mới",
                    "link"       => "/admin/products/".$product->id."/edit",
                    "content"    => "Sản phẩm ".$getCodeProduct." đã được duyệt.",
                    "created_at" => date('Y-m-d H:i:s')
                )));
            }
        }
        $data['price_sale']      = $request->get('price_sale');
        $product->update($data);
        $dataPrice['product_id'] = $id;
        $dataPrice['price_in']   = $request->get('price_in');
        $dataPrice['price_out']  = $request->get('price_out');
        $dataPrice['price_sale'] = $request->get('price_sale');
        $dataPrice['supplier']   = "create";
        $dataPrice['number']     = 0;
        ProductUpdatePrice::create($dataPrice);
        $dataImage['product_id'] = $id;
        if(!empty($request->file('image_detail'))) {
            foreach ($request->file('image_detail') as $key => $image_detail) {
                $imageDetail        = new DetailImageProduct();
                $dataImage['image'] = Util::saveFile($image_detail, '');
                DetailImageProduct::create($dataImage);
            }
        }
        return redirect('admin/products/')->with(['flash_level' => 'success', 'flash_message' => 'Lưu thành công']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $check = ProductOrder::checkProductHasOrder($id);
        if ($check == 0) {
            $product =  Product::destroy($id);
        } else {
            return redirect()->back()->with(['flash_level' => 'danger', 'flash_message' => 'Sản phẩm này đang có đơn hàng, nên không thể xóa']);
        }
        if(!empty($product)) {
            return redirect('admin/products/')->with(['flash_level' => 'success', 'flash_message' => 'Xóa thành công']);
        }
        else{
            return redirect('admin/products/')->with(['flash_level' => 'danger', 'flash_message' => 'Chưa thể xóa']);
        }
    }
    public function deleteDetailImage(Request $request)
    {
        DetailImageProduct::where('id', $request->get('id'))->delete();
        $response = array(
            'status' => 'success',
            'msg' => 'Setting created successfully',
        );
        return \Response::json($response);
    }
}
