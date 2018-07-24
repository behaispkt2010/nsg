<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Notification extends Model
{
    protected $table = 'notification';
    protected $fillable = ['keyname','title','content','link', 'author_id', 'orderID_or_productID','roleview','is_read', 'deleted'];
    public static function GetNotify($strUserID){
        if(Auth::user()->hasRole('kho')) {
            $arrNotify = Notification::leftjoin('users','notification.author_id','=','users.id')
                ->leftjoin('ware_houses','ware_houses.user_id','=','notification.author_id')
                ->where('notification.roleview', $strUserID)
                ->selectRaw('users.* ')
                ->selectRaw('ware_houses.* ')
                ->selectRaw('notification.created_at, notification.keyname, notification.orderID_or_productID, notification.title, notification.content, notification.roleview, notification.author_id, notification.link, notification.id, notification.is_read')
                ->orderBy('notification.id','DESC')
                ->take(5)
                ->get();
        } elseif(Auth::user()->hasRole('com')) { 
            $arrNotify = Notification::leftjoin('users','notification.author_id','=','users.id')
                ->leftjoin('company','company.user_id','=','notification.author_id')
                ->where('notification.roleview', $strUserID)
                ->selectRaw('users.* ')
                ->selectRaw('company.* ')
                ->selectRaw('notification.created_at, notification.keyname, notification.orderID_or_productID, notification.title, notification.content, notification.roleview, notification.author_id, notification.link, notification.id, notification.is_read')
                ->orderBy('notification.id','DESC')
                ->take(5)
                ->get();
        } else {
            $arrNotify = Notification::leftjoin('users','notification.author_id','=','users.id')
            ->leftjoin('ware_houses','ware_houses.user_id','=','notification.author_id')
            ->where('notification.roleview', $strUserID)
            ->selectRaw('users.* ')
            ->selectRaw('ware_houses.* ')
            ->selectRaw('notification.created_at, notification.keyname, notification.orderID_or_productID, notification.title, notification.content, notification.roleview, notification.author_id, notification.link, notification.id, notification.is_read')
            ->orderBy('notification.id','DESC')
            ->take(5)
            ->get();
        }
        return $arrNotify;
    }
}
