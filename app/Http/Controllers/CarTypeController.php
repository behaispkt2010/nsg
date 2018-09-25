<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CarType;

class CarTypeController extends Controller
{
    /**
     * Create a type cart.
     *
     * @return null
     */
    public function createAjax(Request $request) {
        $name = $request->get('name');
        $data['name'] = $name;
        CarType::create($data);
        $response = array(
            'status' => 'success',
            'msg' => 'Setting created successfully',
        );
        return \Response::json($response);
    }
    /**
     * Update a type cart.
     *
     * @return null
     */
    public function updateAjax(Request $request) {
        $id = $request->get('id');
        $name = $request->get('name');
        $data['name'] = $name;
        $arrType = CarType::find($id);
        $arrType->update($data);
        $response = array(
            'status' => 'success',
            'msg' => 'Setting created successfully',
        );
        return \Response::json($response);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->get('name')){
            $name = $request->get('name');
            $arrType = CarType::where('name','LiKE','%'.$name.'%')->where('deleted', 0)->orderBy('id', "DESC")->paginate(12);
        } else {
            $arrType = CarType::where('deleted', 0)->orderBy('id', "DESC")->paginate(12);
        }
        $data = [
            'arrType' => $arrType
        ];
        return view('admin.cartype.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        $data['deleted'] = 1;
        $arrTrans = CarType::find($id);
        $arrTrans->update($data);
        return redirect('admin/cartype/')->with(['flash_level' => 'success', 'flash_message' => 'Xóa thành công']);
    }
}
