@extends('layouts.frontend')
@section('title', 'chi tiết')
@section('description',' chi tiết sản phẩm')

@section('url_seo', url('/').$_SERVER['REQUEST_URI'] )
@section('type_seo','product')
@section('title_seo', $product->title_seo )
@section('description_seo',$product->description )
@section('image_seo', url('/').$product->image )

@section('add-styles')
	<link rel="stylesheet" href="{{asset('frontend/js/fancybox/source/jquery.fancybox.css')}}">
	<link rel="stylesheet" href="{{asset('frontend/js/fancybox/source/helpers/jquery.fancybox-thumbs.css')}}">
@endsection
@section('content')

			<div class="secondary_page_wrapper col-md-12 col-sm-12">
				<div class="container col-md-12 col-sm-12">
					<ul class="breadcrumbs" style="margin: 0px;">
						<li><a href="/">Trang chủ</a></li>
						<li><a href="/products">Sản phẩm</a></li>
						<li>{{$product->title}}</li>
					</ul>
					@if (\Session::has('success'))
						<p class="message green" >Cảm ơn quý khách hàng đã để lại thông tin, chúng tôi sẽ liên hệ trong thời gian sớm nhất có thể</p>
						<br>
					@elseif(\Session::has('RateSuccess'))
						<p class="message green" >Cảm ơn quý khách hàng đã đóng góp đánh giá</p>
						<br>
						@endif
					<div class="section_offset">
						<div class="row">
							<main class="col-md-9 col-sm-8">
									<div class="single_product">
										<div class="image_preview_container" >
											<img id="img_zoom" data-zoom-image="{{url('/')}}{{$product->image}}" src="{{url('/')}}{{$product->image}}" alt="" class="image_product_single" style="border-radius: 5px;">
											<button class="button_grey_2 icon_btn middle_btn open_qv"><i class="icon-resize-full-6"></i></button>
										</div>
										<div class="product_preview">
											<div class="owl_carousel" id="thumbnails">
												@if(count($detailImage) != 0)
													@foreach($detailImage as $item)
													<a href="#" data-image="{{url('/')}}{{$item->image}}" data-zoom-image="{{url('/')}}{{$item->image}}">
														<img src="{{url('/')}}{{$item->image}}" data-large-image="{{url('/')}}{{$item->image}}" alt="" style="border-radius: 5px;">
													</a>
													@endforeach
												@endif
											</div>
										</div>
										<div class="v_centered">
											<div class="addthis_widget_container">
												<div class="fb-share-button" data-href="{{url('/')}}{{$_SERVER['REQUEST_URI']}}" data-layout="button_count" data-size="small" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;src=sdkpreparse">Chia sẻ</a></div>
											</div>
										</div>
									</div>
									<div class="single_product_description">
										<h4 class="offset_title">{{$product->title}}</h4>
										<div class="description_section v_centered">
											{!! \App\Rate::getRateProduct($product->id)!!}
											<ul class="topbar">
												<li><a href="#">{{\App\Rate::countRate($product->id)}} Đã đánh giá</a></li>
											</ul>
										</div>
										<div class="description_section">
											<table class="product_info" style="width: 100%">
												<tbody style="font-size: 15px;">
													<tr style="padding-bottom: 10px;">
														<td style="width: 150px;">Mua tối thiểu: </td>
														<td><span class="in_stock">{{$product->min_gram}}</span> sản phẩm</td>
													</tr>
													<tr style="padding-bottom: 10px;">
														<td style="width: 150px;">Mã sản phẩm: </td>
														<td>{{\App\Util::ProductCode($product->id)}}</td>
													</tr>
													<tr style="padding-bottom: 10px;">
														<td style="width: 150px;">Tồn kho: </td>
														<td><span class="in_stock">{{$product->inventory_num}}</span> sản phẩm</td>
													</tr>
												</tbody>
											</table>
										</div>
										<p class="product_price alignleft">{!! \App\Util::FormatMoney($product->price_out) !!}<span class="discount_price">@if ($product->price_sale != 0) {!! \App\Util::FormatMoney($product->price_sale) !!} @endif </span> </p>
									
										<div class="row text-center col-xs-12">
											<div class="col-xs-6 col-sm-6 col-md-6" style="float: left;padding-left: 0px;">
												<div style="height: 100px; padding: 15px 15px 0px 0px; ">
													@if (( !Auth::check()))
														<button id="" style="border-radius: 4px;line-height: 26px; color: #fff; width: 170px; font-size: 16px;background: #00695c;"
																data-toggle="modal" data-target=".modal-login" class="btn btn-success required_login contacts">
															Gọi trực tiếp
														</button>
													@else
														<button id="phoneKho" style="border-radius: 4px;line-height: 26px; color: #fff; width: 170px; font-size: 16px;background: #00695c;"
															data-toggle="modal" data-target=".modal-buy" class="btn btn-success contacts" data-phone="{{$product->phoneKho}}" data-title="Mua Ngay" data-namekho="{{$product->nameKho}}">
															Gọi trực tiếp
														</button>
													@endif
													<br>
													<!-- <p style="padding: 1px 0px 0px 20px;">Mua trực tiếp với nhà cung cấp</p> -->
												</div>
											</div>
											<div class="col-xs-6 col-sm-6 col-md-6" style="float: right;padding-right: 0px;">
												<div style="height: 100px; padding: 15px 15px 0px 0px; ">
													@if (( !Auth::check()))
														<button id="" style="border-radius: 4px;line-height: 26px; color: #fff; width: 170px; font-size: 16px;background: #0f9d58;"
																data-toggle="modal" data-target=".modal-login" class="btn btn-info required_login contacts">
															Chat Facebook
														</button>
													@else
														<button id="" style="border-radius: 4px;line-height: 26px; color: #fff; width: 170px; font-size: 16px;background: #0f9d58;" class="chat_chukho btn btn-info contacts">
															Chat Facebook
														</button>
														<input type="hidden" id="is_fanpage_fb" name="is_fanpage_fb" value="{{ $product->fanpage_fb }}">
													@endif
													<br>
													<!-- <p style="padding: 1px 0px 0px 20px;">Chat với nhà cung cấp</p> -->
													
												</div>
											</div>
											<div id="chat_page" class="hidden">
													<div class="sidebar-footer hidden-small">
													    <div class="pageface">
													    <div class="title">
										                    
										                    <i class="fa fa-minus" style="float: right;"></i>
										                </div>
													        <div class="fb-page" data-href="{{ $product->fanpage_fb }}"
													             data-tabs="messages, messages"
													             data-small-header="false"
													             data-adapt-container-width="true"
													             data-hide-cover="false" data-show-facepile="true">

													        </div>
													    </div>

													</div>
												</div>
											</div>
										{{--<div class="description_section">
											<p class="text-info">Vui lòng để lại thông tin liên lạc để chúng tôi liên hệ lại trong thời gian sớm nhất</p>
										</div>
										<div class="description_section">
										<form action="{{url('/single-order')}}" method="post"  class="contactform type_2" id="contact_form">
											<input type="hidden" name="_token" value="{{ csrf_token() }}">
											<ul>
												<li class="row">
													<input type="hidden"  name="cf_url" value="{{url('/')}}{{$_SERVER['REQUEST_URI']}}">
													<div class="col-sm-6">
														<label for="cf_name" class="required">Tên</label>
														<input type="text" required name="cf_name" id="cf_name" title="Name">
													</div>
													<div class="col-sm-6">
														<label for="cf_email" class="required">Địa chỉ Email</label>
														<input type="email" required name="cf_email" id="cf_email" title="Email">
													</div>
												</li>
												<li class="row">
													<div class="col-xs-12">
														<label for="cf_order_number" class="required">Số điện thoại</label>
														<input type="text" required name="cf_order_number" id="cf_order_number" title="Order number">
													</div>
												</li>
												<li class="row">
													<div class="col-xs-12">
														<label for="cf_message" class="">Tin nhắn</label>
														<textarea id="cf_message"  name="cf_message" title="Message" rows="4"></textarea>
													</div>
												</li>
											</ul>
											<div class="buttons_row">
												<button class="button_blue middle_btn" type="submit" id="send-order-info">Gửi thông tin</button>
											</div>
										</form>
									</div>--}}
										
									</div>

							</main>
							<aside class="col-md-3 col-sm-4">

								<section class="section_offset">
							@if(!empty($product->levelKho))
									<h5 class="text-center">Thông tin chủ kho</h5>
									<div class="theme_box">
										<div class="seller_info clearfix">
											<div>
												<a href="{{ url('/shop/'.$product->ware_houses_id) }}" class="alignleft photo">
													@if($product->levelKho == 1)
													<img src="{{url('/images')}}/level1.png" alt="">
														@elseif($product->levelKho == 2)
														<img src="{{url('/images')}}/level2.png" alt="">
													@elseif($product->levelKho == 3)
														<img src="{{url('/images')}}/level3.png" alt="">
													@endif
												</a>
												<a href="#" class="alignright" style="margin-right: 8px;">
													@if($product->confirm_kho == 1)
														<img src="{{url('/images')}}/xacthuc.png" alt="">
													@else
													@endif
												</a>
											</div>
										</div>
										<div class="wrapper">
											<a href="{{ url('/shop/'.$product->ware_houses_id) }}"><b>{{$product->nameKho}}</b></a>
											<!-- <p class="seller_category">Chủ kho cấp {{$product->levelKho}}</p> -->
										</div>
										<div class="wrapper">
											<b>{{\App\Util::DayJoinGroup($product->ware_houses_Create)}} ngày cùng nosaGO.com</b>
										</div>
										<ul class="seller_stats">
											<li>
												<ul class="topbar">
													<li>Mã: {{\App\Util::UserCode($product->idKho)}}</li>
												</ul>
											</li>
										</ul>
									</div>
									@endif
								</section>
								<div class="section_offset">
									<a href="#" class="banner">
										<img src="{{asset('frontend/images/banner_img_13.jpg')}}" alt="" style="width: 100%;">
									</a>

								</div>

							</aside>

						</div>
					</div>

					<div class="section_offset" style="margin-bottom: 10px;">
						<div class="tabs type_2">
							<ul class="tabs_nav clearfix">
								<li><a href="#tab-1">Thông tin chi tiết</a></li>
								<li><a href="#tab-2">Tài khản thanh toán</a></li>
								<li><a href="#tab-3">Đánh giá</a></li>
							</ul>

							<div class="tab_containers_wrap">
								<div id="tab-1" class="tab_container">
									{!! $product->content!!}
								</div>
								<div id="tab-2" class="tab_container" style="font-weight: 400;">
									<?php $bank = App\BankWareHouse::getBankOfWareHouse($product->ware_houses_id); 
										  $listBank = count($bank);
										  $i = 1;
									?>
									<p><strong>Thông tin chuyển khoản</strong></p>
									@foreach($bank as $itemBank)
										Tài khoản {{$i}} <br>
										&nbsp;&nbsp; Ngân hàng: {{$itemBank->bankName}} <br>
										&nbsp;&nbsp; Số tài khoản: {{$itemBank->cardNumber}} <br>
										&nbsp;&nbsp; Chủ tài khoản: {{$itemBank->cardName}} <br>
										&nbsp;&nbsp; Chi Nhánh: {{$itemBank->provinceName}} <br>
										<br>
										<?php $i++; ?>
									@endforeach
									Để yên tâm, trước khi chuyển quý khách có thể xác nhận thông tin chuyển khoản qua số điện thoại {{$product->phoneKho}}
								</div>
								<div id="tab-3" class="tab_container">
									<section class="section_offset">
										<div class="row">
											<div class="col-lg-4 col-md-6">
												<p>Đóng góp đánh giá: <a href="#">{{$product->title}}</a><br>
													@if( !Auth::check())<span style="color: red">Vui lòng đăng nhập để được đánh giá*</span>@endif
												</p>
											</div>
											<div class="col-lg-8 col-md-6 text-right">
												<form action="{{url('/customer-rate')}}" method="post" class="type_2">
												<input type="hidden" name="_token" value="{{ csrf_token() }}">
												<div class="table_wrap rate_table">
													<table>
														<thead>
															<tr>
																<th></th>
																<th>1 sao</th>
																<th>2 sao</th>
																<th>3 sao</th>
																<th>4 sao</th>
																<th>5 sao</th>
															</tr>
														</thead>
														<tbody>
															<tr>
																<td>Giá</td>
																<td>
																	<input checked type="radio" value="1" name="price_rate" id="rate_1">
																	<label for="rate_1"></label>
																</td>
																<td>
																	<input type="radio" value="2" name="price_rate" id="rate_2">
																	<label for="rate_2"></label>
																</td>
																<td>
																	<input type="radio" value="3" name="price_rate" id="rate_3">
																	<label for="rate_3"></label>
																</td>
																<td>
																	<input type="radio" value="4" name="price_rate" id="rate_4">
																	<label for="rate_4"></label>
																</td>
																<td>
																	<input type="radio" value="5" name="price_rate" id="rate_5">
																	<label for="rate_5"></label>
																</td>
															</tr>
															<tr>
																<td>Giao hàng</td>
																<td>
																	<input checked type="radio" value="1" name="value_rate" id="rate_6">
																	<label for="rate_6"></label>
																</td>
																<td>
																	<input type="radio" value="2" name="value_rate" id="rate_7">
																	<label for="rate_7"></label>

																</td>

																<td>
																		
																	<input type="radio" value="3" name="value_rate" id="rate_8">
																	<label for="rate_8"></label>

																</td>

																<td>
																		
																	<input type="radio" value="4" name="value_rate" id="rate_9">
																	<label for="rate_9"></label>

																</td>

																<td>
																		
																	<input type="radio" value="5" name="value_rate" id="rate_10">
																	<label for="rate_10"></label>

																</td>

															</tr>

															<tr>
																
																<td>Chất lượng</td>

																<td>
																		
																	<input checked type="radio" value="1" name="quality_rate" id="rate_11">
																	<label for="rate_11"></label>

																</td>

																<td>
																		
																	<input type="radio" value="2" name="quality_rate" id="rate_12">
																	<label for="rate_12"></label>

																</td>

																<td>
																		
																	<input type="radio" value="3" name="quality_rate" id="rate_13">
																	<label for="rate_13"></label>

																</td>

																<td>
																		
																	<input type="radio" value="4" name="quality_rate" id="rate_14">
																	<label for="rate_14"></label>

																</td>

																<td>
																		
																	<input type="radio" value="5" name="quality_rate" id="rate_15">
																	<label for="rate_15"></label>

																</td>

															</tr>

														</tbody>

													</table>

												</div>
												<br>
													<input type="hidden" value="{{$product->id}}" name="id_product">

													@if( Auth::check())
													<input type="hidden" value="{{Auth::user()->id}}" name="id_user">

													<button type="submit" class=" btn btn-success btn-large text-right">Gửi đánh giá</button>
													@endif

												<!-- - - - - - - - - - - - - - End of rate the - - - - - - - - - - - - - - - - -->
												</form>
											</div><!--/ [col]-->

											

										</div>

									</section>

								</div>
							</div>
							<div>
								<section class="section_offset">
									<div class="comment">
										<div class="fb-comments" data-href="{{url('/')}}{{$_SERVER['REQUEST_URI']}}" data-width="100%" data-numposts="5"></div>
									</div>
								</section>
							</div>
						</div>
					</div>
					<div class="section_offset" style="margin-bottom: 10px;">
						<div class="tabs type_2 initialized products">
							<ul class="tabs_nav clearfix">
								<li class="tab_bottom"><a href="#tab-5" style="font-size: 16px;">Sản phẩm gợi ý</a></li>
								<li class="tab_bottom"><a href="#tab-6" style="font-size: 16px;">NCC uy tín</a></li>
								<li class="tab_bottom"><a href="#tab-7" style="font-size: 16px;">Sản phẩm nổi bật</a></li>
							</ul>
							<div class="tab_containers_wrap">
								<div id="tab-5" class="tab_container">
									<div class="table_layout">
				                        <?php $i=0 ;$j=0?>
				                        @foreach(\App\Product::getRelatedProduct($product->id,8) as $product)
				                            @if($i==0)<div class="category_product_row" style="">@endif
				                                    <div class="col-md-3 col-xs-12 category_product_cell">
				                                        <div class="product_bestselt">
				                                            <div class="image_wrap">
				                                                <a href="{{url('/product').'/'.\App\CategoryProduct::getSlugCategoryProduct($product->id).'/'.$product->slug}}"><img src="{{url('/').$product->image}}" alt=""></a>
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
				                                                    <p class="product_price alignleft">{!! \App\Util::FormatMoney($product->price_out) !!}<span class="discount_price">@if ($product->price_sale != 0) {!! \App\Util::FormatMoney($product->price_sale) !!} @endif </span> </p>
																
				                                                    <span class="alignright">{!! \App\Rate::getRateProduct($product->id)!!}</span>
				                                                </div>
				                                                <div class="clearfix product_info">
				                                                    <p class="alignleft">Tối thiểu: {{ number_format($product->min_gram)  }} Kg</p>
				                                                </div>
				                                            </div>

				                                        </div>
				                                    </div>
				                                    <?php $i = $i+1; $j=$j+1; ?>
				                                    @if ($i>=4 || $j>=count(\App\Product::getRelatedProduct($product->id,8)))
				                                        <?php $i=0 ?>
				                                        </div>
				                                    @endif
				                        @endforeach
				                    </div>

								</div>
								<div id="tab-6" class="tab_container">
									<div class="table_layout">
				                        <?php $i=0 ;$j=0?>
				                        @foreach(\App\Product::getProductByKhoVIP(8) as $product)
				                            @if($i==0)<div class="category_product_row" style="">@endif
				                                    <div class="col-md-3 col-xs-12 category_product_cell">

				                                        <div class="product_bestselt">

				                                            <div class="image_wrap">

				                                                <a href="{{url('/product').'/'.\App\CategoryProduct::getSlugCategoryProduct($product->id).'/'.$product->slug}}"><img src="{{url('/').$product->image}}" alt=""></a>
				                                            
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
				                                                    <p class="product_price alignleft">{!! \App\Util::FormatMoney($product->price_out) !!}<span class="discount_price">@if ($product->price_sale != 0) {!! \App\Util::FormatMoney($product->price_sale) !!} @endif </span> </p>
																
				                                                    <span class="alignright">{!! \App\Rate::getRateProduct($product->id)!!}</span>
				                                                </div>
				                                                <div class="clearfix product_info">
				                                                    <p class="alignleft">Tối thiểu: {{ number_format($product->min_gram)  }} Kg</p>
				                                                </div>
				                                            </div>

				                                        </div>
				                                    </div>
				                                    <?php $i = $i+1; $j=$j+1; ?>
				                                    @if ($i>=4 || $j>=count(\App\Product::getProductByKhoVIP(8)))
				                                        <?php $i=0 ?>
				                                        </div>
				                                    @endif
				                        @endforeach
				                    </div>
									
								</div>
								<div id="tab-7" class="tab_container">
									<div class="table_layout">
				                        <?php $i=0 ;$j=0?>
				                        @foreach(\App\Product::getBestSellerProduct(8) as $product)
				                            @if($i==0)<div class="category_product_row" style="">@endif
				                                    <div class="col-md-3 col-xs-12 category_product_cell">

				                                        <div class="product_bestselt">

				                                            <div class="image_wrap">

				                                                <a href="{{url('/product').'/'.\App\CategoryProduct::getSlugCategoryProduct($product->id).'/'.$product->slug}}"><img src="{{url('/').$product->image}}" alt=""></a>
				                                            
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
				                                                    <p class="product_price alignleft">{!! \App\Util::FormatMoney($product->price_out) !!}<span class="discount_price">@if ($product->price_sale != 0) {!! \App\Util::FormatMoney($product->price_sale) !!} @endif </span> </p>
																
				                                                    <span class="alignright">{!! \App\Rate::getRateProduct($product->id)!!}</span>
				                                                </div>
				                                                <div class="clearfix product_info">
				                                                    <p class="alignleft">Tối thiểu: {{ number_format($product->min_gram)  }} Kg</p>
				                                                </div>
				                                            </div>

				                                        </div>
				                                    </div>
				                                    <?php $i = $i+1; $j=$j+1; ?>
				                                    @if ($i>=4 || $j>=count(\App\Product::getBestSellerProduct(8)))
				                                        <?php $i=0 ?>
				                                        </div>
				                                    @endif
				                        @endforeach
				                    </div>
									
								</div>
							</div>
						</div>
					</div>
					
				</div>

			</div>

	@include('admin.partial.modal_requiredlogin')
	<div class="modal fade modal-buy" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false"
		 data-backdrop="static">
		<div class="modal-dialog modal-buy">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title text-center" id="myModalLabel">Mua ngay</h4>
				</div>
				<div class="modal-body">
					<div class="form-group" style="padding-left: 70px; font-size: 15px;">
						<p style="color: #4e8d1a"><strong>Hãy liên hệ Chủ kho theo thông tin bên dưới để mua trực tiếp</strong></p>
						<p>Tên Chủ kho : <strong name="namekho"></strong> </p>
						<p>Số điện thoại: <strong class="text-center" name="phone"></strong></p>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-raised btn-default" data-dismiss="modal">Đóng</button>
				</div>
			</div>
		</div>
	</div>
