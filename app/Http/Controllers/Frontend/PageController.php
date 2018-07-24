<?php

namespace App\Http\Controllers\Frontend;

use App\CategoryWarehouse;
use App\Mail\Contact;
use App\Mail\OrderInfo;
use App\Notification;
use App\Util;
use App\WareHouse;
use App\Product;
use App\Order;
use App\User;
use App\Events\ViewsCompanyEvents;
use App\Events\ViewsWareHouseEvents;
use App\CompanyImage;
use App\NewsCompany;
use App\Company;
use App\WarehouseImageDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;

class PageController extends Controller
{
    public function Contact(){

//        if(!empty(Request::isMethod('post'))) {
//
//            $data = [
//                "name" => $request->get('cf_name'),
//                "email" => $request->get('cf_email'),
//                "phone" => $request->get('cf_order_number'),
//                "comment" => $request->get('cf_message'),
//                "link" => "từ trang liên hệ",
//                "subject" => "Khách hàng cần tư vấn"
//            ];
//            $to = "xtrieu30@gmail.com";
//            Mail::to($to)->send(new OrderInfo($data));
//        }
        return view('frontend.contact');
    }
    public function PostContact(Request $request){
        $data = [
            "name" => $request->get('cf_name'),
            "email" => $request->get('cf_email'),
            "phone" => $request->get('cf_order_number'),
            "comment" => $request->get('cf_message'),
            "subject" => "Khách hàng cần tư vấn"
        ];
        $to = Util::$mailadmin;
        Mail::to($to)->send(new Contact($data));
        $dataNotify['keyname'] = Util::$contact;
        $dataNotify['title'] = "Khách hàng cần được hỗ trợ";
        $dataNotify['content'] = $request->get('cf_name').' .SDT: ' .$request->get('cf_order_number')."cần được hỗ trợ";
        $dataNotify['author_id'] = 1;
        $dataNotify['link'] = "#";
        foreach (Util::getIdUserOfRole(Util::$roleviewAdmin) as $itemUser) {
            $dataNotify['roleview'] = $itemUser;
            Notification::create($dataNotify);
            $message = 'OK';
            if(isset($message)) {
                $redis = Redis::connection();
                $redis->publish("messages", json_encode(array(
                    "status" => 200,
                    "roleview"=> $itemUser,
                    "title" => "Khách hàng cần được hỗ trợ",
                    "link" => "#",
                    "content" => $request->get('cf_name').' .SDT: ' .$request->get('cf_order_number')."cần được hỗ trợ.",
                    "created_at" => date('Y-m-d H:i:s')
                )));
            }
        }
        return redirect('/contact')->with('success','success');
    }
    public function GetResisterWareHouse(){
        /*$userID = Auth::user()->id;
        $arrGetUser = User::find($userID);
        $data = [
            'arrGetUser' => $arrGetUser,
        ];*/
        // return view('frontend.resisterWareHouse', $data);
        return view('frontend.resisterWareHouse');
    }
    public function PostResisterWareHouse(Request $request){
        $data = [
            "name" => $request->get('cf_name'),
            "refferalcode" => $request->get('cf_refferalcode'),
            "email" => $request->get('cf_email'),
            "phone" => $request->get('cf_order_number'),
            "comment" => $request->get('cf_message'),
            "subject" => "Khách hàng cần đăng ký Chủ kho"
        ];
        $to = Util::$mailadmin;
        $dataNotify['keyname'] = Util::$dangkychukho;
        $dataNotify['title'] = "Chủ kho đăng kí mới";
        $dataNotify['content'] = $request->get('cf_name').' .SDT: ' .$request->get('cf_order_number')."cần đăng ký chủ kho với Mã giới thiệu: ".$request->get('cf_refferalcode');
        $dataNotify['author_id'] = 1;
        $dataNotify['link'] = "/admin/warehouse/create";
        foreach (Util::getIdUserOfRole(Util::$roleviewAdmin) as $itemUser) {
            $dataNotify['roleview'] = $itemUser;
            Notification::create($dataNotify);
            $message = 'OK';
            if(isset($message)) {
                $redis = Redis::connection();
                $redis->publish("messages", json_encode(array(
                    "status" => 200,
                    "roleview" => $itemUser,
                    "title" => "Chủ kho đăng kí mới",
                    "link" => "/admin/warehouse/create",
                    "content" => $request->get('cf_name').' .SDT: ' .$request->get('cf_order_number')."cần đăng ký chủ kho với Mã giới thiệu: ".$request->get('cf_refferalcode'),
                    "created_at" => date('Y-m-d H:i:s')
                )));
            }
        }

        Mail::to($to)->send(new Contact($data));
        return redirect('/resisterWareHouse')->with('success','success');
    }
    public function DetailWarehouse($warehouse_id) {
        $arrCategoryWarehouse = CategoryWarehouse::get();
        $arrImageDetail = WarehouseImageDetail::where('warehouse_id',$warehouse_id)->get();
        $getNewProduct = Product::getProductOfWarehouse($warehouse_id,12);
        $warehouse = WareHouse::select('users.*', 'ware_houses.*','ware_houses.address as ware_houses_address')
            ->leftjoin('users','users.id','=','ware_houses.user_id')
            ->where('ware_houses.id',$warehouse_id)
            ->first();
        $order = Order::where('kho_id', $warehouse_id)
            ->where('status',8)
            ->count();  
        // dd ($warehouse);      
        $data = [
            'ware_house' => $warehouse,
            'arrImageDetail' => $arrImageDetail,
            'getNewProduct' => $getNewProduct,
            'arrCategoryWarehouse' => $arrCategoryWarehouse,
            'order' => $order,
        ];
        //dd($getNewProduct);
        event(new ViewsWareHouseEvents($warehouse));
        // dd($warehouse->count_view);
        return view('frontend.warehouse', $data);
    }
    public function DetailCompany($company_id) {
        $arrImageDetail = CompanyImage::where('company_id', $company_id)->get();
        $arrCompany = Company::select('company.*', 'users.*', 'company.address as company_address', 'company.name as name_company')
            ->leftjoin('users','users.id','=','company.user_id')
            ->where('company.id', $company_id)
            ->first();
        $getNewsCompany = NewsCompany::getNewsCompany($company_id, 12); 
        $order = Order::where('customer_id', $arrCompany->user_id)
            ->where('status',8)
            ->count();
        $data = [
            'company' => $arrCompany,
            'arrImageDetail' => $arrImageDetail,
            'getNewsCompany' => $getNewsCompany,
            'order' => $order,
        ];
        return view('frontend.company-single', $data);
    }

