@extends('layouts.admin')
@section('title', 'Quản lý đơn hàng')
@section('pageHeader','Quản lý đơn hàng')
@section('detailHeader','danh sách')
@section('new-btn')
    <!-- <a href="{{route('orders.create')}}" class="btn btn-warning btn-fab" title="Tạo mới đơn hàng">
        <i class="fa fa-paper-plane material-icons new-btn" aria-hidden="true"></i>
    </a>
    <a href="{!! url('/') !!}/report/orders" target="_blank" class="btn btn-warning btn-fab" title="Danh sách đơn hàng">
        <i class="fa fa-print material-icons print-btn" aria-hidden="true"></i>
    </a> -->
    
    <div class="hover-new-btn h-hover">
        <div class="h-report">
            <a href="{!! url('/') !!}/report/export/orders?q=@if(!empty($_REQUEST['q'])){{$_REQUEST['q']}} @endif" target="_blank" class="btn btn-warning btn-fab" title="Xuất excel đơn hàng">
                <i class="material-icons">archive</i>
            </a>
        </div>
        <div class="h-help">
            <a href="{{ url('/tro-giup') }}" target="_blank" class="btn btn-warning btn-fab" title="Thông tin trợ giúp">
                <i class="material-icons">help</i>
            </a>
        </div>
        <div class="h-plus">
            <a href="{{route('orders.create')}}" class="btn btn-warning btn-fab" title="Tạo mới đơn hàng">
                <i class="material-icons iconPlus">add</i>
                <i class="fa fa-paper-plane material-icons new-btn iconCreate hidden-hover" aria-hidden="true"></i>
            </a>
        </div>
    </div>
    
