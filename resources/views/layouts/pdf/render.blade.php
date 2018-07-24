<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="csrf-token" content="{{ csrf_token() }}" />
		<meta name="" content="width=device-width, initial-scale=1">
		<title>@yield('title')</title>

		<!-- end-->
		@yield('components')
		<link rel="stylesheet" type="text/css" href="{{asset('css/pdf.css')}}">
		<!-- Bootstrap -->
    	<link href="{{asset('plugin/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
		<!-- /core JS files -->

		<!-- Page JS files -->

		@yield('page_javascript')
		<!-- /Page JS files -->
	</head>
	<style type="text/css">
		div,p,span,label,h1,h2,h3,h4,title,.text,td{
			font-family: ipag;
		}
		.radio,.checkbox{
  			font-family: sans-serif ;
		}
		.checked{
			font-family: DejaVu Sans, sans-serif ;
		}
		@media print {
		  	@page { margin: 0; }
		  	body { margin: 1.6cm; }
		  	.visible-print  { display: inherit !important; }
		}
	</style>
	<!-- jQuery -->
    <script src="{{asset('plugin/jquery/dist/jquery.min.js')}}"></script>
	<!-- Bootstrap -->
    <script src="{{asset('plugin/bootstrap/dist/js/bootstrap.min.js')}}"></script>
	<script type="text/javascript">
		function print_window(){
		  	window.print();
		  	setTimeout(function () { 
			    window.open('', '_self', '');
			    window.close();
			  }, 100);
		}
	</script>
	<body onload="print_window() ">
		<div class="">
			@yield('content')
		</div>
	</body>

</html>
