@extends('layouts.frontend')
@section('title', 'Trang chủ')
@section('description','trang chủ')

@section('content')
			<!-- - - - - - - - - - - - - - Page Wrapper - - - - - - - - - - - - - - - - -->
			<div class="page_wrapper">

				<div class="container">

					<div class="section_offset">

						<div class="row">
							<div class="col-xs-12 col-md-3">
								@include('frontend.witgets.category-product')

							</div>
							<div class="col-xs-12 col-md-9">
									{!! \App\Setting::getValue('slider')!!}
								</div><!--/ #layerslider-->
								<!-- - - - - - - - - - - - - - End of layer slider - - - - - - - - - - - - - - - - -->
							<div class="clear"></div>
							<br>
							<div class="section_offset">

								<div class="row">

									<div class="col-sm-6">

										<a href="#" class="banner animated visible fadeInDown" data-animation="fadeInDown">

											<img src="{{url('/')}}/images/home-banner.jpeg" alt="">

										</a>

									</div><!--/ [col]-->

									<div class="col-sm-6">

										<a href="#" class="banner animated visible fadeInDown" data-animation="fadeInDown" data-animation-delay="150" style="animation-delay: 150ms;">

											<img src="{{url('/')}}/images/home-banner.jpeg" alt="">

										</a>

									</div><!--/ [col]-->

								</div><!--/ .row-->

							</div>
								</div><!--/ [col]-->

						</div><!--/ .row-->

					</div><!--/ .section_offset-->

					<div class="row">

						<aside class="col-md-3 col-sm-12">
							@include('partial.frontend-banner')
						</aside>

						<main class="col-md-9 col-sm-12">



							<!-- - - - - - - - - - - - - - Category - - - - - - - - - - - - - - - - -->

							@foreach($allCategory as $itemAllCategory)
							<section class="section_offset animated transparent" data-animation="fadeInDown">

								<h3 class="offset_title">{{$itemAllCategory->name}}</h3>

								<div class="tabs type_3 products">

									<!-- - - - - - - - - - - - - - Navigation of tabs - - - - - - - - - - - - - - - - -->

									<ul class="theme_menu tabs_nav clearfix theme_menu_{{$itemAllCategory->id}}">

										@foreach(\App\Product::getChildCateByCate($itemAllCategory->id) as $item)
										<li class="has_submenu"><a href="#tab-{{$item->id}}">{{$item->name}}</a></li>
										@endforeach

									</ul>

									<!-- - - - - - - - - - - - - - End navigation of tabs - - - - - - - - - - - - - - - - -->

									<!-- - - - - - - - - - - - - - Tabs container - - - - - - - - - - - - - - - - -->

									<div class="tab_containers_wrap">
										@foreach(\App\Product::getChildCateByCate($itemAllCategory->id) as $item)

										<div id="tab-{{$item->id}}" class="tab_container">

											<!-- - - - - - - - - - - - - - Carousel of today's deals - - - - - - - - - - - - - - - - -->

											<div class="owl_carousel carousel_in_tabs ">

												@foreach(\App\Product::getProductByCate($item->id) as $product)
												<!-- - - - - - - - - - - - - - Product - - - - - - - - - - - - - - - - -->

												<div class="product_item">

													<!-- - - - - - - - - - - - - - Thumbmnail - - - - - - - - - - - - - - - - -->

													<div class="image_wrap">

														<a href="{{url('/product').'/'.\App\CategoryProduct::getSlugCategoryProduct($product->id).'/'.$product->slug}}"><img src="{{url('/').$product->image}}" alt=""></a>

														<!-- - - - - - - - - - - - - - Product actions - - - - - - - - - - - - - - - - -->

														<!-- - - - - - - - - - - - - - End of product actions - - - - - - - - - - - - - - - - -->

														<!-- - - - - - - - - - - - - - Label - - - - - - - - - - - - - - - - -->

														<div class="label_new">New</div>

														<!-- - - - - - - - - - - - - - End label - - - - - - - - - - - - - - - - -->

													</div><!--/. image_wrap-->

													<!-- - - - - - - - - - - - - - End thumbmnail - - - - - - - - - - - - - - - - -->

													<!-- - - - - - - - - - - - - - Product title & price - - - - - - - - - - - - - - - - -->

													<div class="description">

														<a href="#" class="clearfix">{{$product->title}}</a>

														<div class="kho_info clearfix">
															<a href="#" class="alignleft photo">
																@if($product->levelKho == 1)
																	<img src="{{url('/images')}}/level1.png" alt="">
																@elseif($product->levelKho == 2)
																	<img src="{{url('/images')}}/level2.png" alt="">
																@elseif($product->levelKho == 3)
																	<img src="{{url('/images')}}/level3.png" alt="">
																@else
																	<img src="{{url('/images')}}/level0.jpg" alt="">
																@endif
															</a>
															<p class="alignleft"><b>{{ $product->nameKho  }}</b></p>
														</div>
														<div class="clearfix product_info">
															<p class="product_price alignleft"><b>{{ number_format($product->price_out)  }} VNĐ</b></p>
															<span class="alignright">{!! \App\Rate::getRateProduct($product->id)!!}</span>
														</div>
														<div class="clearfix product_info">
															<p class="alignleft">Tối thiểu: {{ number_format($product->min_gram)  }} Kg</p>
														</div>
													</div>

													<!-- - - - - - - - - - - - - - End of product title & price - - - - - - - - - - - - - - - - -->

												</div><!--/ .product_item-->


												<!-- - - - - - - - - - - - - - End of product - - - - - - - - - - - - - - - - -->

												@endforeach
											</div><!--/ .owl_carousel-->

											<!-- - - - - - - - - - - - - - End of carousel of today's deals - - - - - - - - - - - - - - - - -->

										</div><!--/ #tab-15-->
										@endforeach


									</div>

									<!-- - - - - - - - - - - - - - End of tabs containers - - - - - - - - - - - - - - - - -->

								</div>

							</section>

							<!-- - - - - - - - - - - - - - End of cate - - - - - - - - - - - - - - - - -->
							@endforeach


							<!-- - - - - - - - - - - - - - Tabs - - - - - - - - - - - - - - - - -->

							<div class="tabs products section_offset animated transparent" data-animation="fadeInDown" data-animation-delay="150">

								<!-- - - - - - - - - - - - - - Navigation of tabs - - - - - - - - - - - - - - - - -->

								<ul class="tabs_nav clearfix">

									<li><a href="#tab-1">Sản phẩm mới</a></li>
									<li><a href="#tab-2">Sản phẩm đánh giá tốt</a></li>


								</ul>

								<!-- - - - - - - - - - - - - - End navigation of tabs - - - - - - - - - - - - - - - - -->

								<!-- - - - - - - - - - - - - - Tabs container - - - - - - - - - - - - - - - - -->

								<div class="tab_containers_wrap">

									<!-- - - - - - - - - - - - - - news products - - - - - - - - - - - - - - - - -->

									<div id="tab-1" class="tab_container">

										<div class="table_layout">
											<?php $i=0 ;$j=0?>
											@foreach($getNewProduct as $key => $product)
												@if($i==0)<div class="table_row">@endif
																<!-- - - - - - - - - - - - - - Product - - - - - - - - - - - - - - - - -->
														<div class="table_cell">

															<div class="product_item">

																<!-- - - - - - - - - - - - - - Thumbmnail - - - - - - - - - - - - - - - - -->

																<div class="image_wrap">

																	<a href="{{url('/product').'/'.\App\CategoryProduct::getSlugCategoryProduct($product->id).'/'.$product->slug}}"><img src="{{url('/').$product->image}}" alt=""></a>

																	<!-- - - - - - - - - - - - - - Product actions - - - - - - - - - - - - - - - - -->

																	<!-- - - - - - - - - - - - - - End of product actions - - - - - - - - - - - - - - - - -->

																	<!-- - - - - - - - - - - - - - Label - - - - - - - - - - - - - - - - -->

																	<div class="label_new">New</div>

																	<!-- - - - - - - - - - - - - - End label - - - - - - - - - - - - - - - - -->

																</div><!--/. image_wrap-->

																<!-- - - - - - - - - - - - - - End thumbmnail - - - - - - - - - - - - - - - - -->

																<!-- - - - - - - - - - - - - - Product title & price - - - - - - - - - - - - - - - - -->

																<div class="description">

																	<a href="#" class="clearfix">{{$product->title}}</a>

																	<div class="kho_info clearfix">
																		<a href="#" class="alignleft photo">
																		@if($product->levelKho == 1)
																			<img src="{{url('/images')}}/level1.png" alt="">
																		@elseif($product->levelKho == 2)
																			<img src="{{url('/images')}}/level2.png" alt="">
																		@elseif($product->levelKho == 3)
																			<img src="{{url('/images')}}/level3.png" alt="">
																		@else
																			<img src="{{url('/images')}}/level0.jpg" alt="">
																		@endif
																		</a>
																		<p class="alignleft"><b>{{ $product->nameKho  }}</b></p>
																	</div>
																	<div class="clearfix product_info">
																		<p class="product_price alignleft"><b>{{ number_format($product->price_out)  }} VNĐ</b></p>
																		<span class="alignright">{!! \App\Rate::getRateProduct($product->id)!!}</span>
																	</div>
																	<div class="clearfix product_info">
																		<p class="alignleft">Tối thiểu: {{ number_format($product->min_gram)  }} Kg</p>
																	</div>
																</div>

																<!-- - - - - - - - - - - - - - End of product title & price - - - - - - - - - - - - - - - - -->

															</div><!--/ .product_item-->
														</div>
														<?php $i = $i+1; $j=$j+1; ?>
														@if ($i>=4 || $j>=count($getNewProduct))
															<?php $i=0 ?>
															</div>
														@endif
											@endforeach
										</div>
										<!-- - - - - - - - - - - - - - View all products - - - - - - - - - - - - - - - - -->
										<footer class="bottom_box">
											<a href="/products" class="button_grey middle_btn">Xem nhiều sản phẩm</a>
										</footer>
										<!-- - - - - - - - - - - - - - End of view all products - - - - - - - - - - - - - - - - -->

									</div>

									<!-- - - - - - - - - - - - - - End of featured products - - - - - - - - - - - - - - - - -->

									<!-- - - - - - - - - - - - - - good products - - - - - - - - - - - - - - - - -->
									<div id="tab-2" class="tab_container">


										<div class="table_layout">
											<?php $i=0 ;$j=0?>
											@foreach($getBestStarsProduct as $key=> $product)
												@if($i==0)<div class="table_row">@endif
															<!-- - - - - - - - - - - - - - Product - - - - - - - - - - - - - - - - -->
													<div class="table_cell">

														<div class="product_item">

															<!-- - - - - - - - - - - - - - Thumbmnail - - - - - - - - - - - - - - - - -->

															<div class="image_wrap">

																<a href="{{url('/product').'/'.\App\CategoryProduct::getSlugCategoryProduct($product->id).'/'.$product->slug}}"><img src="{{url('/').$product->image}}" alt=""></a>


																<!-- - - - - - - - - - - - - - Product actions - - - - - - - - - - - - - - - - -->

																<!-- - - - - - - - - - - - - - End of product actions - - - - - - - - - - - - - - - - -->

																<!-- - - - - - - - - - - - - - Label - - - - - - - - - - - - - - - - -->

																<div class="label_hot">Hot</div>


																<!-- - - - - - - - - - - - - - End label - - - - - - - - - - - - - - - - -->

															</div><!--/. image_wrap-->

															<!-- - - - - - - - - - - - - - End thumbmnail - - - - - - - - - - - - - - - - -->

															<!-- - - - - - - - - - - - - - Product title & price - - - - - - - - - - - - - - - - -->

															<div class="description">

																<a href="#">{{$product->title}}</a>
																<div class="kho_info clearfix">
																	<a href="#" class="alignleft photo">
																		@if($product->levelKho == 1)
																			<img src="{{url('/images')}}/level1.png" alt="">
																		@elseif($product->levelKho == 2)
																			<img src="{{url('/images')}}/level2.png" alt="">
																		@elseif($product->levelKho == 3)
																			<img src="{{url('/images')}}/level3.png" alt="">
																		@else
																			<img src="{{url('/images')}}/level0.jpg" alt="">
																		@endif
																	</a>
																	<p class="alignleft"><b>{{ $product->nameKho  }}</b></p>
																</div>
																<div class="clearfix product_info">

																	<p class="product_price alignleft"><b>{{ number_format($product->price_out)  }} VNĐ</b></p>
																	<span class="alignright">
											{!! \App\Rate::getRateProduct($product->id)!!}
											</span>
																</div>
																<div class="clearfix product_info">
																	<p class="alignleft">Tối thiểu: {{ number_format($product->min_gram)  }} Kg</p>
																</div>
															</div>

															<!-- - - - - - - - - - - - - - End of product title & price - - - - - - - - - - - - - - - - -->

														</div><!--/ .product_item-->

													</div>
													<?php $i = $i+1;$j=$j+1; ?>
													@if($i>=4|| $j>=count($getBestStarsProduct))
														<?php $i=0 ?>
												</div>
												@endif

											@endforeach



										</div>

										<!-- - - - - - - - - - - - - - View all products - - - - - - - - - - - - - - - - -->

										<footer class="bottom_box">

											<a href="/products" class="button_grey middle_btn">Xem nhiều sản phẩm</a>

										</footer>

										<!-- - - - - - - - - - - - - - End of view all products - - - - - - - - - - - - - - - - -->

									</div>

									<!-- - - - - - - - - - - - - - End of new products - - - - - - - - - - - - - - - - -->

								</div>

								<!-- - - - - - - - - - - - - - End of tabs container - - - - - - - - - - - - - - - - -->

							</div>

							<!-- - - - - - - - - - - - - - End of tabs - - - - - - - - - - - - - - - - -->

							

							<!-- - - - - - - - - - - - - - Bestsellers - - - - - - - - - - - - - - - - -->

							<section class="section_offset animated transparent" data-animation="fadeInDown" style="display: none;">

								<h3>Sản phẩm bán chạy</h3>
								<div class="table_layout">
									<?php $i=0 ;$j=0?>
									@foreach($bestSellerProduct as $key=> $product)
										@if($i==0)<div class="table_row">@endif
													<!-- - - - - - - - - - - - - - Product - - - - - - - - - - - - - - - - -->
											<div class="table_cell">

												<div class="product_item">

													<!-- - - - - - - - - - - - - - Thumbmnail - - - - - - - - - - - - - - - - -->

													<div class="image_wrap">

														<a href="{{url('/product').'/'.\App\CategoryProduct::getSlugCategoryProduct($product->id).'/'.$product->slug}}"><img src="{{url('/').$product->image}}" alt=""></a>


														<!-- - - - - - - - - - - - - - Product actions - - - - - - - - - - - - - - - - -->

														<!-- - - - - - - - - - - - - - End of product actions - - - - - - - - - - - - - - - - -->

														<!-- - - - - - - - - - - - - - Label - - - - - - - - - - - - - - - - -->

														<div class="label_bestseller">Bestseller</div>



														<!-- - - - - - - - - - - - - - End label - - - - - - - - - - - - - - - - -->

													</div><!--/. image_wrap-->

													<!-- - - - - - - - - - - - - - End thumbmnail - - - - - - - - - - - - - - - - -->

													<!-- - - - - - - - - - - - - - Product title & price - - - - - - - - - - - - - - - - -->

													<div class="description">

														<a href="#">{{$product->title}}</a>
														<div class="kho_info clearfix">
															<a href="#" class="alignleft photo">
																@if($product->levelKho == 1)
																	<img src="{{url('/images')}}/level1.png" alt="">
																@elseif($product->levelKho == 2)
																	<img src="{{url('/images')}}/level2.png" alt="">
																@elseif($product->levelKho == 3)
																	<img src="{{url('/images')}}/level3.png" alt="">
																@else
																	<img src="{{url('/images')}}/level0.jpg" alt="">
																@endif
															</a>
															<p class="alignleft"><b>{{ $product->nameKho  }}</b></p>
														</div>
														<div class="clearfix product_info">

															<p class="product_price alignleft"><b>{{ number_format($product->price_out)  }} VNĐ</b></p>
															<span class="alignright">
											{!! \App\Rate::getRateProduct($product->id)!!}
											</span>

														</div>
														<div class="clearfix product_info">
															<p class="alignleft">Tối thiểu: {{ number_format($product->min_gram)  }} Kg</p>
														</div>
													</div>

													<!-- - - - - - - - - - - - - - End of product title & price - - - - - - - - - - - - - - - - -->

												</div><!--/ .product_item-->

											</div>
											<?php $i = $i+1;$j=$j+1; ?>
											@if($i>=4|| $j>=count($bestSellerProduct))
												<?php $i=0 ?>
										</div>
										@endif

									@endforeach



								</div>


								<!-- - - - - - - - - - - - - - View all products - - - - - - - - - - - - - - - - -->

								<footer class="bottom_box">

									<a href="/products" class="button_grey middle_btn">Xem nhiều sản phẩm</a>

								</footer>

								<!-- - - - - - - - - - - - - - End of view all products - - - - - - - - - - - - - - - - -->

							</section>

							<!-- - - - - - - - - - - - - - End of bestsellers - - - - - - - - - - - - - - - - -->

							

						</main>

					</div><!--/ .row-->

				</div><!--/ .container-->

			</div><!--/ .page_wrapper-->
			
			<!-- - - - - - - - - - - - - - End Page Wrapper - - - - - - - - - - - - - - - - -->
@endsection