<!doctype html>
<html lang="en">
<head>
    <!-- Basic page needs
    ============================================ -->
    <title>Nông sản tự nhiên | @yield('title') </title>
    <meta property="og:url"           content="@yield('url_seo')" />
    <meta property="og:type"          content="@yield('type_seo')" />
    <meta property="og:title"         content="@yield('title_seo')" />
    <meta property="og:description"   content="@yield('description_seo')" />
    <meta property="og:image"         content="@yield('image_seo')" />


    <meta charset="utf-8">
    <meta name="author" content="@yield('author')">
    <meta name="title" content="@yield('title')">
    <meta name="description" content="@yield('description')">
    <meta name="keywords" content="@yield('keywords')">
    
    <!-- Mobile specific metas
    ============================================ -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- Favicon
    ============================================ -->
    <link rel='shortcut icon' type='image/x-icon' href="{{asset('frontend/images/logo.png')}}"/>
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    
    <!-- Google web fonts
    ============================================ -->
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,400italic,300,300italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    @include('partial.frontend-styles')

            <!-- JS Libs
    ============================================ -->
    <script src="{{asset('frontend/js/modernizr.js')}}"></script>

    <!-- Old IE stylesheet
    ============================================ -->
    <!--[if lte IE 9]>
    <link rel="stylesheet" type="text/css" href="{{asset('frontend/css/oldie.css')}}">
    <![endif]-->
</head>

