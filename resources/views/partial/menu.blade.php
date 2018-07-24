<div class="col-md-3 left_col menu_fixed">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="{{url('/')}}" class="site_title"><img src="{{url('/')}}/images/logo-w.png" alt=""></a>
            <div class="btn-close-mn visible-xs"><i class="fa fa-close"></i></div>
        </div>

        <div class="clearfix"></div>

        <!-- menu profile quick info -->
        <div class="profile">
            <div class="profile_pic">
                <img data-toggle="modal" data-target=".bs-example-modal-avata" src="{{url('/')}}{{\Illuminate\Support\Facades\Auth::user()->image}}"
                     alt="..." class="img-circle profile_img">
            </div>
            <div class="profile_info">

                <div style="    font-size: 14px; color: #FFF; margin-bottom: 5px;    font-weight: 500;">{{\Illuminate\Support\Facades\Auth::user()->name}}
                </div>
                @if(Auth::user()->hasRole('kho'))
                <a href="{{route('warehouse.edit',['id' => \App\WareHouse::getIdWareHouse(Auth::user()->id) ])}}" style="margin-right: 10px;    font-size: 13px;"><i class="fa fa-user" aria-hidden="true"></i>
                    Thông tin</a>
                @elseif(Auth::user()->hasRole('com'))
                <a href="{{route('company.edit',['id' => \App\Company::getIdWareHouse(Auth::user()->id) ])}}" style="margin-right: 10px;    font-size: 13px;"><i class="fa fa-user" aria-hidden="true"></i>
                    Thông tin</a>
                @else
                    <a href="{{route('users.edit',['id' => Auth::user()->id])}}" style="margin-right: 10px;    font-size: 13px;"><i class="fa fa-user" aria-hidden="true"></i>
                        Thông tin</a>
                    @endif

                {{--<a style="font-size: 13px;"><i class="fa fa-unlock" aria-hidden="true"></i> Đăng xuất</a>--}}
               <a href="{{ url('/logout') }}"
                   onclick="event.preventDefault();
                         document.getElementById('logout-form').submit();">
                    <i class="fa fa-unlock" aria-hidden="true"></i> Đăng xuất
                </a>
                <form id="logout-form"
                      action="{{ url('/logout') }}"
                      method="POST"
                      style="display: none;">
                    {{ csrf_field() }}
                </form>
            </div>
        </div>
        <!-- /menu profile quick info -->
        <div class="clearfix"></div>


        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <div class="clear"></div>
                <ul class="nav side-menu">
                    @if(Auth::user()->hasRole(['editor','admin','kho']))
                    <li><a><i class="fa fa-laptop"></i> Thống kê <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            @permission('dashboard')
                            <li class="active"><a href="{{url('/admin')}}">Quản trị</a></li>
                            @endpermission
                            @permission('dashboard-admin')
                            <li><a href="{{url('/admin/dashboard')}}">Chủ kho</a></li>
                            @endpermission
                        </ul>
                    </li>
                    @endif
                    @permission('news')
                    <li><a><i class="fa fa-newspaper-o"></i> Tin tức <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li class="active"><a href="{{route('news.index')}}">Tin tức</a></li>
                            <li><a href="{{route('news.create')}}">Tạo mới</a></li>
                            <li><a href="{{route('category.index')}}">Nhóm tin tức</a></li>
                        </ul>
                    </li>
                    @endpermission
                    @permission('newscompany')
                    <li><a><i class="fa fa-wpforms"></i> Quản lý tin Công ty <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li class="active"><a href="{{route('newscompany.index')}}">Tin tức</a></li>
                            <li><a href="{{route('newscompany.create')}}">Tạo mới</a></li>
                        </ul>
                    </li>
                    @endpermission
                    @permission('pages')

                    <li><a><i class="fa fa-clone"></i> Trang <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{route('pages.index')}}">Trang</a></li>
                            <li><a href="{{route('pages.create')}}">Tạo mới</a></li>

                        </ul>
                    </li>
                    @endpermission

                    @permission('orders')
                    <li><a href="{{route('orders.index')}}"><i class="fa fa-edit"></i> Đơn hàng</a></li>
                    @endpermission
                    @permission('products')
                    <li><a><i class="fa fa-tag"></i>Sản Phẩm <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{route('products.index')}}">Sản phẩm</a></li>
                            @permission('categoryProducts')
                            <li><a href="{{route('categoryProducts.index')}}">Nhóm sản phẩm</a></li>
                            @endpermission

                        </ul>
                    </li>
                    @endpermission
                    @if(Auth::user()->hasRole(['editor','admin','kho']))
                    <li><a><i class="fa fa-database"></i>Quản lý kho <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            @permission('warehouse')

                            <li><a href="{{route('warehouse.index')}}"></i> Thông tin chủ kho</a></li>
                            @endpermission
                            @permission('money')

                            <li><a href="{{route('money.index')}}">Sổ quỹ</a></li>
                            @endpermission
                            @permission('inventory')

                            <li><a href="{{route('inventory.index')}}">Kiểm kho</a></li>
                            @endpermission
                            @permission('historyInput')

                            <li><a href="{{route('historyInput.index')}}">Lịch sử nhập hàng</a></li>
                            @endpermission

                        </ul>
                    </li>
                    @endif
                    @if(Auth::user()->hasRole(['editor','admin']))
                        @permission('company')
                        <li><a href="{{route('company.index')}}"><i class="fa fa-industry"></i> Quản lý công ty </a></li>
                        @endpermission
                    @endif

                    @permission('customers')
                    <li><a href="{{route('customers.index')}}"><i class="fa fa-users"></i> Khách hàng</a></li>
                    @endpermission
                    @permission('pricing')
                    <li><a href="{{route('pricing.index')}}"><i class="fa fa-line-chart"></i> Thông tin giá cả</a></li>
                    @endpermission
                    @permission('document')
                    <li><a href="{{route('document.index')}}"><i class="fa fa-book"></i> Tài liệu</a></li>
                    @endpermission
                    @permission('websitelink')
                    <li><a href="{{route('websitelink.index')}}"><i class="fa fa-link"></i> Liên kết website</a></li>
                    @endpermission
                    @permission('driver')
                    <li><a><i class="fa fa-car"></i>Quản lý vận chuyển <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{route('driver.index')}}">Thông tin tài xế</a></li>
                            <li><a href="{{route('driver.create')}}">Tạo mới</a></li>
                        </ul>
                    </li>
                    @endpermission
                    
                    @permission('sharingreferralcode')
                    <li><a href="{{ route('sharingreferralcode.index') }}"><i class="fa fa-qrcode"></i>Mã Giới thiệu</a></li>
                    @endpermission

                </ul>
            </div>
            @role('admin')
            <div class="menu_section">
                <h3>Quản Trị</h3>
                <ul class="nav side-menu">
                    @permission('users')
                    <li><a><i class="fa fa-user"></i> User <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{route('users.index')}}">Users</a></li>
                            <!--<li><a href="page_404.html">Roles</a></li>-->

                            <li><a href="{{route('role.index')}}">Role</a></li>

                            <li><a href="{{route('permission.index')}}">Permission</a></li>
                        </ul>
                    </li>
                    @endpermission
                    @permission('staffs')

                    <li><a><i class="fa fa-sitemap"></i> Nhân Sự<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">

                            <li><a href="{{route('staffs.index')}}">Danh sách nhân viên</a>
                            <li><a href="{{route('staffs.create')}}">Thêm nhân viên</a>
                            </li>

                        </ul>
                    </li>
                    @endpermission
                    @permission('help-menu')
                    <li><a><i class="fa fa-life-ring"></i>Menu trợ giúp <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{route('help-menu.index')}}">Tin hỗ trợ user</a></li>
                        </ul>
                    </li>
                    @endpermission
                    @permission('setting')
                    <li><a><i class="fa fa-cogs"></i>Cài đặt<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">

                            <li><a href="{{route('setting.index')}}">Cài đặt chung</a></li>

                            <li><a href="{{route('menu.index')}}">Menu</a></li>

                        </ul>
                    </li>
                    @endpermission

                </ul>
            </div>
