	<!-- - - - - - - - - - - - - - Popular posts - - - - - - - - - - - - - - - - -->

							<section class="section_offset">

								<h5>Bài viết hot</h5>

								<ul class="list_of_entries">
						@foreach(\App\Article::getBestViewProduct(5) as $item)

									<li>

										<article class="entry">

											<a href="{{url('/blog')}}/{{\App\Category::getSlugCategory($item->blog_id)}}/{{$item->slug}}" class="entry_thumb">

												<img src="{{url('/')}}{{$item->image}}" alt="">

											</a>

											<div class="wrapper">

												<h6 class="entry_title"><a href="{{url('/blog')}}/{{\App\Category::getSlugCategory($item->blog_id)}}/{{$item->slug}}">{{$item->title}}</a></h6>

												<div class="entry_meta">

													{{--<span><i class="icon-calendar"></i> {{$item->created_at}}</span>--}}

													<span><i class="icon-comment"></i> {{$item->view}}</span>

												</div><!--/ .byline-->

												<!-- - - - - - - - - - - - - - End of byline - - - - - - - - - - - - - - - - -->

											</div><!--/ .wrapper-->

										</article><!--/ .clearfix-->

									</li>

									<!-- - - - - - - - - - - - - - End of entry - - - - - - - - - - - - - - - - -->
						@endforeach

								</ul>

							</section><!--/ .section_offset -->

							<!-- - - - - - - - - - - - - - End of popular posts - - - - - - - - - - - - - - - - -->
