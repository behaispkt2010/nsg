<?php

namespace App\Http\Controllers\Frontend;

use App\CategoryProduct;
use App\DetailImageProduct;
use App\Mail\OrderInfo;
use App\Order;
use App\OrderStatus;
use App\Product;
use App\ProductOrder;
use App\Rate;
use App\User;
use App\WareHouse;
use App\BankWareHouse;
use App\NewsCompany;
use App\Events\ViewsProductEvents;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;

class ProductController extends Controller
{

    public function index(Request $request){
        if(!empty($request->get('q'))){
            if($request->get('q')=="ten-san-pham") {
                $products = Product::leftjoin('ware_houses','ware_houses.user_id','products.kho')
                    ->leftjoin('users','users.id','ware_houses.user_id')
                    ->where('products.status',1)
                    ->selectRaw('products.*')
                    ->selectRaw('ware_houses.id as idKho, ware_houses.confirm_kho as confirmkho, ware_houses.name_company as nameKho, ware_houses.level as levelKho')
                    ->orderBy('title', 'DESC')
                    ->paginate(20);
            }
            elseif($request->get('q')=="moi-nhat") {
                $products = Product::leftjoin('ware_houses','ware_houses.user_id','products.kho')
                    ->leftjoin('users','users.id','ware_houses.user_id')
                    ->where('products.status',1)
                    ->selectRaw('products.*')
                    ->selectRaw('ware_houses.id as idKho, ware_houses.confirm_kho as confirmkho, ware_houses.name_company as nameKho, ware_houses.level as levelKho')
                    ->orderBy('id', 'DESC')
                    ->paginate(20);
            }
            elseif($request->get('q')=="cap-kho") {
                $products = Product::leftJoin('ware_houses','products.kho','ware_houses.user_id')
                    ->leftjoin('users','users.id','ware_houses.user_id')
                    ->where('products.status',1)
                    ->selectRaw('products.*')
                    ->selectRaw('ware_houses.id as idKho, ware_houses.confirm_kho as confirmkho, ware_houses.name_company as nameKho, ware_houses.level as levelKho')
                    ->orderBy('ware_houses.level', 'DESC')
                    ->paginate(20);
            }
            elseif($request->get('q')=="gia") {
                $products = Product::leftjoin('ware_houses','ware_houses.user_id','products.kho')
                    ->leftjoin('users','users.id','ware_houses.user_id')
                    ->where('products.status',1)
                    ->selectRaw('products.*')
                    ->selectRaw('ware_houses.id as idKho, ware_houses.confirm_kho as confirmkho, ware_houses.name_company as nameKho, ware_houses.level as levelKho')
                    ->orderBy('price_out', 'ASC')
                    ->paginate(20);
            }

        }
        else {
            $products = Product::leftjoin('ware_houses','ware_houses.user_id','products.kho')
                ->leftjoin('users','users.id','ware_houses.user_id')
                ->where('products.status',1)
                ->selectRaw('products.*')
                ->selectRaw('ware_houses.id as idKho, ware_houses.confirm_kho as confirmkho, ware_houses.name_company as nameKho, ware_houses.level as levelKho')
                ->paginate(20);
        }
        $data =[
          "products"=>$products,
        ];
        return view('frontend.product',$data);

    }

    public function CateProduct($cate){
        
        $cate = CategoryProduct::where('slug',$cate)->first();

        $products = Product::where('category',$cate->id)
            ->leftJoin('ware_houses','products.kho','=','ware_houses.user_id')
            ->where('products.status',1)
            ->selectRaw('products.*')
            ->selectRaw('ware_houses.id as idKho,ware_houses.name_company as nameKho, ware_houses.level as levelKho')
            ->paginate(20);
        // dd($products);
        $data =[
            "products"=>$products,
            "nameCate"=>$cate->name,
            "slugCate"=>$cate->slug,
        ];
        return view('frontend.product',$data);

    }
    public function GetAllCompany(){

        $getAllNewsCompany = NewsCompany::select('users.*', 'company.*', 'news_company.*' , 'company.id as companyID', 'company.confirm as companyConfirm' ,'news_company.id as newscompanyID')
            ->leftjoin('users','users.id','=','news_company.author_id')
            ->leftjoin('company','company.user_id','=','users.id')
            ->where('news_company.status',1)
            ->orderBy('company.confirm','desc')
            ->paginate(120);
        $data =[
            "getAllNewsCompany" => $getAllNewsCompany
        ];
        return view('frontend.company-business',$data);

    }
    public function GetAllWareHouse(){

        $getAllWareHouse = WareHouse::orderBy('level','desc')->paginate(120);

        $data =[
            "getAllWareHouse" => $getAllWareHouse
        ];
        return view('frontend.warehouse-business',$data);

    }
    
