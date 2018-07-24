@extends('layouts.frontend')
@section('title', 'Thông tin Chủ kho')
@section('description','Thông tin Chủ kho')

@section('content')
			<!-- - - - - - - - - - - - - - Page Wrapper - - - - - - - - - - - - - - - - -->
			<div class="page_wrapper col-md-12 col-sm-12">

				<div class="container col-md-12 col-sm-12">

					<ul class="breadcrumbs">
						<li><a href="/">Trang chủ</a></li>
						<li>Hướng dẫn đăng ký chủ kho</li>
					</ul>
					<div class="row ">
						<main class="col-md-12 col-sm-12">
							đăng ký chủ kho như thế nào ?
						</main>
					</div>
					
				</div>
			</div>
			@include('admin.partial.modal_requiredlogin')
@endsection