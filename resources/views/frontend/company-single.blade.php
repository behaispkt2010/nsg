@extends('layouts.frontend')
@section('title', 'Thông tin Công ty')
@section('description','Thông tin Công ty')

@section('url_seo', url('/').$_SERVER['REQUEST_URI'] )
@section('type_seo','article')
@section('title_seo', 'nosaGO.com - Mạng lưới kho nông sản Việt Nam ' )
@section('description_seo','Kết nối nguồn hàng chất lượng và đối tác uy tín' )
@section('image_seo', url('/').'/frontend/images/nosago1.png' )

@section('content')
<div class="secondary_page_wrapper col-md-12 col-sm-12">
    <div class="container col-md-12 col-sm-12">
        <div class="col-xs-12 col-sm-3 col-md-3" style="padding-top: 20px;">
            <!-- <div class="panel panel-default">
                <div class="panel-heading" style="padding-left: 23px;">
                    <h4 class="panel-title">
                        <i class="fa fa-user" aria-hidden="true"></i> Thông tin Công ty
                    </h4>
                </div>
                <div id="filter_ncc_seach" class="panel-collapse collapse in">
                    <div class="panel-body" style="padding-left: 23px;">
                        <ul class="site_info_ncc">
                            <li><i class="fa fa-map-marker" aria-hidden="true" style="margin-top: 4px; margin-right: 4px;"></i> {{$company->company_address}}</li>
                            <li><i class="fa fa-phone-square" aria-hidden="true" style="margin-top: 4px; margin-right: 4px;"></i> {{$company->phone_number}}</li>
                            <li><i class="fa fa-envelope" aria-hidden="true" style="margin-top: 4px; margin-right: 4px;"></i> {{$company->email}}</li>
                        </ul>
                    </div>
                </div>
            </div> -->
            <div class="row">
                <div class="gallery_img_ncc">
                    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            <div class="item active">
                                <img alt="..." width="100%" style="border-radius: 5px;" src="{{ asset($company->image_company) }}">
                            </div>
                            <div class="panel-heading" style="padding-left: 23px;">
                                <h4 class="panel-title" style="text-align: center;">Thông tin Doanh nghiệp </h4>
                            </div>
                            @if(( !Auth::check()))
                            <div id="filter_ncc_seach" class="panel-collapse collapse in">
                                <div class="panel-body" style="padding-left: 23px;">
                                    <ul class="site_info_ncc">
                                        <li class="required_login"><i class="fa fa-user" aria-hidden="true" style="margin-top: 4px; margin-right: 4px;"></i> <a href="#">Đăng nhập để xem thông tin</a></li>
                                        <li class="required_login"><i class="fa fa-phone-square" aria-hidden="true" style="margin-top: 4px; margin-right: 4px;"></i> <a href="#">Đăng nhập để xem thông tin</a></li>
                                        <li class="required_login"><i class="fa fa-envelope" aria-hidden="true" style="margin-top: 4px; margin-right: 4px;"></i> <a href="#">Đăng nhập để xem thông tin</a></li>
                                    </ul>
                                </div>
                            </div>
                            @elseif(\App\Util::CheckRoleUserViewInfo(Auth::user()->id) == 3)
                            <div id="filter_ncc_seach" class="panel-collapse collapse in">
                                <div class="panel-body" style="padding-left: 23px;">
                                    <ul class="site_info_ncc">
                                        <li class=""><i class="fa fa-user" aria-hidden="true" style="margin-top: 4px; margin-right: 4px;"></i> <a href="#">Vui lòng liên hệ ADMIN để xem thông tin</a></li>
                                        <li class=""><i class="fa fa-phone-square" aria-hidden="true" style="margin-top: 4px; margin-right: 4px;"></i> <a href="#">Vui lòng liên hệ ADMIN để xem thông tin</a></li>
                                        <li class=""><i class="fa fa-envelope" aria-hidden="true" style="margin-top: 4px; margin-right: 4px;"></i> <a href="#">Vui lòng liên hệ ADMIN để xem thông tin</a></li>
                                    </ul>
                                </div>
                            </div>
                            @else
                            <div id="filter_ncc_seach" class="panel-collapse collapse in">
                                <div class="panel-body" style="padding-left: 23px;">
                                    <ul class="site_info_ncc">
                                        <li><i class="fa fa-user" aria-hidden="true" style="margin-top: 4px; margin-right: 4px;"></i> {{$company->ndd}}</li>
                                        <li><i class="fa fa-phone-square" aria-hidden="true" style="margin-top: 4px; margin-right: 4px;"></i> {{$company->phone_number}}</li>
                                        <li><i class="fa fa-envelope" aria-hidden="true" style="margin-top: 4px; margin-right: 4px;"></i> {{$company->email}}</li>
                                    </ul>
                                </div>
                            </div>
                            @endif
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-9 col-md-9 " style="padding-top: 20px;">
            <div class="content_verify">
                
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <ul class="info_veryfi_content">
                        
                        <li class="info_kho">
                            <label>Tên Doanh nghiệp:</label>
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
                                <li>@if (!empty($company->name_company)) {{$company->name_company}} @endif</li>
                            </ul>
                            <ul class="info-verified right_list_verify">
                                <li>@if ($company->confirm == 1)<span style="color: #0f9d58;">Xác thực</span> @else Chưa xác thực @endif</li>
                            </ul>
                            @endif
                            <div class="clear"></div>
                        </li>
                        <li class="info_kho">
                            <label>Số điện thoại :</label>
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
                                <li>@if (!empty($company->phone_number)) {{$company->phone_number}} @endif</li>
                            </ul>
                            <ul class="info-verified right_list_verify">
                                <li>@if ($company->confirm == 1)<span style="color: #0f9d58;">Xác thực</span> @else Chưa xác thực @endif</li>
                            </ul>
                            @endif
                            <div class="clear"></div>
                        </li>
                        <li class="info_kho">
                            <label>Email :</label>
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
                                <li>@if (!empty($company->email)) {{$company->email}} @endif</li>
                            </ul>
                            <ul class="info-verified right_list_verify">
                                <li>@if ($company->confirm == 1)<span style="color: #0f9d58;">Xác thực</span> @else Chưa xác thực @endif</li>
                            </ul>
                            @endif
                            <div class="clear"></div>
                        </li>
                        <li class="info_kho">
                            <label>Ngày thành lập :</label>
                            <ul class="left_list_verify">
                                <li>@if (!empty($company->time_active)) {{$company->time_active}} @endif</li>
                            </ul>
                            <ul class="info-verified right_list_verify">
                                <li>@if ($company->confirm == 1)<span style="color: #0f9d58;">Xác thực</span> @else Chưa xác thực @endif</li>
                            </ul>
                            <div class="clear"></div>
                        </li>

                        <li class="info_kho">
                            <label>Thời gian tham gia nosaGo.com:</label>
                            <ul class="left_list_verify">
                                <li>@if (!empty($company->created_at)) {{\App\Util::DayJoinGroup($company->created_at)}} 
                            @endif ngày</li>
                            </ul>
                            <!-- <ul class="info-verified right_list_verify">
                                <li>@if ($company->confirm == 1)<span style="color: #0f9d58;">Xác thực</span> @else Chưa xác thực @endif</li>
                            </ul> -->
                            <div class="clear"></div>
                        </li>
                        <li class="info_kho">
                            <label>Mua thành công:</label>
                            <ul class="left_list_verify">
                                <li>@if (!empty($order)) {{$order}} @else 0 @endif</li>
                            </ul>
                           <!--  <ul class="info-verified right_list_verify">
                                <li>@if ($company->confirm == 1)<span style="color: #0f9d58;">Xác thực</span> @else Chưa xác thực @endif</li>
                            </ul> -->
                            <div class="clear"></div>
                        </li>
                        <li class="info_kho">
                            <label>Mã số thuế:</label>
                            <ul class="left_list_verify">
                                <li>@if (!empty($company->mst)) {{$company->mst}} @endif</li>
                            </ul>
                            <ul class="info-verified right_list_verify">
                                <li>@if ($company->confirm == 1)<span style="color: #0f9d58;">Xác thực</span> @else Chưa xác thực @endif</li>
                            </ul>
                            <div class="clear"></div>
                        </li>
                        <li class="info_kho">
                            <label>Địa chỉ:</label>
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
                                <li>@if (!empty($company->company_address)) {{$company->company_address}} @endif</li>
                            </ul>
                            <ul class="info-verified right_list_verify">
                                <li>@if ($company->confirm == 1)<span style="color: #0f9d58;">Xác thực</span> @else Chưa xác thực @endif</li>
                            </ul>
                            @endif
                            <div class="clear"></div>
                        </li>
                    </ul>
                    <div class="clear"></div>
                    
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12" style="padding-bottom: 30px;">
            <div class="row">
                <div class="detail_veryfi">
                    <div class="detail_veryfi">
                        <div class="tile_veryfy">
                            <h4>Hình ảnh</h4>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>Địa chỉ</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    @if (( !Auth::check()))
                                        <td>
                                        <a href="" class="required_login" style="color: blue;">Đăng nhập để xem địa chỉ</a>
                                        </td>
                                    @elseif (\App\Util::CheckRoleUserViewInfo(Auth::user()->id) == 3)
                                        <td>
                                        <a href="" class="" style="color: blue;">Vui lòng liên hệ ADMIN để xem thông tin</a>
                                        </td>
                                    @else
                                        <td>{{$company->company_address}}</td>
                                    @endif
                                </tr>
                                </tbody>
                            </table>
                            <div class="clear"></div>
                            @if ($company->confirm == 1)
                            <div class="block-inner">
                                <div class="left_arrow_carousel">
                                    <i tag="2" class="fa fa-chevron-left" aria-hidden="true"></i>
                                </div>
                                <ul id="owl-shop" class="products owl-carousel owl-theme" style="opacity: 1; display: block;">
                                    <div class="owl-wrapper-outer">
                                        <div class="owl-wrapper" style="width: auto; display: block; transition: all 0ms ease; transform: translate3d(0px, 0px, 0px);">
                                            @foreach($arrImageDetail as $itemImageDetail)
                                                <div class="owl-item img-warehouse" style="">
                                                    <li class="image_verified">
                                                        <img src="{{url('/').$itemImageDetail->company_image}}" style="border-radius: 5px;" alt="Hình ảnh Công ty">
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="clear"></div>
        <div class="tabs products section_offset animated transparent" data-animation="fadeInDown" data-animation-delay="150">
            <ul class="tabs_nav clearfix">
                <li class="tab_bottom"><a href="#tab-1" style="font-size: 16px;">Các tin mua sản phẩm của Công ty</a></li>
            </ul>
            <div class="tab_containers_wrap">
                <div id="tab-1" class="tab_container">
                    <div class="table_layout">
                        <div class="company_list">
                            @if(count($getNewsCompany)!=0)
                                <?php $i=0 ;$j=0?>
                                @foreach($getNewsCompany as $itemAllNewsCompany)
                                    @if($i==0)<div class="list_company_row" style="">@endif
                                        <div class="col-md-3 col-xs-12 company_cell_other">
                                            <div class="well box_1">
                                                @if ($itemAllNewsCompany->companyConfirm)
                                                <div class="box-status" style="background-color: #64DD17;">
                                                    <p class="text-center status-title">HOT</p>
                                                </div>
                                                @endif
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
                                                    <span style=""><a href="#" class="comments" style="font-size: 12px;"><i class="fa fa-eye-slash" style="padding-top: 3px;"></i> @if(empty($itemAllNewsCompany->view_count))0 @else{{$itemAllNewsCompany->view_count}}@endif </a></span>
                                                </div>
                                            </div>
                                        </div>
                                        <?php $i = $i+1;$j=$j+1; ?>
                                        @if($i>=4|| $j>=count($getNewsCompany))
                                            <?php $i=0 ?>
                                    </div>
                                    @endif
                                @endforeach
                            @else
                                    <br>
                                <h2 class="text-center" style="text-align: center">Không tìm thấy dữ liệu</h2>
                            @endif
                            <div class="bottom_box load_more">
                                <a href="{{ url('/company-business') }}" class="btn btn-raised btn-primary button_grey middle_btn">Xem thêm </a><label style="padding-top: 18px;">(Còn @if ((count($getNewsCompany)-12) < 0 ) 0 @else hơn {{count($getNewsCompany)-12}} @endif cơ hội mua bán)</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>     
    @include('admin.partial.modal_requiredlogin')
</div>    
@endsection