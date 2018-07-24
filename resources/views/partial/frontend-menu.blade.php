<header class="hidden-xs">
    <div class="logo col-md-2 col-sm-2">
        <a href="{{url('/')}}">
            <img src="{{asset('frontend/images/nosago1.png')}}" class="img_logo_front">

        </a>
    </div>
    <div id="search" class="filtergroup w80 nomargin">
        <form action="{{ url('/') }}" class="clearfix search" method="get">
            <input type="text" id="keyword" onkeydown="this.style.color = '#333';" onclick="this.value = '';" value="" name="search">
            <button class="button-search btnsearch" type="submit"><i class="fa fa-search"></i></button>
        </form>
        
    </div>
    <div class="support_menu">
        <div class="specialist-user">
            <a href="{{url('/')}}">
                <img src="{{asset('frontend/images/specialist-user.png')}}" style="" class="img_icon_header_hp">
            </a>
            <div class="info_header_hp">
                <a href="#">Hỗ trợ <br>0944 619 493</a>
            </div>
        </div>
        <div class="check-order">

            <a href="{{url('/')}}">
                <img src="{{asset('frontend/images/check_order.png')}}" class="img_icon_header_hp">
            </a>
            <div class="info_header_hp">
                <a href="{{url('/')}}">Kiểm tra <br>đơn hàng</a>
            </div>
        </div>
    </div>
    <ul class="box-manage">
        @if(( !Auth::check()))
                <li><a class="btn btn-raised btn-dangtin col-xs-12 required_login" href="" style="background-color: #00695c !important;">ĐĂNG CƠ HỘI</a></li>
                <li><a class="btn btn-raised btn-dangtin col-xs-12" href="{{url('/login')}}" data-modal-url="{{url('/login')}}">ĐĂNG NHẬP </a></li>
                <li><a class="btn btn-raised btn-dangtin col-xs-12" href="{{url('/register')}}" >ĐĂNG KÝ</a></li>
        @else
            <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown"
                        aria-expanded="false" style="color: #000; line-height: 54px; padding-left: 10px;">Chào bạn, {{Auth::user()->name}}</a>
            <li><a class="btn btn-raised btn-dangtin col-xs-12" href="{{ route('newscompany.create') }}" style="background-color: #00695c !important;">ĐĂNG CƠ HỘI</a></li>            
            <ul class="dropdown-menu dropdown-usermenu pull-right" style="top: 9%; right: 0px;">
                <li><a href="{{ route('users.edit',['id' => Auth::user()->id]) }}">
                        <i class="fa fa-info-circle pull-right"></i>Tài khoản
                    </a>
                </li>
                <li><a href="{{ url('/logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fa fa-sign-out pull-right"></i>Thoát
                    </a>
                </li>
            </ul>
        @endif

        <form id="logout-form"
              action="{{ url('/logout') }}"
              method="POST"
              style="display: none;">
            {{ csrf_field() }}
        </form>

    </ul>
