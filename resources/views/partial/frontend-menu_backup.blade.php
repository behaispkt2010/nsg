
    <header id="header" class="type_6 hidden-xs">
        <hr>
        <div class="bottom_part">
            <div class="container">
                <div class="row">
                    <div class="main_header_row">
                        <div class="col-sm-3">
                            <a href="{{url('/')}}" class="logo">
                                <img src="{{asset('frontend/images/logo.png')}}" alt="" style="">
                            </a>
                        </div>
                        <div class="col-sm-6">
                            <form action="{{ url('/') }}" class="clearfix search" method="get">
                                <input type="text"  tabindex="1" placeholder="Tìm sản phẩm bạn mong muốn..." name="search" class="alignleft" style="font-size: 15px;">
                                <button class="button_blue def_icon_btn alignleft"></button>
                            </form>
                        </div>
                        <div class="col-sm-2" style="font-size: 16px; color: #fff;">

                            @if(( !Auth::check()))
                                <a href="{{url('/login')}}" data-modal-url="{{url('/login')}}" style="color: #fff;">Đăng nhập</a> <br> Hoặc <a href="{{url('/register')}}" style="color: #fff;">Đăng ký</a>
                            @else
                                Chào bạn <br><a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown"
                                            aria-expanded="false" style="color: #fff;">{{Auth::user()->name}}</a>
                                <ul class="dropdown-menu dropdown-usermenu pull-right" style="top: 71%;right: 0px;">
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
                        </div>
                        <div class="col-sm-3" style="padding: 0px;left: -17px; color: #fff;">
                            {{--<img src="{{asset('/images/user_default.png')}}" class="img-responsive" alt="">--}}
                            <p style="margin: 0px;"><a href="#" style="color: #fff; font-size: 16px;">Hotline hỗ trợ</a></p>
                            <p><i class="fa fa-phone" aria-hidden="true" style="margin-top: 4px; margin-right: 4px;"></i>{!! \App\Setting::getValue('phone')!!}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div><div id="main_navigation_wrap">

            <div class="container">

                <div class="row">

                    <div class="col-xs-12">
                        <div class="sticky_inner type_2"><div class="nav_item">
                                <nav class="main_navigation">
                                    <ul>
                                    {{\App\Menu::get_menu_frontend()}}
                                    </ul>

                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <header class="type_6 visible-xs">
        <div id="main_navigation_wrap" >
            <div class="bottom_part">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="navbar-header">
                                <button type="button" style="float: left;" class="navbar-toggle collapsed main_navigation_fronend" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar" >
                                    <span class="sr-only">Toggle navigation</span>
                                    <i class="fa fa-bars" aria-hidden="true"></i>
                                </button>
                                    <a href="{{url('/')}}" class="logo" style="float: left; width: 72%;margin-top: -17px;">
                                        <img src="{{asset('frontend/images/logo_rp_shop.png')}}" alt="" style="height: 60px;">
                                    </a>
                                    <li class="user">
                                        @if(( !Auth::check()))
                                            <a href="#" title="Đăng nhập" class="fa fa-user login_xs" style="color: #fff; padding-left: 15px; float: right;"></a>
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
                                
                            
                            <div id="navbar" class="navbar-collapse collapse" style="height: 1px;">
                                <ul class="nav navbar-nav clearfix sm">
                                    {{\App\Menu::get_menu_frontend()}}
                                </ul>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>   
    </header>
    <div class="mobile-menu-icon-wrapper visible-xs" style="width: 100%;padding-top: 8px;height: 56px;background-color: #f8f8f8;">
        <ul class="mobile-menu-icon">
            <li class="search" style="width: 93%;-webkit-box-shadow: 3px 4px 15px -5px #888;">
            <div class="">
                <form action="{{ url('/') }}" class="clearfix search" method="get" style="">
                    <input type="text"  tabindex="1" placeholder="Tìm sản phẩm bạn mong muốn..." name="search" class="alignleft" style="">
                    <button class="button_blue def_icon_btn alignleft" ></button>
                </form>
            </div>
            </li>
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
                            <input type="text" name="code-order" placeholder="vui lòng nhập mã đơn hàng">

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

