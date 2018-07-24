@extends('layouts.admin')
@section('title', 'Sổ quỹ')
@section('pageHeader','Sổ quỹ')
@section('detailHeader','Sổ quỹ')
@section('add_styles')
@endsection
@section('content')
    <div class="row">
        <br>
        <div class="col-md-12">
            <div class="">
                <div class="x_content">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-4 col-sm-4 col-xs-12 profile_details box-detail">
                            <div class="well box_1 " style="height: 280px">
                                <div class="col-sm-12 ">
                                    <span class="title-money pst-tootip" style="border-bottom: 1px solid #52b256;">Mới tạo
                                    <!-- ngIf: (transaction.currentTutorialID == 1) -->
                                    </span>
                                        <div class="content-money">
                                            <p style="color: #52b256;">{!!\App\Util::FormatMoney(\App\Order::getInfoOrder(0)['price'])!!} </p>
                                            <span class="">{{\App\Order::getInfoOrder(0)['count']}} đơn hàng</span>
                                        </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-4 col-xs-12 profile_details box-detail">
                            <div class="well box_1 " style="height: 280px">
                                <div class="col-sm-12 ">
                                    <span class="title-money pst-tootip" style="border-bottom: 1px solid #52b256;">Đơn hàng chưa giao
                                    <!-- ngIf: (transaction.currentTutorialID == 1) -->
                                    </span>
                                    <div class="content-money">
                                        <p style="color: #52b256;">{!!\App\Util::FormatMoney(\App\Order::getInfoOrder(8,1)['price'])!!} </p>
                                        <span class="">{{\App\Order::getInfoOrder(8,1)['count']}} đơn hàng</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-4 col-xs-12 profile_details box-detail">
                            <div class="well box_1 " style="height: 280px">
                                <div class="col-sm-12 ">
                                    <span class="title-money pst-tootip" style="border-bottom: 1px solid #52b256;">Đang vận chuyển
                                        <!-- ngIf: (transaction.currentTutorialID == 1) -->
                                    </span>
                                    <div class="content-money">
                                        <p style="color: #52b256;">{!!\App\Util::FormatMoney(\App\Order::getInfoOrder(7)['price'])!!} </p>
                                        <span class="">{{\App\Order::getInfoOrder(7)['count']}} đơn hàng</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-4 col-xs-12 profile_details box-detail">
                            <div class="well box_1 " style="height: 280px">
                                <div class="col-sm-12 ">
                                    <span class="title-money pst-tootip" style="border-bottom: 1px solid #52b256;">Đơn hàng đã giao
                                    <!-- ngIf: (transaction.currentTutorialID == 1) -->
                                    </span>
                                    <div class="content-money">
                                        <p style="color: #52b256;">{!!\App\Util::FormatMoney(\App\Order::getInfoOrder(8)['price'])!!} </p>
                                        <span class="">{{\App\Order::getInfoOrder(8)['count']}} đơn hàng</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-4 col-xs-12 profile_details box-detail">
                            <div class="well box_1 " style="height: 280px">
                                <div class="col-sm-12 ">
                                    <span class="title-money pst-tootip" style="border-bottom: 1px solid #52b256;">Đơn hàng đã hủy
                                    <!-- ngIf: (transaction.currentTutorialID == 1) -->
                                    </span>
                                    <div class="content-money">
                                        <p style="color: #52b256;">{!!\App\Util::FormatMoney(\App\Order::getInfoOrder(10)['price'])!!} </p>
                                        <span class="">{{\App\Order::getInfoOrder(10)['count']}} đơn hàng</span> {{--status Trả hàng mới tính--}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


