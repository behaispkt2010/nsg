<?php

namespace App\Http\Controllers;

use App\Bank;
use App\BankWareHouse;
use App\CategoryWarehouse;
use App\Http\Requests\BankWareHouseRequest;
use App\Http\Requests\UserRequest;
use App\Http\Requests\WareHouseRequest;
use App\Http\Requests\LevelKhoRequest;
use App\Http\Requests\ConfirmKhoRequest;
use App\Http\Requests\AjaxDetailRequest;
use App\Mail\UpgradeKho;
use App\Notification;
use App\Province;
use App\User;
use App\WareHouse;
use App\RoleUser;
use App\WarehouseImageDetail;
use Illuminate\Http\Request;
use DB;
use App\Util;
use App\Http\Requests;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;

class WarehouseController extends Controller
{
    public function AjaxChangePass(Request $request)
    {
        $user    = User::find($request->get('id'));
        $pwdhash = ($request->get('old_password'));
        if (Hash::check($pwdhash, $user->password) == false) {
            $response = array(
                'status' => 'danger',
                'msg'    => 'Mật khẩu cũ thông đúng',
            );
            return \Response::json($response);
        }

        if (empty($request->get('old_password')) || empty($request->get('new_pass')) || empty($request->get('renew_pass'))) {
            $response = array(
                'status' => 'danger',
                'msg'    => 'Vui lòng điền đầy đủ',
            );
            return \Response::json($response);

        }
        if ($request->get('new_pass') != $request->get('renew_pass')) {
            $response = array(
                'status' => 'danger',
                'msg'    => 'Mật khẩu mới không trùng',
            );
            return \Response::json($response);

        }
        $data['password'] = bcrypt($request->get('new_pass'));
        $user->update($data);
        $response = array(
            'status' => 'success',
            'msg'    => 'Setting created successfully',
        );

        return \Response::json($response);
    }

    public function AjaxDetail(Request $request)
    {
        $userID    = Auth::user()->id;
        $id        = $request->get('id');
        $viewer_id = $request->get('user_id');
        $warehouse = WareHouse::find($id);
        $data      = $request->all();
        if (!empty($request->file('image_kho'))) {
            if ($request->hasFile('image_kho')) {
                $data['image_kho'] = Util::saveFile($request->file('image_kho'), '');
            }
        }
        else {
            $data['image_kho'] = $warehouse->image_kho;
        }
        if ($request->get('user_test') == 2 && $warehouse->user_test != 2) {
            $dateTest  = Util::$datetest;
            $date      = date('Y-m-d H:i:s');
            $dateafter = date('Y-m-d H:i:s', strtotime($date . ' +' . $dateTest . ' days'));
            $data['date_end_test'] = $dateafter;
        } else if ($warehouse->user_test == 2){
            $data['date_end_test'] = $warehouse->date_end_test;
        }
        else {
            $data['date_end_test'] = NULL;
        }
        if(Auth::user()->hasRole(\App\Util::$viewWareHouse)) {
            $dataNotify['keyname']   = Util::$dangkytraphiSuccess;
            $dataNotify['title']     = "Thay đổi tài khoản thành công";
            $dataNotify['content']   = "Bạn đã đăng ký trả phí thành công";
            $dataNotify['author_id'] = $userID;
            $dataNotify['roleview']  = $viewer_id;
            $dataNotify['link']      = '/admin/warehouse/'.$id.'/edit';
            $notify                  = Notification::create($dataNotify);
            $message                 = 'OK';
            if(isset($message)) {
                $redis = Redis::connection();
                $redis->publish("messages", json_encode(array(
                    "status"     => 200,
                    "id"         => $id,  
                    "notifyID"   => $notify->id,
                    "roleview"   => $viewer_id,
                    "title"      => "Thay đổi tài khoản thành công",
                    "link"       => '/admin/warehouse/'.$id.'/edit',
                    "content"    => "Bạn đã đăng ký trả phí thành công.",
                    "created_at" => date('Y-m-d H:i:s')
                )));
            }
        }
        //dd($data);

        $warehouse->update($data);
        $response    = array(
            'status' => 'success',
            'msg'    => 'Setting created successfully',
        );
        return \Response::json($response);

    }

