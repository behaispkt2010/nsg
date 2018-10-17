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
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group label-floating">
                                <div class="row">
                                    <div class="col-md-4">
                                        <h2>Xem thông tin đơn hàng</h2>
                                    </div>
                                    <div class="col-md-8" style="float: left; font-size: 13px;">
                                        <div id="reportrange1" class="pull-left" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc;border-radius: 4px;">
                                            <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                                            <span id="date-filter2"></span> <b class="caret"></b>
                                        </div>
                                        <input type="hidden" name="dateview1" value="" id="dateview1" class="dateview1">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-4 col-sm-4 col-xs-12 profile_details box-detail">
                            <div class="well box_1 " style="height: 280px">
                                <div class="col-sm-12 ">
                                    <span class="title-money pst-tootip" style="border-bottom: 1px solid #52b256;">Mới tạo
                                    <!-- ngIf: (transaction.currentTutorialID == 1) -->
                                    </span>
                                    <div class="content-money">
                                        <p style="color: #52b256;">
                                            <span class="moneyNewOrder"></span>
                                            <span class="unit style_format">VNĐ</span>
                                        </p>
                                        <span class="countNewOrder"></span>
                                        <span class="">đơn hàng</span>
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
                                        <p style="color: #52b256;">
                                            <span class="moneyNotTransportOrder"></span>
                                            <span class="unit style_format">VNĐ</span>
                                        </p>
                                        <span class="countNotTransportOrder"></span>
                                        <span class="">đơn hàng</span>
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
                                        <p style="color: #52b256;">
                                            <span class="moneyTransportingOrder"></span>
                                            <span class="unit style_format">VNĐ</span>
                                        </p>
                                        <span class="countTransportingOrder"></span>
                                        <span class="">đơn hàng</span>
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
                                        <p style="color: #52b256;">
                                            <span class="moneyTransportedOrder"></span>
                                            <span class="unit style_format">VNĐ</span>
                                        </p>
                                        <span class="countTransportedOrder"></span>
                                        <span class="">đơn hàng</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12 profile_details box-detail">
                            <div class="well box_1 " style="height: 280px">
                                <div class="col-sm-12 ">
                                    <span class="title-money pst-tootip" style="border-bottom: 1px solid #52b256;">Đơn hàng đã hoàn thành
                                    </span>
                                    <div class="content-money">
                                        <p style="color: #52b256;">
                                            <span class="moneyFinishOrder"></span>
                                            <span class="unit style_format">VNĐ</span>
                                        </p>
                                        <span class="countFinishOrder"></span>
                                        <span class="">đơn hàng</span>
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
                                        <p style="color: #52b256;">
                                            <span class="moneyCancelOrder"></span>
                                            <span class="unit style_format">VNĐ</span>
                                        </p>
                                        <span class="countCancelOrder"></span>
                                        <span class="">đơn hàng</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-md-8 col-sm-12 col-xs-12 text-center">
                            <div class="">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group label-floating">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <h2>Xem thông tin thu chi</h2>
                                            </div>
                                            <div class="col-md-8" style="float: left; font-size: 13px;">
                                                <div id="reportrange" class="pull-left" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc;border-radius: 4px;">
                                                    <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                                                    <span id="date-filter1"></span> <b class="caret"></b>
                                                </div>
                                                <input type="hidden" name="dateview" value="" id="dateview" class="dateview">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-xs-12 profile_details box-detail">
                                        <div class="well box_1 " style="height: 280px">
                                            <div class="col-sm-12 ">
                                                <span class="title-money pst-tootip" style="border-bottom: 1px solid #52b256;">Tổng thu
                                                </span>
                                                    <div class="content-money">
                                                        <p style="color: #52b256;" ><span class="moneyReceipt"></span> <span class="unit style_format">VNĐ</span></p>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-sm-6 col-xs-12 profile_details box-detail">
                                        <div class="well box_1 " style="height: 280px">
                                            <div class="col-sm-12 ">
                                                <span class="title-money pst-tootip" style="border-bottom: 1px solid #52b256;">Tổng chi
                                                </span>
                                                <div class="content-money">
                                                    <p style="color: #52b256;"><span class="moneyPayment"></span> <span class="unit style_format">VNĐ</span></p>
                                                </div>
                                            </div>
                                        </div>
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

