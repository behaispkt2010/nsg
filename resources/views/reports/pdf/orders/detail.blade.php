@extends('layouts.pdf.render')

@section('title')
	ORDERS DETAILS
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
                    <h3 class="uppercase" style="text-align: center;"><strong>HÓA ĐƠN BÁN HÀNG</strong></h3>
                    <br><br>
                    <div class="">
                        <div class="col-xs-6 col-md-6 col-sm-6 text-left">
                            <h4><strong>THÔNG TIN ĐƠN HÀNG</strong></h4>
                            <p><strong>Đơn hàng :</strong> {{ \App\Util::OrderCode($arrOrder->id) }}</p>
                            <p><strong>Khách hàng :</strong> @if(!empty($arrOrder->name)){{$arrOrder->name}}@endif</p> 
                            <p><strong>Ngày đặt hàng :</strong> @if(!empty($arrOrder->time_order)){{$arrOrder->time_order}}@endif </p>
                            <p><strong>Mã khách hàng:</strong> {{ \App\Util::UserCode($arrOrder->customer_id) }}</p>
                        </div>
                        <div class="col-xs-4 col-md-4 col-sm-4 text-left col-xs-offset-1">
                            <h4><strong>CỬA HÀNG TẠO</strong></h4>
                            <p><strong>Cửa hàng :</strong> {{ $arrWareHouse->name_company }} </p> 
                            <p><strong>Điện thoại:</strong> {{ $arrWareHouse->phone_number}} </p> 
                            <p><strong>Nhân viên :</strong> {{ $arrWareHouse->name }} </p> 
                            <p><strong>Địa chỉ:</strong> {{ $arrWareHouse->address }} </p>
                        </div>
                        <div class="col-xs-6 col-md-6 col-sm-6 text-left">
                            <h4><strong>THÔNG TIN GIAO HÀNG</strong></h4>
                            <p><strong>Người giao hàng:</strong> {{ $arrOrder->name_driver }} </p>
                            <p><strong>Điện thoại :</strong> {{ $arrOrder->phone_driver }} </p>
                            <p><strong>Địa chỉ giao hàng :</strong> {{ $arrOrder->address }} </p>
                            <p><strong>Phương thức giao hàng :</strong> {{ $arrOrder->type_driver }} </p>
                            <p><strong>Ghi chú :</strong> {{ $arrOrder->note }} </p>
                        </div>
                    </div>    
                    <div class="clearfix"></div>
                    
                    <table class="table list-order table-bordered ">
                        <tbody>
                            <th>Tên sản phẩm</th>
                            <th>Giá</th>
                            <th>Số Lượng</th>
                            <th>Tổng</th>
                            <?php $total = 0; ?>
                            @foreach($productOrder as $itemProductOrder)
                                <tr class="item-product">
                                    <td><span class="name-product"><span>{{$itemProductOrder->title}} ({{ \App\Util::ProductCode($itemProductOrder->id_product) }})</span></span></td>
                                    <td><span class="price-product"><span>{!! \App\Util::FormatMoney($itemProductOrder->price_out) !!}</span>  </span></td>
                                    <td><span>x </span>{{ $itemProductOrder->num }}</td>
                                    <td><span class="total"> <span>{!! \App\Util::FormatMoney(($itemProductOrder->price_out)*($itemProductOrder->num)) !!}</span> </span></td>
                                </tr>
                                <?php $total=$total + (($itemProductOrder->price_out)*($itemProductOrder->num)); ?>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="clear"></div>
                    <table class="table table-borderless totalCheckout">
                        <tbody>
                            <!-- <tr>
                                <td colspan="4" class="text-right bold">Thành tiền</td>
                                <td class="text-right">{!! \App\Util::FormatMoney($total)!!}</td>
                            </tr> -->
                            <!-- <tr>
                                <td colspan="4" class="text-right">Phí vận chuyển</td>
                                <td class="text-right">{!! \App\Util::FormatMoney($total)!!}</td>
                            </tr> -->
                            <!-- <tr>
                                <td colspan="4" class="text-right">Giảm giá </td>
                                <td class="text-right">{!! \App\Util::FormatMoney($total)!!}</td>
                            </tr> -->
                            <!-- <tr>
                                <td colspan="5" class="text-right">------------------</td>
                            </tr> -->
                            <tr>
                                <td colspan="4" class="text-right bold">Tổng tiền </td>
                                <td colspan="5" class="text-right"><span class="total">  {!! \App\Util::FormatMoney($total)!!} </span></td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-right bold">Tổng khách hàng đã trả </td>
                                <td colspan="5" class="text-right">
                                    <span class="total">  
                                        @if(($arrOrder->type_pay == 1)) {!! \App\Util::FormatMoney($total)!!} @elseif($arrOrder->type_pay == 2) @if(!empty($arrOrder->received_pay)) {!! \App\Util::FormatMoney($arrOrder->received_pay)!!} @endif @endif
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-right bold">Tổng khách hàng còn nợ </td>
                                <td colspan="5" class="text-right">
                                    <span class="total">
                                        @if($arrOrder->type_pay == 2) @if(!empty($arrOrder->remain_pay)) {!! \App\Util::FormatMoney($arrOrder->remain_pay)!!} @endif @endif
                                    </span
                                ></td>
                            </tr>
                            <tr>
                                <td colspan="5" class="text-right">------------------</td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-right bold">Tiền thu khi giao hàng </td>
                                <td colspan="5" class="text-right">...................</td>
                            </tr>
                        </tbody>
                    </table>
            </div>
            
            <!-- <div class=" row hidden-xs">
                <div class="col-md-12 details-tracking ">
                    <label class="title" style=" font-size: 16px; padding-left: 10px;">Chi tiết hành trình</label>
                    <div id="demo0" class="collapse in" style="padding-left: 20px;">
                        <div class="con-details-tracking">
            
                        @foreach($historyOrder as $itemHistoryOrder)
                            @if($itemHistoryOrder->status==0)
                                <div class="item">
                                    <label style="color: #000;"><span style="color: #000;">{{$itemHistoryOrder->updated_at->format('d-m-Y H:m:s')}}</span> -- <label style="width:180px; color: #000">Khởi tạo đơn hàng </label> -- Người cập nhật: {{ $itemHistoryOrder->username }} | ID: {{ \App\Util::UserCode($itemHistoryOrder->userid) }}</label>
                                </div>
                            @else
                                <div class="item">
                                    <label style="color: #000;"><span style="color: #000;">{{$itemHistoryOrder->updated_at->format('d-m-Y H:m:s')}}</span> -- <label style="width:180px; color: #000">{{$itemHistoryOrder->name}}</label> -- Người cập nhật: {{ $itemHistoryOrder->username }} | ID: {{ \App\Util::UserCode($itemHistoryOrder->userid) }}</label>
                                </div>
                            @endif
                        @endforeach
                        </div>
                    </div>
            
                </div>
            </div> -->
            <br>
            <p class="text-center">Chúng tôi biết Bạn có rất nhiều sự lựa chọn - Cảm ơn Bạn đã chọn chúng tôi.</p>
<p class="text-center">Chúng tôi luôn lắng nghe phản hồi của bạn về sản phẩm & dịch vụ qua email: info@nongsantunhien.com</p>
        </div>
    </div>
</div>
@stop