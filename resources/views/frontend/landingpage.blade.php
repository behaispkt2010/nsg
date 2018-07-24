@extends('layouts.page')
@section('title', '')

@section('url_seo', url('/').$_SERVER['REQUEST_URI'] )
@section('type_seo','article')
@section('title_seo', 'nosaGO.com - Mạng lưới kho nông sản Việt Nam ' )
@section('description_seo','Kết nối nguồn hàng chất lượng và đối tác uy tín' )
@section('image_seo', url('/').'/frontend/images/nosago1.png' )

@section('description','Những điều cần biết khi Xác thực kho')
@section('add_style')
<link href="{{ asset('plugin/landingpage/css/scrolling-nav.css') }}" rel="stylesheet">
@endsection
@section('content')
<!-- - - - - - - - - - - - - - Page Wrapper - - - - - - - - - - - - - - - - -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNavLandingpage">
  <div class="container">
    <div class="logo">
        <a href="{{url('/')}}">
            <img src="{{asset('frontend/images/nosago1.png')}}" class="img_logo_front">
        </a> 
    </div>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav ml-auto menu_landingpage">
        <li class="nav-item">
          <a class="nav-link js-scroll-trigger" href="#gioithieu">Giới thiệu</a>
        </li>
        <li class="nav-item">
          <a class="nav-link js-scroll-trigger" href="#tinhnang">Tính năng</a>
        </li>
        <li class="nav-item">
          <a class="nav-link js-scroll-trigger" href="#doitac">Đối tác</a>
        </li>
        <li class="nav-item">
          <a class="nav-link js-scroll-trigger" href="#capkho">Cấp kho</a>
        </li>
        <li class="nav-item">
          <a class="nav-link js-scroll-trigger" href="#dichvu">Dịch vụ</a>
        </li>
        <li class="nav-item">
          <a class="" href="{{ url('/register') }}">Đăng ký</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<header class="bg-primary text-white sidebar" style="height: 400px;">
  <div id="gioithieu" class="container text-center paddingLandingPage" style="">
    <h1 style="color: #fff;">Mạng lưới kho nông sản Việt Nam</h1>
    <p class="lead">Kết nối nguồn hàng chất lượng và đối tác uy tín</p>
  </div>
</header>

<div class="">
<section id="tinhnang" class="bg-light">
  <div class="service" style="height: 500px; background-color: #fff;">
	<div class="title_lp service_lp_1 paddingLandingPage">Khám phá tính năng <span class="small_text">và hơn thế nữa</span></div>
	<div class="row content-service-landingpage">
		<div class="col-md-4 col-sm-4 service_one">
			<div class="box_service_one">
				<div class="ic_service">
					
				</div>
				<div class="bg_service">
					<img class="radius " src="{{ asset('frontend/images/tinhnang1.png') }}" alt="">
				</div>
			</div>
			<div class="info_service_one">
				Tiếp cận mạng lưới đối tác uy tín
			</div>
		</div>
		<div class="col-md-4 col-sm-4 service_one">
			<div class="box_service_one">
				<div class="ic_service">
					
				</div>
				<div class="bg_service">
					<img class="radius " src="{{ asset('frontend/images/tinhnang2.png') }}" alt="">
				</div>
			</div>
			<div class="info_service_one">
				Quản lí kho toàn diện
			</div>
		</div>
		<div class="col-md-4 col-sm-4 service_one">
			<div class="box_service_one">
				<div class="ic_service">
					
				</div>
				<div class="bg_service">
					<img class="radius " src="{{ asset('frontend/images/tinhnang3.png') }}" alt="">
				</div>
			</div>
			<div class="info_service_one">
				Phát triển tính năng thiết thực
			</div>
		</div>
	</div>	
</div>
</section>
</div>

<section id="doitac">
  <div class="company">
	<div class="title_lp service_lp_2 paddingLandingPage">Đối tác của chúng tôi</div>
	<div class="content-service-landingpage service_lp_2">
		<div class="row" style="margin: 0px">
			<?php $getAllNewsCompany = \App\Company::getCompany(18); 
			$i=0 ;$j=0 ?>
			@foreach($getAllNewsCompany as $itemAllNewsCompany)
				@if($i==0)<div class="list_com">@endif
					<div class="col-md-2 col-xs-12 company_cell" style="">
						<div class="well box_1">
							<div class="company_image_lp">
								<a href="#">
									<img class="radius" src="@if (!empty($itemAllNewsCompany->image_company)){{url('/').$itemAllNewsCompany->image_company}} @else {{asset('/images/8.png')}} @endif" alt="">
								</a>
							</div>
						</div>
					</div>
					<?php $i = $i+1;$j=$j+1; ?>
					@if($i>=6|| $j>=count($getAllNewsCompany))
						<?php $i=0 ?>
				</div>
				@endif
			@endforeach
		</div>
		<div class="more" style="text-align: center;">Và hơn 300 đối tác trên cả nước</div>	
		<br>
	</div>
