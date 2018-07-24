<?php

namespace App\Http\Controllers;

use App\Province;
use App\Role;
use App\RoleUser;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
Use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\DB;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->get('q')){
            $q     = $request->get('q');
            $users = User::leftjoin('role_user','role_user.user_id','=','users.id')
                ->where('role_user.role_id',5)
                ->where('deleted', 0)
                ->where('name','LIKE','%'.$q.'%')
                ->orwhere('id','LIKE','%'.$q.'%')
                ->orwhere('phone_number','LIKE','%'.$q.'%')
                ->paginate(9);
        }
        else {
            $users = User::leftjoin('role_user','role_user.user_id','=','users.id')
                ->where('role_user.role_id',5)
                ->where('users.deleted', 0)
                ->orderBy('id','DESC')
                ->paginate(9);
        }
        $roles = RoleUser::leftjoin('users','role_user.user_id','=','users.id')
            ->leftjoin('roles','roles.id','=','role_user.role_id')
            ->get();
        $data = [
            'users' => $users,
            'roles' => $roles,
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
        $data     = [
            'role'     => 'staff',
            'roles'    => $roles,
            'province' => $province
        ];
        return view('admin.users.edit',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
       //
    }
}
