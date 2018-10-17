<?php

namespace App\Http\Controllers;

use App\Province;
use App\Role;
use App\RoleUser;
use App\User;
use App\Util;
use Illuminate\Http\Request;
use App\Http\Requests;
Use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    

    public function AjaxChangeImage(Request $request){
        $res      = $request->all();
        $user     = User::find(Auth::user()->id);
        $response = array(
            'status' => 'success',
            'msg'    => 'Setting created successfully',
        );
        $data['image'] = "/images/".$request->get('img').".png";
        $user->update($data);
        return \Response::json($response);
    }

    public function AjaxCreateCustomer(UserRequest $request)
    {
        $user             = new User();
        $data             = $request->all();
        $data['idwho']    = Auth::user()->id;
        $data['province'] = $request->get('t');
        $data['district'] = $request->get('q');
        if(empty($request->get('password'))){
            $data['password'] = "123456";
        }
        $data['image'] = "/images/user_default.png";
        $user          = User::create($data);
        $addRoles = $user->attachRole(3);
        if($addRoles == NULL) {
            $user1['code'] = Util::UserCode($user->id);    
        }
        $user->update($user1);
        $response = array(
            'status'      => 'success',
            'msg'         => 'Setting created successfully',
            'customer_id' => $user->id
        );
        
        return \Response::json($response);
    }
    public function AjaxEditCustomer(Request $request) {
        $userID = $request->get('customer_id');
        $arrUser = User::find($userID);
        $data             = $request->all();
        $data['province'] = $request->get('t');
        $data['district'] = $request->get('q');
        $arrUser->update($data);
        $response = array(
            'status'      => 'success',
            'msg'         => 'Setting created successfully',
            'customer_id' => $userID
        );
        return \Response::json($response);
    }

    public function AjaxGetDataCustomer(Request $request){
        $user     = User::find($request->get('id_select_kh'));
        $response = array(
            'name'         => $user->name,
            'phone_number' => $user->phone_number,
            'email'        => $user->email,
            'address'      => $user->address,
            'customer_id'  => $user->id,
            'province'     => $user->province,
            'district'     => $user->district
        );
        return \Response::json($response);
    }
    public function AjaxDeleteUser(Request $request) {
        $id         = $request->get('id');
        $checkOrder = User::checkUserHasOrder($id);
        $user = User::find($id);
        if ($checkOrder == 0) {
            $data['deleted'] = 1;
            $user->update($data);
        } else {
            return redirect()->back()->with(['flash_level' => 'danger', 'flash_message' => 'Khách hàng này đang có đơn hàng, nên không thể xóa']);
        }
        $userDeleted = User::where('deleted', '=', 1)->where('id', '=', $id);
        if(!empty($userDeleted) ) {
            return redirect()->back()->with(['flash_level' => 'success', 'flash_message' => 'Xóa thành công']);
        }
        else{

            return redirect()->back()->with(['flash_level' => 'danger', 'flash_message' => 'Chưa thể xóa']);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if($request->get('q')){

            $q     = $request->get('q');
            $users = User::where('name','LIKE','%'.$q.'%')
                ->where('deleted', '=', '0')
                ->orwhere('id','LIKE','%'.$q.'%')
                ->orwhere('phone_number','LIKE','%'.$q.'%')
                ->orderBy('id','DESC')
                ->paginate(9);
        }
        else {
            $users = User::where('deleted', '=', '0')
                ->orderBy('id','DESC')
                ->paginate(9);
        }
        $roles = RoleUser::leftjoin('users','role_user.user_id','=','users.id')
            ->leftjoin('roles','roles.id','=','role_user.role_id')
            ->get();
        $data = [
            'roles' => $roles,
            'users' => $users,
            'type'  => 'users',
        ];
        return view('admin.users.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles    = Role::get();
        $province = Province::get();

        $data = [
            'roles'    => $roles,
            'province' => $province,


        ];
        return view('admin.users.edit',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $today = date("Y-m-d_H-i-s");
        $user  = new User;
        $data  = $request->all();
        $data['password'] = bcrypt($request->get('password'));
        if(empty($request->get('password'))){
            $data['password'] = "123456";
        }
        if ($request->hasFile('image')) {
            $data['image']  = Util::saveFile($request->file('image'), '');
        } else {
            $data['image'] = "/images/user_default.png";
        }
        $data['idwho'] = Auth::user()->id;
        $user          = User::create($data);
        if($request->get('role'))
        {
            $user->attachRole($request->get('role'));
        }
        else
        {
            $user->roles()->sync([]);
        }
        $arrLastUser = User::leftjoin('role_user','role_user.user_id','=','users.id')
                         ->leftjoin('roles','roles.id','=','role_user.role_id')
                         ->where('users.id', '=', $user->id)
                         ->first();
        $strProvinceCode   = strtoupper(\App\Util::StringExplodeProvince($arrLastUser->province));
        $strRoleCode       = strtoupper($arrLastUser->name);
        $data['code'] = $strRoleCode . '-' . $strProvinceCode . '-' . $arrLastUser->user_id;
        $user->update($data);
        if ($request->is('admin/customers/*')) {
            $url = "admin/customers";
        } else {
            $url = "admin/users";
        }
        return redirect($url)->with(['flash_level' => 'success', 'flash_message' => 'Tạo thành công']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $user = User::find($id);
        $data = [
            'id'   => $id,
            'user' => $user,
        ];
        return view('admin.users.edit',$data);
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
        $data     = [
            'id'       => $id,
            'roles'    => $roles,
            'user'     => $user,
            'roleUser' => $roleUser,
            'province' => $province,

        ];
        return view('admin.users.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        $today = date("Y-m-d_H-i-s");
        $user  = User::find($id);
        $data  = $request->all();
        if ($request->hasFile('image')) {
            $data['image']  = Util::saveFile($request->file('image'), '');
        }
        if(!empty($request->get('email'))){
            $data['email']    = $request->get('email');
        }
        if(!empty($request->get('password'))){
            $data['password'] = bcrypt($request->get('password'));
        }
        $user->update($data);
        $roleUser             = RoleUser::where('user_id', $id)->first();
        $roleUser->role_id    = $request->get('role');
        DB::table('role_user')
            ->where('user_id',$id)
            ->update(['role_id' => $request->get('role')]);
            return redirect()->back()->with(['flash_level' => 'success', 'flash_message' => 'Lưu thành công']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $checkOrder = User::checkUserHasOrder($id);
        if ($checkOrder == 0) {
            $user =  User::destroy($id);
        } else {
            return redirect()->back()->with(['flash_level' => 'danger', 'flash_message' => 'Khách hàng này đang có đơn hàng, nên không thể xóa']);
        }

        if(!empty($user) ) {
            return redirect()->back()->with(['flash_level' => 'success', 'flash_message' => 'Xóa thành công']);
        }
        else{

            return redirect()->back()->with(['flash_level' => 'danger', 'flash_message' => 'Chưa thể xóa']);
        }
    }
}