</div>
</section>
<section id="capkho">
  <div class="service-levelkho" style="">
		<div class="title_lp service_lp_3 paddingLandingPage">Gói dịch vụ</div>
		<div class="container">
			<div class="content-service-landingpage">
				<div class="col-md-3 col-sm-3 col-xs-12">
					<div class="row">
						<div class="title_service info_ser">
							
						</div>
						<div class="content_service">
							<ul>
								<li>Thống kê tổng quan</li>
								<li>Quản lí đơn hàng</li>
								<li>Quản lí khách hàng</li>
								<li>Quản lí vận chuyển</li>
								<li>Số lượng sản phẩm</li>
								<li>Quản lí kho</li>
								<li>Quản lí sổ quỹ</li>
								<li>Tối ưu hiển thị</li>
								<li>Nổi bật</li>
								<li>Quảng cáo</li>
								<li>Xác thực kho</li>
							</ul>
						</div>
					</div>
				</div>
				<div class="col-md-3 col-sm-3 col-xs-12">
					<div class="row col_ser">
						<div class="title_service detail_ser1">
							Cơ bản
						</div>
						<div class="content_service">
							<ul>
								<li><img src="{{asset('frontend/images/checked.png')}}" alt="" class="img_ser"></li>
								<li><img src="{{asset('frontend/images/checked.png')}}" alt="" class="img_ser"></li>
								<li><img src="{{asset('frontend/images/checked.png')}}" alt="" class="img_ser"></li>
								<li><img src="{{asset('frontend/images/checked.png')}}" alt="" class="img_ser"></li>
								<li><p class="service_no">5</p></li>
								<li><img src="{{asset('frontend/images/cancel.png')}}" alt="" class="img_ser"></li>
								<li><img src="{{asset('frontend/images/cancel.png')}}" alt="" class="img_ser"></li>
								<li><img src="{{asset('frontend/images/cancel.png')}}" alt="" class="img_ser"></li>
								<li><img src="{{asset('frontend/images/cancel.png')}}" alt="" class="img_ser"></li>
								<li><img src="{{asset('frontend/images/cancel.png')}}" alt="" class="img_ser"></li>
								<li><img src="{{asset('frontend/images/cancel.png')}}" alt="" class="img_ser"></li>
							</ul>
						</div>
					</div>
				</div>
				<div class="col-md-3 col-sm-3 col-xs-12">
					<div class="row col_ser">
						<div class="title_service detail_ser2">
							Tiềm năng
						</div>
						<div class="content_service">
							<ul>
								<li><img src="{{asset('frontend/images/checked.png')}}" alt="" class="img_ser"></li>
								<li><img src="{{asset('frontend/images/checked.png')}}" alt="" class="img_ser"></li>
								<li><img src="{{asset('frontend/images/checked.png')}}" alt="" class="img_ser"></li>
								<li><img src="{{asset('frontend/images/checked.png')}}" alt="" class="img_ser"></li>
								<li><p class="service_no">20</p></li>
								<li><img src="{{asset('frontend/images/checked.png')}}" alt="" class="img_ser"></li>
								<li><img src="{{asset('frontend/images/checked.png')}}" alt="" class="img_ser"></li>
								<li><img src="{{asset('frontend/images/checked.png')}}" alt="" class="img_ser"></li>
								<li><img src="{{asset('frontend/images/checked.png')}}" alt="" class="img_ser"></li>
								<li><img src="{{asset('frontend/images/cancel.png')}}" alt="" class="img_ser"></li>
								<li><img src="{{asset('frontend/images/cancel.png')}}" alt="" class="img_ser"></li>
							</ul>
						</div>
					</div>
				</div>
				<div class="col-md-3 col-sm-3 col-xs-12">
					<div class="row col_ser">
						<div class="title_service detail_ser3">
							Uy tín
						</div>
						<div class="content_service">
							<ul>
								<li><img src="{{asset('frontend/images/checked.png')}}" alt="" class="img_ser"></li>
								<li><img src="{{asset('frontend/images/checked.png')}}" alt="" class="img_ser"></li>
								<li><img src="{{asset('frontend/images/checked.png')}}" alt="" class="img_ser"></li>
								<li><img src="{{asset('frontend/images/checked.png')}}" alt="" class="img_ser"></li>
								<li><p class="service_no">Không giới hạn</p></li>
								<li><img src="{{asset('frontend/images/checked.png')}}" alt="" class="img_ser"></li>
								<li><img src="{{asset('frontend/images/checked.png')}}" alt="" class="img_ser"></li>
								<li><img src="{{asset('frontend/images/checked.png')}}" alt="" class="img_ser"></li>
								<li><img src="{{asset('frontend/images/checked.png')}}" alt="" class="img_ser"></li>
								<li><img src="{{asset('frontend/images/checked.png')}}" alt="" class="img_ser"></li>
								<li><img src="{{asset('frontend/images/checked.png')}}" alt="" class="img_ser"></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- <div class="content-service-landingpage">
			<div class="row">
				<div class="col-md-3 col-sm-3 col-xs-3">
					<div class="row_service">
						
					</div>
					<div class="content_levelKho">
						<p class="detail_service">Thống kê tổng quan</p>
						<p class="detail_service">Quản lí đơn hàng</p>
						<p class="detail_service">Quản lí khách hàng</p>
						<p class="detail_service">Quản lí vận chuyển</p>
						<p class="detail_service">Số lượng sản phẩm</p>
						<p class="detail_service">Quản lí kho</p>
						<p class="detail_service">Quản lí sổ quỹ</p>
						<p class="detail_service">Tối ưu hiển thị</p>
						<p class="detail_service">Nổi bật</p>
						<p class="detail_service">Quảng cáo</p>
						<p class="detail_service">Xác thực kho</p>
						
					</div>
				</div>
				<div class="col-md-3 col-sm-3 col-xs-3 " style="">
					<div class="goidichvu">
						<section class="widget">
							<a href="#" title="Chủ kho cấp 1"><img style="width: 100%;" src="{{asset('frontend/images/dichvu1.png')}}" alt=""></a>
						</section>
					</div>
				</div>
				<div class="col-md-3 col-sm-3 col-xs-3 " style="">
					<div class="goidichvu">
						<section class="widget">
							<a href="#" title="Chủ kho cấp 2"><img style="width: 100%;" src="{{asset('frontend/images/dichvu2.png')}}" alt=""></a>
						</section>
					</div>	
				</div>
				<div class="col-md-3 col-sm-3 col-xs-3 " style="">
					<div class="goidichvu">
						<section class="widget">
							<a href="#" title="Chủ kho cấp 3"><img style="width: 100%;" src="{{asset('frontend/images/dichvu3.png')}}" alt=""></a>
						</section>
					</div>	
				</div>
			</div>
		</div> -->
	</div>