    public function AjaxInfo(UserRequest $request)
    {
        $id   = $request->get('id');
        $user = User::find($id);
        $data = $request->all();
        //dd($data);
        $user->update($data);
        $response = array(
            'status' => 'success',
            'msg'    => 'Setting created successfully',
        );
        return \Response::json($response);

    }
    public function AjaxBank(BankWareHouseRequest $request)
    {
        $ware_id         = $request->ware_id;
        $check           = $request->check;
        $active          = 0;
        $checkBankActive = BankWareHouse::where('ware_id',$ware_id)->get();
        foreach($checkBankActive as $itemCheckBankActive){
            if (($itemCheckBankActive->check == 1)){
                $active++;
            }
        }
        if ($active >= 1  && $check == 1){
            $response = array(
                'status' => 'danger',
                'msg'    => 'Đã có ngân hàng được sử dụng',
            );
        } else {
            $data     = $request->all();
            BankWareHouse::create($data);
            //dd("dsds");
            $response = array(
                'status' => 'success',
                'msg'    => 'Setting created successfully',
            );
        }
        return \Response::json($response);

    }

    public function AjaxEditBank(BankWareHouseRequest $request)
    {
        $ware_id = $request->ware_id;
        $active  = 0;
        $idBank  = 0;
        $id      = $request->get('id_bank');
        $check   = $request->check;
        $checkBankActive = BankWareHouse::where('ware_id',$ware_id)->get();
        foreach($checkBankActive as $itemCheckBankActive){

            if (($itemCheckBankActive->check == 1)){
                $active++;
                $idBank = $itemCheckBankActive->id;
            }
        }
        if ($active >= 1  && $check == 1 && $idBank != $id){
            $response = array(
                'status' => 'danger',
                'msg'    => 'Đã có ngân hàng được sử dụng',
            );
        } else {

            $warehouse = BankWareHouse::find($id);
            $data      = $request->all();
            $warehouse->update($data);
            $response  = array(

                'status' => 'success',
                'msg'    => 'Setting created successfully',
            );
        }
        return \Response::json($response);
    }

