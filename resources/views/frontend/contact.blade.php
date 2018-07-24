@extends('layouts.frontend')
@section('title', 'liên hệ')
@section('description','liên hệ')

@section('url_seo', url('/').$_SERVER['REQUEST_URI'] )
@section('type_seo','article')
@section('title_seo', 'Liên hệ' )
@section('description_seo', 'Giải đáp thắc mắc khách hàng - Phụng sự khách hàng là trách nhiệm của chúng tôi' )
@section('image_seo', url('/').'/frontend/images/nosago1.png' )

@section('add_styles')
{{-- --}}
@endsection
@section('content')
			<!-- - - - - - - - - - - - - - Page Wrapper - - - - - - - - - - - - - - - - -->

			<div class="secondary_page_wrapper col-md-12 col-sm-12">

				<div class="container col-md-12 col-sm-12">
					<ul class="breadcrumbs" style="margin-bottom: 0px; ">
						<li><a href="/">Trang chủ</a></li>
						<li>Liên hệ</li>
					</ul>
					<div class="row">
						<aside class="col-md-3 col-sm-4" style="top: -7px;">
							<section class="section_offset">
								<h3>Thông tin</h3>
								<ul class="theme_menu">
									<li><a href="#">Giới thiệu</a></li>
									<li><a href="#">Dịch vụ</a></li>
									<li><a href="#">Điều khoản</a></li>
									<li ><a href="#">Chính sách bảo mật</a></li>
									<li class="active"><a href="#">Liên hệ</a></li>
								</ul>
							</section>
							<div class="section_offset">
								<a href="#" class="banner">
									<img src="../../../frontend/images/banner_img_11.png" alt="">
								</a>
							</div>
						</aside><!--/ [col]-->
						<main class="col-md-9 col-sm-8">
							<section class="section_offset">
								<h3>Thông tin liên lạc</h3>
								<div class="theme_box">
									<div class="row">
										<div class="col-sm-7">
											<p class="form_caption">Hãy liên hệ với chúng tôi</p>
											<ul class="c_info_list">
												<li class="c_info_location" style="font-weight: 500">Km35 Quốc lộ 26, huyện Krông Păk, tỉnh Dăk Lăk</li>
												<li class="c_info_phone" style="font-weight: 500">0944 619 493</li>
												<li class="c_info_mail" style="font-weight: 500">Email: </span><a href="mailto:#">sale@nongsantunhien.com</a></li>
												<li class="c_info_schedule" style="font-weight: 500">Thời gian làm việc: </span>
													<ul>
														<li>Sáng: 8h30-11h30
														</li>
														<li>Chiều: 13h00-21h00</li>
														<li>Thứ 7 - Chủ nhật: nghỉ</li>
													</ul>
												</li>
											</ul>
											<div class="clear"></div>
										</div><!--/ [col]-->
										<div class="col-md-12 col-sm-12">
											<div class="proportional_frame">
												<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d26178.869235793307!2d108.36331220719113!3d12.745214238637873!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3171f7ae3b2d9915%3A0x666af08dc359365!2zUUwyNiwgVHAuIEJ1w7RuIE1hIFRodeG7mXQsIMSQ4bqvayBM4bqvaywgVmlldG5hbQ!5e0!3m2!1sen!2s!4v1510714770348" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
											</div>
										</div><!--/ [col]-->
									</div>
								</div>
							</section>
							<section class="section_offset">
								<h3>Liên hệ</h3>
								<form action="" method="Post"  enctype="multipart/form-data" class="contactform type_2" id="contact_form" >
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									<div class="theme_box">
									<p class="form_caption">Liên hệ với chúng tôi để được tư vấn tốt hơn thông qua form bên dưới</p>
										@if (\Session::has('success'))
											<p class="message red" style="color: red;">Cảm ơn quý khách hàng đã để lại thông tin, chúng tôi sẽ liên hệ trong thời gian sớm nhất có thể</p>
											<br>
										@endif
									<div class="form-group">
                                        <div class="form-group label-floating">
			                                <label class="control-label" for="focusedInputnote">Tên</label>
			                                <input class="form-control" id="cf_name" name="cf_name" required></input>
			                            </div>
                                    </div>
									<div class="form-group">
                                        <div class="form-group label-floating">
			                                <label class="control-label" for="focusedInputnote">Email</label>
			                                <input class="form-control" id="cf_email" name="cf_email" required></input>
			                            </div>
                                    </div>
									<div class="form-group">
                                        <div class="form-group label-floating">
			                                <label class="control-label" for="focusedInputnote">Số điện thoại</label>
			                                <input class="form-control" id="cf_order_number" name="cf_order_number" required></input>
			                            </div>
                                    </div>
									<div class="form-group">
                                        <div class="form-group label-floating">
			                                <label class="control-label" for="focusedInputnote">Tin nhắn</label>
			                                <input class="form-control" id="cf_message" name="cf_message" required></input>
			                            </div>
                                    </div>
								</div>
								<footer class="bottom_box on_the_sides">
									<div class="text-center">
										<button class="btn btn-raised btn-primary" type="submit">Gửi thông tin <i class="fa fa-paper-plane-o ml-1"></i></button>
									</div>
									<!-- <div class="right_side">
										<p class="prompt">Yêu cầu nhập</p>
									</div> -->
								</footer>
								</form>
							</section>
						</main>
					</div>
				</div>
			</div>
@endsection