    public function GetAllProduct(Request $request){

        if (!empty($request->get('search'))){
            $name = $request->get('search');
            //$cate= $request->get('search');
            // dd($cate);
            $product1 = Product::query();
            if(!empty($name)){
                $product1 =  $product1->where('title','LiKE','%'.$request->get('search').'%');
            }
            // if(!empty($cate)){
            //     $product2 =  $product1->where('category',$request->get('cateSearch'));
            // }
            
            $products = $product1->paginate(16);
            // dd($products);
                $data = [
                    "products" => $products,
                ];
            return view('frontend.productview',$data);
        }

        $getBestStarsProduct = Product::getBestStarsProduct(9);
        $getBestSellerProduct = Product::getBestSellerProduct(10);
        $getNewProduct = Product::getNewProduct(10);
        $allCategory = CategoryProduct::where('parent',0)->get();

        /*$getAllNewsCompany = NewsCompany::leftjoin('users','users.id','=','news_company.author_id')
            ->leftjoin('company','company.user_id','=','users.id')
            ->where('news_company.status',1)
            ->inRandomOrder()
            ->paginate(16);
        $getAllWareHouse = WareHouse::inRandomOrder()->paginate(16);*/

        /*$getVipByCate = WareHouse::getVipByCate(1,3);*/
        // dd($getAllNewsCompany);
        $data = [
            'getNewProduct' =>$getNewProduct,
            'bestSellerProduct'=>$getBestSellerProduct,
            'getBestStarsProduct'=>$getBestStarsProduct,
            'allCategory'=>$allCategory,
            /*'getAllNewsCompany'=>$getAllNewsCompany,
            'getAllWareHouse'=>$getAllWareHouse*/
        ];
        return view('frontend.productview',$data);

    }
    public function SingleProduct($cate,$slug){
        $product=Product::select('products.*','users.name as nameKho','users.phone_number as phoneKho','users.id as idKho','users.address as addressKho','ware_houses.fanpage_fb as fanpage_fb','ware_houses.id as ware_houses_id','ware_houses.level as levelKho','ware_houses.created_at as ware_houses_Create','users.name as nameKho')
            ->leftJoin('users','users.id','=','products.kho')
            ->leftJoin('ware_houses','users.id','=','ware_houses.user_id')
            ->where('slug',$slug)
            ->first();
            
        // dd($product);
        $detailImage = DetailImageProduct::where('product_id',$product->id)->get();
        $data=[
            "product"       =>$product,
            "detailImage"   =>$detailImage
        ];
        event(new ViewsProductEvents($product));
        return view('frontend.product-single',$data);

    }
    public function checkOrder(Request $request){

        $code = $request->get('code-order');
        $order =Order::where('id',$code)->first();
        if(count($order)!=0) {

            $customer = User::where('id', $order->customer_id)->first();
            $productOrder = ProductOrder::select('product_orders.*','products.image')
            ->leftJoin('products','product_orders.id_product','products.id')
            ->where('product_orders.order_id', $order->id)->get();
            $orderStatus = OrderStatus::get();
            $data = [
                "order" => $order,
                "customer" => $customer,
                "productOrder" => $productOrder,
                "orderStatus"=>$orderStatus,
            ];
            return view('frontend.check-order', $data);
            }
            else{
                return view('frontend.check-order');

            }

    }
    public function singleOrder(Request $request){
        $data = [
            "name" => $request->get('cf_name'),
            "email" => $request->get('cf_email'),
            "phone" => $request->get('cf_order_number'),
            "comment" => $request->get('cf_message'),
                "link" => $request->get('cf_url'),
            "subject" => "Thông tin order"
        ];
        $to = "xtrieu30@gmail.com";
        Mail::to($to)->send(new OrderInfo($data));
        return redirect()->back()->with('success','success');
    }
    public function customerRate(Request $request){
       $price_rate = $request->get('price_rate');
       $value_rate = $request->get('value_rate');
        $quality_rate =  $request->get('quality_rate');
        $rateValue = ($price_rate + $value_rate + $quality_rate)/3;
        $id_product = $request->get('id_product');
        $id_user = $request->get('id_user');
        $check = Rate::where('product_id',$id_product)->where('users_id',$id_user)->first();
        if(count($check)==0) {
            $rate = new Rate();
            $rate->product_id = $id_product;
            $rate->users_id = $id_user;
            $rate->rate = $rateValue;
            $rate->save();
        }
        else{
            return redirect()->back()->with('RateSuccess','error');
        }
        return redirect()->back()->with('RateSuccess','success');
    }

}
