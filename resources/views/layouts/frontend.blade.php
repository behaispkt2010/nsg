@include('partial.frontend-header')

<body class="front_page">
<!-- - - - - - - - - - - - - - Main Wrapper - - - - - - - - - - - - - - - - -->
<div class="body">
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.10&appId=1891742487703866";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
	<div class="wide_layout">
		@include('partial.frontend-menu')
		<div class="col-md-10 col-sm-10" style="padding: 0;">
			<div class="right_col" role="main">
				@yield('content')
			</div>
		</div>
	@include('partial.frontend-footer')
	</div><!--/ [layout]-->
{{--@include('partial.frontend-social_feeds')--}}
</div>
<!-- - - - - - - - - - - - - - End Main Wrapper - - - - - - - - - - - - - - - - -->
@include('partial.frontend-script')

</body>
</html>


