<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNavLandingpage">
  <div class="container">
    <div class="logo">
        <a href="{{url('/')}}">
            <img src="{{asset('frontend/images/nosago1.png')}}" class="img_logo_front">
        </a> 
    </div>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav ml-auto menu_landingpage">
        <li class="nav-item">
          <a class="nav-link js-scroll-trigger" href="#gioithieu">Giới thiệu</a>
        </li>
        <li class="nav-item">
          <a class="nav-link js-scroll-trigger" href="#tinhnang">Tính năng</a>
        </li>
        <li class="nav-item">
          <a class="nav-link js-scroll-trigger" href="#doitac">Đối tác</a>
        </li>
        <li class="nav-item">
          <a class="nav-link js-scroll-trigger" href="#capkho">Cấp kho</a>
        </li>
        <li class="nav-item">
          <a class="nav-link js-scroll-trigger" href="#dichvu">Dịch vụ</a>
        </li>
        <li class="nav-item">
          <a class="" href="{{ url('/register') }}">Đăng ký</a>
        </li>
      </ul>
    </div>
  </div>
</nav>