
<footer id="footer">
	<div class="row">
		<div class="mega_menu_footer">
			{{ \App\CategoryProduct::get_cate_frontend_footer() }}
		</div>
	</div>
	
	<div class="footer_section">
		<div class="container">
			<div class="row">
				<div class="col-md-3 col-sm-6">
					<section class="widget hidden-xs">
						<h4>Về nosaGO.com</h4>
						<ul class="list_of_links">
							<li><a href="#">Giới thiệu</a></li>
							<li><a href="#">Dịch vụ</a></li>
							<li><a href="{{ url('/contact') }}">Liên hệ</a></li>
							<li><a href="#">Tìm cộng sự</a></li>
							<li><a href="#">Điều khoản</a></li>
							<li><a href="#">Chính sách bảo mật</a></li>
						</ul>
					</section>
					<section class="widget visible-xs">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Thông tin <span class="caret"></span></a>
				          <ul class="dropdown-menu">
				            <li><a href="#">Giới thiệu</a></li>
							<li><a href="#">Dịch vụ</a></li>
							<li><a href="{{ url('/contact') }}">Liên hệ</a></li>
							<li><a href="#">Tìm cộng sự</a></li>
							<li><a href="#">Điều khoản</a></li>
							<li><a href="#">Chính sách bảo mật</a></li>
				          </ul>
				        </li>
					</section>
				</div>
				<div class="col-md-3 col-sm-6 hidden-xs">
					<section class="widget">
						<h4>Hỗ trợ khách hàng</h4>
						<ul class="list_of_links">
							<li class="c_info_phone" style="padding-bottom: 16px;">0944 619 493 | support@nosaGO.com</li>
							<li class="c_info_schedule" style="padding-bottom: 9px;">(8h - 21h kể cả T7,CN)</li>
							<li><a href="#">Câu hỏi thường gặp</a></li>
							<li><a href="{{ url('/tro-giup') }}">Hướng dẫn sử dụng</a></li>
							<li><a href="{{ url('/contact') }}">Gửi yêu cầu hỗ trợ</a></li>
							<li><a href="#">Hướng dẫn đăng ký chủ kho</a></li>
							<li><a href="#">Hướng dẫn quản lý hệ thống</a></li>
						</ul>
					</section>
				</div>
				<div class="col-md-3 col-sm-6">
					<section class="widget">
						<h4>Hợp tác và liên kết</h4>
						<ul class="list_of_links">
							<li><a href="#">Hợp tác cùng doanh nghiệp</a></li>
							<li><a href="#">Hợp tác bên thứ 3</a></li>
						</ul>
					</section>
				</div>
				<div class="col-md-3 col-sm-6">
					<section class="widget">
						<h4>Kết nối với chúng tôi</h4>
						<ul class="social_btns">
							<li>
								<a href="#" class="icon_btn middle_btn social_facebook tooltip_container"><i class="icon-facebook-1"></i><span class="tooltip top">Facebook</span></a>
							</li>
							<li>
								<a href="#" class="icon_btn middle_btn social_youtube tooltip_container"><i class="icon-youtube"></i><span class="tooltip top">Youtube</span></a>
							</li>
						</ul>
					</section>
					Ứng dụng trên điện thoại
					<div class="applink">
				        <p><a target="_blank" href="#">
				            <img width="115" src="{{ asset('/frontend/images/appstore_button_apple.png') }}">
				        </a></p>
				        <p><a target="_blank" href="#">
				            <img width="114" src="{{ asset('/frontend/images/appstore_button_google.png') }}">
				        </a></p>
				    </div>
				</div>
			</div>
			
		</div>
	</div>
	<hr>
	<div class="footer_section">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-sm-6">
					<section class="widget">
						<h4>Địa chỉ văn phòng <strong>Hồ Chí Minh</strong></h4>
						<p>Hỗ trợ: 0944 619 493 | support.hcm@nosago.com</p>
						<p>Số 52, đường số 10, Phường 4, quận 9, Tp. Hồ Chí Minh</p>
						<a href="https://www.google.com/maps/place/76+S%E1%BB%91+10,+T%C4%83ng+Nh%C6%A1n+Ph%C3%BA+B,+Qu%E1%BA%ADn+9,+H%E1%BB%93+Ch%C3%AD+Minh,+Vietnam/@10.8351902,106.7780861,18z/data=!3m1!4b1!4m13!1m7!3m6!1s0x3175275b3a69ce75:0xfc7063168fc12eaf!2sDistrict+9,+Ho+Chi+Minh,+Vietnam!3b1!8m2!3d10.8428402!4d106.8286851!3m4!1s0x317527045d8e8f0d:0xf39544f19f7cc544!8m2!3d10.835188!4d106.7790063" target="_blank">Xem bản đồ</a>
					</section>
				</div>
				<div class="col-md-6 col-sm-6">
					<section class="widget">
						<h4>Địa chỉ văn phòng <strong>DakLak</strong></h4>
						<p>Hỗ trợ: 0944 619 493 | support.daklak@nosago.com</p>
						<p>Km35 Quốc lộ 26, huyện Krông Păk, tỉnh Dăk Lăk</p>
						<a href="https://www.google.com/maps/place/QL26,+Tp.+Bu%C3%B4n+Ma+Thu%E1%BB%99t,+%C4%90%E1%BA%AFk+L%E1%BA%AFk,+Vietnam/@12.7462428,108.232381,11z/data=!3m1!4b1!4m5!3m4!1s0x3171f7ae3b2d9915:0x666af08dc359365!8m2!3d12.7459448!4d108.3724701" title="" target="_blank">Xem bản đồ</a>
					</section>
				</div>
				<hr>
			</div>
		</div>
	</div>
	<hr>
	<div class="footer_section">
		<div class="container" style="width: 100% !important; padding: 0px;">
			<div class="col-md-4 col-sm-4 dkdichvu" style="padding: 0px;border-radius: 0px !important;">
				<section class="widget">
					<a href="#" title="Đăng ký dịch vụ Quảng cáo"><img src="{{asset('frontend/images/banner-footer-1.jpg')}}" alt=""></a>
				</section>
			</div>
			<div class="col-md-4 col-sm-4 dkdichvu" style="padding: 0px;border-radius: 0px !important;">
				<section class="widget">
					<a href="#" title="Đăng ký dịch vụ Quảng cáo"><img src="{{asset('frontend/images/banner-footer-2.jpg')}}" alt=""></a>
				</section>
			</div>
			<div class="col-md-4 col-sm-4 dkdichvu" style="padding: 0px;border-radius: 0px !important;">
				<section class="widget">
					<a href="#" title="Đăng ký dịch vụ Quảng cáo"><img src="{{asset('frontend/images/banner-footer-3.jpg')}}" alt=""></a>
				</section>
			</div>
			<hr>
		</div>
	</div>
	<hr>
	<div class="footer_section" style="background-color: #f8f8f8;">
		<div class="container">
			<div class="row">
				<h4 style="text-align: center;">Bạn đang thắc mắc điều gì, đừng ngần ngại, hãy gửi thông tin cần thiết cho chúng tôi để được hỗ trợ</h4>
				<div class="row col-md-offset-2">
					<div class="col-md-3 col-sm-3 col-xs-12">
						<section class="widget">
							<div class="form-group">
	                            <select id="select-dichvu" class="form-control dichvu" name="dichvu" data-placeholder="Chọn gói dịch vụ">
	                                <option value="">Chọn gói dịch vụ</option>
	                                <option value="nhan_ho_tro_upgrade">Nâng cấp Kho</option>
	                                <option value="nhan_ho_tro_quangcao">Quảng cáo nâng cao</option>
	                                <option value="nhan_ho_tro_confirm">Xác thực Kho</option>
	                            </select>
	                        </div>
						</section>
					</div>
					<div class="col-md-2 col-sm-2 col-xs-12">
						<input type="text" class="form-control name_user" name="name_user" value="" placeholder="Họ tên của bạn">
					</div>
					<div class="col-md-2 col-sm-2 col-xs-12">
						<input type="text" class="form-control phone_user" name="phone_user" value="" placeholder="Số điện thoại">
					</div>
					<div class="col-md-2 col-sm-2 col-xs-12">
						<button type="button" class="btn btn-raised btn-success btnSendRequest">Nhận hỗ trợ</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<hr>
	<!-- <div class="footer_section">
		<div class="container">
			<div class="row">
				<p style="text-align:center;">Đăng ký chủ kho tại đây <a href="{{url('/resisterWareHouse')}}" class="btn btn-raised btn-primary btn-xs transformUppercase" style="background: #0f9d58;">Đăng ký</a></p>
			</div>
		</div>
	</div>
	<hr> -->
	<div class="footer_section_3 align_center">
		<div class="container text-center">
			<p class="copyright">&copy; 2017 <a href="../html-fronend/index.html">Nông sản tự nhiên</a>. All Rights Reserved.</p>
		</div>
	</div>
</footer>



