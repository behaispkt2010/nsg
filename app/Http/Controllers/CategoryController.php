<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\CategoryRequest;
use App\Util;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category  = Category::get();
        $category0 = Category::where('parent',0)
            ->where('deleted', 0)
            ->orwhere('parent',1)
            ->orwhere('parent',2)
            ->orwhere('parent',3)
            ->get();
        $data = [
            'data'     => $category0,
            'category' =>  $category,
            'type'     => 'category',
        ];
        //dd($category);
        return view('admin.category.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {

        $today    = date("Y-m-d_H-i-s");
        $category = new Category;
        $data     = $request->all();
        if(!empty(Auth::user()->id)) {
            $data['author_id'] = Auth::user()->id;
        }
        else{
            $data['author_id'] = 1;
        }

        if ($request->hasFile('image')) {
            $data['image']  = Util::saveFile($request->file('image'), '');
        }

        if (!empty($request->get('slug_seo'))) {
            $data['slug']  = Util::builtSlug($request->get('slug_seo'));
        }
        else{
            $data['slug']  = Util::builtSlug($request->get('name'));
        }
        $checkSlug = Category::where('slug', $data['slug'])->count();
        if($checkSlug != 0){
            $data['slug'] =  $data['slug'].'-'.$today;
        }
        Category::create($data);
        return redirect('admin/category/')->with(['flash_level' => 'success', 'flash_message' => 'Tạo thành công']);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::find($id);
        $data = [
            'id'      => $id,
            'article' => $category,
        ];
        return view('admin.category.index',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category  = Category::find($id);
        $category0 = Category::where('parent',0)
            ->orwhere('parent',1)
            ->orwhere('parent',2)
            ->orwhere('parent',3)
            ->get();
        $data = [
            'data'     => $category0,
            'category' => $category,
            'type'     => 'category',
            'id'       => $id
        ];
        return view('admin.category.index',$data);
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
        $today    = date("Y-m-d_H-i-s");
        $data     = $request->all();
        $category =  Category::find($id);
        if(!empty(Auth::user()->id)) {
            $data['author_id'] = Auth::user()->id;
        }
        else{
            $data['author_id'] = 1;
        }

        if ($request->hasFile('image')) {
            $data['image']  = Util::saveFile($request->file('image'), '');
        }
        if ($request->get('slug_seo')!="") {
            $data['slug']  = Util::builtSlug($request->get('slug_seo'));
        }
        else{
            $data['slug']  = Util::builtSlug($request->get('title'));
        }
        $checkSlug = Category::where('slug', $data['slug'])->count();
        if($checkSlug != 0){
            $data['slug'] =  $data['slug'].'-'.$today;
        }
        $category->update($data);
        return redirect('admin/category/')->with(['flash_level' => 'success', 'flash_message' => 'Lưu thành công']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category =  Category::destroy($id);
        if(!empty($category)) {
            return redirect('admin/category/')->with(['flash_level' => 'success', 'flash_message' => 'Xóa thành công']);
        }
        else{
            return redirect('admin/category/')->with(['flash_level' => 'success', 'flash_message' => 'Chưa thể xóa']);

        }
    }
    public function data()
    {
        $categorys = Category::get()
            ->map(function ($category) {
                return [
                    'id'         => $category->id,
                    'name'       => $category->name,
                    'parent'     => Category::getNameCateById($category->parent),
                    'created_at' => $category->created_at->format('d/m/Y'),
                ];
            });

        return Datatables::of($categorys)
            ->add_column('actions',
                '<a class = "btn-xs btn-info" href="{{route(\'category.edit\',[\'id\' => $id])}}" style="margin-right: 5px;display: inline"><i class="fa fa-pencil"  aria-hidden="true"></i></a>
                            <form action="{{route(\'category.destroy\',[\'id\' => $id])}}" method="post" class="form-delete" style="display: inline">
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                <input type="text" class="hidden" value="{{$id}}">
                                 {{method_field("DELETE")}}
                           <a type="submit" class = "btn-xs btn-danger" name ="delete_modal" style="display: inline-block"><i class="fa fa-trash" aria-hidden="true"></i></a>
                            </form>')
            ->remove_column('id')
            ->make();
    }
}
