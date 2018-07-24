@extends('layouts.admin')
@section('title', 'dashboard')
@section('pageHeader','Thống kê')
@section('detailHeader','số đơn hàng, hàng tồn kho,...')
@section('content')

    <div class="row">
        <br>
        <div class="col-md-3 col-xs-6 col-ms-6  text-center">Đơn Hàng<br><span class="value-das">{!! $countOrder !!}</span></div>
        <div class="col-md-3 col-xs-6 col-ms-6 text-center">Giao Dịch<br><span class="value-das">{!! \App\Util::FormatMoney($totalPrice)  !!} </span></div>
        <div class="col-md-3 col-xs-6 col-ms-6 text-center">NCC<br><span class="value-das">{!! $chukho !!}</span></div>
        <div class="col-md-3 col-xs-6 col-ms-6 text-center">TB Đơn Hàng<br><span class="value-das">@if(!empty($countOrderFinish)){!! \App\Util::FormatMoney($totalPrice/$countOrderFinish) !!}  @else 0 VNĐ @endif</span></div>

    </div>
    <div class="row">
        <br>
        <div class="col-md-3 col-xs-6 col-ms-6  text-center">Đối tác<br><span class="value-das">{!! $company !!}</span></div>
        <div class="col-md-3 col-xs-6 col-ms-6 text-center">User<br><span class="value-das">{!! $customer !!} </span></div>
        <div class="col-md-3 col-xs-6 col-ms-6 text-center">Nhân viên<br><span class="value-das">{!! $staff !!}</span></div>
        <div class="col-md-3 col-xs-6 col-ms-6 text-center">Tài xế<br><span class="value-das">{{ $driver }}</span></div>

    </div>
    <div class="row">
        <br>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Doanh thu </h2>

                    <div class="col-md-8" style="float: right; font-size: 13px;">
                        <div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc;border-radius: 4px;">
                            <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                            <span id="date-filter1"></span> <b class="caret"></b>
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
                    <h2>Số đơn hàng </h2>
                    <div class="col-md-8" style="float: right; font-size: 13px;">
                        <div id="reportrange2" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc;border-radius: 4px;">
                            <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                            <span id="date-filter2"></span> <b class="caret"></b>
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
    <div class="row">
        <div class="col-md-6 col-sm-6 col-xs-12">

            <div class="x_panel fixed_height_320">
                <div class="x_title">
                    <h2>Gói dịch vụ
                    </h2>

                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <table class="" style="width:100%">

                        <tbody>
                        <tr>
                            <td><iframe class="chartjs-hidden-iframe" style="width: 100%; display: block; border: 0px; height: 0px; margin: 0px; position: absolute; left: 0px; right: 0px; top: 0px; bottom: 0px;"></iframe>
                                <canvas id="canvas2" height="120" width="120" style="margin: 15px 10px 10px 0px; width: 120px; height: 120px;"></canvas>
                            </td>
                            <td><iframe class="chartjs-hidden-iframe" style="width: 100%; display: block; border: 0px; height: 0px; margin: 0px; position: absolute; left: 0px; right: 0px; top: 0px; bottom: 0px;"></iframe>
                                <canvas id="canvas3" height="120" width="120" style="margin: 15px 10px 10px 0px; width: 120px; height: 120px;"></canvas>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <table class="tile_info">
                                    <tbody><tr>
                                        <td>
                                            <p><i class="fa fa-square blue"></i>Cấp 1 </p>
                                        </td>

                                    </tr>
                                    <tr>
                                        <td>
                                            <p><i class="fa fa-square green"></i>Cấp 2 </p>
                                        </td>

                                    </tr>
                                    <tr>
                                        <td>
                                            <p><i class="fa fa-square purple"></i>Cấp 3 </p>
                                        </td>

                                    </tr>
                                    </tbody></table>
                            </td>
                            <td>
                                <table class="tile_info">
                                    <tbody><tr>
                                        <td>
                                            <p><i class="fa fa-square" style="color:#009688;"></i>Trả phí</p>
                                        </td>

                                    </tr>
                                    <tr>
                                        <td>
                                            <p><i class="fa fa-square" style="color: #CDDC39"></i>Dùng thử</p>
                                        </td>
                                    </tr>
                                    </tbody></table>
                            </td>
                        </tr>
                        <input type="hidden" value="{!! $level1 !!}" name="level1">
                        <input type="hidden" value="{!! $level2 !!}" name="level2">
                        <input type="hidden" value="{!! $level3 !!}" name="level3">
                        <input type="hidden" value="{!! $traphi !!}" name="traphi">
                        <input type="hidden" value="{!! $dungthu !!}" name="dungthu">
                        </tbody></table>

                </div>
            </div>
        </div>

        <div class="col-md-6 col-sm-6 col-xs-12">

            <div class="x_panel fixed_height_320">
                <div>
                    <div class="x_title">
                        <h2> Top 3 Sản phẩm bán chạy</h2>

                        <div class="clearfix"></div>
                    </div>
                    <ul class="list-unstyled top_profiles scroll-view">

                        @foreach($arrBestSellProduct as $BestSell)
                            <li class="media event">
                                <a class="pull-left border-aero profile_thumb">
                                    <img src="{{url('/').$BestSell->image}}" alt="" class="img-responsive" style="border-radius: 5px;">
                                </a>
                                <div class="media-body" style="font-weight: 700;">
                                    <a class="title" style="font-weight: 100; font-size: 17px;" href="#">{!! $BestSell->title !!}</a>
                                    <p><strong >{!! \App\Util::FormatMoney($BestSell->priceProduct) !!} </strong></p>
                                    <p> <small>{!! $BestSell->numOrder !!} đơn hàng</small>
                                    </p>
                                    </p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

            </div>
        </div>
        @if(Auth::user()->hasRole(\App\Util::$viewDashboard))
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel" style="min-height: 550px;">
                <div>
                    <div class="x_title">
                        <h2>Địa điểm các chủ kho</h2>
                    </div>
                    <div class="text-left">
                        <button class="btn btn-raised btn-info btnLoadMaps" style="padding: 5px 30px; ">Load maps</button>
                        <a href="{{ url('/mapsadd') }}" target="_blank" class="btn btn-raised btn-info btn" style="padding: 5px 30px;">Add maps</a>
                    </div>
                    <div class="gmap" id="gmap-3" style="height:600px;width: 100%; float:left"></div>
                    <div id="script">
                        
                    </div>
                    <div id="map"></div>
                </div>

            </div>
        </div>

        <div class="col-md-12 col-sm-12 col-xs-12">

            <div class="x_panel" style="min-height: 550px;">
                <div>
                    <div class="x_title">
                        <h2>Sản phẩm cần duyệt</h2>

                        <div class="clearfix"></div>
                    </div>
                    <ul class="list-unstyled top_profiles scroll-view">

                        @foreach($arrProductWaitApproval as $itemProductWaitApproval)
                            <li class="media event product0" style="height: 50px;" id="">
                                <a class="pull-left border-aero profile_thumb" style="margin: 0px; width: 150px;">
                                    {{\App\Util::ProductCode($itemProductWaitApproval->id)}}
                                </a>
                                <div class="media-body" style="padding-top: 10px;">
                                    <div class="col-md-6 col-sm-6 col-xs-6 text-left"><a class="title" style="font-weight :100;" href="{{route('products.edit',['id' => $itemProductWaitApproval->id])}}" target="_blank">{!! $itemProductWaitApproval->title !!}</a></div>
                                    <div class="col-md-2 col-sm-2 col-xs-2">Kho {{\App\Util::UserCode($itemProductWaitApproval->kho)}}</div>

                                    <div class="col-md-3 col-sm-3 col-xs-3 text-right" style="top: -13px;"><button class="btn btn-raised btn-success btnApproval" onclick="Approval(this)" style="padding: 5px 30px;">Duyệt</button></div>
                                </div>
                                <input type="hidden" name="txtProductID" value="{{$itemProductWaitApproval->id}}">
                                <input type="hidden" name="txtKhoID" value="{{$itemProductWaitApproval->kho}}">
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                            </li>

                        @endforeach
                        <div class="text-center">
                            {{ $arrProductWaitApproval->appends(array('q' => Request::get('q')))->links() }}
                        </div>
                        <br>
                    </ul>
                </div>
                
            </div>
            <div class="loading" style="display: none"><img src="{{url('/images/loading.gif')}}" class="img-reponsive" alt=""></div>
        </div>
        
        <div class="col-md-12 col-sm-12 col-xs-12">

            <div class="x_panel" style="min-height: 550px;">
                <div>
                    <div class="x_title">
                        <h2>Cơ hội mua bán cần duyệt</h2>

                        <div class="clearfix"></div>
                    </div>
                    <ul class="list-unstyled top_profiles scroll-view">

                        @foreach($arrNewsCompayWaitApproval as $itemNewsCompanyWaitApproval)
                            <li class="media event product0" style="height: 50px;" id="">
                                <a class="pull-left border-aero profile_thumb" style="margin: -4px; padding: 0px;">
                                    <img src="{{url('/').$itemNewsCompanyWaitApproval->image}}" alt="" class="img-responsive" style="height: 50px; border-radius: 5px;">
                                </a>
                                <div class="media-body" style="padding-top: 10px;">
                                    <div class="col-md-6 col-sm-6 col-xs-6 text-left"><a class="title" style="font-weight :100;" href="{{route('newscompany.edit',['id' => $itemNewsCompanyWaitApproval->id])}}" target="_blank">{!! $itemNewsCompanyWaitApproval->title !!}</a></div>
                                    <div class="col-md-2 col-sm-2 col-xs-2">Công ty {{\App\Util::UserCode($itemNewsCompanyWaitApproval->author_id)}}</div>

                                    <div class="col-md-3 col-sm-3 col-xs-3 text-right" style="top: -13px;"><button class="btn btn-raised btn-success btnApprovalNews" onclick="ApprovalNews(this)" style="padding: 5px 30px;">Duyệt</button></div>
                                </div>
                                <input type="hidden" name="txtnewsID" value="{{$itemNewsCompanyWaitApproval->id}}">
                                <input type="hidden" name="txtauthorID" value="{{$itemNewsCompanyWaitApproval->author_id}}">
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                            </li>

                        @endforeach
                        <div class="text-center">
                            {{ $arrNewsCompayWaitApproval->appends(array('q' => Request::get('q')))->links() }}
                        </div>
                        <br>
                    </ul>
                </div>

            </div>
            <div class="loading" style="display: none"><img src="{{url('/images/loading.gif')}}" class="img-reponsive" alt=""></div>
        </div>
        @endif

    </div>

    @endsection
    @section('add_scripts')
            <!-- Chart.js -->
    <script src="{{asset('plugin/Chart.js/dist/Chart.js')}}"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="{{asset('/js/moment/moment.min.js')}}"></script>
    <script src="{{asset('/js/datepicker/daterangepicker.js')}}"></script>

    <!-- <link rel="stylesheet" href="{{url('/')}}/maps/css/libs.min.css"> -->
    <!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD1ly9FzEHY0YeCm5dvVliYSGeTfIN_XhU"></script> -->
    <!-- <script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD1ly9FzEHY0YeCm5dvVliYSGeTfIN_XhU&callback=initMap"
  type="text/javascript"></script> -->
    <!-- <script src="https://maps.google.com/maps/api/js?sensor=false&libraries=geometry&v=3.22&key=AIzaSyD1ly9FzEHY0YeCm5dvVliYSGeTfIN_XhU">
    </script> -->
    <script src="https://maps.google.com/maps/api/js?sensor=false&libraries=geometry&v=3.22&key=AIzaSyBLcEsjlc0sBoDPAYnPI_Y-_6nQFiX_C50">
    </script>
    <script src="{{url('/')}}/maps/js/maplace.min.js"></script>
    <!-- Doughnut Chart -->
    <script>
        var LocsA = [
            {
                lat: 45.9,
                lon: 10.9,
                title: 'Title A1',
                html: '<h3>Nhấn vào nút Load Maps</h3>',
                icon: 'http://maps.google.com/mapfiles/markerA.png',
                animation: google.maps.Animation.DROP
            }

        ];
        var maplace =  new Maplace({
                map_div: '#gmap-3',
                controls_type: 'list',
                controls_on_map: true,});
        maplace.SetLocations(LocsA,true);
        $('#script').load('{{url("/")}}/mapsgetmap'), function() {
            maplace.SetLocations(LocsA,true).Load();
        };

    </script>
    <script>
    $(document).ready(function(){

        $('.btnLoadMaps').on('click', function(){
            $('#script').load('{{url("/")}}/mapsgetmap');
                maplace.SetLocations(LocsA,true);
        });
    });
    
