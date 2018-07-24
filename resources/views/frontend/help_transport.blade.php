@extends('layouts.frontend')
@section('title', 'Thông tin Chủ kho')
@section('description','Thông tin Chủ kho')

@section('content')
			<!-- - - - - - - - - - - - - - Page Wrapper - - - - - - - - - - - - - - - - -->
			<div class="page_wrapper col-md-12 col-sm-12">

				<div class="container col-md-12 col-sm-12">

					<ul class="breadcrumbs">
						<li><a href="/">Trang chủ</a></li>
						<li>Hướng dẫn phương thức vận chuyển hàng hóa</li>
					</ul>
					<div class="row ">
						<main class="col-md-12 col-sm-12">
							Hình thức vận chuyển hàng hóa ra sao ??
						</main>
					</div>
					
				</div>
			</div>
			@include('admin.partial.modal_requiredlogin')
@endsection