</section>
<section id="dichvu">
  <div class="service-confirm service_lp_4" style="">
	<div class="title_lp service_lp_4 paddingLandingPage">
		DÀNH CHO nhà cung cấp CHUYÊN NGHIỆP
	</div>
	<div class="row content-service-landingpage">
		<div class="col-md-6 col-sm-6 " style="">
			<div class="dkdichvu">
				<section class="widget ">
					<a href="#" title=""><img style="width: 100%;" src="{{asset('frontend/images/dkxacthuc.png')}}" alt=""></a>
				</section>
			</div>
			<div class="info-service">
				<div class="title_lp info-service-ncc">
					Xác thực kho
				</div>
				<div class="content-service-ncc">
					Xác thực khoXác thực khoXác thực khoXác thực khoXác thực khoXác thực khoXác thực khoXác thực khoXác thực khoXác thực khoXác thực khoXác thực khoXác thực khoXác thực khoXác thực kho
				</div>
			</div>
		</div>
		<div class="col-md-6 col-sm-6 " style="">
			<div class="dkdichvu">
				<section class="widget dkdichvu">
					<a href="#" title=""><img style="width: 100%;" src="{{asset('frontend/images/dkquangcao.png')}}" alt=""></a>
				</section>
			</div>	
			<div class="info-service">
				<div class="title_lp info-service-ncc">
					Quảng cáo
				</div>
				<div class="content-service-ncc">
					Quảng cáo
				</div>
			</div>
		</div>
	</div>
</div>
</section>

@include('admin.partial.modal_requiredlogin')
@endsection
@section('add_scripts')

<!-- <script src="vendor/jquery/jquery.min.js"></script> -->
<script src="{{ asset('plugin/landingpage/vendor/popper/popper.min.js') }}"></script>
<!-- <script src="vendor/bootstrap/js/bootstrap.min.js"></script> -->

<!-- Plugin JavaScript -->
<script src="{{ asset('plugin/landingpage/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

<!-- Custom JavaScript for this theme -->
<script src="{{ asset('plugin/landingpage/js/scrolling-nav.js') }}"></script>
<script type="text/javascript">
	$('#tabs_service a').click(function (e) {
	  	e.preventDefault()
	  	$(this).tab('show')
	});
</script>
	
@endsection