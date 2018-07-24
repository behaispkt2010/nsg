<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use App\Notifications\NotificationUser;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */

    protected $redirectTo = '/';
    /*public function redirectPath()
    {
        $redirect = route('users.edit',['id' => Auth::user()->id]);
        return $redirect;
        if(Auth::user()->hasRole(['admin','editor'])) {
            return '/admin';
        }
        else if(Auth::user()->hasRole('kho')) {
            return '/admin/dashboard';
        }
        else {
            return '/';
        }
    }*/

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
}
