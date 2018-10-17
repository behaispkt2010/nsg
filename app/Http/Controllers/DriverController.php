<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\DriverRequest;
use App\Driver;
use App\Util;
use App\Province;
use App\User;
use App\CarType;
use App\Transport;
use Yajra\Datatables\Datatables;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function AjaxCreateTransport(DriverRequest $request) {
        $data['kho'] = Auth::user()->id;
        $data     = $request->all();
        $driver   = Driver::create($data);
        $response = array(
            'status' => 'success',
            'msg'    => 'Setting created successfully'
        );
        return \Response::json($response);
    }
    public function AjaxGetDataTransport(Request $request) {
        $arrDrivers = Driver::leftjoin('transports','transports.id','=','driver.type_driver')
                        ->selectRaw('driver.*')
                        ->selectRaw('transports.name as name')
                        ->where('driver.id', $request->get('id_select_transport'))
                        ->get();
                        // dd($arrDrivers);
        foreach ($arrDrivers as $itemDriver) {
            $id_driver              = $itemDriver['id'];
            $name                   = $itemDriver['name'];
            $name_driver            = $itemDriver['name_driver'];
            $phone_driver           = $itemDriver['phone_driver'];
            $number_license_driver  = $itemDriver['number_license_driver'];
        }
        $response = array(
            'name'                  => $name,
            'id_driver'             => $id_driver,
            'name_driver'           => $name_driver,
            'phone_driver'          => $phone_driver,
            'number_license_driver' => $number_license_driver
        );
        return \Response::json($response);
    }
    public function index(Request $request)
    {
        if ($request->get('name') || $request->get('kho') || $request->get('type_trans')) {
            $name    = $request->get('name');
            $kho     = $request->get('kho');
            $type_trans = $request->get('type_trans');
            // echo($name);
            // echo "<br>";
            // echo($kho);
            // echo "<br>";
            // echo($type_trans);
            // dd(1);
            $driver1 = Driver::query();
            if(!empty($name) || !empty($kho) || !empty($type_trans)) {
                if(Auth::user()->hasRole(\App\Util::$viewDriver))
                    $driver1 =  $driver1->leftjoin('transports','transports.id','=','driver.type_driver')
                                        ->selectRaw('driver.*')
                                        ->selectRaw('transports.name as transName')
                                        ->where('driver.name_driver','LiKE','%'.$name.'%')
                                        ->orwhere('driver.phone_driver','LiKE','%'.$name.'%')
                                        ->orwhere('driver.kho', $kho)
                                        ->orwhere('driver.type_driver', $type_trans)
                                        ->where('driver.deleted', 0);
                else {
                    $driver1 =  $driver1->leftjoin('transports','transports.id','=','driver.type_driver')
                                        ->selectRaw('driver.*')
                                        ->selectRaw('transports.name as transName')
                                        ->where('driver.kho', Auth::user()->id)
                                        ->where('driver.deleted', 0)
                                        ->where(function($q)use ($name) {
                                            $q->where('driver.name_driver','LiKE','%'.$name.'%')
                                            ->orWhere('driver.phone_driver','LiKE','%'.$name.'%');
                                         })
                                        ->where('driver.type_driver', $type_trans);
                }
            }
            
            $driver = $driver1->paginate(9);
            
        }
        else if(Auth::user()->hasRole(\App\Util::$viewDriver)) {
            $driver = Driver::leftjoin('transports','transports.id','=','driver.type_driver')
                ->selectRaw('driver.*')
                ->selectRaw('transports.name as transName')
                ->orderBy('driver.id', 'DESC')
                ->where('driver.deleted', 0)
                ->paginate(9);
        }
        else {
            $driver = Driver::leftjoin('transports','transports.id','=','driver.type_driver')
                ->selectRaw('driver.*')
                ->selectRaw('transports.name as transName')
                ->orderBy('driver.id','DESC')
                ->where('driver.kho',Auth::user()->id)
                ->where('driver.deleted', 0)
                ->paginate(9);
        }
        $user = User::select('users.*','ware_houses.id as ware_houses_id','ware_houses.level as level')
            ->leftjoin('role_user','role_user.user_id','=','users.id')
            ->leftjoin('ware_houses','ware_houses.user_id','=','users.id')
            ->where('role_user.role_id', 4)
            ->where('users.deleted', 0)
            ->get();
        // dd($driver);  
        $transport = Transport::where('deleted', 0)->get();
        $data = [
            'user'      => $user,
            'driver'    => $driver,
            'transport' => $transport,
        ];
        return view('admin.driver.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $arrTransport = Transport::where('deleted', 0)->get();
        $arrProvince  = Province::where('deleted', 0)->get();
        $arrCarType   = CarType::where('deleted', 0)->get();
        $data = [
            'transport' => $arrTransport,
            'province'  => $arrProvince,
            'cartype'   => $arrCarType
        ];
        return view('admin.driver.edit', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DriverRequest $request)
    {
        $data        = $request->all();
        $data['kho'] = Auth::user()->id;
        if ($request->hasFile('image_identity')) {
            $data['image_identity']  = Util::saveFile($request->file('image_identity'), '');
        }
        if ($request->hasFile('image_car')) {
            $data['image_car']  = Util::saveFile($request->file('image_car'), '');
        }
        Driver::create($data);
        return redirect('admin/driver/')->with(['flash_level'=>'success','flash_message'=>'Thành công']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $driver = Driver::find($id);
        $data   = [
            'id'     => $id,
            'driver' => $driver,
        ];
        return view('admin.driver.edit', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $driver       = Driver::find($id);
        $arrProvince  = Province::where('deleted', 0)->get();
        $arrCarType   = CarType::where('deleted', 0)->get();
        $transport    = Transport::where('deleted', 0)->get();
        $data   = [
            'transport' => $transport,
            'province'  => $arrProvince,
            'cartype'   => $arrCarType,
            'id'        => $id,
            'driver'    => $driver,
        ];
        return view('admin.driver.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DriverRequest $request, $id)
    {
        $data   = $request->all();
        if ($request->hasFile('image_identity')) {
            $data['image_identity']  = Util::saveFile($request->file('image_identity'), '');
        }
        if ($request->hasFile('image_car')) {
            $data['image_car']  = Util::saveFile($request->file('image_car'), '');
        }
        $driver = Driver::find($id);
        $driver->update($data);
        return redirect('admin/driver/')->with(['flash_level'=>'success','flash_message'=>'Lưu thành công']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $driver =  Driver::destroy($id);
        if(!empty($driver)) {
            return redirect('admin/driver/')->with(['flash_level' => 'success', 'flash_message' => 'Xóa thành công']);
        }
        else{
            return redirect('admin/driver/')->with(['flash_level' => 'danger', 'flash_message' => 'Chưa thể xóa']);
        }
    }
}
