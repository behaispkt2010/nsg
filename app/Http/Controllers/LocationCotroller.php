<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\LocationGps;

class LocationCotroller extends Controller
{
    /*public function getLocation(){
        return View('welcome');

    }*/
    public function getMap(){
        $location = LocationGps::select('location_gps.*','ware_houses.ndd as name','ware_houses.level as level','users.phone_number as phone_number','ware_houses.address as address','users.id as users_id')
        ->leftjoin('users','users.id','=','location_gps.id_user')
        ->leftjoin('ware_houses','ware_houses.user_id','=','location_gps.id_user')
        ->get();
        // dd($location);
        return view('admin.partial.maps',compact('location'));

    }
    public function getAdd(){
        return view('admin.partial.add');
    }
    public function postAdd(Request $request){
        $idUser    = $request->get('id_user');
        $lat       = $request->get('maps_maplat');
        $lon       = $request->get('maps_maplng');
        $maps_link = $request->get('maps_link');
//        $address= $request->get('address');
//        $description= $request->get('description');
        $isExistuser = LocationGps::where('id_user',$idUser)->first();
        if(count($isExistuser) == 0) {
            $location              = new LocationGps();
            $location->id_user     = $idUser;
            $location->maps_maplat = $lat;
            $location->maps_maplng = $lon;
            $location->maps_link   = $maps_link;
//            $location->address = $address;
//            $location->description = $description;
            $location->save();
        }
        else{
//            dd($isExistuser);
            $location              = LocationGps::find($isExistuser->id);
            $location->maps_maplat = $lat;
            $location->maps_maplng = $lon;
            $location->maps_link   = $maps_link;
//            $location->address = $address;
//            $location->description = $description;
            $location->save();
        }

        return view('admin.partial.add');

    }
}
