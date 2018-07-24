<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    protected $fillable = ['product_id','users_id','rate', 'deleted'];

    public static function getRateProduct($id){
        $rates = Rate::where('product_id',$id)
            ->groupBy('product_id')
            ->selectRaw('rates.*, sum(rate) as numRate ,count(*) as countRate')
            ->first();
        if(empty($rates)){
            $rate = 0;
        }
        else{
            $rate = round($rates->numRate / $rates->countRate);
        }
        $html = '<ul class="rating">';
        for($i=0;$i<$rate;$i++) {
            $html = $html .'<li class="active"></li>';
        }
        if($rate<5)
        {
            for($i=0;$i<(5-$rate);$i++) {
                $html = $html .'<li class=""></li>';
            }
        }
        $html= $html .	'</ul>';
        return $html;
    }
    public static function countRate($id){
        $countRates = Rate::where('product_id',$id)->count();
        return $countRates;
    }
}
