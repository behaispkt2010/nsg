<?php

namespace App;

use App\Order;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use App\Notifications\NotificationUser;

/**
 * App\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $unreadNotifications
 * @method static \Illuminate\Database\Query\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereUpdatedAt($value)
 * @mixin \Eloquent
 */

class User  extends Model implements AuthenticatableContract, CanResetPasswordContract {

    use Authenticatable, CanResetPassword, EntrustUserTrait, Notifiable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','facebook_id','idwho','email','address','province', 'district', 'password','phone_number','image','introCode','myIntroCode','birthday','deleted', 'code', 'deleted'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * @param $value
     */
    /*public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }*/

    public function checkEmailExits($email) {
        $user = User::where('email', $email)->get();
        return count($user);
    }

    public static function checkUserHasOrder($strUID) {
        $user = Order::where('customer_id', $strUID)->get();
        return count($user);
    }


}