</header>
<header class="type_6 visible-xs">
    <div id="main_navigation_wrap" >
        <div class="bottom_part">
            <div class="main">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="navbar-header">
                            <button type="button" style="" class="navbar-toggle collapsed main_navigation_fronend" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar" >
                                <span class="sr-only">Toggle navigation</span>
                                <i class="fa fa-bars" aria-hidden="true"></i>
                            </button>
                                <a href="{{url('/')}}" class="logo" style="width: 66%; margin-top: -17px;">
                                    <img src="{{asset('frontend/images/nosago1.png')}}" alt="" style="height: 60px;">
                                </a>
                                <li class="user">
                                    @if(( !Auth::check()))
                                        <a href="#" title="Đăng nhập" class="fa fa-user login_xs" style="color: #00695b; padding-left: 15px; "></a>
                                    @else
                                        <a href="javascript:;" class="fa fa-user user-profile dropdown-toggle is_login" data-toggle="dropdown"
                                                    aria-expanded="false" ></a>
                                        <ul class="dropdown-menu dropdown-usermenu pull-right" style="top: 38%;right: 0px;">
                                            <li><a href="#">Xin chào {{Auth::user()->name}} !!! </a></li>
                                            <li><a href="{{ route('users.edit',['id' => Auth::user()->id]) }}">
                                                    <i class="fa fa-info-circle pull-right icon_fa_frmlogin"></i>Tài khoản
                                                </a>
                                            </li>
                                            <li><a href="{{ url('/logout') }}"
                                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                    <i class="fa fa-sign-out pull-right icon_fa_frmlogin"></i>Thoát
                                                </a>
                                            </li>
                                        </ul>
                                    @endif

                                    <form id="logout-form"
                                          action="{{ url('/logout') }}"
                                          method="POST"
                                          style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                                </div>
                            
                        <div class="">
                            <div id="navbar" class="navbar-collapse collapse" style="height: 1px;">
                                <ul class="nav navbar-nav clearfix sm">
                                    <li><a href="{{url('/')}}"><i class="material-icons icon_home">home</i> Trang chủ</a></li>
                                    <li><a href="{{url('/resisterWareHouse')}}" target="_blank"><i class="material-icons icon_home">add_circle</i> Tạo hồ sơ</a></li>
                                    <li><a href="{{ url('/company-business') }}" target="_blank"><i class="material-icons icon_home">work</i>Cơ hội giao thương</a></li>
                                    <li class=""><a href="#" class=""><i class="material-icons icon_home">headset</i> Hỗ trợ</a></li>
                                    <li><a target="_blank" href="https://www.facebook.com/nongsan.blog/?hc_ref=ARQggsv1H_Q7Ryl2-x7fgoo7FRzpGLRS66H7z41Km9lfSgH-1lIOabiXvwiM_1ZJEQY&fref=gs&dti=153574518554374&hc_location=group"><i class="material-icons icon_home">share</i> Cộng đồng</a></li>
                                    <li><a target="_blank" href="{{ url('/blogs') }}"><i class="material-icons">chat</i> Blogs</a></li>
                                    <li><a href="#"><i class="material-icons icon_home">flash_on</i> Chiến dịch</a></li>
                                </ul>
                            </div>
                            <div class="mobile-menu-icon-wrapper visible-xs" style="width: 100%;padding-top: 8px;height: 56px;background-color: #f8f8f8;">
                                <ul class="mobile-menu-icon">
                                    <li class="search" style="width: 93%;-webkit-box-shadow: 3px 4px 15px -5px #888;">
                                    <div class="">
                                        <form action="{{ url('/') }}" class="clearfix search" method="get" style="">
                                            <input type="text"  tabindex="1" placeholder="Tìm nguồn hàng chất lượng, tìm nhà cung cấp uy tín,..." name="search" class="alignleft" style="">
                                            <button class="button_blue def_icon_btn alignleft" ></button>
                                        </form>
                                    </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>   
