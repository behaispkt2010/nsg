<?php

namespace App\Http\Controllers;

use App\Menu;
use Illuminate\Http\Request;

use App\Http\Requests;

class MenuController extends Controller
{
    public function AjaxSave(Request $request){
        $menu      = Menu::truncate();
        $res       = $request->all();
        $data_menu = $res['jsonMenu'];
        $arrayjson = json_decode($data_menu);
        $id        = 0;
        foreach ($arrayjson as $key => $menuItem) {
            //var_dump($menuItem->label);
            $menu1 = new Menu();
            $data1 = [
                'label'  => $menuItem->label,
                'link'   => $menuItem->url,
                'parent' => '0',
                'sort'   => $key,
                'class'  => $menuItem->class,
            ];
            $menu1::create($data1);
            $id = $id+1;
            if(!empty($menuItem->children)){
                $id_parent = $id;
                foreach($menuItem->children as $key2 => $itemChil2){
                    $menu2 = new Menu();
                    $data2 = [
                        'label'  => $itemChil2->label,
                        'link'   => $itemChil2->url,
                        'parent' => $id_parent,
                        'sort'   => $key2,
                        'class'  => $itemChil2->class,
                    ];
                    $menu2::create($data2);
                    $id = $id+1;
                    if(!empty($itemChil2->children)){
                        $id_parent1 = $id;
                        foreach($itemChil2->children as $key3 => $itemChil3){
                            $menu3 = new Menu();
                            $data3 = [
                                'label'  => $itemChil3->label,
                                'link'   => $itemChil3->url,
                                'parent' => $id_parent1,
                                'sort'   => $key3,
                                'class'  => $itemChil3->class,
                            ];
                            $menu3::create($data3);
                            $id = $id+1;
                        }
                    }
                }
            }
        }
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
    public function index()
    {
        $menu = Menu::get();
        $data = [
            'menu' => $menu
        ];
        return view('admin.menu.index',$data);
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
        //
    }
}
