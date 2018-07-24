@extends('layouts.frontend')
@section('title', 'Trang chủ')
@section('description','trang chủ')

@section('content')
			<div class="page_wrapper col-md-12 col-sm-12">
				<div class="container col-md-12 col-sm-12">
					<div class="box_headder" style="margin-bottom:0px;">
						<div class="row col-md-12 col-xs-12 col-sm-12" style="height: 220px;">
							<div class="head">
								<a href="{{ url('/lp/lp') }}" target="_blank" title="" class="homepage_sologan">Mạng lưới kho nông sản Việt Nam</a>
							</div>
							<div class="foot">
								<a href="{{ url('/lp/lp') }}" target="_blank" title="" class="homepage_sologan">Kết nối nguồn hàng chất lượng và đối tác uy tín</a>
							</div>
						</div>
						<!-- <div class="row">
							<div class="col-xs-12 col-md-12" style="padding-bottom: 22px; ">
									{!! \App\Setting::getValue('slider')!!}
							</div>
						</div> -->
					</div>
					<div class="row ">
						<main class="col-md-12 col-sm-12">
							<div class="row" style="padding-left: 10px;">
								<h3><a style="color: #0f9d58;" href="{{ url('/company-business') }}">Cơ hội mua bán dành cho bạn</a></h3>
							</div>
							<div class="company_list">
								@if(count($getAllNewsCompany)!=0)
									<?php $i=0 ;$j=0?>
									@foreach($getAllNewsCompany as $itemAllNewsCompany)
										@if($i==0)<div class="list_company_row" style="">@endif
											<div class="col-md-3 col-xs-12 company_cell">
												<div class="well box_1">
													@if ($itemAllNewsCompany->companyConfirm)
													<div class="box-status" style="background-color: #64DD17;">
				                                        <p class="text-center status-title">HOT</p>
				                                    </div>
				                                    @endif
													<a href="{{url('/company/'.$itemAllNewsCompany->companyID.'/'.$itemAllNewsCompany->slug.'/'.$itemAllNewsCompany->newscompanyID)}}">
														<div class="company_image background_img" style="background-image: url('@if (!empty($itemAllNewsCompany->image_company)){{url('/').$itemAllNewsCompany->image_company}} @else {{asset('/images/8.png')}} @endif');">
														</div>
														<div class="description">
															<p class="textoverlow padding7" style="font-weight: bolder;"><a href="{{url('/company/'.$itemAllNewsCompany->companyID.'/'.$itemAllNewsCompany->slug.'/'.$itemAllNewsCompany->newscompanyID)}}" class="clearfix ;">{{$itemAllNewsCompany->name}}</a></p>
															<div class="limit-2">
					                                        	{!! $itemAllNewsCompany->content !!}
					                                        </div>
					                                        <span style=""><a href="#" class="comments" style="font-size: 12px;"><i class="fa fa-eye-slash" style="padding-top: 3px;"></i> @if(empty($itemAllNewsCompany->view_count))0 @else{{$itemAllNewsCompany->view_count}}@endif </a></span>
														</div>
													</a>
												</div>
											</div>
											<?php $i = $i+1;$j=$j+1; ?>
											@if($i>=4|| $j>=count($getAllNewsCompany))
												<?php $i=0 ?>
										</div>
										@endif
									@endforeach
								@else
										<br>
									<h2 class="text-center" style="text-align: center">Không tìm thấy dữ liệu</h2>
								@endif
								<div class="bottom_box load_more">
									<a href="{{ url('/company-business') }}" class="btn btn-raised btn-primary button_grey middle_btn">Xem thêm </a><label class="viewmore">(Còn @if ((count($getAllNewsCompany)-50) < 0 ) 0 @else hơn {{count($getAllNewsCompany)-50}} @endif cơ hội mua bán)</label>
								</div>
							</div>
							<br>
							<br>
							<div>
								<h3><a style="color: #0f9d58;" href="{{ url('/warehouse-business') }}">Nhà cung cấp nổi bật</a></h3>
							</div>
							<div class="warehouse_list">
								<div class="tabs products section_offset animated transparent" data-animation="" data-animation-delay="0">
									<ul class="tabs_nav clearfix">
										<li class="tab_bottom"><a href="#tab-1" style="font-size: 16px;">Đề xuất</a></li>
										<li class="tab_bottom"><a href="#tab-2" style="font-size: 16px;">Xem nhiều</a></li>
										<li class="tab_bottom"><a href="#tab-3" style="font-size: 16px;">Uy tín</a></li>
									</ul>
									<div class="tab_containers_wrap">
										<div id="tab-1" class="tab_container">
											<div class="table_layout">
												@if(count($getAllWareHouseDeXuat)!=0)
												<?php $i=0 ;$j=0?>
												@foreach($getAllWareHouseDeXuat as $itemAllWareHouseDeXuat)
													@if($i==0)<div class="list_warehouse_row" style="">@endif
														<div class="col-md-3 col-xs-12 warehouse_cell">
															<div class="well box_1">
															<!-- <div class="product_bestselt" style="padding-bottom: 10px;"> -->
																<a href="{{ url('/shop/'.$itemAllWareHouseDeXuat->id) }}">
																	<div class="company_image background_img" style="background-image: url('@if (!empty($itemAllWareHouseDeXuat->image_kho)){{url('/').$itemAllWareHouseDeXuat->image_kho}} @else {{asset('/images/2.png')}} @endif');">
																		
																	</div>
																	<div class="description">
																		<p class="textoverlow padding7"><a href="{{ url('/shop/'.$itemAllWareHouseDeXuat->id) }}" class="clearfix ">{{$itemAllWareHouseDeXuat->name_company}}</a></p>
																		<div class="clearfix product_info limit-2">Cung cấp: 
																			@foreach (\App\WareHouse::getCateProductByID($itemAllWareHouseDeXuat->id) as $key => $itemCate)
																				{{$itemCate}},
																			@endforeach
								                                        </div>
								                                        <div class="kho_info clearfix">
								                                        	<span style="float: left; padding-left: 7px;"><a href="#" class="comments" style="font-size: 12px;"><i class="fa fa-eye-slash" style="padding-top: 3px;"></i> @if(empty($itemAllWareHouseDeXuat->count_view))0 @else{{$itemAllWareHouseDeXuat->count_view}}@endif </a></span>
								                                        	<a href="#" class="code_kho" style="">{!! \App\Util::UserCode($itemAllWareHouseDeXuat->user_id) !!}</a>
								                                        </div>
																		<div class="kho_info clearfix">
																			<a href="#" class="alignleft" style="">
																				@if($itemAllWareHouseDeXuat->level == 1)
																					<img src="{{url('/images')}}/level1.png" alt="">
																				@elseif($itemAllWareHouseDeXuat->level == 2)
																					<img src="{{url('/images')}}/level2.png" alt="">
																				@elseif($itemAllWareHouseDeXuat->level == 3)
																					<img src="{{url('/images')}}/level3.png" alt="">
																				@else
																					<img src="{{url('/images')}}/level0.png" alt="">
																				@endif
																			</a>
																			<a href="#" class="alignright" style="margin-right: 8px;">
																				@if($itemAllWareHouseDeXuat->confirm_kho == 1)
																					<img src="{{url('/images')}}/xacthuc.png" alt="">
																				@else
																				@endif
																			</a>
																		</div>	
																	</div>
																</a>
															<!-- </div> -->
															</div>
														</div>
														<?php $i = $i+1;$j=$j+1; ?>
														@if($i>=4|| $j>=count($getAllWareHouseDeXuat))
															<?php $i=0 ?>
													</div>
													@endif
												@endforeach
												@else
													<br>
												<h2 class="text-center" style="text-align: center">Không tìm thấy dữ liệu</h2>
											@endif
											</div>
											<div class="bottom_box load_more">
												<a href="{{ url('/warehouse-business') }}" class="btn btn-raised btn-primary button_grey middle_btn">Xem thêm </a><label class="viewmore">(Còn @if ((count($getAllWareHouseDeXuat)-50)< 0 ) 0 @else hơn {{count($getAllWareHouseDeXuat)-50}} @endif nhà cung cấp)</label>
											</div>
										</div>
										<div id="tab-2" class="tab_container">
											<div class="table_layout">
												@if(count($getAllWareHouseXemNhieu)!=0)
												<?php $i=0 ;$j=0?>
												@foreach($getAllWareHouseXemNhieu as $itemAllWareHouseXemNhieu)
													@if($i==0)<div class="list_warehouse_row" style="">@endif
														<div class="col-md-3 col-xs-12 warehouse_cell">
															<div class="well box_1">
															<!-- <div class="product_bestselt" style="padding-bottom: 10px;"> -->
																<div class="company_image">
																	<a href="{{ url('/shop/'.$itemAllWareHouseXemNhieu->id) }}"><img src="@if (!empty($itemAllWareHouseXemNhieu->image_kho)){{url('/').$itemAllWareHouseXemNhieu->image_kho}} @else {{asset('/images/2.png')}} @endif" alt=""></a>
																</div>
																<div class="description">
																	<p class="textoverlow padding7"><a href="{{ url('/shop/'.$itemAllWareHouseXemNhieu->id) }}" class="clearfix ">{{$itemAllWareHouseXemNhieu->name_company}}</a></p>
																	<div class="clearfix product_info limit-2">Cung cấp: 
																		@foreach (\App\WareHouse::getCateProductByID($itemAllWareHouseXemNhieu->id) as $key => $itemCate)
																			{{$itemCate}},
																		@endforeach
							                                        </div>
																	<div class="kho_info clearfix">
							                                        	<span style="float: left; padding-left: 7px;"><a href="#" class="comments" style="font-size: 12px;"><i class="fa fa-eye-slash" style="padding-top: 3px;"></i> @if(empty($itemAllWareHouseXemNhieu->count_view))0 @else{{$itemAllWareHouseXemNhieu->count_view}}@endif </a></span>
							                                        	<a href="#" class="code_kho" style="">{!! \App\Util::UserCode($itemAllWareHouseXemNhieu->user_id) !!}</a>
							                                        </div>
																	<div class="kho_info clearfix">
																		<a href="#" class="alignleft" style="">
																			@if($itemAllWareHouseXemNhieu->level == 1)
																				<img src="{{url('/images')}}/level1.png" alt="">
																			@elseif($itemAllWareHouseXemNhieu->level == 2)
																				<img src="{{url('/images')}}/level2.png" alt="">
																			@elseif($itemAllWareHouseXemNhieu->level == 3)
																				<img src="{{url('/images')}}/level3.png" alt="">
																			@else
																				<img src="{{url('/images')}}/level0.png" alt="">
																			@endif
																		</a>
																		<a href="#" class="alignright" style="margin-right: 8px;">
																			@if($itemAllWareHouseXemNhieu->confirm_kho == 1)
																				<img src="{{url('/images')}}/xacthuc.png" alt="">
																			@else
																			@endif
																		</a>
																	</div>
																</div>
															</div>
														</div>
														<?php $i = $i+1;$j=$j+1; ?>
														@if($i>=4|| $j>=count($getAllWareHouseXemNhieu))
															<?php $i=0 ?>
													</div>
													@endif
												@endforeach
												@else
													<br>
												<h2 class="text-center" style="text-align: center">Không tìm thấy dữ liệu</h2>
											@endif
											</div>
											<div class="bottom_box load_more">
												<a href="{{ url('/warehouse-business') }}" class="btn btn-raised btn-primary button_grey middle_btn">Xem thêm </a><label class="viewmore">(Còn @if ((count($getAllWareHouseXemNhieu)-50) < 0 ) 0 @else hơn {{count($getAllWareHouseXemNhieu)-50}} @endif nhà cung cấp)</label>
											</div>
										</div>
										<div id="tab-3" class="tab_container">
											<div class="table_layout">
												@if(count($getAllWareHouseUyTin)!=0)
												<?php $i=0 ;$j=0?>
												@foreach($getAllWareHouseUyTin as $itemAllWareHouseUyTin)
													@if($i==0)<div class="list_warehouse_row" style="">@endif
														<div class="col-md-3 col-xs-12 warehouse_cell">
															<div class="well box_1">
															<!-- <div class="product_bestselt" style="padding-bottom: 10px;"> -->
																<div class="company_image">
																	<a href="{{ url('/shop/'.$itemAllWareHouseUyTin->id) }}"><img src="@if (!empty($itemAllWareHouseUyTin->image_kho)){{url('/').$itemAllWareHouseUyTin->image_kho}} @else {{asset('/images/2.png')}} @endif" alt=""></a>
																</div>
																<div class="description">
																	<p class="textoverlow padding7"><a href="{{ url('/shop/'.$itemAllWareHouseUyTin->id) }}" class="clearfix ">{{$itemAllWareHouseUyTin->name_company}}</a></p>
																	<div class="clearfix product_info limit-2">Cung cấp: 
																		@foreach (\App\WareHouse::getCateProductByID($itemAllWareHouseUyTin->id) as $key => $itemCate)
																			{{$itemCate}},
																		@endforeach
							                                        </div>
																	<div class="kho_info clearfix">
							                                        	<span style="float: left; padding-left: 7px;"><a href="#" class="comments" style="font-size: 12px;"><i class="fa fa-eye-slash" style="padding-top: 3px;"></i> @if(empty($itemAllWareHouseUyTin->count_view))0 @else{{$itemAllWareHouseUyTin->count_view}}@endif </a></span>
							                                        	<a href="#" class="code_kho" style="">{!! \App\Util::UserCode($itemAllWareHouseUyTin->user_id) !!}</a>
							                                        </div>
																	<div class="kho_info clearfix">
																		<a href="#" class="alignleft" style="">
																			@if($itemAllWareHouseUyTin->level == 1)
																				<img src="{{url('/images')}}/level1.png" alt="">
																			@elseif($itemAllWareHouseUyTin->level == 2)
																				<img src="{{url('/images')}}/level2.png" alt="">
																			@elseif($itemAllWareHouseUyTin->level == 3)
																				<img src="{{url('/images')}}/level3.png" alt="">
																			@else
																				<img src="{{url('/images')}}/level0.png" alt="">
																			@endif
																		</a>
																		<a href="#" class="alignright" style="margin-right: 8px;">
																			@if($itemAllWareHouseUyTin->confirm_kho == 1)
																				<img src="{{url('/images')}}/xacthuc.png" alt="">
																			@else
																			@endif
																		</a>
																	</div>
																</div>
															</div>
														</div>
														<?php $i = $i+1;$j=$j+1; ?>
														@if($i>=4|| $j>=count($getAllWareHouseUyTin))
															<?php $i=0 ?>
													</div>
													@endif
												@endforeach
												@else
													<br>
												<h2 class="text-center" style="text-align: center">Không tìm thấy dữ liệu</h2>
											@endif
											</div>
											<div class="bottom_box load_more">
												<a href="{{ url('/warehouse-business') }}" class="btn btn-raised btn-primary button_grey middle_btn">Xem thêm </a><label class="viewmore">(Còn @if ((count($getAllWareHouseUyTin)-50) < 0 ) 0 @else hơn {{count($getAllWareHouseUyTin)-50}} @endif nhà cung cấp)</label>
											</div>
										</div>
									</div>
								</div>
							</div>	
						</main>
					</div>
				</div>
			</div>
			@include('admin.partial.modal_requiredlogin')
@endsection