<?php

namespace App\Http\Controllers;

use App\NewsCompany;
use App\CategoryProduct;
use App\Util;
use App\User;
use App\Company;
use App\Notification;
use App\Mail\MailBroadCastProduct;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\ArticleRequest;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;

class NewsCompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $strIDUser = Auth::user()->id;
        if(Auth::user()->hasRole(\App\Util::$viewNewsCompany)) {
            $newsCompany = NewsCompany::where('status', 1)->where('deleted', 0)->get();
        }
        else {
            $newsCompany = NewsCompany::where('status', 1)->where('deleted', 0)->where('author_id', $strIDUser)->get();
        }
        $data = [
            'article' => $newsCompany,
            'type'    => 'newscompany',
        ];
        return view('admin.newscompany.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = CategoryProduct::where('disable',0)->get();
        $data     = [
            'category' => $category,
        ];
        return view('admin.newscompany.edit',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleRequest $request)
    {
        $today       = date("Y-m-d_H-i-s");
        $strIDUser   = Auth::user()->id;
        $newsCompany = new NewsCompany;
        $data        = $request->all();
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
            $data['slug']  = Util::builtSlug($request->get('title'));
        }
        $checkSlug = NewsCompany::where('slug', $data['slug'])->count();
        if($checkSlug != 0){
            $data['slug'] =  $data['slug'].'-'.$today;
        }
        $news = NewsCompany::create($data);
        // insert notify
        if (Auth::user()->hasRole('com')) {
            $getCodeKho                         = Util::UserCode($strIDUser);
            $dataNotify['keyname']              = Util::$newscompany;
            $dataNotify['title']                = "Cơ hội mua bán mới";
            $dataNotify['content']              = "Công ty ".$getCodeKho." vừa đăng cơ hội mua bán mới.";
            $dataNotify['author_id']            = $strIDUser;
            $dataNotify['orderID_or_productID'] = $news->id;
            $dataNotify['link']                 = '/admin/newscompany/'.$news->id.'/edit';
            foreach (Util::getIdUserOfRole(Util::$roleviewAdmin) as $itemUser) {
                $dataNotify['roleview'] = $itemUser;
                $notify = Notification::create($dataNotify);
                $message = 'OK';
                if(isset($message)) {
                    $redis = Redis::connection();
                    $redis->publish("messages", json_encode(array(
                        "status"     => 200,
                        "id"         => $news->id,  
                        "notifyID"   => $notify->id,
                        "roleview"   => $itemUser,
                        "title"      => "Cơ hội mua bán mới",
                        "link"       => "/admin/newscompany/".$news->id."/edit",
                        "content"    => "Công ty ".$getCodeKho." vừa đăng cơ hội mua bán mới.",
                        "created_at" => date('Y-m-d H:i:s')
                    )));
                }
            }
        }

        $getInfoWareHouse = NewsCompany::select('news_company.*', 'users.*', 'products.kho as idwarehouse','news_company.title as productName','company.name as companyName')
            ->leftjoin('products','products.category','=','news_company.category')
            ->leftjoin('users','users.id','=','products.kho')
            ->leftjoin('company','company.user_id','=','news_company.author_id')
            ->where('news_company.category',$data['category'])
            ->where('news_company.author_id', $strIDUser)
            ->get();
        $getInfoCompany = Company::select('users.*')
            ->leftjoin('users','users.id','=','company.user_id')
            ->where('company.user_id', $strIDUser)
            ->get(); 
        $arrMailWareHouse = [];
        foreach ($getInfoWareHouse as $key => $itemInfoWareHouse) {
            if ( !in_array($itemInfoWareHouse->email, $arrMailWareHouse) ) {
                array_push($arrMailWareHouse, $itemInfoWareHouse->email);
            }    
            $productName = $itemInfoWareHouse->productName;
            $companyName = $itemInfoWareHouse->companyName;
            $content = $itemInfoWareHouse->content;
        }
        foreach ($getInfoCompany as $key => $itemgetInfoCompany) {
            $phoneCompany = $itemgetInfoCompany->phone_number;
        }
        // echo $companyName;
        // print_r($arrMailWareHouse);   
        // dd($getInfoWareHouse);
        foreach ($arrMailWareHouse as $key => $itemMailWareHouse) {
            $data = [
                "companyName"  => $companyName,
                "content"      => $content,
                "phoneCompany" => $phoneCompany,
                "subject"      => "Sản phẩm Công ty đang cần ". $productName
            ];
            $to = $itemMailWareHouse;
            $to = Util::$mailadmin;
            // Mail::to($to)->send(new MailBroadCastProduct($data));
        }
        $admin = Util::$mailadmin;
        Mail::to($admin)->send(new MailBroadCastProduct($data));
        return redirect('admin/newscompany/')->with(['flash_level' => 'success', 'flash_message' => 'Tạo thành công']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $newsCompany = NewsCompany::find($id);
        $data = [
            'id'     => $id,
            'article'=> $newsCompany,
        ];
        return view('admin.newscompany.edit',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   $category    = CategoryProduct::where('disable',0)->get();
        $newsCompany = NewsCompany::find($id);
        $data = [
            'id'       => $id,
            'article'  => $newsCompany,
            'category' => $category,
        ];
        return view('admin.newscompany.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ArticleRequest $request, $id)
    {
        $today = date("Y-m-d_H-i-s");
        $data  = $request->all();
        $newsCompany =  NewsCompany::find($id);
        if(Auth::user()->hasRole(\App\Util::$viewNewsCompany)) {
            $data['author_id'] = $newsCompany->author_id;
        }    
        else {
            if(!empty(Auth::user()->id)) {
                $data['author_id'] = Auth::user()->id;
            }
            else{
                $data['author_id'] = 1;
            }
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
        $checkSlug = NewsCompany::where('slug', $data['slug'])->count();
        if($checkSlug != 0){
            $data['slug'] =  $data['slug'].'-'.$today;
        }
        if (($newsCompany->status == 0) && $request->get('status') == 1){
            // $getCodeProduct = Util::ProductCode($newsCompany->id);
            $dataNotify['keyname']              = Util::$newscompanySuccess;
            $dataNotify['title']                = "Cơ hội mua bán mới";
            $dataNotify['content']              = "Cơ hội mua bán của bạn đã được duyệt.";
            $dataNotify['author_id']            = Auth::user()->id;
            $dataNotify['orderID_or_productID'] = $newsCompany->id;
            $dataNotify['roleview']             = $newsCompany->author_id;
            $dataNotify['link']                 = '/admin/newscompany/'.$id.'/edit';
            $notify                             = Notification::create($dataNotify);
            $message                            = 'OK';
            if(isset($message)) {
                $redis = Redis::connection();
                $redis->publish("messages", json_encode(array(
                    "status"     => 200,
                    "id"         => $id,  
                    "notifyID"   => $notify->id,
                    "roleview"   => $newsCompany->author_id,
                    "title"      => "Cơ hội mua bán mới",
                    "link"       => "/admin/newscompany/".$id."/edit",
                    "content"    => "Cơ hội mua bán của bạn đã được duyệt.",
                    "created_at" => date('Y-m-d H:i:s')
                )));
            }
        }
        $newsCompany->update($data);

        

        return redirect('admin/newscompany/')->with(['flash_level' => 'success', 'flash_message' => 'Lưu thành công']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $newsCompany =  NewsCompany::destroy($id);
        if(!empty($newsCompany)) {
            return redirect('admin/newscompany/')->with(['flash_level' => 'success', 'flash_message' => 'Xóa thành công']);
        }
        else{
            return redirect('admin/newscompany/')->with(['flash_level' => 'danger', 'flash_message' => 'Chưa thể xóa']);

        }
    }

    /**
     * Show a list of all the languages posts formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function data()
    {
        $strIDUser = Auth::user()->id;
        if(Auth::user()->hasRole(\App\Util::$viewNewsCompany)) {
            $newsCompany = NewsCompany::get()
            ->map(function ($newsCompany) {
                return [
                    'id'         => $newsCompany->id,
                    'title'      => $newsCompany->title,
                    'category'   => CategoryProduct::getSlugCategoryProduct($newsCompany->category), // cang ak
                    'author_id'  => NewsCompany::getUserName($newsCompany->author_id),
                    'created_at' => $newsCompany->created_at->format('d/m/Y'),
                ];
            });
        }
        else {
            $newsCompany = NewsCompany::where('author_id', $strIDUser)->get()
            ->map(function ($newsCompany) {
                return [
                    'id'         => $newsCompany->id,
                    'title'      => $newsCompany->title,
                    'category'   => CategoryProduct::getSlugCategoryProduct($newsCompany->category), // cang ak
                    'author_id'  => NewsCompany::getUserName($newsCompany->author_id),
                    'created_at' => $newsCompany->created_at->format('d/m/Y'),
                ];
            });
        }
        
        return Datatables::of($newsCompany)
            ->add_column('actions',
                '<a class = "btn-xs btn-info" href="{{route(\'newscompany.edit\',[\'id\' => $id])}}" style="margin-right: 5px;display: inline"><i class="fa fa-pencil"  aria-hidden="true"></i></a>
                            <form action="{{route(\'newscompany.destroy\',[\'id\' => $id])}}" method="post" class="form-delete" style="display: inline">
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                <input type="text" class="hidden" value="{{$id}}">
                                 {{method_field("DELETE")}}
                           <a type="submit" class = "btn-xs btn-danger" name ="delete_modal" style="display: inline-block"><i class="fa fa-trash" aria-hidden="true"></i></a>
                            </form>')
            ->remove_column('id')
            ->make();
    }
}
