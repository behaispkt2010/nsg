<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\Pricing;
use App\Document;
use App\NewsCompany;

class DocumentController extends Controller
{
    public function index()
    {
        $document = Document::get();
        $data     = [
            'document' => $document,
            'type'     => 'document',
        ];
        return view('admin.document.index', $data);
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
        $document =  Document::destroy($id);
        if(!empty($document)) {
            return redirect('admin/document/')->with(['flash_level' => 'success', 'flash_message' => 'Xóa thành công']);
        }
        else{
            return redirect('admin/document/')->with(['flash_level' => 'danger', 'flash_message' => 'Chưa thể xóa']);

        }
    }

    /**
     * Show a list of all the languages posts formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function data()
    {
        $document = Document::get()
            ->map(function ($document) {
                return [
                    'id' => $document->id,
                    'name' => $document->name,
                    'author' => $document->author,
                    'description' => $document->description,
                    'link' => $document->link,
                ];
            });

        return Datatables::of($document)
            ->add_column('actions',
                '<a class="btn-xs btn-info" href="#" style="margin-right: 5px;display: inline" data-toggle="modal" data-target=".modal-document_edit" id="document_edit_modal" data-id="{{$id}}" data-name="{{$name}}" data-link="{{$link}}" data-description="{{$description}}" data-author="{{$author}}"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                <form action="{{route(\'document.destroy\',[\'id\' => $id])}}" method="post" class="form-delete" style="display: inline">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <input type="text" class="hidden" value="{{$id}}">
                     {{method_field("DELETE")}}
               		<a type="submit" class = "btn-xs btn-danger" name ="delete_modal" style="display: inline-block"><i class="fa fa-trash" aria-hidden="true"></i></a>
                </form>')
            ->remove_column('id')
            ->make();
    }
    public function AjaxCreateDocument (Request $request) {
    	$user_id = Auth::user()->id;
    	$data = $request->all();
    	$response = array(
             'status' => 'success',
             'msg' => 'Setting created successfully',
        );
        Document::create($data);
        return \Response::json($response);
    }
    public function AjaxUpdateDocument (Request $request) {
    	$user_id = Auth::user()->id;
    	$id = $request->get('id');
        $document =  Document::find($id);
        $data = $request->all();
        $document->update($data);
        $response = array(
            'status' => 'success',
            'msg' => 'Setting created successfully',
        );
        return \Response::json($response);
    }
}
