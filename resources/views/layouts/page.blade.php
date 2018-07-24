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
    @include('partial.frontend-styles')
    @yield('add_style')
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
    <style>
        html,body{
            height: 100%;
        }
    </style>
</head>
<body>
    <div id="app" style="height: 100%; width: 100%;">
        <!-- @include('partial.page_top') -->
        <div class=""> 
        @yield('content')
            <div class="h-end text-center">
                <!-- <label><span style="color: white">Sản phẩm của </span><span style="color: green">Nông sản tự nhiên</span></label> -->
            </div>
        </div>
        @include('partial.frontend-footer')
    </div>

    @include('partial.frontend-script')
    @yield('add_script')
</body>
</html>

