@extends('layouts.frontend')
@section('title', 'Trang chủ')
@section('description','trang chủ')

@section('content')
			<!-- - - - - - - - - - - - - - Page Wrapper - - - - - - - - - - - - - - - - -->
			<div class="page_wrapper col-md-12 col-sm-12">

				<div class="container col-md-12 col-sm-12">

					<div class="section_offset" style="margin-bottom:0px;">

						<div class="row">
							
							<div class="col-xs-12 col-md-9" style="padding-bottom: 22px; ">
									{!! \App\Setting::getValue('slider')!!}
							</div>
							<div class="clear"></div>
							
							<div class="col-xs-12 hidden-xs">
								<div class="col-sm-3 img_banner" style="padding: 0px;">
									<a href="#" class="">
										<img src="{{url('/')}}/images/fruit.jpg" alt="" class="img_left_border">
									</a>
								</div><!--/ [col]-->
								<div class="col-sm-3 img_banner" style="padding: 0px;">
									<a href="#" class="">
										<img src="{{url('/')}}/images/go.jpg" alt="">
									</a>
								</div><!--/ [col]-->
								<div class="col-sm-3 img_banner" style="padding: 0px;">
									<a href="#" class="">
										<img src="{{url('/')}}/images/seafood.jpeg" alt="">
									</a>
								</div><!--/ [col]-->
								<div class="col-sm-3 img_banner" style="padding: 0px;">
									<a href="#" class="">
										<img src="{{url('/')}}/images/go.jpg" alt="" class="img_right_border">
									</a>
								</div><!--/ [col]-->

							</div><!--/ .row-->
						</div>
							
					</div><!--/ .section_offset-->
					<div class="col-md-12 hidden-xs" style="padding:0px; padding-bottom: 20px;">
						<div class="col-sm-4" style="padding: 0px;">
							<a href="#" class="">
								<img src="{{url('/')}}/images/home-banner.jpeg" alt="" class="img_left_border">
							</a>
						</div>
						<div class="col-sm-4" style="padding: 0px;">
							<a href="#" class="">
								<img src="{{url('/')}}/images/home-banner.jpeg" alt="">
							</a>
						</div>
						<div class="col-sm-4" style="padding: 0px;">
							<a href="#" class="">
								<img src="{{url('/')}}/images/home-banner.jpeg" alt="" class="img_right_border">
							</a>
						</div>
					</div>
					<br>
					<div class="row ">
						<main class="col-md-12 col-sm-12">

							<!-- - - - - - - - - - - - - - Category - - - - - - - - - - - - - - - - -->

							@foreach($allCategory as $itemAllCategory)
							<div class="homepage_category hidden-xs">
								<ul class="homepage_category_list">
									<li class="category_item">
										<h3>
											<a href="#">
												<div class="category_item_icon"><img src="{{url('/')}}/images/{{$itemAllCategory->slug}}.png"></div>
												<div class="category_item_title">{{$itemAllCategory->name}}</div>
											</a>
										</h3>
									</li>
									@foreach(\App\Product::getChildCateByCate($itemAllCategory->id) as $item)
									<li class="subcategory_item">
										<!-- <a href="#tab-{{$item->id}}" title="{{$item->name}}"> --> 
										<a href="{{url('/category-product/').'/'.$item->slug}}" title="{{$item->name}}" target="_blank"> 
											<div class="subcategory_item_icon"><img src="{{url('/')}}/images/{{$item->slug}}.png"></div>
											<div class="subcategory_item_title">{{$item->name}}<div>
										</a>
									</li>
									@endforeach
								</ul>
								<div class="temp-wrapper" style="height: 654px;">
									<ul class="category_khovip_list">
										@foreach(\App\WareHouse::getVipByCate($itemAllCategory->id,4) as $key=> $warehousevip)
											<li class="category_khovip_item">
												<a href="#" class="alignleft" style="padding: 0px 40px;">
													@if (!empty($warehousevip->imageKho))
													<img src="{{url('/').$warehousevip->imageKho}}" alt="" style="border-radius: 5px;">
													@else
													@endif
												</a>
												<p class="alignleft">{{ $warehousevip->nameKho  }}</p>
											</li>
										@endforeach
									</ul>
									<div class="category_product">
										<?php $i=0 ;$j=0?>
										@foreach(\App\Product::getBestSellerProductByCate($itemAllCategory->id,6) as $key=> $product)
											@if($i==0)<div class="category_product_row">@endif
												<div class="col-md-4 category_product_cell">

													<div class="product_bestselt">

														<div class="image_wrap">

															<a href="{{url('/product').'/'.\App\CategoryProduct::getSlugCategoryProduct($product->id).'/'.$product->slug}}"><img src="{{url('/').$product->image}}" alt=""></a>

														</div>

														<div class="description">

															<a href="#" style="font-size: 16px;">{{$product->title}}</a>
															<div class="kho_info clearfix">
																<a href="#" class="alignleft" style="">
																	@if($product->levelKho == 1)
																		<img src="{{url('/images')}}/level1.png" alt="">
																	@elseif($product->levelKho == 2)
																		<img src="{{url('/images')}}/level2.png" alt="">
																	@elseif($product->levelKho == 3)
																		<img src="{{url('/images')}}/level3.png" alt="">
																	@else
																		<img src="{{url('/images')}}/level0.png" alt="">
																	@endif
																</a>
																<a href="#" class="alignleft" style="">
																	@if($product->confirm_kho == 1)
																		<img src="{{url('/images')}}/xacthuc.png" alt="">
																	@else
																	@endif
																</a>
																<p class="alignleft" style="white-space: nowrap; overflow: hidden;text-overflow: ellipsis;padding-left: 10px;">{{ \App\Util::ProductCode($product->product_ID)  }}</p>
															</div>
															@if (( !Auth::check()))
															<div class="clearfix product_info">
											                    <p><a href="#" class="required_login not_login" style="">Đăng nhập để xem giá</a></p>
															</div>
															<div class="clearfix product_info">
																<p class="alignleft">Tối thiểu: <a href="#" class="bg-number">{{ number_format($product->min_kg)  }}</a> SP</p>
															</div>
															@else
															<div class="clearfix product_info">
																<p class="product_price alignleft">{!! \App\Util::FormatMoney($product->price_out) !!}<span class="discount_price">@if ($product->price_sale != 0) {!! \App\Util::FormatMoney($product->price_sale) !!} @endif </span> </p>
															</div>
															<div class="clearfix product_info">	
																<p class="alignleft">Tối thiểu: {!! number_format($product->min_kg) !!} SP</p>
															</div>
															@endif
														</div>
													</div>
												</div>
												<?php $i = $i+1;$j=$j+1; ?>
												@if($i>=3|| $j>=count(\App\Product::getBestSellerProductByCate($itemAllCategory->id,6)))
													<?php $i=0 ?>
											</div>
											@endif
										@endforeach
									</div>
									<div class="banner_home_category"><img src="{{url('/')}}/images/{{$itemAllCategory->slug}}.png">
									</div>
								</div>
							</div>
							
							<!-- - - - - - - - - - - - - - End of cate - - - - - - - - - - - - - - - - -->
							@endforeach
							


							<div class="row product_respone_list visible-xs">
								<br>
								<h4 class="text-center transformUppercase">Sản phẩm bán chạy</h4>
								@foreach($bestSellerProduct as $key => $product)
									<div class="product_respone col-xs-6" >
										<a href="{{url('/product').'/'.\App\CategoryProduct::getSlugCategoryProduct($product->id).'/'.$product->slug}}" class="">
											<div class="image_wrap_respone text-center bg-white" style="border-radius: 5px; ">
												<img src="{{url('/').$product->image}}" class="img_product_respone" style="height: 104px;">
											</div>
											<div class="description_product_respone bg-white">
												<div class="title_product">{{$product->title}}</div>
												<p>{{ \App\Util::ProductCode($product->id)  }}</p>
												
												<div class="clearfix product_info">
												@if (( !Auth::check()))
								                    <p><a href="#" class="required_login not_login" style="">Đăng nhập để xem giá</a> </p>
								                @else
								                	<p class="product_price alignleft">{!! \App\Util::FormatMoney($product->price_out) !!}<span class="discount_price">@if ($product->price_sale != 0) {!! \App\Util::FormatMoney($product->price_sale) !!} @endif </span> </p>
													
												@endif
													
												</div>
												<div class="clearfix product_info">
													<p class="alignleft">Tối thiểu: <a href="#" class="bg-number">{{ number_format($product->min_gram)  }}</a> SP</p>
												</div>
											</div>
										</a>
									</div>
								@endforeach
								<div class="bottom_box text-center bg-home  load_more">
									<a href="{{url('/')}}/products" class="btn btn-raised btn-primary button_grey middle_btn">Xem thêm </a>
								</div>
								<br>
								<h4 class="text-center clearfix transformUppercase">Sản phẩm mới</h4>
								@foreach($getNewProduct as $key => $product)
									<div class="product_respone col-xs-6" >
										<a href="{{url('/product').'/'.\App\CategoryProduct::getSlugCategoryProduct($product->id).'/'.$product->slug}}" class="">
											<div class="image_wrap_respone text-center bg-white" style="border-radius: 5px; ">
												<img src="{{url('/').$product->image}}" class="img_product_respone" style="height: 104px;">
											</div>
											<div class="description_product_respone bg-white">
												<div class="title_product">{{$product->title}}</div>
												<p>{{ \App\Util::ProductCode($product->id)  }}</p>
												
												<div class="clearfix product_info">
												@if (( !Auth::check()))
								                    <p><a href="" class="required_login not_login" style="">Đăng nhập để xem giá</a></p>
								                @else
													<p class="product_price alignleft">{!! \App\Util::FormatMoney($product->price_out) !!}<span class="discount_price">@if ($product->price_sale != 0) {!! \App\Util::FormatMoney($product->price_sale) !!} @endif </span> </p>
																
												@endif
												</div>
												<div class="clearfix product_info">
													<p class="alignleft">Tối thiểu: <a href="#" class="bg-number">{{ number_format($product->min_gram)  }}</a> SP</p>
												</div>
											</div>
										</a>
									</div>
								@endforeach
								<div class="bottom_box text-center bg-home  load_more">
									<a href="{{url('/')}}/products" class="btn btn-raised btn-primary button_grey middle_btn">Xem thêm </a>
								</div>
							</div>
							
							<!-- - - - - - - - - - - - - - Tabs - - - - - - - - - - - - - - - - -->

							<div class="tabs products section_offset animated transparent hidden-xs" data-animation="fadeInDown" data-animation-delay="150">

								<!-- - - - - - - - - - - - - - Navigation of tabs - - - - - - - - - - - - - - - - -->

								<ul class="tabs_nav clearfix">

									<li class="tab_bottom"><a href="#tab-1" style="font-size: 16px;">Sản phẩm mới</a></li>
									<li class="tab_bottom"><a href="#tab-2" style="font-size: 16px;">Sản phẩm đánh giá tốt</a></li>


								</ul>
								<div class="tab_containers_wrap">
									<div id="tab-1" class="tab_container">

										<div class="table_layout">
											<?php $i=0 ;$j=0?>
											@foreach($getNewProduct as $key => $product)
												@if($i==0)<div class="category_product_row" style="background-color: #fff;">@endif
														<div class="col-md-3 col-xs-12 category_product_cell">

															<div class="product_bestselt">

																<div class="image_wrap">

																	<a href="{{url('/product').'/'.\App\CategoryProduct::getSlugCategoryProduct($product->id).'/'.$product->slug}}"><img src="{{url('/').$product->image}}" alt=""></a>
																<div class="label_new">New</div>
																</div>
																<div class="description">

																	<a href="#" class="clearfix">{{$product->title}}</a>

																	<div class="kho_info clearfix">
																		<a href="#" class="alignleft" style="">
																		@if($product->levelKho == 1)
																			<img src="{{url('/images')}}/level1.png" alt="">
																		@elseif($product->levelKho == 2)
																			<img src="{{url('/images')}}/level2.png" alt="">
																		@elseif($product->levelKho == 3)
																			<img src="{{url('/images')}}/level3.png" alt="">
																		@else
																			<img src="{{url('/images')}}/level0.png" alt="">
																		@endif
																		</a>
																		<a href="#" class="alignleft" style="">
																			@if($product->confirm_kho == 1)
																				<img src="{{url('/images')}}/xacthuc.png" alt="">
																			@else
																			@endif
																		</a>
																		<p class="alignleft" style="white-space: nowrap; overflow: hidden;text-overflow: ellipsis;padding-left: 10px;">{{ \App\Util::ProductCode($product->id)  }}</p>
																	</div>

																	<div class="clearfix product_info">
																	@if (( !Auth::check()))
													                    <a href="" class="required_login not_login" style="">Đăng nhập để xem giá</a>
													                    <span class="alignright">{!! \App\Rate::getRateProduct($product->id)!!}</span>
													                @else
																		<p class="product_price alignleft">{!! \App\Util::FormatMoney($product->price_out) !!}<span class="discount_price">@if ($product->price_sale != 0) {!! \App\Util::FormatMoney($product->price_sale) !!} @endif </span> </p>
															
																		<span class="alignright">{!! \App\Rate::getRateProduct($product->id)!!}</span>
																	@endif
																	</div>
																	<div class="clearfix product_info">
																		<p class="alignleft">Tối thiểu: <a href="#" class="bg-number">{{ number_format($product->min_gram)  }}</a> SP</p>
																	</div>
																</div>

															</div>
														</div>
														<?php $i = $i+1; $j=$j+1; ?>
														@if ($i>=4 || $j>=count($getNewProduct))
															<?php $i=0 ?>
															</div>
														@endif
											@endforeach
										</div>
										<div class="bottom_box load_more">
											<a href="{{url('/')}}/products" class="btn btn-raised btn-primary button_grey middle_btn">Xem thêm </a>
										</div>
										
									</div>
									<div id="tab-2" class="tab_container">


										<div class="table_layout">
											<?php $i=0 ;$j=0?>
											@foreach($getBestStarsProduct as $key=> $product)
												@if($i==0)<div class="category_product_row" style=" background-color: #fff;">@endif
														
													<div class="col-md-3 col-xs-12 category_product_cell">

														<div class="product_bestselt">

															<div class="image_wrap">

																<a href="{{url('/product').'/'.\App\CategoryProduct::getSlugCategoryProduct($product->id).'/'.$product->slug}}"><img src="{{url('/').$product->image}}" alt=""></a>

																<div class="label_hot">Hot</div>

															</div>
															<div class="description">

																<a href="#">{{$product->title}}</a>
																<div class="kho_info clearfix">
																	<a href="#" class="alignleft" style="">
																		@if($product->levelKho == 1)
																			<img src="{{url('/images')}}/level1.png" alt="">
																		@elseif($product->levelKho == 2)
																			<img src="{{url('/images')}}/level2.png" alt="">
																		@elseif($product->levelKho == 3)
																			<img src="{{url('/images')}}/level3.png" alt="">
																		@else
																			<img src="{{url('/images')}}/level0.png" alt="">
																		@endif
																	</a>
																	<a href="#" class="alignleft" style="">
																		@if($product->confirm_kho == 1)
																			<img src="{{url('/images')}}/xacthuc.png" alt="">
																		@else
																		@endif
																	</a>
																	<p class="alignleft" style="white-space: nowrap; overflow: hidden;text-overflow: ellipsis;padding-left: 10px;">{{ \App\Util::ProductCode($product->id)  }}</p>
																</div>

																<div class="clearfix product_info">
																	@if (( !Auth::check()))
													                    <a href="" class="required_login not_login" style="">Đăng nhập để xem giá</a>
													                    <span class="alignright">{!! \App\Rate::getRateProduct($product->id)!!}</span>
													                @else
																		<p class="product_price alignleft">{!! \App\Util::FormatMoney($product->price_out) !!}<span class="discount_price">@if ($product->price_sale != 0) {!! \App\Util::FormatMoney($product->price_sale) !!} @endif </span> </p>
																
																		<span class="alignright">{!! \App\Rate::getRateProduct($product->id)!!}</span>
																	@endif
																</div>
																<div class="clearfix product_info">
																	<p class="alignleft">Tối thiểu: <a href="#" class="bg-number">{{ number_format($product->min_gram)  }}</a> SP</p>
																</div>

															</div>

														</div>

													</div>
													<?php $i = $i+1;$j=$j+1; ?>
													@if($i>=4|| $j>=count($getBestStarsProduct))
														<?php $i=0 ?>
												</div>
												@endif

											@endforeach

										</div>

										<div class="bottom_box load_more">
											<a href="{{url('/')}}/products" class="btn btn-raised btn-primary button_grey middle_btn">Xem thêm </a>
										</div>

									</div>

								</div>

							</div>

							<section class="section_offset animated transparent" data-animation="fadeInDown" style="display: none;">

								<h3>Sản phẩm bán chạy</h3>
								<div class="table_layout">
									<?php $i=0 ;$j=0?>
									@foreach($bestSellerProduct as $key=> $product)
										@if($i==0)<div class="table_row">@endif
													<!-- - - - - - - - - - - - - - Product - - - - - - - - - - - - - - - - -->
											<div class="table_cell">

												<div class="product_item">

													<div class="image_wrap">
														<a href="{{url('/product').'/'.\App\CategoryProduct::getSlugCategoryProduct($product->id).'/'.$product->slug}}"><img src="{{url('/').$product->image}}" alt=""></a>

														<div class="label_bestseller">Bestseller</div>

													</div>
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
																	<img src="{{url('/images')}}/level0.png" alt="">
																@endif
															</a>
															<p class="alignleft" style="width: 80%; white-space: nowrap; overflow: hidden;text-overflow: ellipsis;"><b>{{ $product->nameKho  }}</b></p>
														</div>
														<div class="clearfix product_info">

															<p class="product_price alignleft">{!! \App\Util::FormatMoney($product->price_out) !!}<span class="discount_price">@if ($product->price_sale != 0) {!! \App\Util::FormatMoney($product->price_sale) !!} @endif </span> </p>
																
															<span class="alignright">{!! \App\Rate::getRateProduct($product->id)!!}</span>

														</div>
														<div class="clearfix product_info">
															<p class="alignleft">Tối thiểu: {{ number_format($product->min_gram)  }} Kg</p>
														</div>
													</div>

												</div>

											</div>
											<?php $i = $i+1;$j=$j+1; ?>
											@if($i>=4|| $j>=count($bestSellerProduct))
												<?php $i=0 ?>
										</div>
										@endif

									@endforeach

								</div>

								<footer class="bottom_box load_more">

									<a href="url('/')}}/products" class="btn btn-raised btn-primary button_grey middle_btn">Xem thêm </a>

								</footer>

							</section>

						</main>

					</div><!--/ .row-->

				</div><!--/ .container-->

			</div>
			@include('admin.partial.modal_requiredlogin')
@endsection