@endsection
@section('add-script')
	<script src="{{asset('frontend/js/jquery.elevateZoom-3.0.8.min.js')}}"></script>
	<script src="{{asset('frontend/js/fancybox/source/jquery.fancybox.pack.js')}}"></script>
	<script src="{{asset('frontend/js/fancybox/source/helpers/jquery.fancybox-media.js')}}"></script>
	<script src="{{asset('frontend/js/fancybox/source/helpers/jquery.fancybox-thumbs.js')}}"></script>
	

	<script>
		$(document).on("click", "#phoneKho", function () {
			var _self = $(this);
			$('.modal-product .title').text(_self.data('title'));
			$('.modal-buy [name="phone"]').html(_self.data('phone'));
			$('.modal-buy [name="namekho"]').html(_self.data('namekho'));
		});

	</script>
	<script>
    $('#img_zoom').elevateZoom({
	    zoomType: "inner",
		cursor: "crosshair",
		zoomWindowFadeIn: 500,
		zoomWindowFadeOut: 750
	   }); 
    // $("#img_zoom").ezPlus();
	</script>
	<script type="text/javascript">

		$('.chat_chukho').on('click',function() {
			var is_fanpage_fb = $('#is_fanpage_fb').val();
			if (is_fanpage_fb != "") {
				$('#chat_page').toggleClass("hidden");
			}
			else {
				alert('Chủ kho không có FanPage Facebook');
			}
		});
		$('.fa-minus').on('click',function() {
			$('#chat_page').addClass("hidden");
		});
	</script>
	@endsection
