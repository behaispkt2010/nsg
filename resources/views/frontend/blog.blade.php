@extends('layouts.blogs')
@section('title', 'blog')
@section('description','blog')

@section('url_seo', url('/').$_SERVER['REQUEST_URI'] )
@section('type_seo','article')
@section('title_seo', 'nosaGO.com - Mạng lưới kho nông sản Việt Nam ' )
@section('description_seo','Kết nối nguồn hàng chất lượng và đối tác uy tín' )
@section('image_seo', url('/').'/frontend/images/nosago1.png' )

@section('add_styles')
{{-- --}}
@endsection
@section('content')
			<div class="secondary_page_wrapper col-md-12 col-sm-12">
				<div class="container col-md-12 col-sm-12">
					<ul class="breadcrumbs">
						<li><a href="/">Trang chủ</a></li>
						<li>Blogs</li>
					</ul>
					<div class="row col-md-10 col-sm-10 col-xs-12 col-md-offset-1 col-sm-offset-1">
						<main class="col-md-9 col-sm-8 col-xs-12">
							<h5>@if(empty($category))Tin tức @else {{$category->name}} @endif</h5>
							
							<ul id="main_blog_list" class="list_of_entries list_view">
								@if(count($blogs)==0)
									<h4 class="text-center">Không tìm thấy bài viết</h4>
									@else
								@foreach($blogs as $blog)
								<li>
									<article class="entry blogitem">
										<div class="img_blog">
											<a href="{{url('/blog')}}/{{\App\Category::getSlugCategory($blog->category)}}/{{$blog->slug}}" class=" entry_image">
												<img src="{{url('/')}}{{$blog->image}}" alt="">
											</a>
										</div>
										<div class="entry_meta">
											<h4 class="entry_title" style="font-size:16px;"><a href="{{url('/blog')}}/{{\App\Category::getSlugCategory($blog->category)}}/{{$blog->slug}}">{{$blog->title}}</a></h4>
											<div class="alignleft">
												<span><i class="icon-calendar"></i> {{$blog->created_at->format('d-m-Y')}}</span>
												<span><a href="#" class="comments"><i class="icon-comment"></i> @if(empty($blog->view))0 @else{{$blog->view}}@endif</a></span>
												<span><i class="icon-folder-open-empty-1"></i> <a href="#">{{\App\Category::getNameCateById($blog->category)}}</a></span>
											</div>
										</div>
										<p>{!! \App\Util::_substr($blog->content,300) !!}</p>

										<!-- <a href="{{url('/blog')}}/{{\App\Category::getSlugCategory($blog->id)}}/{{$blog->slug}}" class="button_grey middle_btn">Đọc thêm</a> -->

									</article>
								</li>
							@endforeach
								@endif
							</ul>
							<footer class="bottom_box on_the_sides">
								<div class="left_side">
								</div>
								<div class="right_side ">
									{!! $blogs->render() !!}
								</div>
							</footer>
						</main>
						<aside class="col-md-3 col-sm-4" style="margin-top: -10px;">

						
						@include('frontend.witgets.hot-post')
						@include('frontend.panner.blog-banner')

						</aside>
					</div>
				</div>
			</div>
@endsection