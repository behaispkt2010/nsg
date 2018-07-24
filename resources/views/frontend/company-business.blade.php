@extends('layouts.frontend')
@section('title', 'Thông tin Công ty')
@section('description','Thông tin Công ty')

@section('url_seo', url('/').$_SERVER['REQUEST_URI'] )
@section('type_seo','article')
@section('title_seo', 'nosaGO.com - Mạng lưới kho nông sản Việt Nam ' )
@section('description_seo','Kết nối nguồn hàng chất lượng và đối tác uy tín' )
@section('image_seo', url('/').'/frontend/images/nosago1.png' )


@section('content')
			<!-- - - - - - - - - - - - - - Page Wrapper - - - - - - - - - - - - - - - - -->
			<div class="page_wrapper col-md-12 col-sm-12">

				<div class="container col-md-12 col-sm-12">
					<ul class="breadcrumbs">

						<li><a href="/">Trang chủ</a></li>
						<li>Danh sách các Công ty uy tín</li>

					</ul>
					<div class="row">
						<main class="col-md-12 col-sm-12">

							<div class="company_list">
								
								@if(count($getAllNewsCompany)!=0)
									<?php $i=0 ;$j=0?>
									@foreach($getAllNewsCompany as $itemAllNewsCompany)
										@if($i==0)<div class="list_company_row" style="">@endif
													<!-- - - - - - - - - - - - - - Product - - - - - - - - - - - - - - - - -->
											<div class="col-md-3 col-xs-12 company_cell">
												<div class="well box_1">
													@if ($itemAllNewsCompany->companyConfirm)
													<div class="box-status" style="background-color: #64DD17;">
				                                        <p class="text-center status-title">HOT</p>
				                                    </div>
				                                    @endif

													<!-- <div class="product_bestselt"> -->
														<div class="company_image">
															<a href="{{url('/company/'.$itemAllNewsCompany->companyID.'/'.$itemAllNewsCompany->slug.'/'.$itemAllNewsCompany->newscompanyID)}}">
																<img src="@if (!empty($itemAllNewsCompany->image_company)){{url('/').$itemAllNewsCompany->image_company}} @else {{asset('/images/8.png')}} @endif" alt="">
															</a>
														</div>
														<div class="description">
															<p class="textoverlow padding7" style="font-weight: bolder;"><a href="{{url('/company/'.$itemAllNewsCompany->companyID.'/'.$itemAllNewsCompany->slug.'/'.$itemAllNewsCompany->newscompanyID)}}" class="clearfix ;">{{$itemAllNewsCompany->name}}</a></p>
															<div class="limit-2">
					                                        	{!! $itemAllNewsCompany->content !!}
					                                        </div>
					                                        <span style="padding-left: 5px;"><a href="#" class="comments" style="font-size: 12px;"><i class="fa fa-eye-slash" style="padding-top: 3px;"></i> @if(empty($itemAllNewsCompany->view_count))0 @else{{$itemAllNewsCompany->view_count}}@endif </a></span>
														</div>
													<!-- </div> -->
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
							</div>	
						</main>
					</div>
					@if($getAllNewsCompany->perPage() != 0)
					<footer class="bottom_box text-center">
						<div class="right_side">

							{!! $getAllNewsCompany->render() !!}

						</div>
					</footer>
					@endif
				</div>	
			</div>	
			@include('admin.partial.modal_requiredlogin')
@endsection