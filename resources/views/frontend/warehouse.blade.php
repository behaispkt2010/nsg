@extends('layouts.frontend')
@section('title', 'Thông tin chủ kho')
@section('description','Thông tin chủ kho')

@section('url_seo', url('/').$_SERVER['REQUEST_URI'] )
@section('type_seo','article')
@section('title_seo', 'nosaGO.com - Mạng lưới kho nông sản Việt Nam ' )
@section('description_seo','Kết nối nguồn hàng chất lượng và đối tác uy tín' )
@section('image_seo', url('/').'/frontend/images/nosago1.png' )

@section('content')
<div class="secondary_page_wrapper col-md-12 col-sm-12">
    <div class="container col-md-12 col-sm-12">
        <div class="col-xs-12 col-sm-4 col-md-4" style="padding-top: 20px; padding-left: 0px;">
            <div class="panel panel-default">
                <div class="item active">
                    <img alt="..." width="100%" style="border-radius: 5px 5px 0 0;" src="{{ asset($ware_house->image_kho) }}">
                </div>
                <div class="panel-heading" style="padding-left: 23px;">
                    <h4 class="panel-title" style="text-align: center;">Thông tin NCC </h4>
                </div>
                @if(( !Auth::check()))
                <div id="filter_ncc_seach" class="panel-collapse collapse in">
                    <div class="panel-body" style="padding-left: 23px;">
                        <ul class="site_info_ncc">
                            <li class="required_login"><i class="fa fa-map-marker icon_info_ncc" aria-hidden="true"></i> <a href="#">Đăng nhập để xem thông tin</a></li>
                            <li class="required_login"><i class="fa fa-phone-square icon_info_ncc" aria-hidden="true"></i> <a href="#">Đăng nhập để xem thông tin</a></li>
                            <li class="required_login"><i class="fa fa-envelope icon_info_ncc" aria-hidden="true"></i> <a href="#">Đăng nhập để xem thông tin</a></li>
                            <li class="required_login"><i class="fa fa-clock-o icon_info_ncc" aria-hidden="true"></i><a href="#">Đăng nhập để xem thông tin</a></li>
                            <li class="required_login"><i class="fa fa-shopping-cart icon_info_ncc" aria-hidden="true"></i> <a href="#">Đăng nhập để xem thông tin</a></li>
                            <li class=""><i class="fa fa-eye-slash icon_info_ncc" aria-hidden="true"></i>{{$ware_house->count_view}} </li>
                        </ul>
                    </div>
                </div>
                @else
                <div id="filter_ncc_seach" class="panel-collapse collapse in">
                    <div class="panel-body" style="padding-left: 23px;">
                        <ul class="site_info_ncc">
                            @if(\App\Util::CheckRoleUserViewInfo(Auth::user()->id) == 3)
                                <li><i class="fa fa-map-marker icon_info_ncc" aria-hidden="true"></i> Vui lòng liên hệ ADMIN để xem thông tin</li>
                                <li><i class="fa fa-phone-square icon_info_ncc" aria-hidden="true"></i> Vui lòng liên hệ ADMIN để xem thông tin </li>
                                <li><i class="fa fa-envelope icon_info_ncc" aria-hidden="true"></i>  Vui lòng liên hệ ADMIN để xem thông tin </li>
                                <li><i class="fa fa-clock-o icon_info_ncc" aria-hidden="true"></i>{{\App\Util::DayJoinGroup($ware_house->created_at)}} ngày cùng nosaGO.com</li>
                                <li><i class="fa fa-shopping-cart icon_info_ncc" aria-hidden="true""></i> Bán thành công: {{$order}}</li>
                                <li class=""><i class="fa fa-eye-slash icon_info_ncc" aria-hidden="true"></i>{{$ware_house->count_view}} </li>
                            @else
                                <li><i class="fa fa-map-marker icon_info_ncc" aria-hidden="true"></i> {{$ware_house->ware_houses_address}}</li>
                                <li><i class="fa fa-phone-square icon_info_ncc" aria-hidden="true"></i> {{$ware_house->phone_number}}</li>
                                <li><i class="fa fa-envelope icon_info_ncc" aria-hidden="true"></i> {{$ware_house->email}}</li>
                                <li><i class="fa fa-clock-o icon_info_ncc" aria-hidden="true"></i>{{\App\Util::DayJoinGroup($ware_house->created_at)}} ngày cùng nosaGO.com</li>
                                <li><i class="fa fa-shopping-cart icon_info_ncc" aria-hidden="true"></i> Bán thành công: {{$order}}</li>
                                <li class=""><i class="fa fa-eye-slash icon_info_ncc" aria-hidden="true"></i>{{$ware_house->count_view}} </li>
                            @endif
                        </ul>
                    </div>
                </div>
                @endif
            </div>
            <div class="hidden-xs">
            
            </div>
        </div>
        <div class="col-xs-12 col-sm-8 col-md-8" style="padding-top: 20px;">
            <div class="content_verify">
                <ul class="info_veryfi_content">
                    <li class="info_kho">
                        <label>Mô hình kinh doanh:</label>
                        
                        <ul class="left_list_verify">
                            <li>@foreach($arrCategoryWarehouse as $itemCategoryWareHouse)
                                    @if ($itemCategoryWareHouse->id == $ware_house->category_warehouse_id ) {{$itemCategoryWareHouse->category_warehouse_name}}
                                    @endif
                                @endforeach
                            </li>
                        </ul>
                        <ul class="info-verified right_list_verify">
                            <li>@if ($ware_house->confirm_kho == 1)<span style="color: #0f9d58;">Xác thực</span> @else Chưa xác thực @endif</li>
                        </ul>
                        
                        <div class="clear"></div>
                    </li>
                    <li class="info_kho">
                        <label>Tên doanh nghiệp:</label>
                        @if (( !Auth::check()))
                        <ul class="left_list_verify required_login">
                            <li style="color: blue;"><a href="#">Đăng nhập để xem thông tin</a></li>
                        </ul>
                        <ul class="info-verified right_list_verify">
                            <li></li>
                        </ul>
                        @elseif(\App\Util::CheckRoleUserViewInfo(Auth::user()->id) == 3)
                        <ul class="left_list_verify">
                            <li style="color: blue;"><a href="#">Vui lòng liên hệ ADMIN để xem thông tin</a></li>
                        </ul>
                        <ul class="info-verified right_list_verify">
                            <li></li>
                        </ul>
                        @else
                        <ul class="left_list_verify">
                            <li>@if (!empty($ware_house->name_company)) {{$ware_house->name_company}} @endif</li>
                        </ul>
                        <ul class="info-verified right_list_verify">
                            <li>@if ($ware_house->confirm_kho == 1) <span style="color: #0f9d58;">Xác thực</span> @else Chưa xác thực @endif</li>
                        </ul>
                        @endif
                        <div class="clear"></div>
                    </li>
                    <li class="info_kho">
                        <label>Ngày thành lập :</label>
                        <ul class="left_list_verify">
                            <li>@if (!empty($ware_house->time_active)) {{$ware_house->time_active}} @endif</li>
                        </ul>
                        <ul class="info-verified right_list_verify">
                            <li>@if ($ware_house->confirm_kho == 1)<span style="color: #0f9d58;">Xác thực</span> @else Chưa xác thực @endif</li>
                        </ul>
                        <div class="clear"></div>
                    </li>
                    <li class="info_kho">
                        <label>Mã số thuế:</label>
                        <ul class="left_list_verify">
                            <li>@if (!empty($ware_house->mst)) {{$ware_house->mst}} @endif</li>
                        </ul>
                        <ul class="info-verified right_list_verify">
                            <li>@if ($ware_house->confirm_kho == 1)<span style="color: #0f9d58;">Xác thực</span> @else Chưa xác thực @endif</li>
                        </ul>
                        <div class="clear"></div>
                    </li>
                    <li class="info_kho">
                        <label>Địa chỉ kho :</label>
                        @if (( !Auth::check()))
                        <ul class="left_list_verify required_login">
                            <li style="color: blue;"><a href="#">Đăng nhập để xem thông tin</a></li>
                        </ul>
                        <ul class="info-verified right_list_verify">
                            <li></li>
                        </ul>
                        @elseif(\App\Util::CheckRoleUserViewInfo(Auth::user()->id) == 3)
                        <ul class="left_list_verify">
                            <li style="color: blue;"><a href="#">Vui lòng liên hệ ADMIN để xem thông tin</a></li>
                        </ul>
                        <ul class="info-verified right_list_verify">
                            <li></li>
                        </ul>
                        @else 
                        <ul class="left_list_verify">
                            <li>@if (!empty($ware_house->ware_houses_address)) {{$ware_house->ware_houses_address}} @endif</li>
                        </ul>
                        <ul class="info-verified right_list_verify">
                            <li>@if ($ware_house->confirm_kho == 1)<span style="color: #0f9d58;">Xác thực</span> @else Chưa xác thực @endif</li>
                        </ul>
                        @endif
                        <div class="clear"></div>
                    </li>
                    <div class="clear"></div>
                    <li class="info_kho">
                        <label>Người đại diện :</label>
                        @if (( !Auth::check()))
                        <ul class="left_list_verify required_login">
                            <li style="color: blue;"><a href="#">Đăng nhập để xem thông tin</a></li>
                        </ul>
                        <ul class="info-verified right_list_verify">
                            <li></li>
                        </ul>
                        @elseif(\App\Util::CheckRoleUserViewInfo(Auth::user()->id) == 3)
                        <ul class="left_list_verify">
                            <li style="color: blue;"><a href="#">Vui lòng liên hệ ADMIN để xem thông tin</a></li>
                        </ul>
                        <ul class="info-verified right_list_verify">
                            <li></li>
                        </ul>
                        @else 
                        <ul class="left_list_verify">
                            <li>@if (!empty($ware_house->ndd)) {{$ware_house->ndd}} @endif</li>
                        </ul>
                        <ul class="info-verified right_list_verify">
                            <li>@if ($ware_house->confirm_kho == 1)<span style="color: #0f9d58;">Xác thực</span> @else Chưa xác thực @endif</li>
                        </ul>
                        @endif
                        <div class="clear"></div>
                    </li>
                    <li class="info_kho">
                        <label>Số điện thoại NDD :</label>
                        @if (( !Auth::check()))
                        <ul class="left_list_verify required_login">
                            <li style="color: blue;"><a href="#">Đăng nhập để xem thông tin</a></li>
                        </ul>
                        <ul class="info-verified right_list_verify">
                            <li></li>
                        </ul>
                        @elseif(\App\Util::CheckRoleUserViewInfo(Auth::user()->id) == 3)
                        <ul class="left_list_verify">
                            <li style="color: blue;"><a href="#">Vui lòng liên hệ ADMIN để xem thông tin</a></li>
                        </ul>
                        <ul class="info-verified right_list_verify">
                            <li></li>
                        </ul>
                        @else 
                        <ul class="left_list_verify">
                            <li>@if (!empty($ware_house->phone_number)) {{$ware_house->phone_number}} @endif</li>
                        </ul>
                        <ul class="info-verified right_list_verify">
                            <li>@if ($ware_house->confirm_kho == 1)<span style="color: #0f9d58;">Xác thực</span> @else Chưa xác thực @endif</li>
                        </ul>
                        @endif
                        <div class="clear"></div>
                    </li>
                    <li class="info_kho">
                        <label>Email NDD :</label>
                        @if (( !Auth::check()))
                        <ul class="left_list_verify required_login">
                            <li style="color: blue;"><a href="#">Đăng nhập để xem thông tin</a></li>
                        </ul>
                        <ul class="info-verified right_list_verify">
                            <li></li>
                        </ul>
                        @elseif(\App\Util::CheckRoleUserViewInfo(Auth::user()->id) == 3)
                        <ul class="left_list_verify">
                            <li style="color: blue;"><a href="#">Vui lòng liên hệ ADMIN để xem thông tin</a></li>
                        </ul>
                        <ul class="info-verified right_list_verify">
                            <li></li>
                        </ul>
                        @else 
                        <ul class="left_list_verify">
                            <li>@if (!empty($ware_house->email)) {{$ware_house->email}} @endif</li>
                        </ul>
                        <ul class="info-verified right_list_verify">
                            <li>@if ($ware_house->confirm_kho == 1)<span style="color: #0f9d58;">Xác thực</span> @else Chưa xác thực @endif</li>
                        </ul>
                        @endif
                        <div class="clear"></div>
                    </li>
                </ul>
                <div class="clear"></div>
            </div>
        </div>
            
        <div class="col-xs-12 col-sm-12 col-md-12" style="padding-bottom: 30px;">
            <div class="row">
                <div class="detail_veryfi">
                    <div class="detail_veryfi">
                        <div class="tile_veryfy">
                            <h4>Kho hàng</h4>
                        </div>
                        <div class="table-responsive">
                            @if (( !Auth::check()))
                            <ul class="left_list_verify required_login">
                                <li style="color: blue;"><a href="#">Đăng nhập để xem thông tin</a></li>
                            </ul>
                            <ul class="info-verified right_list_verify">
                                <li></li>
                            </ul>
                            @elseif(\App\Util::CheckRoleUserViewInfo(Auth::user()->id) == 3)
                            <ul class="left_list_verify">
                                <li style="color: blue;"><a href="#">Vui lòng liên hệ ADMIN để xem thông tin</a></li>
                            </ul>
                            <ul class="info-verified right_list_verify">
                                <li></li>
                            </ul>
                            @else 
                            @if ($ware_house->confirm_kho == 1)
                            <div class="block-inner">
                                <div class="left_arrow_carousel">
                                    <i tag="2" class="fa fa-chevron-left" aria-hidden="true"></i>
                                </div>
                                <ul id="owl-shop" class="products owl-carousel owl-theme" style="opacity: 1; display: block;">
                                    <div class="owl-wrapper-outer">
                                        <div class="owl-wrapper" style="width: auto; float: right; display: block; transition: all 0ms ease; transform: translate3d(0px, 0px, 0px);">
                                            @foreach($arrImageDetail as $itemImageDetail)
                                                <div class="owl-item img-warehouse" style="">
                                                    <li class="image_verified">
                                                        <img src="{{url('/').$itemImageDetail->warehouse_detail_image}}" style="border-radius: 5px;" alt="Hình ảnh kho hàng">
                                                    </li>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="owl-controls clickable" style="display: none;"><div class="owl-pagination"><div class="owl-page"><span class=""></span></div></div></div></ul>
                                <div class="right_arrow_carousel">
                                    <i style="display:block" tag="2" class="fa fa-chevron-right" aria-hidden="true"></i>
                                </div>
                            </div>
                            @else
                                <div></div>
                            @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <main class="col-md-12 col-sm-12">
                <div class="row" style="padding-left: 10px;">
                    <h3><a style="color: #0f9d58;">Sản phẩm của NCC</a></h3>
                </div>
                <div class="warehouse_list">
                    <?php $i=0 ;$j=0?>
                        @foreach($getNewProduct as $key => $product)
                            @if($i==0)<div class="category_product_row" style="">@endif
                                <div class="col-md-3 col-xs-12 category_product_cell">
                                    <div class="product_bestselt">
                                        <div class="image_wrap">
                                            <a href="{{url('/product').'/'.\App\CategoryProduct::getSlugCategoryProduct($product->id).'/'.$product->slug}}"><img src="{{url('/').$product->image}}" alt=""></a>
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
                                                    @if($product->confirm_kho == 1)
                                                        <img src="{{url('/images')}}/xacthuc.png" alt="">
                                                    @else
                                                    @endif
                                                </a>
                                                <p class="alignleft" style="white-space: nowrap; overflow: hidden;text-overflow: ellipsis;padding-left: 10px;">{{ \App\Util::ProductCode($product->id)  }}</p>
                                            </div>
        
                                            <div class="clearfix product_info">
                                            @if (( !Auth::check()))
                                                <a href="" class="required_login not_login" style="">Đăng nhập để xem giá</a>
                                            @else
                                                <p class="product_price alignleft">{!! \App\Util::FormatMoney($product->price_out) !!}<span class="discount_price">@if ($product->price_sale != 0) {!! \App\Util::FormatMoney($product->price_sale) !!} @endif </span> </p>
                                                        
                                                <span class="alignright">{!! \App\Rate::getRateProduct($product->id)!!}</span>
                                            @endif
                                            </div>
                                            <div class="clearfix product_info">
                                                <p class="alignleft">Tối thiểu: <a href="#" class="bg-number">{{ number_format($product->min_gram)  }}</a> SP</p>
                                            </div>
        
                                        </div>
        
                                    </div>
                                </div>
                                <?php $i = $i+1; $j=$j+1; ?>
                                @if ($i>=4 || $j>=count($getNewProduct))
                                    <?php $i=0 ?>
                                    </div>
                                @endif
                        @endforeach
                </div>
                <div class="bottom_box load_more">
                    <a href="{{url('/')}}/products" class="btn btn-raised btn-primary button_grey middle_btn">Xem thêm </a><label class="viewmore">(Còn @if ((count($getNewProduct)-12) < 0 ) 0 @else hơn {{count($getNewProduct)-12}} @endif sản phẩm)</label>
                </div>
            
            </main>
        </div>
            <!-- <div class="clear"></div>
            <div class="tabs products section_offset animated transparent" data-animation="" data-animation-delay="0">
                <ul class="tabs_nav clearfix">
                    <li class="tab_bottom"><a href="#tab-1" style="font-size: 16px;">Sản phẩm của NCC</a></li>
                </ul>
                <div class="tab_containers_wrap">
                    <div id="tab-1" class="tab_container">
                        <div class="table_layout">
                            <?php $i=0 ;$j=0?>
                            @foreach($getNewProduct as $key => $product)
                                @if($i==0)<div class="category_product_row" style="">@endif
                                        <div class="col-md-3 col-xs-12 category_product_cell">
            
                                            <div class="product_bestselt">
            
                                                <div class="image_wrap">
            
                                                    <a href="{{url('/product').'/'.\App\CategoryProduct::getSlugCategoryProduct($product->id).'/'.$product->slug}}"><img src="{{url('/').$product->image}}" alt=""></a>
                                                
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
                                                            @if($product->confirm_kho == 1)
                                                                <img src="{{url('/images')}}/xacthuc.png" alt="">
                                                            @else
                                                            @endif
                                                        </a>
                                                        <p class="alignleft" style="white-space: nowrap; overflow: hidden;text-overflow: ellipsis;padding-left: 10px;">{{ \App\Util::ProductCode($product->id)  }}</p>
                                                    </div>
            
                                                    <div class="clearfix product_info">
                                                    @if (( !Auth::check()))
                                                        <a href="" class="required_login not_login" style="">Đăng nhập để xem giá</a>
                                                    @else
                                                        <p class="product_price alignleft">{!! \App\Util::FormatMoney($product->price_out) !!}<span class="discount_price">@if ($product->price_sale != 0) {!! \App\Util::FormatMoney($product->price_sale) !!} @endif </span> </p>
                                                                
                                                        <span class="alignright">{!! \App\Rate::getRateProduct($product->id)!!}</span>
                                                    @endif
                                                    </div>
                                                    <div class="clearfix product_info">
                                                        <p class="alignleft">Tối thiểu: <a href="#" class="bg-number">{{ number_format($product->min_gram)  }}</a> SP</p>
                                                    </div>
            
                                                </div>
            
                                            </div>
                                        </div>
                                        <?php $i = $i+1; $j=$j+1; ?>
                                        @if ($i>=4 || $j>=count($getNewProduct))
                                            <?php $i=0 ?>
                                            </div>
                                        @endif
                            @endforeach
                        </div>
                        <div class="bottom_box load_more">
                            <a href="{{url('/')}}/products" class="btn btn-raised btn-primary button_grey middle_btn">Xem thêm </a><label style="padding-top: 18px;">(Còn @if ((count($getNewProduct)-12) < 0 ) 0 @else hơn {{count($getNewProduct)-12}} @endif sản phẩm)</label>
                        </div>
                        
                    </div>
            
                </div>
            
            </div> -->
            @include('admin.partial.modal_requiredlogin')
    </div>   
</div>     
@endsection