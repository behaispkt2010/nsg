@extends('layouts.pdf.render')

@section('title')
    In phiếu chi
@stop

@section('content')
<div class="container">
    <div class="row">
        <!-- icon logo Lien -->
            <?php
                $image = "/images/logo_pnsg.png";
             ?>
            <div style="text-align: center;">
                <img src="{!! url('/') !!}/images/logo_pnsg.png" width="40%" style="margin-top:10px;" class=""> 
            </div>
            <br>
            <div style="text-align: center;">
                <label><strong>Website: </strong><span>www.nongsan.co - </span><strong>Email: </strong><span>sale@nongsantunhien.com</span></label><br><br>
                <label><strong>Công ty TNHH Nông Nghiệp NOSAGO</strong> - <span>MST: </span><strong>6001584687</strong></label>
            </div>
    </div>
    <div class="clear"></div>
    <br>
    <div class="row">
        <div class="tracking">
            <div class="col-md-12" style="color: #000;">
                <div class="col-md-12 col-sm-12 col-xs-12 text-center ">
                    <h3 class="uppercase" style="text-align: center;"><strong>Phiếu chi</strong></h3>
                    <label style="width: 100%;">
                        <span class="col-xs-4"></span>
                        <span class="col-xs-4 text-center">{!! \App\Util::getDateNowVN() !!}</span>
                        <span class="col-xs-4 right">Số: ........................ </span>
                    </label>
                    <br><br>
                    <div class="">
                        
                        <div class="col-xs-12 col-md-12 col-sm-12 text-left">
                            <p><strong>Họ và tên người nộp tiền:  </strong>  </p><br>
                            <p><strong>Địa chỉ: </strong></p><br>
                            <p><strong>Lý do chi: </strong></p><br>
                            <p><strong>Số tiền: </strong></p><br>
                            <p><strong>Bằng chữ: </strong></p><br>
                            <p><strong>Ghi chú: </strong></p><br>
                        </div>
                    </div>    
                    <div class="clearfix"></div>
            </div>
            <br>
            <div class="col-xs-12 col-md-12 col-sm-12 text-left">
                <span class="col-xs-12 right text-right">{!! \App\Util::getDateNowVN() !!}</span>
            </div>
            <div class="row">
                <div class="col-xs-3">
                    <h4 class="uppercase text-center bold">Người lập phiếu</h4>
                    <p class="text-center">(Ký và ghi rõ họ tên)</p>
                </div>
                <div class="col-xs-3">
                    <h4 class="uppercase text-center bold">Người nhận tiền</h4>
                    <p class="text-center">(Ký và ghi rõ họ tên)</p>
                </div>
                <div class="col-xs-3">
                    <h4 class="uppercase text-center bold">Giám đốc</h4>
                    <p class="text-center">(Ký và ghi rõ họ tên)</p>
                </div>
                <div class="col-xs-3">
                    <h4 class="uppercase text-center bold">Thủ quỹ</h4>
                    <p class="text-center">(Ký và ghi rõ họ tên)</p>
                </div>
            </div>
            <div class="row">
                <br><br><br>
            </div>
        </div>
    </div>
</div>
@stop