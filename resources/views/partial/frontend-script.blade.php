	<!-- - - - - - - - - - - - - - End Social feeds - - - - - - - - - - - - - - - - -->

		<!-- Include Libs & Plugins
		============================================ -->
		<script src="{{asset('frontend/js/jquery-2.1.1.min.js')}}"></script>
		

		<script src="{{asset('frontend/js/queryloader2.min.js')}}"></script>
		<script src="{{asset('frontend/js/layerslider/js/greensock.js')}}"></script>
		<script src="{{asset('frontend/js/layerslider/js/layerslider.transitions.js')}}"></script>
		<script src="{{asset('frontend/js/layerslider/js/layerslider.kreaturamedia.jquery.js')}}"></script>
		<script src="{{asset('frontend/js/jquery.appear.js')}}"></script>
		<script src="{{asset('frontend/js/owlcarousel/owl.carousel.min.js')}}"></script>
		<script src="{{asset('frontend/js/jquery.countdown.plugin.min.js')}}"></script>
		<script src="{{asset('frontend/js/jquery.countdown.min.js')}}"></script>
		<script src="{{asset('frontend/js/arcticmodal/jquery.arcticmodal.js')}}"></script>
		<script src="{{asset('frontend/twitter/jquery.tweet.min.js')}}"></script>
		<script src="{{asset('frontend/js/bootstrap.min.js')}}"></script>
		<script src="{{asset('plugin/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js')}}"></script>

		<!-- <script src="js/colorpicker/colorpicker.js"></script> -->
		<!-- <script src="js/retina.min.js"></script> -->
		<!-- <script type="text/javascript" src="http://s7.addthis.com/js/300/addthis_widget.js"></script> -->

		<!-- Theme files
		============================================ -->
		<script src="{{asset('frontend/js/theme.plugins.js')}}"></script>
		<script src="{{asset('frontend/js/theme.core.js')}}"></script>

		<!-- Bootstrap Material Design -->
		<script  src="{{asset('js/material.js')}}"></script>
		<script  src="{{asset('js/ripples.js')}}"></script>
		<script src="{{asset('js/selectize.js')}}"></script>

@yield('add-script')
<script>
	$(document).on('ready',function(){
		var url      = window.location.pathname;
		// alert(url);

		$('.main_navigation ul li a[href ="'+url+'"]').closest('li').addClass('current');
	})

</script>
<script>
    $(function () {
        $.material.init();

    });
</script>
	<script>
		$(document).on('click','.categories_list li a',function(){

				$(this).closest('.dropdown').removeClass("active visible");
				$(this).closest('.open_categories').removeClass("active");
				var slabel = $(this).text();
								var sval = $(this).parent().attr('data-id');

				$('input[name="cateSearch"]').val(sval);
				$('.open_categories').text(slabel);



		});
		</script>
		<script>(function (d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s);
			js.id = id;
			js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.5&appId=916823978398914";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));</script>
		<script>
		// when DOM is ready
$(document).ready(function () {

     // Attach Button click event listener
    $(".check-order ").click(function(e){
		e.preventDefault()
         // show Modal
         $('#modalCheckOrder').modal('show');
    });
    $('.btnSendRequest').on('click', function() {
    	var dichvu = $('.dichvu').val();
    	var name_user = $('.name_user').val();
    	var phone_user = $('.phone_user').val();
    	$.get("/nhan-ho-tro", { dichvu: dichvu, name_user: name_user, phone_user: phone_user })
    	 .done( function(data){
			alert('Chúng tôi đã nhận được thông tin từ quý khách, chúng tôi sẽ liên lạc với quý khách để giải đáp thắc mắc của quý khách !!!');
		});
    });
});
</script>
<script>
	$(document).on('click', '.required_login', function(e){
		e.preventDefault();
		$('#required_login').modal({ backdrop: 'static', keyboard: false });
	});
	$(document).on('click', '.login_xs', function(e){
		e.preventDefault();
		$('#login_xs').modal({ backdrop: 'static', keyboard: false });
	});
</script>
<script>
    $('#select-province, #select-category, #select-levelkho, #select-dichvu').selectize({});
</script>