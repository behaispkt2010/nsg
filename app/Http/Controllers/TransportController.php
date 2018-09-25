<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transport;

class TransportController extends Controller
{

    /**
     * Create a transport.
     *
     * @return null
     */
    public function createAjax(Request $request) {
        $name = $request->get('name');
        $data['name'] = $name;
        Transport::create($data);
        $response = array(
            'status' => 'success',
            'msg' => 'Setting created successfully',
        );
        return \Response::json($response);
    }
    /**
     * Update a transport.
     *
     * @return null
     */
    public function updateAjax(Request $request) {
        $id = $request->get('id');
        $name = $request->get('name');
        $data['name'] = $name;
        $arrTrans = Transport::find($id);
        $arrTrans->update($data);
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
            $arrTrans = Transport::where('name','LiKE','%'.$name.'%')->where('deleted', 0)->orderBy('id', "DESC")->paginate(12);
        } else {
            $arrTrans = Transport::where('deleted', 0)->orderBy('id', "DESC")->paginate(12);
        }
        
        $data = [
            'arrTrans' => $arrTrans
        ];
        return view('admin.transport.index', $data);
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
        $arrTrans = Transport::find($id);
        $arrTrans->update($data);
        return redirect('admin/transport/')->with(['flash_level' => 'success', 'flash_message' => 'Xóa thành công']);
    }
}