    public function DetailNewsCompany($newscompanySlug, $company_id, $newscompany_id) {

        $arrImageDetail = CompanyImage::where('company_id', $company_id)->get();
        $arrNewsCompany = NewsCompany::select('users.*','company.*','news_company.*','company.name as namecompany','company.id as companyID','category_products.name as categoryname')
            ->leftjoin('users','users.id','=','news_company.author_id')
            ->leftjoin('company','company.user_id','=','news_company.author_id')
            ->leftjoin('category_products','news_company.category','=','category_products.id')
            ->where('news_company.id', $newscompany_id)
            ->first();

        $category = $arrNewsCompany->category; 
        $idNews = $arrNewsCompany->id;
        $getNewsCompanyRelated = NewsCompany::getAllNewsCompanyRelated($category,$idNews,4);
        $getWareHouseRelated = WareHouse::orderBy('level','desc')->take(4)->get();
        // dd($arrNewsCompany);
        $data = [
            'arrImageDetail' => $arrImageDetail,
            'arrNewsCompany' => $arrNewsCompany,
            'getNewsCompanyRelated' => $getNewsCompanyRelated,
            'getWareHouseRelated' => $getWareHouseRelated,
        ];    
        event(new ViewsCompanyEvents($arrNewsCompany));
        return view('frontend.newscompany-single', $data);   
    }



