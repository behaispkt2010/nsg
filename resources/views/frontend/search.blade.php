@extends('layouts.frontend')
@section('title', 'Tìm kiếm')
@section('description','tìm kiếm')
@section('add_styles')
	{{-- --}}
@endsection
@section('content')
<div class="secondary_page_wrapper col-md-12 col-sm-12">

	{{--{{dd(\App\Product::getBestStarsProduct())}}--}}

	<div class="container col-md-12 col-sm-12">
		<ul class="breadcrumbs">

			<li><a href="/">Trang chủ</a></li>
			<li>Sản phẩm</li>

		</ul>
		<div class="row">

			<aside class="col-md-3 col-sm-4">

						@include('frontend.witgets.category-product')

				<!-- - - - - - - - - - - - - - Infoblocks - - - - - - - - - - - - - - - - -->

				<div class="section_offset">
					@include('frontend.panner.product-banner')

				</div>

				<!-- - - - - - - - - - - - - - End of infoblocks - - - - - - - - - - - - - - - - -->


			</aside>
		<!-- - - - - - - - - - - - - - Products - - - - - - - - - - - - - - - - -->
<div class="col-md-9">
		<div class="section_offset">

			<header class="top_box on_the_sides">
				<div class="right_side clearfix v_centered">
					<h4>Tất cả sản phẩm</h4>
					</div>
				<div class="right_side clearfix v_centered">

					<!-- - - - - - - - - - - - - - Sort by - - - - - - - - - - - - - - - - -->

					<div class="v_centered">

						<span>Xắp xếp theo:</span>

						<div class=" sort_select">

							<select name="fillter">

								<option value="Cấp kho">Cấp kho</option>
								<option value="Đánh giá">Đánh giá</option>
								<option value="Tên sản phẩm">Tên sản phẩm</option>
								<option value="Mới nhất">Mới nhất</option>
								<option value="Giá">Giá</option>


							</select>

						</div>

					</div>

					<!-- - - - - - - - - - - - - - End of sort by - - - - - - - - - - - - - - - - -->

					<!-- - - - - - - - - - - - - - Number of products shown - - - - - - - - - - - - - - - - -->


				</div>



			</header>

			<div class="table_layout" id="products_container">

				<div class="table_layout">
					<?php $i=0 ;$j=0?>
					@foreach($products as $key=> $product)
						@if($i==0)<div class="table_row">@endif
									<!-- - - - - - - - - - - - - - Product - - - - - - - - - - - - - - - - -->
							<div class="table_cell">

								<div class="product_item">

									<!-- - - - - - - - - - - - - - Thumbmnail - - - - - - - - - - - - - - - - -->

									<div class="image_wrap">

										<a href="{{url('/product').'/'.\App\CategoryProduct::getSlugCategoryProduct($product->id).'/'.$product->slug}}"><img src="{{url('/').$product->image}}" alt=""></a>


										<!-- - - - - - - - - - - - - - Product actions - - - - - - - - - - - - - - - - -->

										<!-- - - - - - - - - - - - - - End of product actions - - - - - - - - - - - - - - - - -->

										<!-- - - - - - - - - - - - - - Label - - - - - - - - - - - - - - - - -->

										{{--<div class="label_bestseller"></div>--}}



										<!-- - - - - - - - - - - - - - End label - - - - - - - - - - - - - - - - -->

									</div><!--/. image_wrap-->

									<!-- - - - - - - - - - - - - - End thumbmnail - - - - - - - - - - - - - - - - -->

									<!-- - - - - - - - - - - - - - Product title & price - - - - - - - - - - - - - - - - -->

									<div class="description">

										<a href="#">{{$product->title}}</a>

										<div class="clearfix product_info">

											<p class="product_price alignleft">{!! \App\Util::FormatMoney($product->price_out) !!}<span class="discount_price">@if ($product->price_sale != 0) {!! \App\Util::FormatMoney($product->price_sale) !!} @endif </span> </p>
																
											<ul class="rating alignright">

												<li class="active"></li>
												<li class="active"></li>
												<li class="active"></li>
												<li class="active"></li>
												<li></li>

											</ul>
										</div>

									</div>

									<!-- - - - - - - - - - - - - - End of product title & price - - - - - - - - - - - - - - - - -->

								</div><!--/ .product_item-->

							</div>
							<?php $i = $i+1;$j=$j+1; ?>
							@if($i>=4|| $j>=count($products))
								<?php $i=0 ?>
						</div>
						@endif

					@endforeach



				</div>

			</div><!--/ .table_layout -->

			@if($products->perPage() != 0)
			<footer class="bottom_box on_the_sides">
				<div class="right_side">

					{!! $products->render() !!}

				</div>
			</footer>
				@endif

		</div>

		<!-- - - - - - - - - - - - - - End of products - - - - - - - - - - - - - - - - -->
		</div>
	</div>
	</div><!--/ .container-->

</div><!--/ .page_wrapper-->

<!-- - - - - - - - - - - - - - End Page Wrapper - - - - - - - - - - - - - - - - -->

	@endsection
@section('add-script')
	<script>
		$(document).on('change','select[name="fillter"]',function(){
			var q= $(this).val();
			window.location.href ="/product?q="+q;
		})
	</script>
@endsection