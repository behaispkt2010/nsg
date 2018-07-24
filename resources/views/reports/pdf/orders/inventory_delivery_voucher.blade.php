@extends('layouts.pdf.render')

@section('title')
	In phiếu xuất kho
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
                    <h3 class="uppercase" style="text-align: center;"><strong>Phiếu xuất kho</strong></h3>
                    <label style="width: 100%;">
                        <span class="col-xs-4"></span>
                        <span class="col-xs-4 text-center">{!! \App\Util::getDateNowVN() !!}</span>
                        <span class="col-xs-4 right">Số: ........................ </span>
                    </label>
                    <br><br>
                    <div class="">
                        
                        <div class="col-xs-12 col-md-12 col-sm-12 text-left">
                            <p><strong >Họ và tên người nhận:  </strong> {{ $arrOrder->name }} </p>
                            <p>
                                <label style="width: 50%;"><strong class="text-left">Địa chỉ: </strong><span>  {{ $arrOrder->address }}  </span></label>
                                <label class="center"><strong class="text-right">Điện thoại : </strong> <span> {{ $arrOrder->phone_number }} </span> </label>
                            </p>
                        </div>
                    </div>    
                    <div class="clearfix"></div>
                    
                    <table class="table list-order table-bordered ">
                        <tbody>
                            <th>STT</th>
                            <th>Tên sản phẩm</th>
                            <!-- <th>Đơn vị tính</th> -->
                            <th>Số Lượng</th>
                            <th>Đơn giá</th>
                            <th>Thành tiền</th>
                            <?php $total = 0; $i = 1; ?>

                            @foreach($productOrder as $itemProductOrder)
                                <tr class="item-product">
                                    <td>{{ $i }}</td>
                                    <td><span class="name-product"><span>{{ $itemProductOrder->name }}</span></span></td>
                                    <!-- <td><span>VNĐ</span></td> -->
                                    <td><span>x </span>{{ $itemProductOrder->num }}</td>
                                    <td><span class="price-product"><span>{!! \App\Util::FormatMoney($itemProductOrder->price_out) !!}</span></span></td>
                                    <td><span class="total">{!! \App\Util::FormatMoney(($itemProductOrder->price_out)*($itemProductOrder->num)) !!}</span></td>
                                </tr>
                                <?php $total = $total + (($itemProductOrder->price_out)*($itemProductOrder->num)); 
                                $i = $i++ ;
                                ?>
                            @endforeach
                            <tr>
                                <td></td>
                                <td>Tổng cộng</td>
                                <td colspan="4"> {!! \App\Util::FormatMoney($total) !!} </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="clear"></div>
                    
            </div>
           
            <br>
            <div class="col-xs-12 col-md-12 col-sm-12 text-left">
                <label>Tổng số tiền (Viết bằng chữ): @if(!empty($total)) {!! \App\Util::readMoneyVN($total) !!} @endif</label>
            </div>
            <div class="col-xs-12 col-md-12 col-sm-12 text-left">
                <span class="col-xs-12 right text-right">{!! \App\Util::getDateNowVN() !!}</span>
            </div>
            <div class="row">
                <div class="col-xs-4">
                    <h4 class="uppercase text-center bold">Người lập phiếu</h4>
                    <p class="text-center">(Ký và ghi rõ họ tên)</p>
                </div>
                <div class="col-xs-4">
                    <h4 class="uppercase text-center bold">Người nhận hàng</h4>
                    <p class="text-center">(Ký và ghi rõ họ tên)</p>
                </div>
                <div class="col-xs-4">
                    <h4 class="uppercase text-center bold">Giám đốc</h4>
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