</script>
    <!-- <script type="text/javascript">
              var customLabel = {
        restaurant: {
          label: 'R'
        },
        bar: {
          label: 'B'
        }
      };

        function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: new google.maps.LatLng(-33.863276, 151.207977),
          zoom: 12
        });
        var infoWindow = new google.maps.InfoWindow;

          // Change this depending on the name of your PHP or XML file
          downloadUrl('https://storage.googleapis.com/mapsdevsite/json/mapmarkers2.xml', function(data) {
            var xml = data.responseXML;
            var markers = xml.documentElement.getElementsByTagName('marker');
            Array.prototype.forEach.call(markers, function(markerElem) {
              var id = markerElem.getAttribute('id');
              var name = markerElem.getAttribute('name');
              var address = markerElem.getAttribute('address');
              var type = markerElem.getAttribute('type');
              var point = new google.maps.LatLng(
                  parseFloat(markerElem.getAttribute('lat')),
                  parseFloat(markerElem.getAttribute('lng')));

              var infowincontent = document.createElement('div');
              var strong = document.createElement('strong');
              strong.textContent = name
              infowincontent.appendChild(strong);
              infowincontent.appendChild(document.createElement('br'));

              var text = document.createElement('text');
              text.textContent = address
              infowincontent.appendChild(text);
              var icon = customLabel[type] || {};
              var marker = new google.maps.Marker({
                map: map,
                position: point,
                label: icon.label
              });
              marker.addListener('click', function() {
                infoWindow.setContent(infowincontent);
                infoWindow.open(map, marker);
              });
            });
          });
        }



      function downloadUrl(url, callback) {
        var request = window.ActiveXObject ?
            new ActiveXObject('Microsoft.XMLHTTP') :
            new XMLHttpRequest;

        request.onreadystatechange = function() {
          if (request.readyState == 4) {
            request.onreadystatechange = doNothing;
            callback(request, request.status);
          }
        };

        request.open('GET', url, true);
        request.send(null);
      }

      function doNothing() {}
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBLcEsjlc0sBoDPAYnPI_Y-_6nQFiX_C50&callback=initMap">
    </script> -->
    <script>
        var lineLabels="";
        var lineDatas="";
        var barLabels="";
        var barDatas1="";
        var barDatas2="";


    </script>
    

    <script type="text/javascript">
        $(document).ready(function() {
            $('span').find('.unit').addClass('style_format');
        });
    </script>
    <script>
        $(document).ready(function() {

            var cb = function(start, end, label) {
                console.log(start.toISOString(), end.toISOString(), label);
                $('#reportrange2 span').html(start.format('DD-MM-YYYY') + ' > ' + end.format('DD-MM-YYYY'));
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
            $('#reportrange2 span').html(moment().subtract(6, 'days').format('DD-MM-YYYY') + ' > ' + moment().format('DD-MM-YYYY'));
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
            var _token = $('input[name="_token"]').val();
            $('.loading').css('display','block');
            $.ajax({
                type: "POST",
                url: '{!! url("/") !!}/admin/dashboardctrl',
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
                                fill: false,
                                backgroundColor: "rgba(76, 175, 80, 0.68)",
                                borderColor: "rgba(38, 185, 154, 0.7)",
                                pointBorderColor: "rgba(38, 185, 154, 0.7)",
                                pointBackgroundColor: "rgba(38, 185, 154, 0.7)",
                                pointBorderWidth: 1,
                                pointHoverRadius: 5,
                                pointHoverBackgroundColor: "rgba(38, 185, 154, 0.7)",
                                pointHoverBorderColor: "rgba(38, 185, 154, 0.7)",
                                pointHoverBorderWidth: 2,
                                data: lineDatas,
                            }]
                        },
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true,
                                        callback: function(value) {
                                            return value.toLocaleString();
                                        }
                                    }
                                }],
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
                url: '{!! url("/") !!}/admin/dashboardctrl',
                data: {data: data,_token: _token},
                success: function( msg ) {
                    $('.loading').css('display','none');
                    lineLabels = msg['lineLabels'];
                    lineDatas = msg['lineDatas'];
                    barLabels = msg['barLabels'];
                    barDatas1 = msg['barDatas1'];
                    barDatas2 = msg['barDatas2'];

                    //graph options
                    var options = {
                        scaleOverride: true,
                        scaleSteps: 8,
                        scaleStepWidth: 1800,
                        scaleStartValue: 10800,
                        responsive: true,
                        maintainAspectRatio: false,
                        scaleLabel: function(valuePayload) {
                          return new Date(valuePayload.value * 1000).toISOString().substr(12, 7);
                        },
                        multiTooltipTemplate: function(valuePayload) {
                          return valuePayload.datasetLabel + " " + new Date(valuePayload.value * 1000).toISOString().substr(12, 7)
                        }
                      };
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
                                label: 'Bị lỗi',
                                backgroundColor: "#FF9800",
                                data: barDatas2
                            }]
                        }, 

                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true,
                                        callback: function(value) {
                                            return value.toLocaleString();
                                        }
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

    <script>
        $(document).ready(function () {
            var options = {
                legend: false,
                responsive: false
            };
            var level1 = $('input[type="hidden"][name="level1"]').val();
            var level2 = $('input[type="hidden"][name="level2"]').val();
            var level3 = $('input[type="hidden"][name="level3"]').val();
            new Chart(document.getElementById("canvas2"), {
                type: 'doughnut',
                tooltipFillColor: "rgba(51, 51, 51, 0.55)",
                data: {
                    labels: [
                        "Cấp 1",
                        "Cấp 2",
                        "Cấp 3"
                    ],
                    datasets: [{
                        data: [level1,level2,level3],
                        backgroundColor: [
                            "#3498DB",
                            "#1ABB9C",
                            "#9B59B6"
                        ],
                        hoverBackgroundColor: [
                            "#CFD4D8",
                            "#B370CF",
                            "#E95E4F"
                        ]
                    }]
                },
                options: options
            });
        });
        $(document).ready(function () {
            var options = {
                legend: false,
                responsive: false
            };
            var traphi = $('input[type="hidden"][name="traphi"]').val();
            var dungthu = $('input[type="hidden"][name="dungthu"]').val();
            new Chart(document.getElementById("canvas3"), {
                type: 'doughnut',
                tooltipFillColor: "rgba(51, 51, 51, 0.55)",
                data: {
                    labels: [
                        "Trả phí",
                        "Dùng thử"
                    ],
                    datasets: [{
                        data: [traphi,dungthu],
                        backgroundColor: [
                            "#009688",
                            "#CDDC39"
                        ],
                        hoverBackgroundColor: [
                            "#009688",
                            "#CDDC39"
                        ]
                    }]
                },
                options: options
            });
        });
    </script>
    <!-- /Doughnut Chart -->
    <script>

        // Line chart
        var ctx = document.getElementById("lineChart");

        //alert(PriceByMonth);
        var lineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ["1", "2", "3", "4", "5", "6", "7","8","9","10","11","12"],
                datasets: [{
                    label: "Doanh Thu",
                    backgroundColor: "rgba(76, 175, 80, 0.68)",
//                    borderColor: "rgba(38, 185, 154, 0.7)",
                    pointBorderColor: "rgba(38, 185, 154, 0.7)",
                    pointBackgroundColor: "rgba(38, 185, 154, 0.7)",
                    pointHoverBackgroundColor: "#fff",
                    pointHoverBorderColor: "rgba(220,220,220,1)",
                    pointBorderWidth: 1,
                    data: []
                }]
            },
        });

        // Bar chart
        var ctx = document.getElementById("mybarChart");

        var mybarChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ["1", "2", "3", "4", "5", "6", "7","8","9","10","11","12"],
                datasets: [{
                    label: 'Thành công',
                    backgroundColor: "#4caf50",
                    data: []
                }, {
                    label: 'Bị lỗi',
                    backgroundColor: "#FF9800",
                    data: []
                }]
            },

            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>
    <script type="text/javascript">
        function ParseRow($LI){
            var ctlPID = $LI.find('input[type="hidden"][name="txtProductID"]');
            var ctlKhoID = $LI.find('input[type="hidden"][name="txtKhoID"]');
            var pid = ctlPID.val();
            var khoid = ctlKhoID.val();
            var result = {
                "pid"    : pid,
                "khoid"    : khoid
            };
            return result;
        }

        function Approval(sender){
            var parentLI = $(sender).parent().parent().parent();
            //console.log(parentLI);
            var product = ParseRow(parentLI);
            var pid = product['pid'];
            var khoid = product['khoid'];
            var _token = $('input[name="_token"]').val();
            $('.loading').css('display','block');
            $.ajax({
                type: "POST",
                url: '{{ url('/') }}/admin/dashboard/Approval',
                data: {pid: pid, khoid: khoid, _token: _token},
                success: function( msg ) {
                    $('.loading').css('display','none');
                    //show notify
                    new PNotify({
                        title: 'Duyệt sản phẩm thành công',
                        text: '',
                        type: 'success',
                        hide: true,
                        styling: 'bootstrap3'
                    });
                    location.reload();
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    //show notify
                    var Data = JSON.parse(XMLHttpRequest.responseText);
                    new PNotify({
                        title: 'Lỗi',
                        text: "Có lỗi xảy ra",
                        type: 'danger',
                        hide: true,
                        styling: 'bootstrap3'
                    });
                    $('.loading').css('display','none');

                }
            });
        }
    </script>
    <script type="text/javascript">
        function ParseRowNews($LI){
            var ctlnewsID = $LI.find('input[type="hidden"][name="txtnewsID"]');
            var ctlauthorID = $LI.find('input[type="hidden"][name="txtauthorID"]');
            var newsid = ctlnewsID.val();
            var authorid = ctlauthorID.val();
            var result = {
                "newsid"    : newsid,
                "authorid"    : authorid
            };
            return result;
        }

        function ApprovalNews(sender){
            var parentLI = $(sender).parent().parent().parent();
            //console.log(parentLI);
            var newsCompany = ParseRowNews(parentLI);
            var newsid = newsCompany['newsid'];
            var authorid = newsCompany['authorid'];
            var _token = $('input[name="_token"]').val();
            $('.loading').css('display','block');
            $.ajax({
                type: "POST",
                url: '{{ url('/') }}/admin/dashboard/ApprovalNews',
                data: {newsid: newsid, authorid: authorid, _token: _token},
                success: function( msg ) {
                    $('.loading').css('display','none');
                    //show notify
                    new PNotify({
                        title: 'Duyệt cơ hội mua bán thành công',
                        text: '',
                        type: 'success',
                        hide: true,
                        styling: 'bootstrap3'
                    });
                    location.reload();
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    //show notify
                    var Data = JSON.parse(XMLHttpRequest.responseText);
                    new PNotify({
                        title: 'Lỗi',
                        text: "Có lỗi xảy ra",
                        type: 'danger',
                        hide: true,
                        styling: 'bootstrap3'
                    });
                    $('.loading').css('display','none');

                }
            });
        }
    </script>
@endsection