<?php

namespace App\Http\Controllers\Frontend;

use App\Article;
use App\Category;
use App\Pricing;
use App\Document;
use App\WebsiteLink;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BlogController extends Controller
{
    public function index(){
        $news = Category::leftJoin('articles', 'categories.id', '=', 'articles.category')
            ->where('articles.category','=', 1)
            ->orderBy('articles.id','DESC')
            ->selectRaw('articles.*')
            ->selectRaw('categories.slug as cateSlug')
            ->take(10)
            ->get();
        $arrCateNews = Category::find('1');    
        $arrFamer = Category::find('2');    
        $category_technical = Category::whereNotIn('id',[1,2])->get();
        $pricing = Pricing::get();
        $website = WebsiteLink::get();
        $data = [
            'news' => $news,
            'cateNews' => $arrCateNews,
            'arrFamer' => $arrFamer,
            'category_technical' => $category_technical,
            'pricing' => $pricing,
            'website' => $website
        ];
        // dd($news);
        return view('frontend.blogs.blog_homepage', $data);
        // return view('frontend.blog',$data);

    }

    public function CateBlog($cate){

        $category = Category::where('slug',$cate)->first();
        if(count($category) == 0){
            $idCate = 0;
        }
        else {
            $idCate = $category->id;
        }
        $blogs = Article::orderBy('id','DESC')
            ->where('category',$idCate)
            ->paginate(10);

        $data=[
            'blogs'=>$blogs,
            'category'=>$category
        ];
//        dd($blogs);
        return view('frontend.blog',$data);
    }
    public function SingleBlog($cate,$slug){
        $singleBlog = Article::select('articles.*','views.view')
        ->leftJoin('views','views.id','=','articles.id')
            ->where('slug',$slug)
            ->first();
        $data =[
            "singleBlog"=>$singleBlog,
            "cate"=>$cate
        ];
//        dd($singleBlog);
        return view('frontend.blog-single', $data);

    }
    public function PricingMaker () {
        $pricing = Pricing::get();
        $data = [
            'pricing' => $pricing,
        ];
        // dd($pricing);
        return view('frontend.blogs.pricing', $data);
    }
    public function Document () {
        $document = Document::get();
        $data = [
            'document' => $document,
        ];
        // dd($document);
        return view('frontend.blogs.document', $data);
    }
}
