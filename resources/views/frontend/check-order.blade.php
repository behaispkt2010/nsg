@extends('layouts.frontend')
@section('title', 'check order')
@section('description','check order')
@section('add_styles')
    {{-- --}}
@endsection
@section('content')
        <!-- - - - - - - - - - - - - - Page Wrapper - - - - - - - - - - - - - - - - -->
<div class="page_wrapper col-md-12 col-sm-12">

    <div class="container col-md-12 col-sm-12">
        @if(!empty($order))
    <div class="row">

<h4 class="text-center">Đơn hàng {{\App\Util::OrderCode($order->id)}}</h4>
        <div class="tracking con-tracking" style="border-radius: 5px;">
            <div class="col-sm-12 col-xs-12 fix-padlr cl-center">
                <ul class="ul-date-car">
                    @foreach($orderStatus as $itemOrderStatus)
                    <li class="date-past @if($itemOrderStatus->id ==$order->status) active @endif">
                        <img src="{{url('/')}}{{$itemOrderStatus->image}}" class="icon-tracking" alt="" title="{{$itemOrderStatus->name}}">
                        <div class="clear"></div>
                            @if($itemOrderStatus->id ==$order->status)
                            <span>{{$order->updated_at->format('d-m-Y')}}</span>
                            <div class=" fix-status">{{$itemOrderStatus->name}}</div>
                            @endif
                    </li>
                        @endforeach
                </ul>
            </div>
            <div class="clear"></div>
            <div class="col-md-12 con-tracking ">
                <div class="col-sm-6 col-xs-12 fix-padlr">
                    {{--<p class="text-center"><i class="ic-tracking ic-xe"></i></p>--}}
                    <h4>Thông tin đặt hàng</h4>
                    <table class="table list-order table-curved product-list">
                        <tbody>
                        <?php $total = 0; ?>
                        @foreach($productOrder as $item)
                        <tr>
                            <th><img src="{{url('/')}}{{$item->image}}"
                                     class="img-responsive img-thumbnail"
                                     style="max-width: 50px;" alt=""></th>
                            <td><span class="name-product"><a href="">{{$item->name}} (#{{$item->id_product}})</a></span>
                            </td>
                            <td><span class="price-product">{{ number_format($item->price)  }} VNĐ</span></td>
                            <td><span class="sl">x {{$item->num}} </span></td>
                            <td><span class="total"> {{ number_format($item->price * $item->num)  }} VNĐ</span></td>
                        </tr>
                            <?php $total =  $total + ($item->price * $item->num); ?>
                        @endforeach

                        <tr>
                            <th></th>
                            <td>
                            </td>
                            <td></td>
                            <td>Tổng: </td>
                            <td><span class="total">  {{number_format($total)}} VNĐ</span></td>
                        </tr>

                        </tbody>
                    </table>
                    <div class="clear"></div>
                    <br>
                    <p class="row">
                        <div class="col-md-3">
                            Thanh toán:
                        </div>
                        <div class="col-md-8">
                            <p>@if($order->status_pay==0) Chưa thanh toán
                                @elseif($order->status_pay==1) Đã thanh toán
                                @elseif($order->status_pay==2) Đã đặt cọc
                                   @endif
                            </p>
                        </div>
                    </p>
                    <p class="row">
                        <div class="col-md-3">
                            Vận chuyển:
                        </div>
                        <div class="col-md-8">
                            <p>{{$order->type_driver}}</p>
                        </div>
                    </p>
                    <p class="row">
                        <div class="col-md-3">
                            Thông tin tài xế:
                        </div>
                        <div class="col-md-8">
                            <div>Tên: {{$order->name_driver}}</div>
                            <div>SĐT: {{$order->phone_driver}}</div>
                            <div>Biển số xe: {{$order->number_license_driver}}</div>
                        </div>
                    </p>

                    <p class="row">
                        <div class="col-md-3">
                            Ghi chú:
                        </div>
                        <div class="col-md-8">
                            <p class="note-order">{{$order->note}}</p>
                        </div>
                    </p>
                </div>
                <div class="col-sm-2 col-xs-12 fix-padlr cl-center">

                </div>
                <div class="col-sm-4 col-xs-12 fix-padlr">
                    {{--<p class="text-center"><i class="ic-tracking ic-co"></i></p>--}}
                    <h4>Thông tin nhận hàng</h4>
                    <p><i class="ic-tracking ic-nguoidung"></i> {{$customer->name}} </p>
                    <p><i class="ic-tracking ic-diadiem"></i> {{$customer->address}} </p>

                    <p><i class="ic-tracking ic-dienthoai"></i> {{$customer->phone_number}} </p>


                </div>

            </div>




        </div>
    </div>
            @else
            <h4>không tìm thấy đơn hàng</h4>
        @endif

</div>
    </div>
    @endsection