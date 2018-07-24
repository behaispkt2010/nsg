@extends('layouts.frontend')
@section('title', 'blog')
@section('description','blog')
@section('add_styles')
{{-- --}}
@endsection
@section('content')
			<div class="secondary_page_wrapper">

				<div class="container" style="padding-left: 35px;">

					<ul class="breadcrumbs">

						<li><a href="/">Trang chủ</a></li>
						<li>Blogs</li>

					</ul>

					<div class="row">

						<aside class="col-md-3 col-sm-4" style="margin-top: -10px;">

						@include('frontend.witgets.category-post')
						@include('frontend.witgets.hot-post')
						@include('frontend.panner.blog-banner')

						</aside><!--/ [col]-->

						<main class="col-md-9 col-sm-8">

							<h5>@if(empty($category))Tin tức @else {{$category->name}} @endif</h5>

							<header class="top_box on_the_sides">

								<div class="left_side v_centered">

									<div class="layout_type buttons_row" data-table-container="#main_blog_list">

										<a href="#" data-table-layout="grid_view" class="button_grey middle_btn icon_btn tooltip_container"><i class="icon-th"></i><span class="tooltip top">Grid View</span></a>

										<a href="#" data-table-layout="list_view" class="button_grey middle_btn icon_btn active tooltip_container"><i class="icon-th-list"></i><span class="tooltip top">List View</span></a>

									</div>

									{{--<p>Showing 1 to 3 of 45 (15 Pages)</p>--}}

								</div>

								<div class="right_side">
									{!! $blogs->render() !!}

								</div>

							</header>

							<ul id="main_blog_list" class="list_of_entries list_view">
								@if(count($blogs)==0)
									<h4 class="text-center">Không tìm thấy bài viết</h4>
									@else
								@foreach($blogs as $blog)

								<li>

									<article class="entry">

										<a href="{{url('/blog')}}/{{\App\Category::getSlugCategory($blog->category)}}/{{$blog->slug}}" class="thumbnail entry_image">

											<img src="{{url('/')}}{{$blog->image}}" alt="">

										</a>

										<h4 class="entry_title" style="font-size:16px;"><a href="{{url('/blog')}}/{{\App\Category::getSlugCategory($blog->category)}}/{{$blog->slug}}">{{$blog->title}}</a></h4>

										<div class="entry_meta">

											<div class="alignleft">

												<span><i class="icon-calendar"></i> {{$blog->created_at->format('d-m-Y')}}</span>

												<span><a href="#" class="comments"><i class="icon-comment"></i> @if(empty($blog->view))0 @else{{$blog->view}}@endif</a></span>


												<span><i class="icon-folder-open-empty-1"></i> <a href="#">{{\App\Category::getNameCateById($blog->category)}}</a></span>

											</div>



										</div><!--/ .byline-->

										<p>{!!\App\Util::_substr($blog->content,300)!!}</p>

										<a href="{{url('/blog')}}/{{\App\Category::getSlugCategory($blog->id)}}/{{$blog->slug}}" class="button_grey middle_btn">Đọc thêm</a>

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


						</main><!--/ [col]-->


					</div><!--/ .row-->

				</div><!--/ .container-->

			</div><!--/ .page_wrapper-->
			
			<!-- - - - - - - - - - - - - - End Page Wrapper - - - - - - - - - - - - - - - - -->
@endsection