@endsection
@section('content')
    <div class="row top-right">

        <div class="x_panel">
            <div class="x_content">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 text-center hidden-xs">
                        <ul class="tab-fill">
                            <li class="show-menu @if($select == 99 )  active @endif"><a href="{!! url('/') !!}/admin/orders">Tất cả</a><span
                                        style="background-color: #9C27B0"
                                        class="ng-binding">{{$allOrders}}</span></li>
                            <li class="show-menu li-0 @if($select == 0 )  active @endif"><a href="{!! url('/') !!}/admin/orders/getOrderByStatus/0">Mới tạo</a><span
                                        style="background-color: #8bc34a"
                                        class="ng-binding">{{\App\ProductOrder::countOrderByStatus(0)}}</span></li>
                            @foreach($arrOrderByStatus as $item)
                            <li class="show-menu li-{{$item->id}} @if($select == $item->id )  active @endif"><a href="{!! url('/') !!}/admin/orders/getOrderByStatus/{{$item->id}}">{{$item->name}}</a><span
                                        style="background-color:{{$item->color}}"
                                        class="ng-binding">{{\App\ProductOrder::countOrderByStatus($item->id)}}</span></li>
                            @endforeach
                            <li class="show-menu other-item-button pst-tootip" style="">
                                Trạng thái khác
                                <span class="glyphicon glyphicon-menu-down"></span>
                                <!-- ngIf: (orderByStatus.currentTutorialID == 4) -->
                                <div class="other-item-list">
                                    <ul>
                                        @foreach($arrOrderByStatus as $item)
                                            <li class="show-menu li-{{$item->id}} @if($select == $item->id )  active @endif" style="display: none" >
                                                <a href="{!! url('/') !!}/admin/orders/getOrderByStatus/{{$item->id}}">{{$item->name}}</a>
                                                <span style="background-color:{{$item->color}}"class="ng-binding">{{\App\ProductOrder::countOrderByStatus($item->id)}}
                                                </span>
                                            </li>
                                        @endforeach                                                                                 {{--class="ng-binding">{!! $arrCountOrderByStatus[3] !!}</span></li>--}}
                                    </ul>
                                </div>
                            </li>
                        </ul>

                    </div>
                    <div class="col-xs-12 tab-fill visible-xs">
                        <select name="" class="form-control" id="select-status">
                            <option value="{!! url('/') !!}/admin/orders" @if($select == 99 )  selected @endif>Tất cả ({{$allOrders}})</option>
                            <option  value="{!! url('/') !!}/admin/orders/getOrderByStatus/0" @if($select == 0 )  selected @endif>Mới tạo ({{\App\ProductOrder::countOrderByStatus(0)}})</option>
                            @foreach($arrOrderByStatus as $item)
                                <option class="li-{{$item->id}}" @if($select == $item->id )  selected @endif value="{!! url('/') !!}/admin/orders/getOrderByStatus/{{$item->id}}">{{$item->name}} ({{\App\ProductOrder::countOrderByStatus($item->id)}})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="clearfix"></div>
                <form action="" method="GET">
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3 col-sm-12 col-xs-12">
                            <div class="form-group label-floating">

                                <label class="control-label" for="addon2">Số điện thoại | Tên khách hàng</label>

                                <div class="input-group text-center">
                                    <input type="text" id="addon2" class="form-control" name="q" value="{{Request::get('q')}}">
                                    <span class="input-group-btn">
                                        <button type="submit" class="btn btn-fab btn-fab-mini">
                                            <i class="material-icons">search</i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
    <div class="row">

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="">
                <div class="x_content">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 text-center">

                        </div>

                        <div class="clearfix"></div>
                    @if(count($arrAllOrders) != 0)
                        @foreach($arrAllOrders as $arrOrders)
                            <?php
                            $priceTotal = 0;
                            ?>
                            <div class="col-md-4 col-sm-4 col-xs-12 profile_details profile_details_mobile">
                                <div class="well box_1">
                                    <div class="box-status"
                                         style="background-color: @if($arrOrders->status==0) #8bc34a @else @foreach($arrOrderByStatus as $itemOrderStatus) @if(@$arrOrders->status==$itemOrderStatus->id) {{ $itemOrderStatus->color }} @endif @endforeach @endif ;">
                                        <p class="text-center status-title">@if($arrOrders->status==0) Mới tạo @else @foreach($arrOrderByStatus as $itemOrderStatus) @if(@$arrOrders->status==$itemOrderStatus->id) {{ $itemOrderStatus->name }} @endif @endforeach @endif</p>
                                    </div>
                                    <div class="col-sm-12 col-xs-12" data-toggle="modal" data-target=".modal-tracking" href="{{route('orders.show',['id' => $arrOrders->id])}}">
                                        <h4 class="cod" style="padding-left: 10px;">{{\App\Util::OrderCode( $arrOrders->id)}}</h4>

                                        <div class="col-xs-12" >
                                            <ul class="list-unstyled">
                                                <li class="limitcharacter"><i class="fa fa-user "></i> {{ $arrOrders->name }} </li>
                                                <li class="limitcharacter"><i class="fa fa-building "></i>
                                                    <span class="">{{ $arrOrders->address }}</span>
                                                </li>
                                                <li class="limitcharacter"><i class="fa fa-phone"></i> {{$arrOrders->phone_number }}</li>
                                                <li class="limitcharacter"><i class="fa fa-usd"></i> <span class="box-money">{!! \App\Util::FormatMoney(\App\ProductOrder::getSumOrder($arrOrders->id)) !!} </span></li>
                                                <li class="limitcharacter"><i class="fa fa-database"></i> Thuộc Chủ Kho {{\App\Util::UserCode($arrOrders->kho_id)}}
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 text-center">
                                        <button type="button" class="btn btn-raised btn-success btn-xs" data-toggle="modal"
                                                data-target=".modal-tracking" href="{{route('orders.show',['id' => $arrOrders->id])}}">
                                            <i class="fa fa-eye" aria-hidden="true"></i> Xem chi tiết
                                        </button>
                                        <a href="{{route('orders.edit',['id' => $arrOrders->id])}}" class="btn btn-raised btn-primary btn-xs">
                                            <i class="fa fa-pencil" aria-hidden="true"></i> Chỉnh sửa
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="clearfix"></div>
                        <div class="text-center">
                            {{ $arrAllOrders->appends(array('q' => Request::get('q')))->links() }}
                        </div>
                        @else
                            <div>Không tìm thấy dữ liệu</div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--modal--}}
    <div class="modal fade modal-tracking" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false"
         data-backdrop="static">
        <div class="modal-dialog modal-tracking">
            <div class="modal-content">

            </div>
        </div>
    </div>

    @endsection

    @section('add_scripts')

            <!-- Datatables -->
    <script src="{{asset('js/selectize.js')}}"></script>        
    <script>
        $('#select-status').selectize({
            //create: true,
            //sortField: 'text'
        });
    </script>
<script type="text/javascript">

    $(document).ready(function () {
        updateContainer();
    });

    $(document).on('change','#select-status',function(){
        // similar behavior as clicking on a link
        var href = $('#select-status').val();
        window.location.href = href;
    });
    // provide a resizeend event
//    var timer = window.setTimeout(function() {}, 0);
    var rtime;
    var timeout = false;
    var delta = 200;
    $(window).resize(function() {
        rtime = new Date();
        if (timeout === false) {
            timeout = true;
            setTimeout(resizeend, delta);
        }
    });

    function resizeend() {
        if (new Date() - rtime < delta) {
            setTimeout(resizeend, delta);
        } else {
            timeout = false;
            updateContainer();
        }
    }
    function updateContainer() {
        var width = $('.right_col').width();
        var y=0;
        if (width >= 896) {

           y=4;
        }
        else if (width > 700) {
            y=3;
        }
        else if (width > 670) {
            y=1;
        }
        $('.tab-fill .show-menu').css('display','inline-block');
        $('.show-menu.other-item-button.pst-tootip .show-menu').css('display','none');

        for(var i=10;i>y;i--){
            $('.tab-fill .show-menu.li-'+i).css('display','none');
            $('.show-menu.other-item-button.pst-tootip .show-menu.li-'+i).css('display','block');

        }
//        alert(width);
    }
</script>


@endsection

