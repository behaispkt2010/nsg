<?php

namespace App\Http\Controllers;

use App\CategoryProduct;
use App\Product;
use App\User;
use App\WareHouse;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user_id = Auth::user()->id;
        if ( Auth::user()->hasRole(\App\Util::$viewHistoryInput) ) {
            if($request->get('name') || $request->get('kho')|| $request->get('category')){
                $name     = $request->get('name');
                $kho      = $request->get('kho');
                $cate     = $request->get('category');
                $product1 = Product::query();
                if(!empty($name)){
                    $product1 =  $product1->where('title','LiKE','%'.$name.'%')->where('deleted', 0);
                }
                if(!empty($cate)){
                    $product1 =  $product1->where('category', $cate)->where('deleted', 0);
                }
                if(!empty($kho)){
                    $product1 =  $product1->where('kho', $kho)->where('deleted', 0);
                }

                $product = $product1->paginate(9);
            }
            else {
            $product = Product::orderBy('id','DESC')
                ->where('deleted', 0)
                ->paginate(9);
            }
        }
        else if ( Auth::user()->hasRole(['kho']) ) {
            if($request->get('name') || $request->get('category')){
                $name = $request->get('name');
                $cate = $request->get('category');
                $product1 = Product::query();
                if(!empty($name)){
                    $product1 =  $product1->where('title','LiKE','%'.$name.'%')->where('kho', $user_id)->where('deleted', 0);
                }
                if(!empty($cate)){
                    $product1 =  $product1->where('category', $cate)->where('kho', $user_id)->where('deleted', 0);
                }
                $product = $product1->paginate(9);
            }
            else {
            $product = Product::where('kho', $user_id)
                ->orderBy('id','DESC')
                ->where('deleted', 0)
                ->paginate(9);
            }
            
        }
        
        $category   = CategoryProduct::where('disable',0)->get();
        $wareHouses = User::select('users.*','ware_houses.id as ware_houses_id','ware_houses.level as level')
            ->leftjoin('role_user','role_user.user_id','=','users.id')
            ->leftjoin('ware_houses','ware_houses.user_id','=','users.id')
            ->where('role_user.role_id',4)
            ->where('users.deleted', 0)
            ->orderBy('id','DESC')
            ->get();


        $data = [
            'products'  => $product,
            'wareHouses'=> $wareHouses,
            'category'  => $category,
            'type'      => 'products',
        ];
        return view('admin.inventory.index',$data);
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