    public function ConfirmKho(){
        return view('frontend.xacthuckho');
    }
    public function QuangCao(){
        return view('frontend.quangcao');
    }
    public function TraPhi(){
        return view('frontend.dungtraphi');
    }
    public function UpgradeKho(){
        return view('frontend.upgradekho');
    }
    public function Help ($content) {
        if ($content == "dang-ky-chu-kho") {
            return view('frontend.help_resisterwarehouse');
        } elseif ($content == "co-hoi") {
            return view('frontend.help_cohoi');
        } elseif ($content == "van-chuyen") {
            return view('frontend.help_transport');
        }
    }
    public function getWareHouseArea($area) {
        $from = 62;
        $to = 68;
        $title = "Tây Nguyên";
        if ($area == 'tay-nguyen') {
            $from = 62;
            $to = 68;
            $title = "Tây Nguyên";
        } elseif ($area == 'dong-nam-bo') {
            $from = 70;
            $to = 79;
            $title = "Đông Nam Bộ";
        } elseif ($area == 'tay-nam-bo') {
            $from = 80;
            $to = 96;
            $title = "Tây Nam Bộ";
        }
        $getAllWareHouse = WareHouse::select('ware_houses.*')
            ->leftjoin('province','province.provinceid','=','ware_houses.province')
            ->whereBetween('province.provinceid', array($from, $to))
            ->paginate(30);
        // dd($getAllWareHouse);    
        $data =[
            "title" => $title,
            "getAllWareHouse" => $getAllWareHouse
        ];
        return view('frontend.warehouse-level',$data);
    }
    
    public function GetWareHouseByLevel($capdo){
        $level = 1;
        $title = "Thường";
        if ($capdo == 'chuyen-nghiep') {
            $level = 3;
            $title = "Chuyên nghiệp";
        } elseif ($capdo == 'tiem-nang') {
            $level = 2;
            $title = "Tiềm năng";
        } else {
            $level = 1;
            $title = "Thường";
        }
        $getAllWareHouse = WareHouse::where('level', $level)->inRandomOrder()->paginate(30);

        $data =[
            "title" => $title,
            "getAllWareHouse" => $getAllWareHouse
        ];
        return view('frontend.warehouse-level',$data);

    }
    public function SendHelpUser(Request $request){
        $dichvu = $request->get('dichvu');
        if ($dichvu == "nhan_ho_tro_upgrade") $subject = "Khách hàng cần được tư vấn dịch vụ Nâng cấp kho";
        elseif ($dichvu == "nhan_ho_tro_quangcao") $subject = "Khách hàng cần được tư vấn dịch vụ Quảng cáo";
        elseif ($dichvu == "nhan_ho_tro_confirm") $subject = "Khách hàng cần được tư vấn dịch vụ Xác thực kho";
        
        $data = [
            "name" => $request->get('name_user'),
            "email" => "",
            "refferalcode" => "",
            "phone" => $request->get('phone_user'),
            "subject" => $subject,
            "comment" => $subject
        ];
        $to = Util::$mailadmin;
        Mail::to($to)->send(new Contact($data));
        $dataNotify['keyname'] = Util::$contact;
        $dataNotify['title'] = "Khách hàng cần được hỗ trợ";
        $dataNotify['content'] = $subject. ' : ' .$request->get('name_user').' .SDT: ' .$request->get('phone_user');
        $dataNotify['author_id'] = 1;
        $dataNotify['link'] = "#";
        foreach (Util::getIdUserOfRole(Util::$roleviewAdmin) as $itemUser) {
            $dataNotify['roleview'] = $itemUser;
            Notification::create($dataNotify);
            $message = 'OK';
            if(isset($message)) {
                $redis = Redis::connection();
                $redis->publish("messages", json_encode(array(
                    "status" => 200,
                    "roleview" => $itemUser,
                    "title" => "Khách hàng cần được hỗ trợ",
                    "link" => "#",
                    "content" => $subject. ' : ' .$request->get('name_user').' .SDT: ' .$request->get('phone_user'),
                    "created_at" => date('Y-m-d H:i:s')
                )));
            }
        }
        return redirect('/')->with('success','success');
    }
}
