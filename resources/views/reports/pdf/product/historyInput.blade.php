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
                    <h3 class="uppercase" style="text-align: center;"><strong>Lịch sử nhập hàng ngày {{$date}}</strong></h3>
                    <!-- <label style="width: 100%;">
                        <span class="col-xs-4"></span>
                        <span class="col-xs-4 text-center">{!! \App\Util::getDateNowVN() !!}</span>
                        <span class="col-xs-4 right">Số: ........................ </span>
                    </label> -->
                    <br><br>
                    <div class="">
                        
                        <div class="col-xs-12 col-md-12 col-sm-12 text-left">
                            <table class="table table-striped table-hover ">
                                <thead>
                                <tr>
                                    <th>Thời gian</th>
                                    <th>Mã sản phẩm</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Số lượng nhập</th>
                                    <th>Số tiền nhập</th>
                                    <th>Tổng số tiền nhập</th>
                                    <th>Tên nhà cung cấp</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $total_price_in=0;
                                    $total_num=0;
                                ?>
                              @foreach($productUpdatePrice as $item)
                                <tr>
                                    <td>{{$item->created_at->format('h:i')}}</td>
                                    <td>#{{\App\Util::ProductCode($item->product_id)}}</td>
                                    <td>{{\App\Product::getNameById($item->product_id)}}</td>
                                    <td>{{$item->number}}</td>
                                    <td>{!! \App\Util::FormatMoney($item->price_in) !!}</td>
                                    <td>{!! \App\Util::FormatMoney($item->price_in * $item->number) !!}</td>
                                    <td>@if($item->supplier != "create"){{ $item->supplier }} @endif</td>
                                    
                                    <?php
                                    $total_num +=$item->number;
                                    $total_price_in = $total_price_in + ($item->price_in * $item->number);
                                    ?>
                                </tr>
                                    @endforeach
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>{{$total_num}}</td>
                                    <td></td>
                                    <td>{!! \App\Util::FormatMoney($total_price_in) !!}</td>
                                    <td></td>
                                    
                                </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>    
                    <div class="clearfix"></div>
            </div>
            <br>
            <div class="col-xs-12 col-md-12 col-sm-12 text-center">
                <span class="col-xs-12 center text-center">{!! \App\Util::getDateNowVN() !!}</span>
            </div>
            <div class="row center">
                <div class="col-xs-12 center">
                    <h4 class="uppercase text-center bold">Người lập phiếu</h4>
                    <p class="text-center">(Ký và ghi rõ họ tên)</p>
                </div>
                <!-- <div class="col-xs-3">
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
                </div> -->
            </div>
            <div class="row">
                <br><br><br>
            </div>
        </div>
    </div>
</div>
@stop