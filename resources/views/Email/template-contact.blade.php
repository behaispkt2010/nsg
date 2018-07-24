<!doctype html>
<html>
<head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Simple Transactional Email</title>

</head>
<body class="">
<table border="0" cellpadding="0" cellspacing="0" class="body">
    <tr>
        <td>&nbsp;</td>
        <td class="container">
            <div class="content">

                <!-- START CENTERED WHITE CONTAINER -->
                <table class="main">

                    <!-- START MAIN CONTENT AREA -->
                    <tr>
                        <td class="wrapper">
                            <table border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
                                        <h3>Thông tin khách hàng cần tư vấn</h3>
                                    <div> <span>Tên: </span>{{$name}}</div>
                                    <div> <span>Email: </span>{{$email}}</div>
                                    <div><span>Số điện thoại: </span> {{$phone}}</div>
                                    <div><span>Yêu cầu: </span> {{$comment}}</div>
                                    <div><span>Mã giới thiệu: </span> {{$refferalcode}}</div>
                                    {{--<div> <span>Link sản phẩm:</span><a href="{{$link}}">link</a></div>--}}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- END MAIN CONTENT AREA -->
                </table>
                <hr>
                <!-- START FOOTER -->
                <div class="footer">

                    <table border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td class="content-block">
                                <p class="apple-link">Km35 Quốc lộ 26, huyện Krông Păk, tỉnh Dăk Lăk|</p>
                            </td>
                            <td class="content-block">
                                <p class="apple-link">0944 619 493|</p>
                            </td>
                            <td class="content-block">
                                <p class="apple-link">sale@nongsantunhien.com</p>
                            </td>
                        </tr>

                    </table>
                </div>

                <!-- END FOOTER -->

                <!-- END CENTERED WHITE CONTAINER --></div>
        </td>
        <td>&nbsp;</td>
    </tr>
</table>
</body>
</html>