    public function AjaxEditLevel(LevelKhoRequest $request)
    {
        $id                 = $request->get('id');
        $userID             = Auth::user()->id;
        $viewer_id          = $request->get('user_id');
        $levelkho           = $request->get('levelkho');
        $time_upgrade_level = $request->get('time_upgrade_level');
        $time_upgrade_bonus = $request->get('time_upgrade_bonus');
        $time_now           = date("Y-m-d H:i:s");
        $dateStart          = new DateTime($time_now);
        $arrGetWarehouse    = wareHouse::where('id',$id)->get();
        foreach ($arrGetWarehouse as $itemGetWarehouse) {
            $strLevelOld  = $itemGetWarehouse->level;
            $strCreateOld = $itemGetWarehouse->created_upgrade_level;
        }
        
        if ($levelkho != $strLevelOld) {
            $dataKho = [
                'level'                 => $levelkho,
                'time_upgrade_level'    => $time_upgrade_level,
                'time_upgrade_bonus'    => $time_upgrade_bonus,
                'created_upgrade_level' => $dateStart
            ];
        }
        else {
            $dataKho = [
                'level'                 => $levelkho,
                'time_upgrade_level'    => $time_upgrade_level,
                'time_upgrade_bonus'    => $time_upgrade_bonus,
                'created_upgrade_level' => $strCreateOld
            ];
            
        }
        $warehouse         = WareHouse::where('id', $id)->update($dataKho);
        $data['keyname']   = Util::$upgradeLevelKhoSuccess;
        $data['title']     = "Nâng cấp kho thành công";
        $data['content']   = "Cấp kho hiện tại ".$levelkho;
        $data['author_id'] = $userID;
        $data['roleview']  = $viewer_id;
        $data['link']      = '/admin/warehouse/'.$id.'/edit';
        $notify            = Notification::create($data);
        $message           = 'OK';
        if(isset($message)) {
            $redis = Redis::connection();
            $redis->publish("messages", json_encode(array(
                "status"     => 200,
                "id"         => $id,  
                "notifyID"   => $notify->id,
                "roleview"   => $viewer_id,
                "title"      => "Nâng cấp kho thành công",
                "link"       => '/admin/warehouse/'.$id.'/edit',
                "content"    => "Cấp kho hiện tại ".$levelkho,
                "created_at" => date('Y-m-d H:i:s')
            )));
        }
        $response = array(
            'status' => 'success',
            'msg'    => 'Setting created successfully',
        );
        return \Response::json($response);

    }
    public function AjaxConfirmKho(Request $request)
    {
        $id                     = $request->get('id');
        $userID                 = Auth::user()->id;
        $viewer_id              = $request->get('user_id');
        $time_confirm_kho       = $request->get('time_confirm_kho');
        $time_confirm_kho_bonus = $request->get('time_confirm_kho_bonus');
        $checkWareHouse = WareHouse::find($id);
        if (($checkWareHouse->name_company == $request->name_company) && ($checkWareHouse->address == $request->address) && ($checkWareHouse->mst == $request->mst) && ($checkWareHouse->ndd == $request->ndd) && ($checkWareHouse->time_active == $request->time_active)) {
            $confirm_kho = 1;
            $time_now    = date("Y-m-d H:i:s");
            $dateStart   = new DateTime($time_now);
            $dataKho     = [
                'confirm_kho'            => $confirm_kho,
                'time_confirm_kho'       => $time_confirm_kho,
                'time_confirm_kho_bonus' => $time_confirm_kho_bonus,
                'created_confirm_kho'    => $dateStart
            ];
            $warehouse         = WareHouse::where('id', $id)->update($dataKho);
            $data['keyname']   = Util::$confirmkhoSuccess;
            $data['title']     = "Xác thực doanh nghiệp thành công";
            $data['content']   = "Xem thông tin xác thực doanh nghiệp";
            $data['author_id'] = $userID;
            $data['roleview']  = $viewer_id;
            $data['link']      = '/admin/warehouse/'.$id.'/edit';
            $notify            = Notification::create($data);
            $message           = 'OK';
            if(isset($message)) {
                $redis = Redis::connection();
                $redis->publish("messages", json_encode(array(
                    "status"     => 200,
                    "id"         => $id,  
                    "notifyID"   => $notify->id,
                    "roleview"   => $viewer_id,
                    "title"      => "Xác thực doanh nghiệp thành công",
                    "link"       => '/admin/warehouse/'.$id.'/edit',
                    "content"    => "Xem thông tin xác thực doanh nghiệp",
                    "created_at" => date('Y-m-d H:i:s')
                )));
            }
            $response = array(
                'status' => 'success',
                'msg'    => 'Setting created successfully',
            );
        } else {
            $response = array(
                'status' => 'danger',
                'msg'    => 'Có lỗi xảy ra! Vui lòng kiểm tra lại thông tin hoặc cập nhật thông tin kho trước khi Xác nhận kho',
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
        $dataKho = [
            'quangcao'              => $quangcao,
            'time_quangcao'         => $time_quangcao,
            'time_quangcao_bonus'   => $time_quangcao_bonus,
            'created_time_quangcao' => $dateStart
        ];
        $warehouse         = WareHouse::where('id', $id)->update($dataKho);
        $data['keyname']   = Util::$quangcaoSuccess;
        $data['title']     = "Đăng ký quảng cáo thành công";
        $data['content']   = "Yêu cầu đăng ký quảng cáo của bạn đã được duyệt";
        $data['author_id'] = $userID;
        $data['roleview']  = $viewer_id;
        $data['link']      = '/admin/warehouse/'.$id.'/edit';
        $notify            = Notification::create($data);
        $message           = 'OK';
        if(isset($message)) {
            $redis = Redis::connection();
            $redis->publish("messages", json_encode(array(
                "status"     => 200,
                "id"         => $id,  
                "notifyID"   => $notify->id,
                "roleview"   => $viewer_id,
                "title"      => "Đăng ký quảng cáo thành công",
                "link"       => '/admin/warehouse/'.$id.'/edit',
                "content"    => "Yêu cầu đăng ký quảng cáo của bạn đã được duyệt",
                "created_at" => date('Y-m-d H:i:s')
            )));
        }
        $response = array(
            'status' => 'success',
            'msg'    => 'Setting created successfully',
        );
        return \Response::json($response);

    }
    public function AjaxSendRequestUpdateLevelKho(LevelKhoRequest $request){
        //$data = $request->all();
        $time_request_upgrade_level = $request->get('time_request_upgrade_level');
        $userID                     = Auth::user()->id;
        $user                       = User::leftjoin('ware_houses','ware_houses.user_id','=','users.id')->where('users.id',$userID)->get()->toArray();
        $name                       = "";
        $wareHouseID                = "";
        $email                      = "";
        $phone_number               = "";
        foreach($user as $itemUser){
            $name         = $itemUser['name'];
            $wareHouseID  = $itemUser['id'];
            $email        = $itemUser['email'];
            $phone_number = $itemUser['phone_number'];
        }
        $getCodeKho        = Util::UserCode($userID);
        $levelKho          = $request->get('levelkho');
        $data['keyname']   = Util::$upgradeLevelKho;
        $data['title']     = "Chủ kho đăng kí nâng cấp";
        $data['content']   = "Chủ kho ".$getCodeKho.' - '.$phone_number." muốn nâng lên cấp ".$levelKho." với thời gian " .$time_request_upgrade_level." tháng";
        $data['author_id'] = $userID;
        $data['link']      = '/admin/warehouse/'.$wareHouseID.'/edit';
        
        foreach (Util::getIdUserOfRole(Util::$roleviewAdmin) as $itemUser) {
            $data['roleview'] = $itemUser;
            $notify           = Notification::create($data);
            $message          = 'OK';
            if(isset($message)) {
                $redis = Redis::connection();
                $redis->publish("messages", json_encode(array(
                    "status"     => 200,
                    "id"         => $wareHouseID,  
                    "notifyID"   => $notify->id,
                    "roleview"   => $itemUser,
                    "title"      => "Chủ kho đăng kí nâng cấp",
                    "link"       => '/admin/warehouse/'.$wareHouseID.'/edit',
                    "content"    => "Chủ kho ".$getCodeKho.' - '.$phone_number." muốn nâng lên cấp ".$levelKho." với thời gian " .$time_request_upgrade_level." tháng",
                    "created_at" => date('Y-m-d H:i:s')
                )));
            }
        }
        //dd($data);
        $response = array(
            'status' => 'success',
            'msg'    => 'Setting created successfully',
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
    public function AjaxReQuestConfirmKho(Request $request){
        //$data = $request->all();
        $time_request_confirm_kho = $request->get('time_request_confirm_kho');
        $userID                   = Auth::user()->id;
        $user                     = User::leftjoin('ware_houses','ware_houses.user_id','=','users.id')->where('users.id',$userID)->get()->toArray();
        $name                     = "";
        $wareHouseID              = "";
        $email                    = "";
        $phone_number             = "";
        foreach($user as $itemUser){
            $name         = $itemUser['name'];
            $wareHouseID  = $itemUser['id'];
            $email        = $itemUser['email'];
            $phone_number = $itemUser['phone_number'];
        }
        $getCodeKho        = Util::UserCode($userID);
        $data['keyname']   = Util::$confirmkho;
        $data['title']     = "Chủ kho đăng kí xác thực kho";
        $data['content']   = "Chủ kho ".$getCodeKho.' - '.$phone_number." muốn xác thực kho với thời gian " .$time_request_confirm_kho ." tháng";
        $data['author_id'] = $userID;
        $data['link']      = '/admin/warehouse/'.$wareHouseID.'/edit';
        foreach (Util::getIdUserOfRole(Util::$roleviewAdmin) as $itemUser) {
            $data['roleview'] = $itemUser;
            $notify           = Notification::create($data);
            $message          = 'OK';
            if(isset($message)) {
                $redis = Redis::connection();
                $redis->publish("messages", json_encode(array(
                    "status"     => 200,
                    "id"         => $wareHouseID, 
                    "notifyID"   => $notify->id, 
                    "roleview"   => $itemUser,
                    "title"      => "Chủ kho đăng kí xác thực kho",
                    "link"       => '/admin/warehouse/'.$wareHouseID.'/edit',
                    "content"    => "Chủ kho ".$getCodeKho.' - '.$phone_number." muốn xác thực kho với thời gian " .$time_request_confirm_kho ." tháng",
                    "created_at" => date('Y-m-d H:i:s')
                )));
            }
        }
        //dd($data);
        $response = array(
            'status' => 'success',
            'msg'    => 'Setting created successfully',
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
        //$data = $request->all();
        $time_request_quangcao = $request->get('time_request_quangcao');
        $userID                = Auth::user()->id;
        $user                  = User::leftjoin('ware_houses','ware_houses.user_id','=','users.id')->where('users.id',$userID)->get()->toArray();
        $name                  = "";
        $wareHouseID           = "";
        $email                 = "";
        $phone_number          = "";
        foreach($user as $itemUser){
            $name         = $itemUser['name'];
            $wareHouseID  = $itemUser['id'];
            $email        = $itemUser['email'];
            $phone_number = $itemUser['phone_number'];
        }
        $getCodeKho        = Util::UserCode($userID);
        $data['keyname']   = Util::$quangcaoKho;
        $data['title']     = "Chủ kho đăng kí quảng cáo";
        $data['content']   = "Chủ kho ".$getCodeKho.' - '.$phone_number." muốn đăng ký quảng cáo với thời gian " .$time_request_quangcao. " tháng";
        $data['author_id'] = $userID;
        $data['link']      = '/admin/warehouse/'.$wareHouseID.'/edit';
        foreach (Util::getIdUserOfRole(Util::$roleviewAdmin) as $itemUser) {
            $data['roleview'] = $itemUser;
            $notify           = Notification::create($data);
            $message          = 'OK';
            if(isset($message)) {
                $redis = Redis::connection();
                $redis->publish("messages", json_encode(array(
                    "status"     => 200,
                    "id"         => $wareHouseID,  
                    "notifyID"   => $notify->id,
                    "roleview"   => $itemUser,
                    "title"      => "Chủ kho đăng kí quảng cáo",
                    "link"       => '/admin/warehouse/'.$wareHouseID.'/edit',
                    "content"    => "Chủ kho ".$getCodeKho.' - '.$phone_number." muốn đăng ký quảng cáo với thời gian " .$time_request_quangcao. " tháng",
                    "created_at" => date('Y-m-d H:i:s')
                )));
            }
        }
        //dd($data);
        $response = array(
            'status' => 'success',
            'msg'    => 'Setting created successfully',
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
        $userID        = Auth::user()->id;
        $user          = User::leftjoin('ware_houses','ware_houses.user_id','=','users.id')->where('users.id',$userID)->get()->toArray();
        $name          = "";
        $wareHouseID   = "";
        $email         = "";
        $phone_number  = "";
        foreach($user as $itemUser){
            $name          = $itemUser['name'];
            $wareHouseID   = $itemUser['id'];
            $email         = $itemUser['email'];
            $phone_number  = $itemUser['phone_number'];
        }
        $getCodeKho        = Util::UserCode($userID);
        $data['keyname']   = Util::$dangkytraphiKho;
        $data['title']     = "Chủ kho đăng kí dùng trả phí";
        $data['content']   = "Mã chủ kho ".$getCodeKho.' - '.$phone_number;
        $data['author_id'] = $userID;
        $data['link']      = '/admin/warehouse/'.$wareHouseID.'/edit';
        foreach (Util::getIdUserOfRole(Util::$roleviewAdmin) as $itemUser) {
            $data['roleview'] = $itemUser;
            $notify = Notification::create($data);
            $message = 'OK';
            if(isset($message)) {
                $redis = Redis::connection();
                $redis->publish("messages", json_encode(array(
                    "status"     => 200,
                    "id"         => $wareHouseID, 
                    "notifyID"   => $notify->id, 
                    "roleview"   => $itemUser,
                    "title"      => "Chủ kho đăng kí dùng trả phí",
                    "link"       => '/admin/warehouse/'.$wareHouseID.'/edit',
                    "content"    => "Mã chủ kho ".$getCodeKho.' - '.$phone_number,
                    "created_at" => date('Y-m-d H:i:s')
                )));
            }
        }
        //dd($data);
        $response = array(
            'status' => 'success',
            'msg'    => 'Setting created successfully',
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
        $dataImage                 = $request->all();
        $dataImage['warehouse_id'] = $request->get('id');
        if(!empty($request->file('file'))) {
            foreach ($request->file('file') as $image_detail) {
                $imageDetail                         = new WarehouseImageDetail();
                $dataImage['warehouse_detail_image'] = Util::saveFile($image_detail, '');
                WarehouseImageDetail::create($dataImage);
            }
        }
        $response = array(
            'status' => 'success',
            'msg'    => 'Setting created successfully',
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
        if ($request->get('q')) {
            $q         = $request->get('q');
            $wareHouse = User::select('users.*', 'ware_houses.id as ware_houses_id','ware_houses.user_id as userID', 'ware_houses.level as level', 'ware_houses.confirm_kho as confirm_kho', 'ware_houses.quangcao as quangcao')
                ->leftjoin('role_user', 'role_user.user_id', '=', 'users.id')
                ->leftjoin('ware_houses', 'ware_houses.user_id', '=', 'users.id')
                ->where('role_user.role_id', 4)
                ->where('users.deleted', 0)
                ->where('users.name', 'LIKE', '%' . $q . '%')
                ->orwhere('users.id', 'LIKE', '%' . $q . '%')
                ->orwhere('users.phone_number', 'LIKE', '%' . $q . '%')
                ->paginate(9);
        } else {
            $wareHouse = User::select('users.*', 'ware_houses.id as ware_houses_id','ware_houses.user_id as userID', 'ware_houses.level as level', 'ware_houses.confirm_kho as confirm_kho', 'ware_houses.quangcao as quangcao')
                ->where('users.deleted', 0)
                ->leftjoin('role_user', 'role_user.user_id', '=', 'users.id')
                ->leftjoin('ware_houses', 'ware_houses.user_id', '=', 'users.id')
                ->where('role_user.role_id', 4)
                ->orderBy('id', 'DESC')
                ->paginate(9);
        }

        $data = [
            'wareHouse' => $wareHouse,
        ];


        return view('admin.warehouse.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $arrCategoryWarehouse = CategoryWarehouse::get();
        $province             = Province::get();

        $data = [
            'arrCategoryWarehouse' => $arrCategoryWarehouse,
            'province'             => $province,
        ];

        return view('admin.warehouse.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(WareHouseRequest $request)
    {
        $myIntroCode = str_random(8);
        DB::beginTransaction();
        try {
            $today                    = date("Y-m-d_H-i-s");
            $dataUser['name']         = $request->get('name');
            $dataUser['email']        = $request->get('email');
            $dataUser['phone_number'] = $request->get('phone_number');
            $dataUser['password']     = bcrypt($request->get('password'));
            $dataUser['myIntroCode']  = $myIntroCode;
            if (empty($request->get('password'))) {
                $dataUser['password'] = "123456";
            }
            $dataUser['image']        = "/images/user_default.png";
            $checkExits               = count(User::where('email', $request->get('email'))->get());
            // Log::debug('logHaiTVB.', ['checkExits' => $checkExits]);
            if ($checkExits == 0) {
                $user = User::create($dataUser);
                $user->attachRole(4);
            } else {
                $user      = User::where('email', $request->get('email'))->first();
                $checkRole = RoleUser::where('user_id', $user->id)->first();
                if ($checkRole->role_id == 3) {
                    $user->update($dataUser);
                    $user->detachRole(3);
                    $user->attachRole(4);
                }
            }
            
            
            $wareHouse     = new WareHouse();
            $data          = $request->all();
            if ($request->hasFile('image_kho')) {
                $data['image_kho']  = Util::saveFile($request->file('image_kho'), '');
            }
            $data['user_id'] = $user->id;
            if ($request->get('user_test') == 2) {
                $dateTest              = Util::$datetest;
                $date                  = date('Y-m-d H:i:s');
                $dateafter             = date('Y-m-d H:i:s', strtotime($date . ' +' . $dateTest . ' days'));
                $data['date_end_test'] = $dateafter;
            }
            $res                       = WareHouse::create($data);

        } catch (\Exception $e) {
            DB::rollback();
            return redirect('admin/warehouse/create')->with(['flash_level' => 'danger', 'flash_message' => 'Tạo không thành công']);
        }
        DB::commit();
        return redirect('admin/warehouse/' . $res->id . '/edit')->with(['flash_level' => 'success', 'flash_message' => 'Tạo thành công']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $wareHouse = WareHouse::find($id);
        $data      = [
            'wareHouse' => $wareHouse,
            'id'        => $id,
        ];
        return view('admin.warehouse.edit', $data);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $bank                 = Bank::get();
        $province             = Province::get();
        $detailImage          = WarehouseImageDetail::where('warehouse_id',$id)->get();
        $wareHouse            = WareHouse::find($id);
        $bankWareHouse        = BankWareHouse::where('ware_id', $id)->get();
        $arrCategoryWarehouse = CategoryWarehouse::get();
        $userInfo             = User::where('id', $wareHouse->user_id)->first();
        // dd($wareHouse);
        $data = [
            'wareHouse'            => $wareHouse,
            'bank'                 => $bank,
            'province'             => $province,
            'detailImage'          => $detailImage,
            'bankWareHouse'        => $bankWareHouse,
            'arrCategoryWarehouse' => $arrCategoryWarehouse,
            'id'                   => $id,
            'userInfo'             => $userInfo,
        ];

        return view('admin.warehouse.edit',$data);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $warehouse = WareHouse::find($id);
            $res       = WareHouse::destroy($id);
            BankWareHouse::where('ware_id', $id)->delete();
            User::where('id', $warehouse->user_id)->delete();
        } catch (\Exception $e) {

            DB::rollback();
            return redirect('admin/warehouse/')->with(['flash_level' => 'danger', 'flash_message' => 'Chưa thể xóa']);
        }

        DB::commit();
        return redirect('admin/warehouse/')->with(['flash_level' => 'success', 'flash_message' => 'Xóa thành công']);

    }
    public function deleteDetailImage(Request $request)
    {
        WarehouseImageDetail::where('id',$request->get('id'))->delete();
        $response = array(
            'status' => 'success',
            'msg'    => 'Setting created successfully',
        );
        return \Response::json($response);
    }
}
