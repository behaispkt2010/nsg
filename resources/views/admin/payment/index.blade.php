@extends('layouts.admin')
@section('title', 'Tồn kho')
@section('pageHeader','Tồn kho sản phẩm ')
@section('detailHeader','kiểm tra tồn kho')
@section('new-btn')
<div class="hover-new-btn h-hover">
    <div class="h-report">
        <a href="{{route('payment.create', ['type' => 'payment'])}}" class="btn btn-success btn-fab" title="Tạo phiếu chi">
            <i class="material-icons iconPlus">add</i>
            <i class="fa fa-arrow-up material-icons new-btn iconCreate hidden-hover" aria-hidden="true"></i>
        </a>
    </div>
    <div class="h-help">
        <a href="{{ url('/tro-giup') }}" target="_blank" class="btn btn-warning btn-fab" title="Thông tin trợ giúp">
            <i class="material-icons">help</i>
        </a>
    </div>
    <div class="h-plus">
        <a href="{{route('payment.create', ['type' => 'receipt'])}}" class="btn btn-warning btn-fab" title="Tạo phiếu thu">
            <i class="material-icons iconPlus">add</i>
            <i class="fa fa-arrow-down material-icons new-btn iconCreate hidden-hover" aria-hidden="true"></i>
        </a>

    </div>
</div>
@endsection
@section('content')
    <div class="row top-right">

        <div class="x_panel">
            <form action="" method="GET">
                <div class="x_content">
                    <div class="row">
                        
                        <div class="col-md-3 col-sm-12 col-xs-12">
                            <div class="form-group label-floating">
                                <div class="col-md-12" style="float: right; font-size: 13px;">
                                    <div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc;border-radius: 4px;">
                                        <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                                        <span id="date-filter1"></span> <b class="caret"></b>
                                    </div>
                                    <input type="hidden" name="dateview" value="" id="dateview" class="dateview">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 col-xs-12">
                            <div class="form-group label-floating">
                                <div class="input-group text-center">
                                    <select name="name" class="form-control" id="select-type" placeholder="Chọn loại phiếu">
                                        <option value=""></option>
                                        <option value="payment" @if(Request::get("name") == "payment") selected="" @endif>Phiếu chi</option>
                                        <option value="receipt" @if(Request::get("name") == "receipt") selected="" @endif>Phiếu thu</option>
                                    </select>
                                    <span class="input-group-btn">
                                        <button type="submit" class="btn btn-fab btn-fab-mini">
                                            <i class="material-icons">search</i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

    </div>
    <div class="row">

        <div class="col-md-12">
            <div class="">
                <div class="x_content">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 text-center">

                        </div>

                        <div class="clearfix"></div>
                        @if(count($payments) !=0)
                        @foreach($payments as $payment)

                        <div class="col-md-4 col-sm-4 col-xs-12 profile_details product-detail">
                            <div class="well box_1">
                                <div class="box-status"
                                     style="background-color: @if($payment->type=='receipt') blue @elseif($payment->type=='payment') red @endif ;">
                                    <p class="text-center status-title">@if($payment->type=='receipt') Phiếu thu @elseif($payment->type=='payment') Phiếu chi @endif</p>
                                </div>
                                <div class="col-sm-12">
                                    <h2 class="cod">{{ $payment->code }}</h2>
                                    <div class="col-xs-12" style="padding-left: 0px;">
                                        <ul class="list-unstyled">
                                            <li class="limitcharacter"><span class="label-box1">Đối tượng </span>
                                                {{ $payment->cardNameBank }}
                                            </li>
                                            <li class="limitcharacter"><span class="label-box1">Giá trị </span>
                                                {!! \App\Util::FormatMoney($payment->price) !!}
                                            </li>
                                            <li class="limitcharacter"><span class="label-box1">Danh mục</span>
                                                {{ $payment->cateName }}
                                            </li>
                                            <li class="limitcharacter"><span class="label-box1">Thanh toán</span>
                                                @if($payment->type_pay == 1)
                                                {{ $payment->cardNameBank }}
                                                @elseif($payment->type_pay == 2)
                                                {{ $payment->nameBank }}
                                                @endif
                                            </li>
                                            <li class="limitcharacter"><span class="label-box1">Trạng thái</span>
                                                @if($payment->status == 0)
                                                Mới tạo
                                                @elseif($payment->status == 1)
                                                Đang xử lý
                                                @elseif($payment->status == 2)
                                                Hoàn thành
                                                @elseif($payment->status == 3)
                                                Hủy
                                                @endif
                                            </li>
                                            <li class="limitcharacter"><span class="label-box1">Người tạo:</span>{{ \App\NewsCompany::getUserName($payment->author_id) }}</li>
                                            <li class="limitcharacter"><span class="label-box1">Thời gian:</span><?php echo (date_format($payment->created_at ,"d/m/Y - H:i:s")) ?></li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="col-xs-12 text-center">
                                    <a href="{{route('payment.edit',['id' => $payment->id])}}" class="btn btn-raised btn-primary btn-xs">
                                        <i class="fa fa-pencil" aria-hidden="true" ></i> Sửa
                                    </a>
                                    <form action="{{route('payment.destroy',['id' => $payment->id])}}" method="post" class="form-delete" style="display: inline">
                                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                                        <input type="text" class="hidden" value="{{$payment->id}}">
                                        {{method_field("DELETE")}}
                                        <a type="submit" class = "btn btn-raised  btn-xs btn-danger" name ="delete_modal" style="display: inline-block"><i class="fa fa-times" aria-hidden="true"></i> Xóa</a>
                                    </form>

                                </div>
                            </div>
                        </div>
                        @endforeach
                        <div class="clearfix"></div>
                        <div class="text-center">
                            {{ $payments->appends(array('name' => Request::get('name'),'dateview' => Request::get('dateview')))->links() }}
                        </div>
                        @else
                            <div>Không tìm thấy dữ liệu</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.partial.modal_delete')
@endsection

@section('add_scripts')
    <script src="{{asset('js/selectize.js')}}"></script>
    <!-- Select2 -->
    <script>
        $('#select-type, #select-cate, #parent-cate').selectize({
            create: true,
            /*sortField: 'text'*/
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
            $("#dateview").val(data);
        });
    </script>
@endsection

