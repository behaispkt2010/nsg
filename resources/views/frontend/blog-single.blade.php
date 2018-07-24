@extends('layouts.blogs')
@section('title', 'chi tiết')
@section('description','chi tiết bài viết')

@section('url_seo', url('/').$_SERVER['REQUEST_URI'] )
@section('type_seo','article')
@section('title_seo', $singleBlog->title_seo )
@section('description_seo',$singleBlog->description )
@section('image_seo', url('/').$singleBlog->image )

@section('add_styles')
@endsection
@section('content')
			<!-- - - - - - - - - - - - - - Page Wrapper - - - - - - - - - - - - - - - - -->

			<div class="secondary_page_wrapper col-md-12 col-sm-12">
				<div class="container col-md-12 col-sm-12">
					<!-- - - - - - - - - - - - - - Breadcrumbs - - - - - - - - - - - - - - - - -->
					<ul class="breadcrumbs">
						<li><a href="/">Trang chủ</a></li>
						<li><a href="/blogs">Blogs</a></li>
						<li>{{$singleBlog->title}}</li>
					</ul>
					<div class="row">
						<aside class="col-md-3 col-sm-4">
							@include('frontend.witgets.category-post')
							@include('frontend.witgets.hot-post')
							@include('frontend.panner.blog-banner')
						</aside><!--/ [col]-->
						<main class="col-md-9 col-sm-8">
							<section class="section_offset">
								<h1>{{$singleBlog->title}}</h1>
								<!-- - - - - - - - - - - - - - Entry - - - - - - - - - - - - - - - - -->
								<article class="entry single">
									<!-- - - - - - - - - - - - - - Entry meta - - - - - - - - - - - - - - - - -->
									<div class="entry_meta">
										<div class="alignleft">
											<span><i class="icon-calendar"></i> {{$singleBlog->created_at->format('d-m-Y')}}</span>
											<span><i class="icon-comment"></i>@if(empty($singleBlog->view)) 0 @else {{$singleBlog->view}}@endif</span>
											<span><i class="icon-folder-open-empty-1"></i> <a href="{{url('/category-blog')}}/{{$cate}}">{{\App\Category::getNameCateById($singleBlog->category)}}</a></span>
										</div>
									</div><!--/ .entry_meta-->
									<div class="entry_image">
										{{--<img src="{{url('/')}}{{$singleBlog->image}}" alt="">--}}
									</div>
									<div class="content">
										{!! $singleBlog->content !!}
									</div>
									<div class="v_centered share">
										<span class="title">Chia sẻ:</span>
										<div class="addthis_widget_container">
											<div class="fb-share-button" data-href="{{url('/')}}{{$_SERVER['REQUEST_URI']}}" data-layout="button_count" data-size="small" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;src=sdkpreparse">Chia sẻ</a></div>
										</div>
									</div><!--/ .v_centered-->
								</article>
								<!-- - - - - - - - - - - - - - End of entry - - - - - - - - - - - - - - - - -->
								{{--<footer class="bottom_box">--}}

									{{--Tags: <a href="#">beauty</a>, <a href="#">medicine</a>, <a href="#">health</a>--}}

								{{--</footer>--}}

							</section>

							<!-- - - - - - - - - - - - - - Related posts - - - - - - - - - - - - - - - - -->

							<section class="section_offset">
								
								<h3>Bài viết cùng danh mục</h3>

								<div class="table_layout related_posts">

									<div class="table_row">

										@foreach(\App\Article::getRelatedArticle($singleBlog->id,3) as $itemRelated)

										<!-- - - - - - - - - - - - - - Entry - - - - - - - - - - - - - - - - -->

										<div class="table_cell">

											<article class="entry">
												
												<!-- - - - - - - - - - - - - - Thumbnail - - - - - - - - - - - - - - - - -->

												<a href="{{url('/blog')}}/{{\App\Category::getSlugCategory($itemRelated->id)}}/{{$itemRelated->slug}}" class="entry_thumb">

													<img src="{{url('/')}}/{{$itemRelated->image}}" alt="">

												</a>

												<!-- - - - - - - - - - - - - - End of thumbnail - - - - - - - - - - - - - - - - -->

												<div class="wrapper">

													<h6 class="entry_title"><a href="{{url('/blog')}}/{{\App\Category::getSlugCategory($itemRelated->id)}}/{{$itemRelated->slug}}">{{$itemRelated->title}}</a></h6>

													<!-- - - - - - - - - - - - - - Byline - - - - - - - - - - - - - - - - -->

													<div class="entry_meta">

														<span><i class="icon-calendar"></i> {{$itemRelated->created_at->format('d-m-Y')}}</span>

														<span><a href="{{url('/blog')}}/{{\App\Category::getSlugCategory($itemRelated->id)}}/{{$itemRelated->slug}}" class="comments"><i class="icon-comment"></i> @if(empty($itemRelated->view)) 0 @else {{$itemRelated->view}}@endif</a></span>

													</div><!--/ .byline-->

													<!-- - - - - - - - - - - - - - End of byline - - - - - - - - - - - - - - - - -->

												</div><!--/ .wrapper-->

											</article><!--/ .clearfix-->

										</div>

										<!-- - - - - - - - - - - - - - End of entry - - - - - - - - - - - - - - - - -->
										@endforeach
									</div>

								</div>						

							</section>

							<!-- - - - - - - - - - - - - - End related posts - - - - - - - - - - - - - - - - -->

							<!-- - - - - - - - - - - - - - Comments - - - - - - - - - - - - - - - - -->

							<section class="section_offset">
								


										<div class="clear"></div>
										<div class="comment">
											<div class="fb-comments" data-href="{{url('/')}}{{$_SERVER['REQUEST_URI']}}" data-width="100%" data-numposts="5"></div>
										</div>



									<!-- - - - - - - - - - - - - - End of comment (level 1) - - - - - - - - - - - - - - - - -->



							</section>

							<!-- - - - - - - - - - - - - - End of comments - - - - - - - - - - - - - - - - -->

							<!-- - - - - - - - - - - - - - Leave a comment - - - - - - - - - - - - - - - - -->


						</main><!--/ [col]-->

					</div><!--/ .row-->

				</div><!--/ .container-->

			</div><!--/ .page_wrapper-->
			
			<!-- - - - - - - - - - - - - - End Page Wrapper - - - - - - - - - - - - - - - - -->
@endsection
@section('add-script')

	@endsection