@endrole
        </div>
        <!-- /sidebar menu -->

        <!-- /menu footer buttons -->
        <div class="sidebar-footer hidden-small">
            <div class="pageface">
                <div class="title">
                    <i class="fa fa-headphones"></i>  Hỗ trợ chủ kho
                    <i class="fa fa-minus"></i>
                </div>
                <div class="fb-page" data-href="https://www.facebook.com/nongsantunhien/"
                     data-tabs="messages"
                     data-small-header="false"
                     data-adapt-container-width="true"
                     data-hide-cover="false" data-show-facepile="true">

                </div>
            </div>

        </div>
        <!-- /menu footer buttons -->
    </div>
</div>

<!-- top navigation -->
<div class="top_nav">
    <div class="nav_menu">
        <nav>
            <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
            </div>

            <ul class="nav navbar-nav navbar-right">
                {{--<li class="">
                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown"
                       aria-expanded="false">
                        <img src="{{url('/')}}{{\Illuminate\Support\Facades\Auth::user()->image}}" alt="">
                        <span class=" fa fa-angle-down"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                        <li><a href="login.html"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                    </ul>
                </li>--}}
                <?php
                    $strUserID = Auth::user()->id;
                    $strNumNotify = count(\App\Notification::where('is_read',0)->where('roleview',$strUserID)->get());
                    $arrNotification = \App\Notification::GetNotify($strUserID);
                ?>
                
                <li role="presentation" class="dropdown" style="display: block" >
                    <a href="javascript;" class="dropdown-toggle info-number" id="" data-toggle="dropdown"
                       aria-expanded="false">
                        <i class="fa fa-bell-o"></i>
                        <span class="badge bg-template " id="notify_count">@if ($strNumNotify != 0) {{$strNumNotify}} @endif</span>
                    </a>
                    <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                        <div class="notify_heading">
                            <strong>Thông báo</strong>
                            <a id="menu_notify" class="alignright">Đánh dấu tất cả đã đọc</a>
                        </div>
                        @if (count($arrNotification) != 0)
                            @foreach ($arrNotification as $itemNotification)
                                <li class="notify @if($itemNotification->is_read == 1)notifyIsRead @endif">
                                    <a onclick="UpdateClickOneNotify({{ $itemNotification->id }})" href="{{ url('/').$itemNotification->link }}" target="_blank">
                                        <span class="image"><img src="@if (!empty($itemNotification->image)){{ url('/').$itemNotification->image }} @else {{url('/').'/images/user_default.png'}} @endif " alt="Profile Image"/></span>
                                            <span>
                                                <span class="notification_title">{{$itemNotification->title}}</span>
                                            </span>
                                        <span class="message">{{$itemNotification->content}}</span>
                                        <span class="time">{{ $itemNotification->created_at }}</span>
                                    </a>
                                </li>

                            @endforeach
                            <li style="height: 40px;">
                                <div class="text-center">
                                    <a href="{{ route('notification.index') }}">
                                        <strong>Xem tất cả</strong>
                                        <i class="fa fa-angle-right"></i>
                                    </a>
                                </div>
                            </li>
                        @else
                            <div class="notify_area">
                                <div class="message_null">
                                    <span class="different">Bạn không có thông báo mới.</span>
                                </div>
                                <div class="img_notify">
                                    <img src="{{ asset('/images/box-mail.png')}}" alt="">
                                </div>
                            </div>
                        @endif
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</div>
<!-- /top navigation -->
<!--modal-->
<div class="modal fade bs-example-modal-avata" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false"
     data-backdrop="static">
    <div class="modal-dialog bs-example-modal-avata">
        <div class="img-circle logo"></div>
        <div class="modal-content">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title text-center" id="myModalLabel">Thay đổi hình đại diện</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-2 col-xs-2">
                        <div class="img-circle avarta-item">
                            <img src="{{asset('/images/1.png')}}" data-value="1">
                        </div>
                    </div>
                    <div class="col-md-2 col-xs-2">
                        <div class="img-circle avarta-item">
                            <img src="{{asset('/images/2.png')}}" data-value="2">
                        </div>
                    </div>
                    <div class="col-md-2 col-xs-2">
                        <div class="img-circle avarta-item">
                            <img src="{{asset('/images/3.png')}}" data-value="3">
                        </div>
                    </div>
                    <div class="col-md-2 col-xs-2">
                        <div class="img-circle avarta-item">
                            <img src="{{asset('/images/4.png')}}" data-value="4">
                        </div>
                    </div>
                    <div class="col-md-2 col-xs-2">
                        <div class="img-circle avarta-item">
                            <img src="{{asset('/images/5.png')}}" data-value="5">
                        </div>
                    </div>
                    <div class="col-md-2 col-xs-2">
                        <div class="img-circle avarta-item">
                            <img src="{{asset('/images/6.png')}}" data-value="6">
                        </div>
                    </div>
                    <div class="col-md-2 col-xs-2">
                        <div class="img-circle avarta-item">
                            <img src="{{asset('/images/7.png')}}" data-value="7">
                        </div>
                    </div>
                    <div class="col-md-2 col-xs-2">
                        <div class="img-circle avarta-item">
                            <img src="{{asset('/images/8.png')}}" data-value="8">
                        </div>
                    </div>

                </div>

            </div>


        </div>
    </div>
    <input type="hidden" id="user_id" value="{{Auth::user()->id}}">
