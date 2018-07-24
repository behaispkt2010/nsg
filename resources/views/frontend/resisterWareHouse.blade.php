@extends('layouts.frontend')
@section('title', 'Nhận ngay những tháng ngày miễn phí dùng dịch vụ')
@section('description','Đăng ký Chủ kho')

@section('url_seo', url('/').$_SERVER['REQUEST_URI'] )
@section('type_seo','article')
@section('title_seo', 'Nhận thêm ưu đãi khi sử dụng dịch vụ' )
@section('description_seo','Đăng ký Chủ kho để có thể tiếp cận nhiều khách hàng tiềm năng hơn nhé' )
@section('image_seo', url('/').'/frontend/images/nosago1.png' )

@section('add_styles')
{{-- --}}
@endsection
@section('content')

			<div class="secondary_page_wrapper col-md-12 col-sm-12">
				<div class="container col-md-12 col-sm-12">
					<ul class="breadcrumbs">
						<li><a href="/">Trang chủ</a></li>
						<li>Đăng ký Chủ kho</li>
					</ul>
					<div class="row">
						<aside class="col-md-3 col-sm-4" style="top: -8px;">
							<section class="section_offset">
								<h3>Thông tin</h3>
								<ul class="theme_menu">
									<li><a href="#">Giới thiệu</a></li>
									<li><a href="#">Dịch vụ</a></li>
									<li><a href="#">Điều khoản</a></li>
									<li ><a href="#">Chính sách bảo mật</a></li>
									<li ><a href="#">Liên hệ</a></li>
									<li class="active"><a href="#">Đăng ký Chủ kho</a></li>
								</ul>
							</section>
							<div class="section_offset">
								<a href="#" class="banner">
									<img src="../../../frontend/images/banner_img_11.png" alt="">
								</a>
							</div>
						</aside>
						<main class="col-md-6 col-sm-6">

							{{--<h1 class="page_title">Contact Us</h1>--}}

							<section class="section_offset">
								
								<h3>Đăng ký Chủ kho</h3>
								<form action="" method="Post"  enctype="multipart/form-data" class="contactform type_2" id="contact_form" >
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
								    <p class="h5 text-center mb-4">Điền đầy đủ thông tin form bên dưới</p>
								    @if (\Session::has('success'))
											<p class="message red" style="color: red;">Cảm ơn quý khách đã đăng ký. Chúng tôi sẽ liên hệ trong thời gian sớm nhất có thể</p>
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
									<div class="form-group">
                                        <div class="form-group label-floating">
			                                <label class="control-label" for="focusedInputnote">Mã giới thiệu</label>
			                                <input class="form-control" id="cf_refferalcode" name="cf_refferalcode" value="<?php echo (!empty($_GET['referral'])?$_GET['referral']:''); ?>"></input>
			                            </div>
                                    </div>
								    <div class="text-center">
								        <button class="btn btn-raised btn-primary" type="submit">Đăng ký chủ kho <i class="fa fa-paper-plane-o ml-1"></i></button>
								    </div>
								</form>

							</section>

							<section class="section_offset">

								<h3>Thông tin liên lạc</h3>

								<div class="theme_box">

									<div class="row">

										<div class="col-sm-5">

											<div class="proportional_frame">

												<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d26178.869235793307!2d108.36331220719113!3d12.745214238637873!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3171f7ae3b2d9915%3A0x666af08dc359365!2zUUwyNiwgVHAuIEJ1w7RuIE1hIFRodeG7mXQsIMSQ4bqvayBM4bqvaywgVmlldG5hbQ!5e0!3m2!1sen!2s!4v1510714770348" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>

											</div>

										</div>
										<div class="col-sm-7">

											<p class="form_caption">Thông tin liên hệ của chúng tôi</p>

											<ul class="c_info_list">

												<li class="c_info_location">Km35 Quốc lộ 26, huyện Krông Păk, tỉnh Dăk Lăk</li>
												<li class="c_info_phone">0944 619 493</li>
												<li class="c_info_mail"><a href="mailto:#">sale@nongsantunhien.com</a></li>
												<li class="c_info_schedule">
													<ul>

														<li>Sáng: 8h30-11h30

															</li>
														<li>Chiều: 13h00-21h00</li>
														<li>Thứ 7 - Chủ nhật: nghỉ</li>

													</ul>

												</li>

											</ul>

										</div><!--/ [col]-->

									</div><!--/ .row -->

								</div><!--/ .theme_box -->

							</section>

						</main><!--/ [col]-->

					</div><!--/ .row-->

				</div><!--/ .container-->

			</div>
@endsection

@section('add-script')

<script type="text/javascript">
	$(function() {
		
	});
</script>

@endsection