@extends('layouts.admin')
@section('title', 'dashboard')
@section('pageHeader','Thống kê')
@section('detailHeader','số đơn hàng, hàng tồn kho,...')
@section('content')

    <div class="row">
        <br>
        <div class="col-md-3 col-xs-6 col-ms-6 text-center">Đơn Hàng<br><span class="value-das">{{$numOrder}}</span></div>
        <div class="col-md-3 col-xs-6 col-ms-6 text-center">Doanh Thu<br><span class="value-das">{{$totalPrice}}</span></div>
        <div class="col-md-3 col-xs-6 col-ms-6 text-center">Lợi nhuận<br><span class="value-das">{{$profit}}</span></div>
        <div class="col-md-3 col-xs-6 col-ms-6 text-center">Số sản phẩm<br><span class="value-das">{{$numProduct}}</span></div>

    </div>
    <input type="hidden" name="_token" value="{{ csrf_token() }}">

    <div class="row">
        <br>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <div class="row">
                        <div class="col-md-4">
                    <h2>Doanh thu </h2>
                        </div>
                    <div class="col-md-8">
                        <div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                            <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                            <span id="date-filter1"></span> <b class="caret"></b>
                        </div>
                    </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <canvas id="lineChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <div class="row">
                        <div class="col-md-4">
                            <h2>Đơn hàng </h2>
                        </div>
                        <div class="col-md-8">
                            <div id="reportrange2" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                                <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                                <span id="date-filter2"></span> <b class="caret"></b>
                            </div>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <canvas id="mybarChart"></canvas>
                </div>
            </div>
        </div>
    </div>


    @endsection
    @section('add_scripts')
        <script>
            var lineLabels="";
            var lineDatas="";
            var barLabels="";
            var barDatas1="";
            var barDatas2="";


        </script>
        <script>
            $(document).ready(function() {

                var cb = function(start, end, label) {
                    console.log(start.toISOString(), end.toISOString(), label);
                    $('#reportrange2 span').html(start.format('DD-MM-YYYY') + ' -> ' + end.format('DD-MM-YYYY'));
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
                        monthNames: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 12', 'Tháng 12'],
                        firstDay: 1
                    }
                };
                $('#reportrange2 span').html(moment().subtract(6, 'days').format('DD-MM-YYYY') + ' -> ' + moment().format('DD-MM-YYYY'));
                $('#reportrange2').daterangepicker(optionSet1, cb);
                $('#reportrange2').on('show.daterangepicker', function() {
                    console.log("show event fired");
                });
                $('#reportrange2').on('hide.daterangepicker', function() {
                    console.log("hide event fired");
                });
                $('#reportrange2').on('apply.daterangepicker', function(ev, picker) {
                    console.log("apply event fired, start/end dates are " + picker.startDate.format('DD-MM-YYYY') + " to " + picker.endDate.format('DD-MM-YYYY'));
                });
                $('#reportrange2').on('cancel.daterangepicker', function(ev, picker) {
                    console.log("cancel event fired");
                });
                $('#options1').click(function() {
                    $('#reportrange2').data('daterangepicker').setOptions(optionSet1, cb);

                });
                $('#options2').click(function() {
                    $('#reportrange2').data('daterangepicker').setOptions(optionSet2, cb);

                });
                $('#destroy').click(function() {
                    $('#reportrange2').data('daterangepicker').remove();
                });

            });
        </script>
        <script>
            $(document).ready(function() {

                var cb = function(start, end, label) {
                    console.log(start.toISOString(), end.toISOString(), label);
                    $('#reportrange span#date-filter1').html(start.format('DD-MM-YYYY') + ' -> ' + end.format('DD-MM-YYYY'));
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
                $('#reportrange span#date-filter1').html(moment().subtract(6, 'days').format('DD-MM-YYYY') + ' -> ' + moment().format('DD-MM-YYYY'));
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
                var _token = $('input[name="_token"]').val();
                $('.loading').css('display','block');
                $.ajax({
                    type: "POST",
                    url: '{!! url("/") !!}/admin/getdashboard',
                    data: {data: data,_token: _token},
                    success: function( msg ) {
                        $('.loading').css('display','none');
                        lineLabels = msg['lineLabels'];
                        lineDatas = msg['lineDatas'];
                        barLabels = msg['barLabels'];
                        barDatas1 = msg['barDatas1'];
                        barDatas2 = msg['barDatas2'];
                        // Line chart
                        var ctx = document.getElementById("lineChart");
                        var lineChart = new Chart(ctx, {
                            responsive: true,
                            skipXLabels: 5,
                            type: 'line',
                            data: {
                                labels: lineLabels,
                                datasets: [{
                                    label: "Doanh Thu",
                                    backgroundColor: "rgba(76, 175, 80, 0.68)",
//                                  borderColor: "rgba(38, 185, 154, 0.7)",
                                    pointBorderColor: "rgba(38, 185, 154, 0.7)",
                                    pointBackgroundColor: "rgba(38, 185, 154, 0.7)",
                                    pointHoverBackgroundColor: "#fff",
                                    pointHoverBorderColor: "rgba(220,220,220,1)",
                                    pointBorderWidth: 1,
                                    data: lineDatas,
                                }]
                            },
                            options: {
                                scales: {
                                    xAxes: [{
                                        display: false
                                    }]
                                }

                            }
                        })// Bar chart

                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        $('.loading').css('display','none');

                    }
                });
            });
        </script>
        <script>
            $(document).on('DOMSubtreeModified','#date-filter2',function(){
                var data = $(this).text();
                var _token = $('input[name="_token"]').val();
                $('.loading').css('display','block');
                $.ajax({
                    type: "POST",
                    url: '{!! url("/") !!}/admin/getdashboard',
                    data: {data: data,_token: _token},
                    success: function( msg ) {
                        $('.loading').css('display','none');
                        lineLabels = msg['lineLabels'];
                        lineDatas = msg['lineDatas'];
                        barLabels = msg['barLabels'];
                        barDatas1 = msg['barDatas1'];
                        barDatas2 = msg['barDatas2'];

                        //graph options
                        var ctx = document.getElementById("mybarChart");
                        var mybarChart = new Chart(ctx, {

                            type: 'bar',
                            data: {
                                labels: barLabels,
                                datasets: [{
                                    label: 'Thành công',
                                    backgroundColor: "#4caf50",
                                    data: barDatas1
                                }, {
                                    label: 'Thất bại',
                                    backgroundColor: "#FF9800",
                                    data: barDatas2
                                }]
                            },

                            options: {
                                scales: {
                                    yAxes: [{
                                        ticks: {
                                            beginAtZero: true
                                        }
                                    }],
                                    xAxes: [{
                                        display: false
                                    }]
                                }

                            }

                        });

                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        $('.loading').css('display','none');

                    }
                });

            });
        </script>

            <!-- Chart.js -->
    <!-- Chart.js -->
    <script src="{{asset('plugin/Chart.js/dist/Chart.js')}}"></script>
    <!-- gauge.js -->
    <!-- Doughnut Chart -->
    <script>
        $(document).ready(function () {
            var options = {
                legend: false,
                responsive: false
            };

            new Chart(document.getElementById("canvas2"), {
                type: 'doughnut',
                tooltipFillColor: "rgba(51, 51, 51, 0.55)",
                data: {
                    labels: [
                        "Cấp 1",
                        "Cấp 2",
                        "Cấp 3",
                        "Cấp 4",
                        "Cấp 5"
                    ],
                    datasets: [{
                        data: [15, 20, 30, 10, 30],
                        backgroundColor: [
                            "#BDC3C7",
                            "#9B59B6",
                            "#E74C3C",
                            "#26B99A",
                            "#3498DB"
                        ],
                        hoverBackgroundColor: [
                            "#CFD4D8",
                            "#B370CF",
                            "#E95E4F",
                            "#36CAAB",
                            "#49A9EA"
                        ]
                    }]
                },
                options: options
            });
        });
    </script>
    <!-- /Doughnut Chart -->
    <script>




    </script>
    <!-- bootstrap-daterangepicker -->

@endsection