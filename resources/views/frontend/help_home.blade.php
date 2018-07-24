@extends('layouts.page')
@section('title', 'Bạn gặp khó khăn gì, hãy để chúng tôi giúp đỡ nhé')
@section('description','Bạn gặp khó khăn gì, hãy để chúng tôi giúp đỡ nhé')
@section('add_style')
<link href="{{asset('frontend/css/help_menu.css')}}" rel="stylesheet">
@endsection
@section('content')
    <!-- - - - - - - - - - - - - - Page Wrapper - - - - - - - - - - - - - - - - -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNavLandingpage">
      <div class="container">
        <div class="logo">
            <a href="{{url('/')}}">
                <img src="{{asset('frontend/images/nosago1.png')}}" class="img_logo_front">
            </a> 
        </div>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto menu_landingpage menu_help">
            @if(( !Auth::check()))
                <li><a class="btn btn-raised btn-dangtin col-xs-12 btnHelpMenu" href="{{ url('/login') }}">Đăng nhập</a></li>
                <li><a class="btn btn-raised btn-dangtin col-xs-12 btnHelpMenu" href="{{ url('/register') }}">Đăng ký</a></li>
            @else
                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown"
                            aria-expanded="false" style="color: #000; line-height: 54px; padding-left: 10px;">Chào bạn, {{Auth::user()->name}}</a>          
                <ul class="dropdown-menu dropdown-usermenu pull-right" style="">
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
        </div>
      </div>
    </nav>

    <div class="page_wrapper" style="width: 100%;">
        <div class="container body_help_menu">
            <ul class="breadcrumbs">
                <li><a href="{!!url('/')!!}">Trang chủ</a></li>
                <li>Trợ giúp</li>
            </ul>
            <div class="row">
                <div id="MenuJSTree" class=""></div>
                <div class="MenuContent">
                    <section class="section_offset">
                        <h1>Trang trợ giúp</h1>
                        <article class="entry single">
                            <div class="entry_meta">
                                <div class="alignleft">
                                    
                                </div>
                            </div>
                            <div class="content">
                                <h1>Chúng tôi có thể giúp gì cho bạn?</h1>
                                <p>Bạn có thể tìm thấy câu trả lời từ thanh menu bên trái này</p>
                                <br>
                                <hr>
                                <div class="question_other">
                                    <p><h3>Bạn vẫn chưa có câu trả lời?</h3></p>
                                    Đừng lo, bạn có thể gửi mail cho chúng tôi!
                                    <div class="row text-center">
                                        <div class="col-md-3">
                                            <a class="btn btn-raised btn-dangtin col-xs-12 btnHelpMenu" href="{{ url('/contact') }}">Liên hệ hỗ trợ</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </section>
                </div>
            </div>
        </div>
    </div>
    @include('admin.partial.modal_login_xs')
@endsection
@section('add_script')
    <script src="{{ asset('plugin/jquery/dist/jquery.min.js')}}"></script>
    <script src="{{ asset('frontend/js/jstree/jstree.min.js')}}"></script>
    <script type="text/javascript">
        var baseURL="{!!url('/')!!}";
    </script>
    <script type="text/javascript">
        $(function () {
            $('#MenuJSTree').jstree({
                'core' : {
                  'data' : 
                  {
                    "url" : baseURL+"/dataJsTree", 
                    "dataType" : "json"
                  }
                },
                "state" : { "key" : "state_demo" },
                "plugins" : ["state"]
            }).on("changed.jstree", function (e, data) {
                var href = data.node.a_attr.href;
                document.location.href = href;
            });

        });
        
    </script>
@endsection
