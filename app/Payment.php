<?php

namespace App;

use DateTime;
use App\Util;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Payment extends Model
{
	protected $table = 'payment';
    protected $fillable = ['code', 'type','cate','status','price','type_pay', 'type_pay_detail', 'period_pay', 'time_pay','author_id', 'note', 'order_id', 'deleted'];

    public static function getMoneyCommission($idWH) {
    	$arrPayment = Payment::where('type', 'payment')
							->where('cate', Util::$commission)
							->where('status', 2)
							->where('author_id', $idWH)
							->get();
		$res = 0;
		foreach ($arrPayment as $itemPayment) {
			$res = $res + $itemPayment->price;
		}
		return $res;
    }
}
