<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Company;
use App\Bank;
use App\RoleUser;
use App\CompanyImage;
use App\CompanyBank;
use DB;
use App\Util;
use DateTime;

use App\Http\Requests\UserRequest;
use App\Http\Requests\ConfirmKhoRequest;
use App\Http\Requests\AjaxDetailRequest;
use App\Http\Requests\BankWareHouseRequest;
use App\Notification;
use App\Province;
use App\WarehouseImageDetail;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->get('q')) {
            $q       = $request->get('q');
            $company = User::select('users.*', 'company.id as company_id','company.user_id as userID')
                ->leftjoin('role_user', 'role_user.user_id', '=', 'users.id')
                ->leftjoin('company', 'company.user_id', '=', 'users.id')
                ->where('role_user.role_id', 6)
                ->where('company.deleted', 0)
                ->where('users.name', 'LIKE', '%' . $q . '%')
                ->orwhere('users.id', 'LIKE', '%' . $q . '%')
                ->orwhere('users.phone_number', 'LIKE', '%' . $q . '%')
                ->paginate(9);
        } else {
            $company = User::select('users.*', 'company.id as company_id','company.user_id as userID')
                ->leftjoin('role_user', 'role_user.user_id', '=', 'users.id')
                ->leftjoin('company', 'company.user_id', '=', 'users.id')
                ->where('role_user.role_id', 6)
                ->where('company.deleted', 0)
                ->orderBy('id', 'DESC')
                ->paginate(9);
        }

        $data = [
            'company' => $company
        ];
        return view('admin.company.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        /*$arrCategoryWarehouse = CategoryWarehouse::get();*/
        $province = Province::get();

        $data = [
            /*'arrCategoryWarehouse'=>$arrCategoryWarehouse,*/
            'province' => $province,
        ];

        return view('admin.company.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $myIntroCode = str_random(8);
        DB::beginTransaction();
        try {
            $today                    = date("Y-m-d_H-i-s");
            $dataUser['name']         = $request->get('name');
            $dataUser['email']        = $request->get('email');
            $dataUser['phone_number'] = $request->get('phone_number');
            $dataUser['password']     = bcrypt($request->get('password'));
            $dataUser['province']     = $request->get('province');
            $dataUser['myIntroCode']  = $myIntroCode;
            if (empty($request->get('password'))) {
                $dataUser['password'] = "123456";
            }
            $dataUser['image']        = "/images/user_default.png";
            $checkExits               = count(User::where('email', $request->get('email'))->get());
            // Log::debug('logHaiTVB.', ['checkExits' => $checkExits]);
            if ($checkExits == 0) {
                $user = User::create($dataUser);
                $user->attachRole(6);
            } else {
                $user      = User::where('email', $request->get('email'))->first();
                $checkRole = RoleUser::where('user_id', $user->id)->first();
                if ($checkRole->role_id == 3) {
                    $user->update($dataUser);
                    $user->detachRole(3);
                    $user->attachRole(6);
                }
            }
            $data = $request->all();
            if ($request->hasFile('image_company')) {
                $data['image_company']  = Util::saveFile($request->file('image_company'), '');
            }
            $data['user_id'] = $user->id;
            $res = Company::create($data);

        } catch (\Exception $e) {
            DB::rollback();
            return redirect('admin/company/create')->with(['flash_level' => 'danger', 'flash_message' => 'Tạo không thành công']);
        }
        DB::commit();
        return redirect('admin/company/' . $res->id . '/edit')->with(['flash_level' => 'success', 'flash_message' => 'Tạo thành công']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $company = Company::find($id);
        $data = [
            'company' => $company,
            'id' => $id,
        ];
        return view('admin.company.edit', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $bank        = Bank::get();
        $province    = Province::get();
        $detailImage = CompanyImage::where('company_id',$id)->get();
        $company     = Company::find($id);
        $companyBank = CompanyBank::where('company_id', $id)->get();
        $userInfo    = User::where('id', $company->user_id)->first();
        $data = [
            'company'     => $company,
            'bank'        => $bank,
            'province'    => $province,
            'detailImage' => $detailImage,
            'companyBank' => $companyBank,
            'id'          => $id,
            'userInfo'    => $userInfo,
        ];

        return view('admin.company.edit',$data);
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
        DB::beginTransaction();
        try {
            $company = Company::find($id);
            $res     = Company::destroy($id);
            CompanyBank::where('company_id', $id)->delete();
            User::where('id', $company->user_id)->delete();
        } catch (\Exception $e) {

            DB::rollback();
            return redirect('admin/company/')->with(['flash_level' => 'danger', 'flash_message' => 'Chưa thể xóa']);
        }

        DB::commit();
        return redirect('admin/company/')->with(['flash_level' => 'success', 'flash_message' => 'Xóa thành công']);

    }
    public function deleteDetailImage(Request $request)
    {
        CompanyImage::where('id',$request->get('id'))->delete();
        $response = array(
            'status' => 'success',
            'msg' => 'Setting created successfully',
        );
        return \Response::json($response);
    }
    public function AjaxChangePass(Request $request)
    {
        $user    = User::find($request->get('id'));
        $pwdhash = ($request->get('old_password'));
        if (Hash::check($pwdhash, $user->password) == false) {
            $response = array(
                'status' => 'danger',
                'msg' => 'Mật khẩu cũ thông đúng',
            );
            return \Response::json($response);

        }
        if (empty($request->get('old_password')) || empty($request->get('new_pass')) || empty($request->get('renew_pass'))) {
            $response = array(
                'status' => 'danger',
                'msg' => 'Vui lòng điền đầy đủ',
            );
            return \Response::json($response);
        }
        if ($request->get('new_pass') != $request->get('renew_pass')) {
            $response = array(
                'status' => 'danger',
                'msg' => 'Mật khẩu mới không trùng',
            );
            return \Response::json($response);
        }
        $data['password'] = bcrypt($request->get('new_pass'));
        $user->update($data);
        $response = array(
            'status' => 'success',
            'msg' => 'Setting created successfully',
        );

        return \Response::json($response);
    }

    public function AjaxDetail(Request $request)
    {
        $userID    = Auth::user()->id;
        $id        = $request->get('id');
        $viewer_id = $request->get('user_id');
        $company   = Company::find($id);
        $data      = $request->all();
        if (!empty($request->file('image_company'))) {
            if ($request->hasFile('image_company')) {
                $data['image_company'] = Util::saveFile($request->file('image_company'), '');
            }
        }
        else {
            $data['image_company'] = $company->image_company;
        }
        if ($request->get('user_test') == 2 && $company->user_test != 2) {
            $dateTest              = Util::$datetest;
            $date                  = date('Y-m-d H:i:s');
            $dateafter             = date('Y-m-d H:i:s', strtotime($date . ' +' . $dateTest . ' days'));
            $data['date_end_test'] = $dateafter;
        } else if ($company->user_test == 2){
            $data['date_end_test'] = $company->date_end_test;
        }
        else {
            $data['date_end_test'] = NULL;
        }
        if(Auth::user()->hasRole(\App\Util::$viewCompany)) {
            $dataNotify['keyname']   = Util::$dangkytraphiCompanySuccess;
            $dataNotify['title']     = "Thay đổi tài khoản thành công";
            $dataNotify['content']   = "Bạn đã đăng ký trả phí thành công";
            $dataNotify['author_id'] = $userID;
            $dataNotify['roleview']  = $viewer_id;
            $dataNotify['link']      = '/admin/company/'.$id.'/edit';
            $notify                  = Notification::create($dataNotify);
            $message                 = 'OK';
            if(isset($message)) {
                $redis = Redis::connection();
                $redis->publish("messages", json_encode(array(
                    "status"     => 200,
                    "roleview"   => $viewer_id, 
                    "notifyID"   => $notify->id,
                    "title"      => "Thay đổi tài khoản thành công",
                    "link"       => '/admin/company/'.$id.'/edit',
                    "content"    => "Bạn đã đăng ký trả phí thành công",
                    "created_at" => date('Y-m-d H:i:s')
                )));
            }
        }
        //dd($data);

        $company->update($data);
        $response = array(
            'status' => 'success',
            'msg' => 'Setting created successfully',
        );
        return \Response::json($response);

    }

    public function AjaxInfo(UserRequest $request)
    {
        $id   = $request->get('id');
        $user = User::find($id);
        $data = $request->all();
        $user->update($data);
        $response = array(
            'status' => 'success',
            'msg'    => 'Setting created successfully',
        );
        return \Response::json($response);
    }
    public function AjaxBank(BankWareHouseRequest $request)
    {
        $company_id      = $request->company_id;
        $check           = $request->check;
        $active          = 0;
        $checkBankActive = CompanyBank::where('company_id',$company_id)->get();
        foreach($checkBankActive as $itemCheckBankActive){
            if (($itemCheckBankActive->check == 1)){
                $active++;
            }
        }
        if ($active >= 1  && $check == 1){
            $response = array(
                'status' => 'danger',
                'msg' => 'Đã có ngân hàng được sử dụng',
            );
        } else {
            $data = $request->all();
            CompanyBank::create($data);
            $response = array(
                'status' => 'success',
                'msg' => 'Setting created successfully',
            );
        }
        return \Response::json($response);
    }

    public function AjaxEditBank(BankWareHouseRequest $request)
    {
        $company_id      = $request->company_id;
        $active          = 0;
        $idBank          = 0;
        $id              = $request->get('id_bank');
        $check           = $request->check;
        $checkBankActive = CompanyBank::where('company_id',$company_id)->get();
        foreach($checkBankActive as $itemCheckBankActive){

            if (($itemCheckBankActive->check == 1)){
                $active++;
                $idBank = $itemCheckBankActive->id;
            }
        }
        if ($active >= 1  && $check == 1 && $idBank != $id){
            $response = array(
                'status' => 'danger',
                'msg' => 'Đã có ngân hàng được sử dụng',
            );
        } else {

            $company  = CompanyBank::find($id);
            $data     = $request->all();
            $company->update($data);
            $response = array(

                'status' => 'success',
                'msg' => 'Setting created successfully',
            );
        }
        return \Response::json($response);

    }

    
    public function AjaxConfirmKho(Request $request)
    {
        $id                 = $request->get('id');
        $userID             = Auth::user()->id;
        $viewer_id          = $request->get('user_id');
        $time_confirm       = $request->get('time_confirm');
        $time_confirm_bonus = $request->get('time_confirm_bonus');
        $checkCompany       = Company::find($id);
        if (($checkCompany->name == $request->name_company) && ($checkCompany->address == $request->address) && ($checkCompany->mst == $request->mst) && ($checkCompany->ndd == $request->ndd) && ($checkCompany->time_active == $request->time_active)) {
            $confirm     = 1;
            $time_now    = date("Y-m-d H:i:s");
            $dateStart   = new DateTime($time_now);
            $dataCompany = [
                'confirm'            => $confirm,
                'time_confirm'       => $time_confirm,
                'time_confirm_bonus' => $time_confirm_bonus,
                'created_confirm'    => $dateStart
            ];
            $company           = Company::where('id', $id)->update($dataCompany);
            $data['keyname']   = Util::$confirmCompanySuccess;
            $data['title']     = "Xác thực doanh nghiệp thành công";
            $data['content']   = "Xem thông tin xác thực doanh nghiệp";
            $data['author_id'] = $userID;
            $data['roleview']  = $viewer_id;
            $data['link']      = '/admin/company/'.$id.'/edit';

            Notification::create($data);
            $message = 'OK';
            if(isset($message)) {
                $redis = Redis::connection();
                $redis->publish("messages", json_encode(array(
                    "status"     => 200,
                    "roleview"   => $viewer_id,
                    "title"      => "Xác thực doanh nghiệp thành công",
                    "link"       => '/admin/company/'.$id.'/edit',
                    "content"    => "Xem thông tin xác thực doanh nghiệp",
                    "created_at" => date('Y-m-d H:i:s')
                )));
            }
            $response = array(
                'status' => 'success',
                'msg' => 'Setting created successfully',
            );
        } else {
            $response = array(
                'status' => 'danger',
                'msg' => 'Có lỗi xảy ra! Vui lòng kiểm tra lại thông tin hoặc cập nhật thông tin kho trước khi Xác nhận kho',
            );
        }
        return \Response::json($response);

    }
    public function AjaxQuangCao(Request $request)
    {
        $id                  = $request->get('id');
        $userID              = Auth::user()->id;
        $viewer_id           = $request->get('user_id');
        $time_quangcao       = $request->get('time_quangcao');
        $time_quangcao_bonus = $request->get('time_quangcao_bonus');
        $quangcao            = 1;
        $time_now            = date("Y-m-d H:i:s");
        $dateStart           = new DateTime($time_now);
        $dataCompany = [
            'quangcao'              => $quangcao,
            'time_quangcao'         => $time_quangcao,
            'time_quangcao_bonus'   => $time_quangcao_bonus,
            'created_time_quangcao' => $dateStart
        ];
        $company           = Company::where('id', $id)->update($dataCompany);
        $data['keyname']   = Util::$quangcaoCompanySuccess;
        $data['title']     = "Đăng ký quảng cáo thành công";
        $data['content']   = "Yêu cầu đăng ký quảng cáo của bạn đã được duyệt";
        $data['author_id'] = $userID;
        $data['roleview']  = $viewer_id;
        $data['link']      = '/admin/company/'.$id.'/edit';
        Notification::create($data);
        $message = 'OK';
        if(isset($message)) {
            $redis = Redis::connection();
            $redis->publish("messages", json_encode(array(
                "status"     => 200,
                "roleview"   => $viewer_id,
                "title"      => "Đăng ký quảng cáo thành công",
                "link"       => '/admin/company/'.$id.'/edit',
                "content"    => "Yêu cầu đăng ký quảng cáo của bạn đã được duyệt",
                "created_at" => date('Y-m-d H:i:s')
            )));
        }
        $response = array(
            'status' => 'success',
            'msg' => 'Setting created successfully',
        );
        return \Response::json($response);

    }
    public function AjaxReQuestConfirmKho(Request $request){
        //$data = $request->all();
        $time_request_confirm = $request->get('time_request_confirm');
        $userID               = Auth::user()->id;
        $user                 = User::leftjoin('company','company.user_id','=','users.id')->where('users.id',$userID)->get()->toArray();
        $name                 = "";
        $companyID            = "";
        $email                = "";
        $phone_number         = "";
        foreach($user as $itemUser){
            $name         = $itemUser['name'];
            $companyID    = $itemUser['id'];
            $email        = $itemUser['email'];
            $phone_number = $itemUser['phone_number'];
        }
        $getCodeCompany    = Util::UserCode($userID);
        $data['keyname']   = Util::$confirmCompany;
        $data['title']     = "Chủ kho đăng kí xác thực kho";
        $data['content']   = "Chủ kho ".$getCodeCompany.' - '.$phone_number." muốn xác thực kho với thời gian " .$time_request_confirm ." tháng";
        $data['author_id'] = $userID;
        $data['link']      = '/admin/company/'.$companyID.'/edit';
        foreach (Util::getIdUserOfRole(Util::$roleviewAdmin) as $itemUser) {
            $data['roleview'] = $itemUser;
            Notification::create($data);
            $message = 'OK';
            if(isset($message)) {
                $redis = Redis::connection();
                $redis->publish("messages", json_encode(array(
                    "status"     => 200,
                    "roleview"   => $itemUser,
                    "title"      => "Chủ kho đăng kí xác thực kho",
                    "link"       => '/admin/company/'.$companyID.'/edit',
                    "content"    => "Chủ kho ".$getCodeCompany.' - '.$phone_number." muốn xác thực kho với thời gian " .$time_request_confirm ." tháng",
                    "created_at" => date('Y-m-d H:i:s')
                )));
            }
        }
        //dd($data);
        $response = array(
            'status' => 'success',
            'msg' => 'Setting created successfully',
        );
        /*$mailData = [
            "name" => $name,
            "email" => $email,
            "phone" => $phone_number,
            "comment" => "Chủ kho $name muốn nâng cấp kho lên $request->levelkho. Click vào <a href='$url'>đây</a> để tiến hành nâng cấp kho",
            "subject" => "Chủ kho cần nâng cấp kho"
        ];
        $to = "behaispkt2010@gmail.com";
        Mail::to($to)->send(new UpgradeKho($mailData));*/

        return \Response::json($response);
    }
    public function AjaxReQuestQuangCao(Request $request){
        $time_request_quangcao = $request->get('time_request_quangcao');
        $userID                = Auth::user()->id;
        $user                  = User::leftjoin('company','company.user_id','=','users.id')->where('users.id',$userID)->get()->toArray();
        $name                  = "";
        $companyID             = "";
        $email                 = "";
        $phone_number          = "";
        foreach($user as $itemUser){
            $name         = $itemUser['name'];
            $companyID    = $itemUser['id'];
            $email        = $itemUser['email'];
            $phone_number = $itemUser['phone_number'];
        }
        $getCodeCompany   = Util::UserCode($userID);
        $data['keyname']  = Util::$quangcaoCompany;
        $data['title']    = "Chủ kho đăng kí quảng cáo";
        $data['content']  = "Chủ kho ".$getCodeCompany.' - '.$phone_number." muốn đăng ký quảng cáo với thời gian " .$time_request_quangcao. " tháng";
        $data['author_id'] = $userID;
        $data['link']     = '/admin/company/'.$companyID.'/edit';
        foreach (Util::getIdUserOfRole(Util::$roleviewAdmin) as $itemUser) {
            $data['roleview'] = $itemUser;
            Notification::create($data);
            $message = 'OK';
            if(isset($message)) {
                $redis = Redis::connection();
                $redis->publish("messages", json_encode(array(
                    "status"     => 200,
                    "roleview"   => $itemUser,
                    "title"      => "Chủ kho đăng kí quảng cáo",
                    "link"       => '/admin/company/'.$companyID.'/edit',
                    "content"    => "Chủ kho ".$getCodeCompany.' - '.$phone_number." muốn đăng ký quảng cáo với thời gian " .$time_request_quangcao. " tháng",
                    "created_at" => date('Y-m-d H:i:s')
                )));
            }
        }
        //dd($data);
        $response = array(
            'status' => 'success',
            'msg' => 'Setting created successfully',
        );
        /*$mailData = [
            "name" => $name,
            "email" => $email,
            "phone" => $phone_number,
            "comment" => "Chủ kho $name muốn nâng cấp kho lên $request->levelkho. Click vào <a href='$url'>đây</a> để tiến hành nâng cấp kho",
            "subject" => "Chủ kho cần nâng cấp kho"
        ];
        $to = "behaispkt2010@gmail.com";
        Mail::to($to)->send(new UpgradeKho($mailData));*/

        return \Response::json($response);
    }
    public function AjaxReQuestTraphi(Request $request){
        //$data = $request->all();
        $userID       = Auth::user()->id;
        $user         = User::leftjoin('company','company.user_id','=','users.id')->where('users.id',$userID)->get()->toArray();
        $name         = "";
        $companyID    = "";
        $email        = "";
        $phone_number = "";
        foreach($user as $itemUser){
            $name         = $itemUser['name'];
            $companyID    = $itemUser['id'];
            $email        = $itemUser['email'];
            $phone_number = $itemUser['phone_number'];
        }
        $getCodeCompany   = Util::UserCode($userID);
        $data['keyname']  = Util::$dangkytraphiCompany;
        $data['title']    = "Chủ kho đăng kí dùng trả phí";
        $data['content']  = "Mã chủ kho ".$getCodeCompany.' - '.$phone_number;
        $data['author_id']= $userID;
        $data['link']     = '/admin/company/'.$companyID.'/edit';
        foreach (Util::getIdUserOfRole(Util::$roleviewAdmin) as $itemUser) {
            $data['roleview'] = $itemUser;
            Notification::create($data);
            $message = 'OK';
            if(isset($message)) {
                $redis = Redis::connection();
                $redis->publish("messages", json_encode(array(
                    "status"     => 200,
                    "roleview"   => $itemUser,
                    "title"      => "Chủ kho đăng kí dùng trả phí",
                    "link"       => '/admin/company/'.$companyID.'/edit',
                    "content"    => "Mã chủ kho ".$getCodeCompany.' - '.$phone_number,
                    "created_at" => date('Y-m-d H:i:s')
                )));
            }
        }
        //dd($data);
        $response = array(
            'status' => 'success',
            'msg' => 'Setting created successfully',
        );
        /*$mailData = [
            "name" => $name,
            "email" => $email,
            "phone" => $phone_number,
            "comment" => "Chủ kho $name muốn nâng cấp kho lên $request->levelkho. Click vào <a href='$url'>đây</a> để tiến hành nâng cấp kho",
            "subject" => "Chủ kho cần nâng cấp kho"
        ];
        $to = "behaispkt2010@gmail.com";
        Mail::to($to)->send(new UpgradeKho($mailData));*/

        return \Response::json($response);
    }
    public function UploadImgDetail(Request $request){
        //dd($request->all());
        $dataImage               = $request->all();
        $dataImage['company_id'] = $request->get('id');
        if(!empty($request->file('file'))) {
            foreach ($request->file('file') as $image_detail) {
                $imageDetail = new CompanyImage();
                $dataImage['company_image'] = Util::saveFile($image_detail, '');
                CompanyImage::create($dataImage);
            }
        }
        $response = array(
            'status' => 'success',
            'msg' => 'Setting created successfully',
        );
        return \Response::json($response);
    }
}