@section('add_scripts')
    <script>
        $(document).ready(function() {
            $('.moneyReceipt').number(true, 0);
            $('.moneyPayment').number(true, 0);
            var cb = function(start, end, label) {
                console.log(start.toISOString(), end.toISOString(), label);
                $('#reportrange span#date-filter1').html(start.format('DD-MM-YYYY') + ' > ' + end.format('DD-MM-YYYY'));
            };

            var optionSet1 = {
                startDate: moment().subtract(6, 'days'),
                endDate: moment(),
                minDate: '01/01/2012',
                maxDate: '12/31/2020',
                dateLimit: {
                    days: 90
                },
                showDropdowns: true,
                showWeekNumbers: true,
                timePicker: false,
                timePickerIncrement: 1,
                timePicker12Hour: true,
                ranges: {
                    'Hôm nay': [moment(), moment()],
                    '7 ngày': [moment().subtract(6, 'days'), moment()],
                    '30 ngày': [moment().subtract(29, 'days'), moment()],
                    '90 ngày': [moment().subtract(89, 'days'), moment()],
                },
                opens: 'left',
                buttonClasses: ['btn btn-default btn-xs btn-raised'],
                applyClass: 'btn-small btn-primary ',
                cancelClass: 'btn-small',
                format: 'DD/MM/YYYY',
                separator: ' to ',
                locale: {
                    applyLabel: 'Lọc dữ liệu',
                    cancelLabel: 'Xóa',
                    fromLabel: 'Từ ngày',
                    toLabel: 'Đến ngày',
                    customRangeLabel: 'chọn bất kỳ',
                    daysOfWeek: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'],
                    monthNames: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
                    firstDay: 1
                }
            };
            $('#reportrange span#date-filter1').html(moment().subtract(6, 'days').format('DD-MM-YYYY') + ' > ' + moment().format('DD-MM-YYYY'));
            $('#reportrange').daterangepicker(optionSet1, cb);
            $('#reportrange').on('show.daterangepicker', function() {
                console.log("show event fired");
            });
            $('#reportrange').on('hide.daterangepicker', function() {
                console.log("hide event fired");
            });
            $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
                console.log("apply event fired, start/end dates are " + picker.startDate.format('DD-MM-YYYY') + " to " + picker.endDate.format('DD-MM-YYYY'));
            });
            $('#reportrange').on('cancel.daterangepicker', function(ev, picker) {
                console.log("cancel event fired");
            });
            $('#options1').click(function() {
                $('#reportrange').data('daterangepicker').setOptions(optionSet1, cb);

            });
            $('#options2').click(function() {
                $('#reportrange').data('daterangepicker').setOptions(optionSet2, cb);

            });
            $('#destroy').click(function() {
                $('#reportrange').data('daterangepicker').remove();
            });

        });
    </script>
    <script>
        $(document).on('DOMSubtreeModified','#date-filter1',function(){
            var data = $(this).text();
            // console.log(data);
            var _token = $('input[name="_token"]').val();
            $('.loading').css('display','block');
            $.ajax({
                type: "POST",
                url: '{!! url("/") !!}/admin/payment/getTotalPayment',
                data: {data: data,_token: _token},
                success: function( msg ) {
                    $('.loading').css('display','none');
                    console.log((msg['payment']));
                    $('.moneyPayment').html(msg['payment'][0]['price']);
                    $('.moneyReceipt').html(msg['receipt'][0]['price']);
                    $('.moneyReceipt').number(true, 0);
                    $('.moneyPayment').number(true, 0);
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    $('.loading').css('display','none');
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.moneyReceipt').number(true, 0);
            $('.moneyPayment').number(true, 0);
            var cb = function(start, end, label) {
                console.log(start.toISOString(), end.toISOString(), label);
                $('#reportrange1 span#date-filter2').html(start.format('DD-MM-YYYY') + ' > ' + end.format('DD-MM-YYYY'));
            };

            var optionSet1 = {
                startDate: moment().subtract(6, 'days'),
                endDate: moment(),
                minDate: '01/01/2012',
                maxDate: '12/31/2020',
                dateLimit: {
                    days: 90
                },
                showDropdowns: true,
                showWeekNumbers: true,
                timePicker: false,
                timePickerIncrement: 1,
                timePicker12Hour: true,
                ranges: {
                    'Hôm nay': [moment(), moment()],
                    '7 ngày': [moment().subtract(6, 'days'), moment()],
                    '30 ngày': [moment().subtract(29, 'days'), moment()],
                    '90 ngày': [moment().subtract(89, 'days'), moment()],
                },
                opens: 'left',
                buttonClasses: ['btn btn-default btn-xs btn-raised'],
                applyClass: 'btn-small btn-primary ',
                cancelClass: 'btn-small',
                format: 'DD/MM/YYYY',
                separator: ' to ',
                locale: {
                    applyLabel: 'Lọc dữ liệu',
                    cancelLabel: 'Xóa',
                    fromLabel: 'Từ ngày',
                    toLabel: 'Đến ngày',
                    customRangeLabel: 'chọn bất kỳ',
                    daysOfWeek: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'],
                    monthNames: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
                    firstDay: 1
                }
            };
            $('#reportrange1 span#date-filter2').html(moment().subtract(6, 'days').format('DD-MM-YYYY') + ' > ' + moment().format('DD-MM-YYYY'));
            $('#reportrange1').daterangepicker(optionSet1, cb);
            $('#reportrange1').on('show.daterangepicker', function() {
                console.log("show event fired");
            });
            $('#reportrange1').on('hide.daterangepicker', function() {
                console.log("hide event fired");
            });
            $('#reportrange1').on('apply.daterangepicker', function(ev, picker) {
                console.log("apply event fired, start/end dates are " + picker.startDate.format('DD-MM-YYYY') + " to " + picker.endDate.format('DD-MM-YYYY'));
            });
            $('#reportrange1').on('cancel.daterangepicker', function(ev, picker) {
                console.log("cancel event fired");
            });
            $('#options1').click(function() {
                $('#reportrange1').data('daterangepicker').setOptions(optionSet1, cb);

            });
            $('#options2').click(function() {
                $('#reportrange1').data('daterangepicker').setOptions(optionSet2, cb);

            });
            $('#destroy').click(function() {
                $('#reportrange1').data('daterangepicker').remove();
            });
        });
    </script>
    <script>
        $(document).on('DOMSubtreeModified','#date-filter2',function(){
            var data1 = $(this).text();
            var _token = $('input[name="_token"]').val();
            $('.loading').css('display','block');
            $.ajax({
                type: "POST",
                url: '{!! url("/") !!}/admin/payment/getMoneyOrderByDate',
                data: {data1: data1,_token: _token},
                success: function( msg ) {
                    // console.log(msg);
                    $('.loading').css('display','none');
                    $('.moneyNewOrder').html(msg['arrTotalPrice'][0]);
                    $('.countNewOrder').html(msg['arrOrders'][0]);
                    $('.moneyNotTransportOrder').html(msg['arrTotalPrice'][1]);
                    $('.countNotTransportOrderOrder').html(msg['arrOrders'][1]);
                    $('.moneyTransportingOrder').html(msg['arrTotalPrice'][2]);
                    $('.countTransportingOrder').html(msg['arrOrders'][2]);
                    $('.moneyTransportedOrder').html(msg['arrTotalPrice'][3]);
                    $('.countTransportedOrder').html(msg['arrOrders'][3]);
                    $('.moneyFinishOrder').html(msg['arrTotalPrice'][4]);
                    $('.countFinishOrder').html(msg['arrOrders'][4]);
                    $('.moneyCancelOrder').html(msg['arrTotalPrice'][5]);
                    $('.countCancelOrder').html(msg['arrOrders'][5]);

                    $('.moneyNewOrder').number(true, 0);
                    $('.moneyNotTransportOrder').number(true, 0);
                    $('.moneyTransportingOrder').number(true, 0);
                    $('.moneyTransportedOrder').number(true, 0);
                    $('.moneyFinishOrder').number(true, 0);
                    $('.moneyCancelOrder').number(true, 0);
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    $('.loading').css('display','none');
                }
            });
        });
    </script>
@endsection