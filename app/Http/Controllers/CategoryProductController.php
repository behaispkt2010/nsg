<?php

namespace App\Http\Controllers;

use App\CategoryProduct;
use App\Http\Requests\CategoryProductRequest;
use App\Product;
use App\User;
use App\Util;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class CategoryProductController extends Controller
{
    /**
     * ajax create
     */
     public function createAjax(CategoryProductRequest $request){

         $category      = new CategoryProduct();
         $today         = date("Y-m-d_H-i-s");
         $data          = $request->all();
         $data['slug']  = Util::builtSlug($request->get('name'));
         $checkSlug = CategoryProduct::where('slug', $data['slug'])->count();
         if($checkSlug != 0){
             $data['slug'] =  $data['slug'].'-'.$today;
         }
         CategoryProduct::create($data);
         $response = array(
             'status' => 'success',
             'msg'    => 'Setting created successfully',
         );
         return \Response::json($response);
     }

    /**
     * ajax update
     */
    public function updateAjax(CategoryProductRequest $request)
    {
        $id           = $request->get('id');
        $category     =  CategoryProduct::find($id);
        $today        = date("Y-m-d_H-i-s");
        $data         = $request->all();
        $data['slug'] = Util::builtSlug($request->get('name'));
        $checkSlug = CategoryProduct::where('slug', $data['slug'])->count();
        if ($checkSlug != 0) {
            $data['slug'] = $data['slug'] . '-' . $today;
        }
        $category->update($data);
        $response = array(
            'status' => 'success',
            'msg'    => 'Setting created successfully',
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
        $user_id = Auth::user()->id;
        if($request->get('name') || $request->get('kho')){
            $name = $request->get('name');
            $kho  = $request->get('kho');
            if (Auth::user()->hasRole(\App\Util::$viewCategory)) {
                $categoryProduct = CategoryProduct::where('name','LiKE','%'.$name.'%')->where('disable', 0)->where('deleted', 0)->paginate(6);
            } else {
                $categoryProduct = CategoryProduct::leftjoin('products','products.category','=','category_products.id')
                    ->where('products.kho', $user_id)
                    ->where('category_products.name','LiKE','%'.$name.'%')
                    ->where('category_products.disable', 0)
                    ->where('category_products.deleted', 0)
                    ->paginate(6);
            }
        }
        else {
            if (Auth::user()->hasRole(\App\Util::$viewCategory)) {
                $categoryProduct = CategoryProduct::where('disable', 0)->where('deleted', 0)->paginate(16);
            } else {
                $categoryProduct = CategoryProduct::leftjoin('products','products.category','=','category_products.id')
                    ->where('products.kho', $user_id)
                    ->where('category_products.disable', 0)
                    ->where('category_products.deleted', 0)
                    ->paginate(6);
            }
            
        }
        $categoryProduct0 = CategoryProduct::where('parent','0')->where('disable', 0)->where('deleted', 0)->get();
        $wareHouses       = User::select('users.*','ware_houses.id as ware_houses_id','ware_houses.level as level')
            ->leftjoin('role_user','role_user.user_id','=','users.id')
            ->leftjoin('ware_houses','ware_houses.user_id','=','users.id')
            ->where('role_user.role_id',4)
            ->orderBy('id','DESC')
            ->get();
        $data = [
            'categoryProduct'  => $categoryProduct,
            'categoryProduct0' => $categoryProduct0,
            "wareHouses"       => $wareHouses,
        ];
        //dd($categoryProduct);
        return view('admin.categoryProduct.index',$data);
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
        $res =  CategoryProduct::destroy($id);
        if(!empty($res)) {
            return redirect('admin/categoryProducts/')->with(['flash_level' => 'success', 'flash_message' => 'Xóa thành công']);
        }
        else{
            return redirect('admin/categoryProducts/')->with(['flash_level' => 'success', 'flash_message' => 'Chưa thể xóa']);

        }
    }
    public function data()
    {
        $articles = Article::get()
            ->map(function ($article) {
                return [
                    'id' => $article->id,
                    'title' => $article->title,
                    'category' => Category::getNameCateById($article->category),
                    'author_id' => NewsCompany::getUserName($article->author_id),
                    'created_at' => $article->created_at->format('d/m/Y'),
                ];
            });

        return Datatables::of($articles)
            ->add_column('actions',
                '<a class = "btn-xs btn-info" href="{{route(\'news.edit\',[\'id\' => $id])}}" style="margin-right: 5px;display: inline"><i class="fa fa-pencil"  aria-hidden="true"></i></a>
                            <form action="{{route(\'news.destroy\',[\'id\' => $id])}}" method="post" class="form-delete" style="display: inline">
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                <input type="text" class="hidden" value="{{$id}}">
                                 {{method_field("DELETE")}}
                           <a type="submit" class = "btn-xs btn-danger" name ="delete_modal" style="display: inline-block"><i class="fa fa-trash" aria-hidden="true"></i></a>
                            </form>')
            ->remove_column('id')
            ->make();
    }
}
