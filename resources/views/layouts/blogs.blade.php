<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Nông sản tự nhiên | @yield('title') </title>
    <meta property="og:url"           content="@yield('url_seo')" />
    <meta property="og:type"          content="@yield('type_seo')" />
    <meta property="og:title"         content="@yield('title_seo')" />
    <meta property="og:description"   content="@yield('description_seo')" />
    <meta property="og:image"         content="@yield('image_seo')" />
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,400italic,300,300italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" />
    <!-- Styles -->
    <script src="{{asset('plugin/jquery/dist/jquery.min.js')}}"></script>
    <script type="text/javascript">
        var baseURL="{!!url('/')!!}";
    </script>
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
    @include('partial.frontend-styles')
    <link href="{{asset('plugin/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('frontend/css/blogs/homepage.css')}}" rel="stylesheet">
    <!-- <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/blogs/ghpages-materialize.css') }}"> -->
    @yield('add_style')
    <style>
        html,body{
            height: 100%;
            padding-top: 0px;
        }
    </style>
</head>
<body class="" >
    <div id="app" class="" style="height: 100%; width: 100%;">
        <div class=""> 
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark" id="mainNavLandingpage">
          <div class="container">
            <div class="logo">
                <a href="{{url('/')}}">
                    <img src="{{asset('frontend/images/nosago1.png')}}" class="img_logo_front">
                </a> 
            </div>
            <div class="collapse navbar-collapse" id="navbarResponsive">
              <ul class="navbar-nav ml-auto menu_blogs menu_top">
                @if(( !Auth::check()))
                    <li><a class="btn btn-raised btn-dangtin col-xs-12 btnMenuTop" href="{{ url('/login') }}">Đăng nhập</a></li>
                    <li><a class="btn btn-raised btn-dangtin col-xs-12 btnMenuTop" href="{{ url('/register') }}">Đăng ký</a></li>
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
        @yield('content')
            <div class="h-end text-center">
            </div>
        </div>
        @include('partial.frontend-footer')
    </div>

    @include('partial.frontend-script')
    @yield('add_script')
</body>
</html>

