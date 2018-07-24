<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\WebsiteLink;
use App\NewsCompany;

class WebsiteLinkController extends Controller
{
    public function index()
    {
        $websitelink = WebsiteLink::where('deleted', 0)->get();
        $data        = [
            'pricing' => $websitelink,
            'type'    => 'websitelink',
        ];
        return view('admin.websitelink.index', $data);
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
        $article =  WebsiteLink::destroy($id);
        if(!empty($article)) {
            return redirect('admin/websitelink/')->with(['flash_level' => 'success', 'flash_message' => 'Xóa thành công']);
        }
        else{
            return redirect('admin/websitelink/')->with(['flash_level' => 'danger', 'flash_message' => 'Chưa thể xóa']);

        }
    }

    /**
     * Show a list of all the languages posts formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function data()
    {
        $pricing = WebsiteLink::get()
            ->map(function ($pricing) {
                return [
                    'id'            => $pricing->id,
                    'website_name'  => $pricing->website_name,
                    'website_url'   => $pricing->website_url,
                    'website_image' => $pricing->website_image,
                    //'author_id' => NewsCompany::getUserName($pricing->author_id),
                ];
            });

        return Datatables::of($pricing)
            ->add_column('actions',
                '<a class="btn-xs btn-info" href="#" style="margin-right: 5px;display: inline" data-toggle="modal" data-target=".modal-pricing_edit" id="pricing_edit_modal" data-id="{{$id}}" data-website_name="{{$website_name}}" data-website_url="{{$website_url}}" data-website_image="{{$website_image}}"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                <form action="{{route(\'websitelink.destroy\',[\'id\' => $id])}}" method="post" class="form-delete" style="display: inline">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <input type="text" class="hidden" value="{{$id}}">
                     {{method_field("DELETE")}}
               		<a type="submit" class = "btn-xs btn-danger" name ="delete_modal" style="display: inline-block"><i class="fa fa-trash" aria-hidden="true"></i></a>
                </form>')
            ->remove_column('id')
            ->make();
    }
    public function AjaxCreateWebsiteLink (Request $request) {
    	$user_id           = Auth::user()->id;
    	$data              = $request->all();
    	$data['author_id'] = $user_id;
    	$response          = array(
             'status' => 'success',
             'msg'    => 'Setting created successfully',
        );
        WebsiteLink::create($data);
        return \Response::json($response);
    }
    public function AjaxUpdateWebsiteLink (Request $request) {
    	$user_id               = Auth::user()->id;
    	$id                    = $request->get('id');
        $website               = WebsiteLink::find($id);
        $data                  = $request->all();
        $data['website_name']  = $request->get('website_name');
    	$data['website_url']   = $request->get('website_url');
        $data['website_image'] = $request->get('website_image');
    	$data['author_id']     = $user_id;
        $website->update($data);
        $response = array(
            'status' => 'success',
            'msg'    => 'Setting created successfully',
        );
        return \Response::json($response);
    }
}
