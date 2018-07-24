<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReferralCodeController extends Controller
{
    public function index(){
        $userID 	= Auth::user()->id;
        $arrGetUser = User::find($userID);
        $data = [
            'arrGetUser' => $arrGetUser,
        ];
        return view('admin.referralcode.index', $data);
    }
}
