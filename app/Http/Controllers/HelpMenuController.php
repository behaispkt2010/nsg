<?php

namespace App\Http\Controllers;

use App\Util;
use App\HelpMenu;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class HelpMenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createAjax(Request $request){

        $helpmenu          = new HelpMenu();
        $today             = date("Y-m-d_H-i-s");
        $data              = $request->all();
        $data['parent_id'] = $request->get('parent');
        $linkTmp           = Util::builtSlug($request->get('text'));
        $data['link']      = '/tro-giup/'.$linkTmp;
        dd ($data);
         HelpMenu::create($data);
         $response = array(
             'status' => 'success',
             'msg' => 'Setting created successfully',
         );
         return \Response::json($response);
    }

    /**
     * ajax update
     */
    public function updateAjax(Request $request)
    {
        $id                = $request->get('id');
        $helpmenu          =  HelpMenu::find($id);
        $today             = date("Y-m-d_H-i-s");
        $data              = $request->all();
        $data['parent_id'] = $request->get('parent');
        $linkTmp           = Util::builtSlug($request->get('text'));
        $data['link']      = '/tro-giup/'.$linkTmp;
        $helpmenu->update($data);
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
        $helpmenu  = HelpMenu::where('status', 1)->where('deleted', 0)->paginate(15);
        $helpmenu0 = HelpMenu::where('parent_id','0')->where('deleted', 0)->get();
        $data = [
            'helpmenu'  => $helpmenu,
            'helpmenu0' => $helpmenu0,
        ];
        //dd($categoryProduct);
        return view('admin.helpmenu.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $helpmenu = HelpMenu::where('parent_id','0')->get();
        $data = [
            'helpmenu' => $helpmenu,
        ];
        return view('admin.helpmenu.edit', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $helpmenu = new HelpMenu();
        $today    = date("Y-m-d_H-i-s");
        $data     = $request->all();

        $linkTmp  = Util::builtSlug($request->get('text'));
        $data['link']  = '/tro-giup/'.$linkTmp;
        
        HelpMenu::create($data);
        return redirect('admin/help-menu/')->with(['flash_level' => 'success', 'flash_message' => 'Lưu thành công']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $helpmenu = HelpMenu::find($id);
        $data = [
            'id'       => $id,
            'helpmenu' => $helpmenu,
        ];
        return view('admin.helpmenu.edit', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $helpmenu        = HelpMenu::get();
        $helpmenuContent = HelpMenu::find($id);
        $data = [
            'id'              => $id,
            'helpmenu'        => $helpmenu,
            'helpmenuContent' => $helpmenuContent,
        ];
        return view('admin.helpmenu.edit',$data);
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
        $today         = date("Y-m-d_H-i-s");
        $data          = $request->all();
        $helpmenu      =  HelpMenu::find($id);

        $linkTmp       = Util::builtSlug($request->get('text'));
        $data['link']  = '/tro-giup/'.$linkTmp;

        $helpmenu->update($data);
        return redirect('admin/help-menu/')->with(['flash_level' => 'success', 'flash_message' => 'Lưu thành công']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $res =  HelpMenu::destroy($id);
        if(!empty($res)) {
            return redirect('admin/help-menu/')->with(['flash_level' => 'success', 'flash_message' => 'Xóa thành công']);
        }
        else{
            return redirect('admin/help-menu/')->with(['flash_level' => 'danger', 'flash_message' => 'Chưa thể xóa']);

        }
    }
}
