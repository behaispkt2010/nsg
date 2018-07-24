@extends('layouts.admin')
@section('title', 'Chia sẻ mã Referral Code')
@section('pageHeader','Chia sẻ mã Referral Code')
@section('detailHeader','Chia sẻ mã Referral Code')

@section('content')
    <div id="fb-root"></div>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#share_facebook').click(function (e) {
                e.preventDefault();
                FB.ui(
                {
                    method: 'feed',
                    name: 'Nhận thêm ưu đãi khi sử dụng dịch vụ',
                    link: '{{url("/")}}/resisterWareHouse?referral={{ $arrGetUser->myIntroCode }}&utm_source=facebook',
                    picture: '{{url("/")}}/frontend/images/nosago1.png',
                    description: 'Đăng ký Chủ kho với mã {{ $arrGetUser->myIntroCode }} để nhận được thêm ưu đãi khi đăng ký sử dụng các dịch vụ',
                });
            });
        });
    </script>
<div class="img-refferalcode" style="text-align: center; padding-top: 100px;">
    <img src="{{asset('/images/sharecodereferral.png')}}" alt="">
    <div class="link-id">
        <p id="txtReferralCode">@if (!empty($arrGetUser->myIntroCode)){{$arrGetUser->myIntroCode}} @endif</p>
    </div>
    <label for="" style="font-size: 18px; color: #000;" >
        <p style="margin: 3px;">Góp phần tạo nên mạng lưới nông sản rộng khắp Việt Nam</p>

        <p style="margin: 3px;">Hãy chia sẻ MÃ GIỚI THIỆU đến bạn bè, đối tác kinh doanh để cả hai cùng</p>

        <p style="margin: 3px;">nhận được những ưu đãi hấp dẫn nhé.</p>
    </label>
    <div class="social">
        <ul>
            <!-- <div class="fb-share-button" data-href="{{url('/')}}/resisterWareHouse?referral={{ $arrGetUser->myIntroCode }}" data-description="Đăng ký ngay tài khoản với mã"  data-layout="button" data-size="large" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fhasuko.xyz%2F&amp;src=sdkpreparse">Chia sẻ</a></div> -->
            <li class="facebook">
                <a id="share_facebook" href=""><img class="icon_facebook" src="{{ asset('/images/facebookicon.png') }}" alt=""></a>
            </li>
            <!-- <li class="google"></li>
            <li class="mail"></li> -->
        </ul>
    </div>
<!-- https://developers.facebook.com/docs/plugins/share-button -->
</div>
@endsection
@section('add_scripts')
    
    <script>
      window.fbAsyncInit = function() {
        FB.init({
          appId      : '755215574685946',
          cookie     : true,
          xfbml      : true,
          version    : 'v2.10'
        });
          
        FB.AppEvents.logPageView();   
          
      };

      (function(d, s, id){
         var js, fjs = d.getElementsByTagName(s)[0];
         if (d.getElementById(id)) {return;}
         js = d.createElement(s); js.id = id;
         js.src = "https://connect.facebook.net/en_US/sdk.js";
         fjs.parentNode.insertBefore(js, fjs);
       }(document, 'script', 'facebook-jssdk'));
    </script>

    <!-- <script>
        (function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.10&appId=755215574685946";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script> -->
    <!-- <script>
        $(document).ready(function() {
            $.ajaxSetup({ cache: true });
            $.getScript('//connect.facebook.net/en_US/sdk.js', function(){
                FB.init({
                    appId: '1891742487703866',
                    version: 'v2.7'
                });
                $('#loginbutton,#feedbutton').removeAttr('disabled');
                FB.getLoginStatus(updateStatusCallback);
            });
        });
    </script>
    
    <script>
        document.getElementById('share_facebook').onclick = function() {
            FB.ui({
                method: 'share',
                mobile_iframe: true,
                href: 'http://hasuko.xyz/',
            }, function(response){});
        }
    </script> -->
@endsection