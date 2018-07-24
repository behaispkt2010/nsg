@extends('layouts.frontend')
@section('title', 'Sản phẩm')
@section('description','sản phẩm')
@section('add_styles')
	{{-- --}}
@endsection
@section('content')
<div class="secondary_page_wrapper col-md-12 col-sm-12">

	{{--{{dd(\App\Product::getBestStarsProduct())}}--}}

	<div class="container col-md-12 col-sm-12">
		<ul class="breadcrumbs">

			<li><a href="/">Trang chủ</a></li>
			<li><a href="{{ url('/products')}}">Sản phẩm</a> </li>
			<li>@if(!empty(Request::get('search'))) Tìm kiếm: {{Request::get('search')}} @elseif(!empty($nameCate)) {{$nameCate}} @else Tất cả sản phẩm @endif</li>
			<li style="float: right">
				<div class="right_side clearfix v_centered" style="margin-top: -8px;">
					<div class="v_centered">
						<span>Xắp xếp theo:</span>
						<div class=" sort_select">
							<select name="fillter">
								<option value="cap-kho" @if(Request::get('q')=='cap-kho') selected @endif>Cấp kho</option>
								<option value="ten-san-pham" @if(Request::get('q')=='ten-san-pham') selected @endif>Tên sản phẩm</option>
								<option value="moi-nhat" @if(Request::get('q')=='moi-nhat') selected @endif>Mới nhất</option>
								<option value="gia" @if(Request::get('q')=='gia') selected @endif>Giá</option>
							</select>
						</div>
					</div>
				</div>
			</li>
		</ul>

		<div class="row">
		<div class="col-md-12">
		<div class="section_offset">
			<!-- <header class="top_box on_the_sides">
				<div class="clearfix v_centered" style="text-align: center;">
					@if(!empty(Request::get('search')))
					<h4>Tìm kiếm: {{Request::get('search')}}</h4>
						@elseif(!empty($nameCate))
						<h4>{{$nameCate}}</h4>
						@else
						<h4>Tất cả sản phẩm</h4>
					@endif
				</div>
				
			</header> -->
			<div class="table_layout" id="products_container">
				<div class="table_layout" style="">
					@if(count($products)!=0)
					<?php $i=0 ;$j=0?>
					@foreach($products as $key=> $product)
						@if($i==0)<div class="category_product_row" style="">@endif
							<div class="col-md-3 col-xs-12 category_product_cell">
								<div class="product_bestselt">
									<div class="image_wrap">
										<a href="{{url('/product').'/'.\App\CategoryProduct::getSlugCategoryProduct($product->id).'/'.$product->slug}}"><img src="{{url('/').$product->image}}" alt=""></a>
										{{--<div class="label_bestseller"></div>--}}
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
												@if($product->confirmkho == 1)
													<img src="{{url('/images')}}/xacthuc.png" alt="Đã xác thực">
												@endif
											</a>
											<span class="alignright">{!! \App\Rate::getRateProduct($product->id)!!}</span>
											<p class="alignleft textoverlow">{{ \App\Util::ProductCode($product->id)  }}</p>
										</div>
										<div class="clearfix product_info">
                                        @if (( !Auth::check()))
                                            <a href="" class="required_login not_login" style="">Đăng nhập để xem giá</a>
                                        @else
                                            <p class="product_price alignleft">{!! \App\Util::FormatMoney($product->price_out) !!}<span class="discount_price">@if ($product->price_sale != 0) {!! \App\Util::FormatMoney($product->price_sale) !!} @endif </span> </p>
                                        @endif
                                        </div>
                                        <div class="clearfix product_info">
                                            <p class="alignleft">Tối thiểu: <a href="#" class="bg-number">{{ number_format($product->min_gram)  }}</a> SP</p>
                                        </div>
									</div>

								</div>
							</div>
							<?php $i = $i+1;$j=$j+1; ?>
							@if($i>=4|| $j>=count($products))
								<?php $i=0 ?>
						</div>
						@endif

					@endforeach

					@else
						<br>
					<h2 class="text-center" style="text-align: center">Không tìm thấy dữ liệu</h2>
				@endif
				</div>

			</div>
			@if($products->perPage() != 0)
			<footer class="bottom_box text-center">
				<div class="right_side">

					{!! $products->render() !!}

				</div>
			</footer>
			@endif

		</div>
		</div>
	</div>
	</div>
</div>
	@endsection
@section('add-script')
	<script>
		$(document).on('change','select[name="fillter"]',function(){
			var q= $(this).val();
			window.location.href ="{{url('/')}}/products?q="+q;
		})
	</script>
@endsection