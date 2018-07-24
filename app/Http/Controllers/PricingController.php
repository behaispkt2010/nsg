<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\Pricing;
use App\NewsCompany;

class PricingController extends Controller
{
    public function index()
    {
        $pricing = Pricing::where('deleted', 0)->get();
        $data = [
            'pricing' => $pricing,
            'type' => 'pricing',
        ];
        return view('admin.price.index', $data);
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
        $article =  Article::destroy($id);
        if(!empty($article)) {
            return redirect('admin/pricing/')->with(['flash_level' => 'success', 'flash_message' => 'Xóa thành công']);
        }
        else{
            return redirect('admin/pricing/')->with(['flash_level' => 'danger', 'flash_message' => 'Chưa thể xóa']);

        }
    }

    /**
     * Show a list of all the languages posts formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function data()
    {
        $pricing = Pricing::get()
            ->map(function ($pricing) {
                return [
                    'id' => $pricing->id,
                    'product_name' => $pricing->product_name,
                    'price_new' => $pricing->price_new,
                    'price_old' => $pricing->price_old,
                    'change' => $pricing->change,
                    'source' => $pricing->source,
                    'author_id' => NewsCompany::getUserName($pricing->author_id),
                ];
            });

        return Datatables::of($pricing)
            ->add_column('actions',
                '<a class="btn-xs btn-info" href="#" style="margin-right: 5px;display: inline" data-toggle="modal" data-target=".modal-pricing_edit" id="pricing_edit_modal" data-id="{{$id}}" data-product_name="{{$product_name}}" data-price_new="{{$price_new}}" data-source="{{$source}}"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                <form action="{{route(\'pricing.destroy\',[\'id\' => $id])}}" method="post" class="form-delete" style="display: inline">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <input type="text" class="hidden" value="{{$id}}">
                     {{method_field("DELETE")}}
               		<a type="submit" class = "btn-xs btn-danger" name ="delete_modal" style="display: inline-block"><i class="fa fa-trash" aria-hidden="true"></i></a>
                </form>')
            ->remove_column('id')
            ->make();
    }
    public function AjaxCreatePricing (Request $request) {
    	$user_id = Auth::user()->id;
    	$data = $request->all();
    	$data['price_old'] = 0;
    	$data['change'] = "0";
    	$data['author_id'] = $user_id;
    	$response = array(
             'status' => 'success',
             'msg' => 'Setting created successfully',
        );
        Pricing::create($data);
        return \Response::json($response);
    }
    public function AjaxUpdatePricing (Request $request) {
    	$user_id = Auth::user()->id;
    	$id = $request->get('id');
        $pricing =  Pricing::find($id);
        $data = $request->all();
        $data['price_old'] = $pricing->price_new;
    	$data['change'] = ($request->get('price_new')) - ($pricing->price_new);
    	$data['author_id'] = $user_id;
        $pricing->update($data);
        $response = array(
            'status' => 'success',
            'msg' => 'Setting created successfully',
        );
        return \Response::json($response);
    }
}
