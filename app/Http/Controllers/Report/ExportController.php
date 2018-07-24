<?php
namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use App\Order;
use App\OrderStatus;
use App\Product;
use App\ProductOrder;
use App\Province;
use App\Company;
use App\User;
use App\Role;
use App\Driver;
use DateTime;
use App\RoleUser;
use App\ProductUpdatePrice;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;

class ExportController extends Controller 
{
	public function getExportOrders(Request $request)
    {
    	$author_id = Auth::user()->id;
        if($request->get('q')){
            $q = $request->get('q');
            if(Auth::user()->hasRole(['kho'])) {
                $arrAllOrders = Order::leftJoin('users', 'orders.customer_id', '=', 'users.id')
                    ->leftjoin('province', 'province.provinceid', '=', 'users.province')
                    ->selectRaw('orders.id as ID, users.name as Người_Nhận, users.phone_number as SDT, orders.time_order as Thời_gian_đặt_hàng, orders.note as Chú_thích, orders.type_pay as Hình_thức_thanh_toán, orders.status_pay as Trạng_thái_thanh_toán, orders.received_pay as Đã_nhận, orders.remain_pay as Còn_lại, orders.type_driver as Hình_thức_vận_chuyển, orders.name_driver as Tài_xế, orders.phone_driver as SDT_Tài_xế, orders.number_license_driver as Biển_số_xe, users.address as Địa_Chỉ_Giao_Hàng, province.name as Tỉnh_TP')
                    ->where('kho_id', $author_id)
                    ->where('users.name', 'LIKE', '%' . $q . '%')
                    ->orwhere('users.phone_number', 'LIKE', '%' . $q . '%')
                    ->orderBy('orders.id','DESC')
                    ->get();
            }
            else{
                $arrAllOrders = Order::leftJoin('users', 'orders.customer_id', '=', 'users.id')
                    ->leftjoin('province', 'province.provinceid', '=', 'users.province')
                    ->selectRaw('orders.id as ID, users.name as Người_Nhận, users.phone_number as SDT, orders.time_order as Thời_gian_đặt_hàng, orders.note as Chú_thích, orders.type_pay as Hình_thức_thanh_toán, orders.status_pay as Trạng_thái_thanh_toán, orders.received_pay as Đã_nhận, orders.remain_pay as Còn_lại, orders.type_driver as Hình_thức_vận_chuyển, orders.name_driver as Tài_xế, orders.phone_driver as SDT_Tài_xế, orders.number_license_driver as Biển_số_xe, users.address as Địa_Chỉ_Giao_Hàng, province.name as Tỉnh_TP')
                    ->where('users.name', 'LIKE', '%' . $q . '%')
                    ->orwhere('users.phone_number', 'LIKE', '%' . $q . '%')
                    ->orderBy('orders.id','DESC')
                    ->get();
            }

        }
        else if ( Auth::user()->hasRole(['kho']) ){
            $arrAllOrders = Order::leftJoin('users', 'orders.customer_id', '=', 'users.id')
                ->leftjoin('province', 'province.provinceid', '=', 'users.province')
                ->selectRaw('orders.id as ID, users.name as Người_Nhận, users.phone_number as SDT, orders.time_order as Thời_gian_đặt_hàng, orders.note as Chú_thích, orders.type_pay as Hình_thức_thanh_toán, orders.status_pay as Trạng_thái_thanh_toán, orders.received_pay as Đã_nhận, orders.remain_pay as Còn_lại, orders.type_driver as Hình_thức_vận_chuyển, orders.name_driver as Tài_xế, orders.phone_driver as SDT_Tài_xế, orders.number_license_driver as Biển_số_xe, users.address as Địa_Chỉ_Giao_Hàng, province.name as Tỉnh_TP')
                ->where('kho_id', $author_id)
                ->orderBy('orders.id','DESC')
                ->get();
        }
        else {
            $arrAllOrders = Order::leftJoin('users', 'orders.customer_id', '=', 'users.id')
                ->leftjoin('province', 'province.provinceid', '=', 'users.province')
                ->selectRaw('orders.id as ID, users.name as Người_Nhận, users.phone_number as SDT, orders.time_order as Thời_gian_đặt_hàng, orders.note as Chú_thích, orders.type_pay as Hình_thức_thanh_toán, orders.status_pay as Trạng_thái_thanh_toán, orders.received_pay as Đã_nhận, orders.remain_pay as Còn_lại, orders.type_driver as Hình_thức_vận_chuyển, orders.name_driver as Tài_xế, orders.phone_driver as SDT_Tài_xế, orders.number_license_driver as Biển_số_xe, users.address as Địa_Chỉ_Giao_Hàng, province.name as Tỉnh_TP')
                ->orderBy('orders.id','DESC')
                ->get();
        }
        $data = $arrAllOrders->toArray();
		return Excel::create('Don_Hang', function($excel) use ($data) {
			$excel->sheet('Đơn hàng', function($sheet) use ($data)
	        {
				$sheet->fromArray($data, NULL, 'A3');
	        });
		})->download('xlsx');
    }
    public function getExportProduct(Request $request) 
    {
    	if($request->get('name') || $request->get('kho')|| $request->get('category')){
            $name = $request->get('name');
            $kho = $request->get('kho');
            $cate = $request->get('category');
            $product1 = Product::query()->leftjoin('category_products', 'category_products.id', '=', 'products.category')
            ->selectRaw('products.id as ID, products.title as Sản_Phẩm, products.gram as Giá_Tính_Theo_Bao_Nhiêu_Kg, products.price_in as Giá_Thu_Vào, products.price_out as Giá_Bán_Ra, products.price_sale as Giá_Khuyến_Mãi, products.min_gram as Bán_Tối_Thiểu, products.inventory_num as Tồn_Kho, products.category as Danh_Mục, products.kho as Chủ_Kho, products.content as Nội_Dung');
            if(!empty($name)){
                if(!Auth::user()->hasRole('kho'))
                    $product1 =  $product1->where('title','LiKE','%'.$name.'%');
                else {
                    $product1 =  $product1->where('title','LiKE','%'.$name.'%')->where('kho',Auth::user()->id);
                }
            }
            if(!empty($cate)){
                if(!Auth::user()->hasRole('kho'))
                    $product1 =  $product1->where('category',$cate);
                else {
                    $product1 =  $product1->where('category',$cate)->where('kho',Auth::user()->id);
                }
            }
            if(!empty($kho)){
                if(!Auth::user()->hasRole('kho'))
                    $product1 =  $product1->where('kho',$kho);
                else {
                    $product1 =  $product1->where('kho',Auth::user()->id);
                }
            }
            $product = $product1->get();;
        }
        else if(!Auth::user()->hasRole('kho')) {
            $product = Product::leftjoin('category_products', 'category_products.id', '=', 'products.category')
            ->selectRaw('products.id as ID, products.title as Sản_Phẩm, products.gram as Giá_Tính_Theo_Bao_Nhiêu_Kg, products.price_in as Giá_Thu_Vào, products.price_out as Giá_Bán_Ra, products.price_sale as Giá_Khuyến_Mãi, products.min_gram as Bán_Tối_Thiểu, products.inventory_num as Tồn_Kho, products.category as Danh_Mục, products.kho as Chủ_Kho, products.content as Nội_Dung')
            ->orderBy('products.id', 'DESC')
            ->get();
        }
        else {
            $product = Product::leftjoin('category_products', 'category_products.id', '=', 'products.category')
            ->selectRaw('products.id as ID, products.title as Sản_Phẩm, products.gram as Giá_Tính_Theo_Bao_Nhiêu_Kg, products.price_in as Giá_Thu_Vào, products.price_out as Giá_Bán_Ra, products.price_sale as Giá_Khuyến_Mãi, products.min_gram as Bán_Tối_Thiểu, products.inventory_num as Tồn_Kho, products.category as Danh_Mục, products.kho as Chủ_Kho, products.content as Nội_Dung')
            ->orderBy('products.id','DESC')
            ->where('products.kho',Auth::user()->id)
            ->get();
        }
    	$data = $product->toArray();
		return Excel::create('San_Pham', function($excel) use ($data) {
			$excel->sheet('Sản Phẩm', function($sheet) use ($data)
	        {
				$sheet->fromArray($data, NULL, 'A3');
	        });
		})->download('xlsx');
    }
    public function getExportCompany(Request $request) 
    {
        if ($request->get('q')) {
            $q = $request->get('q');
            $company = User::select('company.id as ID', 'company.name as Tên_Công_Ty','company.address as Địa_Chỉ_Công_Ty', 'company.province as Tỉnh', 'company.mst as Mã_Số_Thuế', 'company.ndd as Người_Đại_Diện', 'users.address as Địa_Chỉ_Người_Đại_Diện', 'users.province as Tỉnh', 'users.phone_number as Số_Điện_Thoại_Người_Đại_Diện', 'users.email as Email_Người_Đại_Diện', 'company.confirm as Xác_Thực', 'company.quangcao as Quảng_Cáo', 'company.time_confirm as Thời_Gian_Xác_Thực' ,'company.time_confirm_bonus as Thời_Gian_Xác_Thực_Tặng_Thêm', 'company.time_quangcao as Thời_Gian_Quảng_Cáo', 'company.time_quangcao_bonus as Thời_Gian_Quảng_Cáo_Tặng_Thêm')
                ->leftjoin('role_user', 'role_user.user_id', '=', 'users.id')
                ->leftjoin('province', 'province.provinceid', '=', 'users.province')
                ->leftjoin('company', 'company.user_id', '=', 'users.id')
                ->where('role_user.role_id', 6)
                ->where('users.name', 'LIKE', '%' . $q . '%')
                ->orwhere('users.id', 'LIKE', '%' . $q . '%')
                ->orwhere('users.phone_number', 'LIKE', '%' . $q . '%')
                ->get();
        } else {
            $company = User::select('company.id as ID', 'company.name as Tên_Công_Ty','company.address as Địa_Chỉ_Công_Ty', 'province.name as Tỉnh', 'company.mst as Mã_Số_Thuế', 'company.ndd as Người_Đại_Diện', 'users.address as Địa_Chỉ_Người_Đại_Diện', 'province.name as Tỉnh', 'users.phone_number as Số_Điện_Thoại_Người_Đại_Diện', 'users.email as Email_Người_Đại_Diện', 'company.confirm as Xác_Thực', 'company.quangcao as Quảng_Cáo', 'company.time_confirm as Thời_Gian_Xác_Thực' ,'company.time_confirm_bonus as Thời_Gian_Xác_Thực_Tặng_Thêm', 'company.time_quangcao as Thời_Gian_Quảng_Cáo', 'company.time_quangcao_bonus as Thời_Gian_Quảng_Cáo_Tặng_Thêm')
                ->leftjoin('role_user', 'role_user.user_id', '=', 'users.id')
                ->leftjoin('province', 'province.provinceid', '=', 'users.province')
                ->leftjoin('company', 'company.user_id', '=', 'users.id')
                ->where('role_user.role_id', 6)
                ->orderBy('company.id', 'DESC')
                ->get();

        }
        $data = $company->toArray();
        return Excel::create('Cong_Ty', function($excel) use ($data) {
            $excel->sheet('Danh sách Công ty', function($sheet) use ($data)
            {
                $sheet->fromArray($data, NULL, 'A3');
            });
        })->download('xlsx');
    }
    public function getExportWarehouse(Request $request) 
    {
    	if ($request->get('q')) {
            $q = $request->get('q');
            $wareHouse = User::select('ware_houses.id as ID', 'ware_houses.name_company as Tên_Công_Ty','ware_houses.address as Địa_Chỉ_Công_Ty', 'province.name as Tỉnh', 'ware_houses.mst as Mã_Số_Thuế', 'ware_houses.level as Cấp_Kho', 'ware_houses.ndd as Người_Đại_Diện', 'users.address as Địa_Chỉ_Người_Đại_Diện', 'province.name as Tỉnh', 'users.phone_number as Số_Điện_Thoại_Người_Đại_Diện', 'users.email as Email_Người_Đại_Diện', 'ware_houses.time_active as Thời_Gian_Hoạt_Động', 'ware_houses.confirm_kho as Xác_Thực', 'ware_houses.quangcao as Quảng_Cáo', 'ware_houses.time_confirm_kho as Thời_Gian_Xác_Thực' ,'ware_houses.time_confirm_kho_bonus as Thời_Gian_Xác_Thực_Tặng_Thêm', 'ware_houses.time_quangcao as Thời_Gian_Quảng_Cáo', 'ware_houses.time_quangcao_bonus as Thời_Gian_Quảng_Cáo_Tặng_Thêm')
                ->leftjoin('role_user', 'role_user.user_id', '=', 'users.id')
                ->leftjoin('province', 'province.provinceid', '=', 'users.province')
                ->leftjoin('ware_houses', 'ware_houses.user_id', '=', 'users.id')
                ->where('role_user.role_id', 4)
                ->where('users.name', 'LIKE', '%' . $q . '%')
                ->orwhere('users.id', 'LIKE', '%' . $q . '%')
                ->orwhere('ware_houses.phone_number', 'LIKE', '%' . $q . '%')
                ->get();
        } else {
            $wareHouse = User::select('ware_houses.id as ID', 'ware_houses.name_company as Tên_Công_Ty','ware_houses.address as Địa_Chỉ_Công_Ty', 'province.name as Tỉnh', 'ware_houses.mst as Mã_Số_Thuế', 'ware_houses.level as Cấp_Kho', 'ware_houses.ndd as Người_Đại_Diện', 'users.address as Địa_Chỉ_Người_Đại_Diện', 'province.name as Tỉnh', 'users.phone_number as Số_Điện_Thoại_Người_Đại_Diện', 'users.email as Email_Người_Đại_Diện', 'ware_houses.time_active as Thời_Gian_Hoạt_Động', 'ware_houses.confirm_kho as Xác_Thực', 'ware_houses.quangcao as Quảng_Cáo', 'ware_houses.time_confirm_kho as Thời_Gian_Xác_Thực' ,'ware_houses.time_confirm_kho_bonus as Thời_Gian_Xác_Thực_Tặng_Thêm', 'ware_houses.time_quangcao as Thời_Gian_Quảng_Cáo', 'ware_houses.time_quangcao_bonus as Thời_Gian_Quảng_Cáo_Tặng_Thêm')
                ->leftjoin('role_user', 'role_user.user_id', '=', 'users.id')
                ->leftjoin('province', 'province.provinceid', '=', 'users.province')
                ->leftjoin('ware_houses', 'ware_houses.user_id', '=', 'users.id')
                ->where('role_user.role_id', 4)
                ->orderBy('users.id', 'DESC')
                ->get();
        }
    	$data = $wareHouse->toArray();
		return Excel::create('Chu_Kho', function($excel) use ($data) {
			$excel->sheet('Danh sách Chủ Kho', function($sheet) use ($data)
	        {
				$sheet->fromArray($data, NULL, 'A3');
	        });
		})->download('xlsx');
    }
    public function getExportUser(Request $request) 
    {
    	if($request->get('q')){
            $q = $request->get('q');
            $users = User::select('users.id as STT', 'users.name as Họ_Tên', 'users.address as Địa_Chỉ', 'province.name as Tỉnh', 'users.phone_number as Số_Điện_Thoại', 'users.email as Email', 'roles.display_name as Chức_Vụ')
                ->leftjoin('province', 'province.provinceid', '=', 'users.province')
                ->leftjoin('role_user', 'role_user.user_id', '=', 'users.id')
                ->leftjoin('roles' , 'roles.id' , '=', 'role_user.role_id')
                ->where('users.name','LIKE','%'.$q.'%')
                ->orwhere('users.id','LIKE','%'.$q.'%')
                ->orwhere('users.phone_number','LIKE','%'.$q.'%')
                ->get();
        }
        else {
            $users = User::select('users.id as STT', 'users.name as Họ_Tên', 'users.address as Địa_Chỉ', 'province.name as Tỉnh', 'users.phone_number as Số_Điện_Thoại', 'users.email as Email', 'roles.display_name as Chức_Vụ')
                ->leftjoin('province', 'province.provinceid', '=', 'users.province')
                ->leftjoin('role_user', 'role_user.user_id', '=', 'users.id')
                ->leftjoin('roles' , 'roles.id' , '=', 'role_user.role_id')
                ->orderBy('users.id','DESC')
                ->get();
        }
    	$data = $users->toArray();
		return Excel::create('User', function($excel) use ($data) {
			$excel->sheet('Danh sách User', function($sheet) use ($data)
	        {
				$sheet->fromArray($data, NULL, 'A3');
	        });
		})->download('xlsx');
    }
    public function getExportStaffs(Request $request) 
    {
        if($request->get('q')){
            $q = $request->get('q');
            $users = User::select('users.id as STT', 'users.name as Họ_Tên', 'users.address as Địa_Chỉ', 'province.name as Tỉnh', 'users.phone_number as Số_Điện_Thoại', 'users.email as Email', 'roles.display_name as Chức_Vụ')
                ->leftjoin('province', 'province.provinceid', '=', 'users.province')
                ->leftjoin('role_user', 'role_user.user_id', '=', 'users.id')
                ->leftjoin('roles' , 'roles.id' , '=', 'role_user.role_id')
                ->where('role_user.role_id',5)
                ->where('users.name','LIKE','%'.$q.'%')
                ->orwhere('users.id','LIKE','%'.$q.'%')
                ->orwhere('users.phone_number','LIKE','%'.$q.'%')
                ->get();
        }
        else {
            $users = User::select('users.id as STT', 'users.name as Họ_Tên', 'users.address as Địa_Chỉ', 'province.name as Tỉnh', 'users.phone_number as Số_Điện_Thoại', 'users.email as Email', 'roles.display_name as Chức_Vụ')
                ->leftjoin('province', 'province.provinceid', '=', 'users.province')
                ->leftjoin('role_user', 'role_user.user_id', '=', 'users.id')
                ->leftjoin('roles' , 'roles.id' , '=', 'role_user.role_id')
                ->where('role_user.role_id',5)
                ->orderBy('users.id','DESC')
                ->get();
        }
        $data = $users->toArray();
        return Excel::create('Nhan_Vien', function($excel) use ($data) {
            $excel->sheet('Danh sách Nhân viên', function($sheet) use ($data)
            {
                $sheet->fromArray($data, NULL, 'A3');
            });
        })->download('xlsx');
    }
    public function getExportCustomer(Request $request) 
    {
        if($request->get('q')){
            $q = $request->get('q');
            $users = User::select('users.id as STT', 'users.name as Họ_Tên', 'users.address as Địa_Chỉ', 'province.name as Tỉnh', 'users.phone_number as Số_Điện_Thoại', 'users.email as Email', 'roles.display_name as Chức_Vụ')
                ->leftjoin('province', 'province.provinceid', '=', 'users.province')
                ->leftjoin('role_user', 'role_user.user_id', '=', 'users.id')
                ->leftjoin('roles' , 'roles.id' , '=', 'role_user.role_id')
                ->where('role_user.role_id', 3)
                ->where('users.name','LIKE','%'.$q.'%')
                ->orwhere('users.id','LIKE','%'.$q.'%')
                ->orwhere('users.phone_number','LIKE','%'.$q.'%')
                ->get();
        }
        else {
            $users = User::select('users.id as STT', 'users.name as Họ_Tên', 'users.address as Địa_Chỉ', 'province.name as Tỉnh', 'users.phone_number as Số_Điện_Thoại', 'users.email as Email', 'roles.display_name as Chức_Vụ')
                ->leftjoin('province', 'province.provinceid', '=', 'users.province')
                ->leftjoin('role_user', 'role_user.user_id', '=', 'users.id')
                ->leftjoin('roles' , 'roles.id' , '=', 'role_user.role_id')
                ->where('role_user.role_id', 3)
                ->orderBy('users.id','DESC')
                ->get();
        }
    	$data = $users->toArray();
		return Excel::create('Khach_Hang', function($excel) use ($data) {
			$excel->sheet('Danh sách Khách hàng', function($sheet) use ($data)
	        {
				$sheet->fromArray($data, NULL, 'A3');
	        });
		})->download('xlsx');
    }
    public function getExportDriver(Request $request) 
    {
        if ($request->get('name') || $request->get('kho')) {
            $name = $request->get('name');
            $kho = $request->get('kho');
            $driver1 = Driver::query()->selectRaw('driver.id as STT, driver.type_driver as Loại_Hình_Vận_Chuyển, driver.name_driver as Họ_Tên_Tài_Xế, driver.phone_driver as Số_Điện_Thoại_Tài_Xế, driver.number_license_driver as Biển_Số_Xe, driver.kho as Chủ_Kho');
            if(!empty($name)){
                if(!Auth::user()->hasRole('kho'))
                    $driver1 =  $driver1->where('name_driver','LiKE','%'.$name.'%')->orwhere('phone_driver','LiKE','%'.$name.'%');
                else {
                    $driver1 =  $driver1->where('kho', Auth::user()->id)->where('name_driver','LiKE','%'.$name.'%')->orwhere('phone_driver','LiKE','%'.$name.'%');
                }
            }
            if(!empty($kho)){
                if(!Auth::user()->hasRole('kho'))
                    $driver1 =  $driver1->where('kho',$kho);
                else {
                    $driver1 =  $driver1->where('kho',Auth::user()->id);
                }
            }
            $driver = $driver1->get();
        }
        else if(!Auth::user()->hasRole('kho')) {
            $driver = Driver::selectRaw('driver.id as STT, driver.type_driver as Loại_Hình_Vận_Chuyển, driver.name_driver as Họ_Tên_Tài_Xế, driver.phone_driver as Số_Điện_Thoại_Tài_Xế, driver.number_license_driver as Biển_Số_Xe, driver.kho as Chủ_Kho')
                ->orderBy('driver.id', 'DESC')
                ->get();
        }
        else {
            $driver = Driver::selectRaw('driver.id as STT, driver.type_driver as Loại_Hình_Vận_Chuyển, driver.name_driver as Họ_Tên_Tài_Xế, driver.phone_driver as Số_Điện_Thoại_Tài_Xế, driver.number_license_driver as Biển_Số_Xe, driver.kho as Chủ_Kho')
                ->orderBy('driver.id', 'DESC')
                ->where('kho', Auth::user()->id)
                ->get();
        }
        $data = $driver->toArray();
        return Excel::create('Tai_xe', function($excel) use ($data) {
            $excel->sheet('Danh sách Tài xế', function($sheet) use ($data)
            {
                $sheet->fromArray($data, NULL, 'A3');
            });
        })->download('xlsx');
    }
    public function getExportHisInput(Request $request) 
    {
    	$user_id = Auth::user()->id;
        if(!empty($request->get('date'))){
            $date = $request->get('date');    
            if ( Auth::user()->hasRole(\App\Util::$viewHistoryInput) ) {
                $productUpdatePrice = ProductUpdatePrice::where(DB::raw("(DATE_FORMAT(created_at,'%d-%m-%Y'))"),$date)
                    ->selectRaw('products.title as Tên_Sản_Phẩm, product_update_prices.price_in as Giá_Nhập, product_update_prices.price_out as Giá_Bán, product_update_prices.price_sale Giá_Khuyến_Mãi, product_update_prices.number as Số_Lượng, product_update_prices.supplier as Nhà_Cung_Cấp, product_update_prices.created_at as Ngày_Tạo')
                    ->leftjoin('products', 'products.id', '=', 'product_update_prices.product_id')
                    ->orderBy('product_update_prices.id','DESC')
                    ->get();
            } else {
                $productUpdatePrice = ProductUpdatePrice::where(DB::raw("(DATE_FORMAT(product_update_prices.created_at,'%d-%m-%Y'))"),$date)
                    ->selectRaw('products.title as Tên_Sản_Phẩm, product_update_prices.price_in as Giá_Nhập, product_update_prices.price_out as Giá_Bán, product_update_prices.price_sale Giá_Khuyến_Mãi, product_update_prices.number as Số_Lượng, product_update_prices.supplier as Nhà_Cung_Cấp, product_update_prices.created_at as Ngày_Tạo')
                    ->leftjoin('products', 'products.id', '=', 'product_update_prices.product_id')
                    ->where('products.kho', $user_id)
                    ->orderBy('product_update_prices.id','DESC')
                    ->get();
            }
        }
        elseif(!empty($request->get('from'))){

            $from = $request->get('from');
            $to = $request->get('to');
            if ( Auth::user()->hasRole(\App\Util::$viewHistoryInput) ) {
                $productUpdatePrice = ProductUpdatePrice::/*groupBy(DB::raw("DATE(product_update_prices.created_at)"))*/
                /*->selectRaw('sum(price_in * number) as sum_price_in')
                ->selectRaw('sum(price_out) as sum_price_out')
                ->selectRaw('count(*) as count')
                ->selectRaw('sum(number) as sum_number')
                ->selectRaw('created_at')*/
                selectRaw('product_update_prices.id as STT, products.title as Tên_Sản_Phẩm, product_update_prices.price_in as Giá_Nhập, product_update_prices.price_out as Giá_Bán, product_update_prices.price_sale Giá_Khuyến_Mãi, product_update_prices.number as Số_Lượng, product_update_prices.supplier as Nhà_Cung_Cấp, product_update_prices.created_at as Ngày_Tạo')
                ->leftjoin('products', 'products.id', '=', 'product_update_prices.product_id')
                ->whereBetween('product_update_prices.created_at', array(new DateTime($from), new DateTime($to)))
                ->orderBy('product_update_prices.id','DESC')
                ->get();
            } else {
                $productUpdatePrice = ProductUpdatePrice::where('products.kho', $user_id)
                    ->groupBy(DB::raw("DATE(product_update_prices.created_at)"))
                    /*->selectRaw('sum(product_update_prices.price_in * product_update_prices.number) as sum_price_in')
                    ->selectRaw('sum(product_update_prices.price_out) as sum_price_out')
                    ->selectRaw('count(*) as count')
                    ->selectRaw('sum(product_update_prices.number) as sum_number')
                    ->selectRaw('product_update_prices.created_at')*/
                    ->selectRaw('product_update_prices.id as STT, products.title as Tên_Sản_Phẩm, product_update_prices.price_in as Giá_Nhập, product_update_prices.price_out as Giá_Bán, product_update_prices.price_sale Giá_Khuyến_Mãi, product_update_prices.number as Số_Lượng, product_update_prices.supplier as Nhà_Cung_Cấp, product_update_prices.created_at as Ngày_Tạo')
                    ->leftjoin('products', 'products.id', '=', 'product_update_prices.product_id')
                    ->whereBetween('product_update_prices.created_at', array(new DateTime($from), new DateTime($to)))
                    ->orderBy('product_update_prices.id','DESC')
                    ->get();
            }
        }
        else {
            if ( Auth::user()->hasRole(\App\Util::$viewHistoryInput) ) {
                $productUpdatePrice = ProductUpdatePrice::selectRaw('product_update_prices.id as STT, products.title as Tên_Sản_Phẩm, product_update_prices.price_in as Giá_Nhập, product_update_prices.price_out as Giá_Bán, product_update_prices.price_sale Giá_Khuyến_Mãi, product_update_prices.number as Số_Lượng, product_update_prices.supplier as Nhà_Cung_Cấp, product_update_prices.created_at as Ngày_Tạo')
                ->leftjoin('products', 'products.id', '=', 'product_update_prices.product_id')
                ->orderBy('product_update_prices.id','DESC')
                ->get();
            } else {
                $productUpdatePrice = ProductUpdatePrice::leftjoin('products','products.id','=','product_update_prices.product_id')
                    ->where('products.kho', $user_id)
                    ->selectRaw('product_update_prices.id as STT, products.title as Tên_Sản_Phẩm, product_update_prices.price_in as Giá_Nhập, product_update_prices.price_out as Giá_Bán, product_update_prices.price_sale Giá_Khuyến_Mãi, product_update_prices.number as Số_Lượng, product_update_prices.supplier as Nhà_Cung_Cấp, product_update_prices.created_at as Ngày_Tạo')
                    ->orderBy('product_update_prices.id','DESC')
                    ->get();
            }
        }
    	$data = $productUpdatePrice->toArray();
		return Excel::create('Lich_Su_Nhap_Hang', function($excel) use ($data) {
			$excel->sheet('Lịch sử nhập hàng', function($sheet) use ($data)
	        {
				$sheet->fromArray($data, NULL, 'A3');
	        });
		})->download('xlsx');
    }
}