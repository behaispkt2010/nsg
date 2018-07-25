<!DOCTYPE html>

<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin - @yield('title')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel='shortcut icon' type='image/x-icon' href='{{asset('frontend/images/logo.png')}}'/>
    <!-- Font Awesome -->
    <link rel="stylesheet" type="text/css" href="{{asset('css/icon.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/font-awesome.min.css')}}">
    <!-- jQuery -->
    <script src="{{asset('plugin/jquery/dist/jquery.min.js')}}"></script>
    <script type="text/javascript">
        var baseURL="{!!url('/')!!}";
    </script>
    {{--ckeditor--}}
    <script src="{{asset('plugin/ckeditor/ckeditor.js')}}" ></script>
    <script src="{{asset('plugin/ckfinder/ckfinder.js')}}" ></script>

    <script src="{{asset('plugin/func_ckfinder.js')}}" ></script>
    <script src='{{ url("/") }}:{{env("PORT_NODE")}}/socket.io/socket.io.js'></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
    <!-- Theme style -->
    @include('partial.styles')
    @yield('add_styles')
<body class="nav-md">
<div class="container body">
    <div class="main_container">
        @include('partial.menu')
                <!-- page content -->
        <div class="right_col" role="main">
            <!-- top tiles -->
            <div class="message">
                @if (count($errors))
                    <div class="row alert alert-dismissible alert-danger">
                        <div class="col-md-1"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></div>
                        <div class="col-md-11">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>Lỗi!</strong>
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                        </div>
                    </div>

                @endif
                @if (Session::has('flash_message'))

                        <div class="alert alert-dismissible alert-{!! Session::get('flash_level') !!}">
                            @if (Session::get('flash_level') == "success") <i class="fa fa-check" aria-hidden="true"></i>
                            @else <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                            @endif
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            {!! Session::get('flash_message') !!}
                        </div>
                @endif
            </div>
            <div class="btn-new">
                @yield('new-btn')
            </div>
            <div class="clear"></div>
            @yield('content')
        </div>
        @include('partial.footer')
    </div>
</div>
@include('partial.scripts')
@yield('add_scripts')
</body>
</html>