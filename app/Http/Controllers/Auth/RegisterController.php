<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Socialite;
use App\Traits\CaptchaTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Notifications\NotificationUser;
use Illuminate\Notifications\Notifiable;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers,CaptchaTrait;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $data['captcha'] = $this->captchaCheck();
        return Validator::make($data, [
            'name' => 'required|max:255',
            'province' => 'required',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|numbers|symbols|min:6|confirmed',
            'g-recaptcha-response'  => 'required',
            'captcha' => 'required|min:1'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {

         $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'myIntroCode' => $data['myIntroCode'],
            'introCode' => $data['introCode'],
            'province' => $data['province'],
            'image' => '/images/user_default.png',
            'password' => bcrypt($data['password']),
        ]);
        $user->attachRole(3);
        return $user;
    }

    // login socialite
    public function redirectToProvider()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback()
    {
        /*$socialiteUser = Socialite::driver('facebook')->user();
        return $socialiteUser->getId();*/
        try {
            $socialiteUser = Socialite::driver('facebook')->user();
        } catch (Exception $e) {
            return redirect('/');
        }
        $user = User::where('facebook_id',$socialiteUser->getId())->first();
        if (!$user) {
            $myIntroCode = str_random(8);
            $dataUser = [
                'facebook_id' => $socialiteUser->getId(),
                'name' => $socialiteUser->getName(),
                'email' => $socialiteUser->getEmail(),
                'myIntroCode' => $myIntroCode,
                'image' => '/images/user_default.png',
            ];
            $user = User::create($dataUser);
            $user->attachRole(3);
        }
        auth()->login($user);
        return redirect()->to('/');
    }
}