</div>
<script type="text/javascript">
    $('#menu_notify').on('click', function (e) {
        //alert('click');
        e.preventDefault();
        $.ajax({
            type: "GET",
            url: '{{ url('/') }}/admin/notify/AjaxUpdateIsReadNotify',
            success: function( msg ) {
                console.log[msg];
                $("#notify_count").addClass('hidden');
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                var Data = JSON.parse(XMLHttpRequest.responseText);
            }
        });
    });
    var socket = io.connect('{{ url('/') }}:{{env("PORT_NODE")}}/');
    socket.on("messages", function (data) {
        var data = JSON.parse(data);
        if($('#user_id').val() == data.roleview){
            var currentCountMsg = 0;  
            if($('#notify_count').text() != ''){
                currentCountMsg = parseInt($('#notify_count').text());
            }
            $('#notify_count').text(currentCountMsg+1);
            $('#notify_count').removeClass('hidden');
            //add new messge to Message List when a new product had been created
            $(".notify_heading").after('<li class="notify"><a onclick="UpdateClickOneNotify('+data.notifyID+')" href="{{url('/')}}'+data.link+'" target="_blank"><span class="image"><img src="{{asset("/images/user_default.png")}}" alt="Profile Image"></span><span><span class="notification_title">'+data.title+'</span></span><span class="message">'+data.content+'</span><span class="time">'+data.created_at+'</span><div class="ripple-container"></div></a></li>');
        }
    });

    function UpdateClickOneNotify($NotifyID) {
        var NotifyID = $NotifyID;
        console.log(NotifyID);
        $.ajax({
            type: "GET",
            data: {strNotifyID: NotifyID},
            url: '{{ url('/') }}/admin/notify/AjaxUpdateClickOneNotify',
            success: function( msg ) {
                console.log(msg);
                currentCountMsg = parseInt($('#notify_count').text());
                if (currentCountMsg > 0) {
                    $('#notify_count').text(currentCountMsg-1);
                } 
                if (currentCountMsg == 1) {
                    $('#notify_count').addClass('hidden');
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                var Data = JSON.parse(XMLHttpRequest.responseText);
            }
        });
    }

</script>