</header>
<div class="col-md-2 col-sm-2 left_col menu_fixed hidden-xs">
    <div class="left_col scroll-view">
        <div class="clearfix"></div>

        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <div class="clear"></div>
                <ul class="nav side-menu" style="background-color: #efefef;">
                    <li><a class="menu_left_item" href="{{url('/')}}"><i class="material-icons icon_home">home</i> Trang chủ</a></li>
                    <li><a class="menu_left_item"target="_blank"  href="{{url('/resisterWareHouse')}}"><i class="material-icons icon_home">add_circle</i> Tạo hồ sơ</a></li>
                    <li><a class="menu_left_item"target="_blank"  href="{{ url('/company-business') }}"><i class="material-icons icon_home">work</i>Cơ hội giao thương</a></li>
                    <li class=""><a class="menu_left_item hotro_chat" href="#"><i class="material-icons icon_home">headset</i> Hỗ trợ</a></li>
                    <li><a class="menu_left_item" target="_blank" href="https://www.facebook.com/nongsan.blog/?hc_ref=ARQggsv1H_Q7Ryl2-x7fgoo7FRzpGLRS66H7z41Km9lfSgH-1lIOabiXvwiM_1ZJEQY&fref=gs&dti=153574518554374&hc_location=group"><i class="material-icons icon_home">share</i> Cộng đồng</a></li>
                    <li><a class="menu_left_item" target="_blank" href="{{ url('/blogs') }}"><i class="material-icons icon_home">chat</i> Blogs</a></li>
                    <li><a class="menu_left_item" href="#"><i class="material-icons icon_home">flash_on</i> Chiến dịch</a></li>
                </ul>
            </div>
        </div>
        <div id="chat_hotro" class="hidden">
            <div class="sidebar-footer hidden-small">
                <div class="pageface">
                    <div class="title">
                        <i class="fa fa-minus" style="float: right;"></i>
                    </div>
                    <div class="fb-page" data-href="https://www.facebook.com/nosaGOcom/"
                         data-tabs="messages, messages"
                         data-width="380"
                         data-small-header="false"
                         data-adapt-container-width="true"
                         data-hide-cover="false" data-show-facepile="true">
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="" style="background-color: #fff;padding: 10px 10px 10px 14px;font-size: 16px;font-weight: bold;">
            <i class="fa fa-bars" aria-hidden="true" style="padding-top: 2px; padding-right: 7px;"></i>Danh mục sản phẩm
        </div>
        <div class="">
            
        </div> -->
        <div class="clearfix"></div>
        <div class="clearfix"></div>
        <div class="search_advance">
            <div class=""> Tìm kiếm nâng cao </div>
            <form action="{{ url('/') }}" class="clearfix" method="get" style="font-weight: 300;">
                <div class="x_panel search_advance_content">
                    <div class="wrapper-content mt20 ">
                        <div class="pd-all-20 border-top-title-main">
                            <div class="form-group">
                                <div class="form-group">
                                    <select id="select-province" name="tinh" class="form-control" data-placeholder="Tỉnh/Thành Phố" style="padding-left: 0px;">
                                        <option></option>
                                        @foreach(\App\Province::get() as $itemProvince)
                                            <option value="{{$itemProvince->provinceid}}">{{$itemProvince->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <select id="select-category" name="sanpham" class="form-control" data-placeholder="Danh mục sản phẩm">
                                        <option></option>
                                        <?php $category = \App\CategoryProduct::where('disable',0)->get();?>
                                        {{ \App\Category::CateMulti($category,0,$str="&nbsp&nbsp&nbsp&nbsp",old('parent')) }}
                                    </select>
                                </div>
                                <div class="form-group">
                                    <select id="select-levelkho" name="capkho" class="form-control" data-placeholder="Cấp kho">
                                        <option></option>
                                        <option value="1">Cơ bản</option>
                                        <option value="2">Tiềm năng</option>
                                        <option value="3">Uy tín</option>
                                    </select>
                                </div>
                                <input type="text" id="keyword" onkeydown="this.style.color = '#333';" onclick="this.value = '';" value="" placeholder="Nhập thông tin cần tìm" name="search" class="textsearch">
                            </div>
                        </div>
                    </div>
                </div>
                <button class="btn btn-raised btn-dangtin button-search btnsearch" style="width: 100%;" type="submit"><i style="padding-right: 10px;" class="material-icons">search</i>Tìm kiếm</button>
            </form>
        </div>
        <div class="clearfix"></div>
        <div class="banner_qc">
            
            <div class="banner_one">
                @include('frontend.panner.home-panner-left-1')
                @include('frontend.panner.home-panner-left-2')
                @include('frontend.panner.home-panner-left-3')
                
            </div>
            
        </div>
    </div>
</div>
<div class="col-md-10 col-sm-10 menu_top_bg hidden-xs" style="height: 41px;">
    

<ul class="col-md-12 col-sm-12 nav navbar-nav clearfix sm hidden-xs" style="margin-left: 150px; height: 41px;">
    <div class="mainmenu_frontend">
        <nav class="full_width_nav main_navigation">
            <ul>
                {{\App\Menu::get_menu_frontend_full()}}
            </ul>
        </nav>
    </div>
    <!-- <div class="sticky_inner type_2">
        <div class="nav_item">
            <nav class="main_navigation">
                <ul>
                {{\App\Menu::get_menu_frontend()}}
                </ul>

            </nav>
        </div>
    </div> -->
</ul>
</div>


@include('admin.partial.modal_login_xs')
<div class="modal fade " id="modalCheckOrder" role="dialog">
    <div class="modal-dialog ">

        <!-- Modal content-->
        <div class="modal-content col-md-offset-3 col-md-6  col-sm-8 col-sm-offset-2 col-xs-12">
            <form action="{{url('/check-order')}}" method="get">
            <div class="modal-header">
                <h4 class="modal-title">Nhập mã đơn hàng</h4>
            </div>

            <div class="modal-body">
                <div class="row">
                        <input type="text" name="code-order" placeholder="Vui lòng nhập mã đơn hàng">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Thoát</button>
                <button type="submit" class="btn btn-default btn-success" id="check-order-pupup">Kiểm tra</button>
            </div>
            </form>
        </div>

    </div>
</div>
@include('admin.partial.modal_requiredlogin')
@section('add-script')
<script src="{{asset('js/selectize.js')}}"></script>
<script type="text/javascript">
    $(function() {
        var heightMain = $('main').height();
        $('.heightMain').val(heightMain);
        var heightBanner = $('.banner_qc').height();
        $('.heightBanner').val(heightBanner);


    });
</script>
<script type="text/javascript">
    $('.hotro_chat').on('click',function() {
        // alert(1);
        $('#chat_hotro').toggleClass("hidden");
    });
    $('.fa-minus').on('click',function() {
        $('#chat_hotro').addClass("hidden");
    });
</script>

@endsection