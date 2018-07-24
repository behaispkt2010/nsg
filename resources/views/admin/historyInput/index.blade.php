@extends('layouts.admin')
@section('title', 'Danh sách Khách hàng ')
@section('pageHeader','Danh sách khách hàng ')
@section('detailHeader','danh sách')
@section('add_styles')
        <!-- Datatables -->
<link href="{{asset('css/bootstrap-material-datetimepicker.css')}}" rel="stylesheet">
@endsection
@section('new-btn')
    <!-- <a href="{{route('historyInput.create')}}" class="btn btn-warning btn-fab" title="Tạo thêm lịch sử nhập hàng">
        <i class="fa fa-paper-plane material-icons new-btn" aria-hidden="true"></i>
    </a> -->
    <div class="hover-new-btn h-hover">
        <div class="h-report">
            <a href="{!! url('/') !!}/report/export/hisInput?date=@if(!empty($_REQUEST['date'])){{$_REQUEST['date']}} @endif&from=@if(!empty($_REQUEST['from'])){{$_REQUEST['from']}} @endif&to=@if(!empty($_REQUEST['to'])){{$_REQUEST['to']}} @endif" target="_blank" class="btn btn-warning btn-fab" title="Danh sách đơn hàng">
                <i class="material-icons">archive</i>
            </a>
        </div>
        <div class="h-help">
            <a href="{{ url('/tro-giup') }}" target="_blank" class="btn btn-warning btn-fab" title="Thông tin trợ giúp">
                <i class="material-icons">help</i>
            </a>
        </div>
        <div class="h-plus">
            <a href="{{route('historyInput.create')}}" class="btn btn-warning btn-fab" title="Tạo thêm lịch sử nhập hàng">
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
                <form action="" method="get">
                <div class="row">
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group label-floating">
                            <label class="control-label" for="date-start">Từ ngày</label>
                            <input class="form-control" name="from" id="date-start" type="text">
                        </div>

                    </div>
                    <div class="col-md-5 col-sm-12 col-xs-12">
                        <div class="form-group label-floating">

                            <label class="control-label" for="date-end">Đến ngày</label>
                            <input class="form-control" name="to" id="date-end" type="text">
                        </div>
                    </div>
                    <div class="col-md-1 col-sm-12 col-xs-12">

                                        <button type="submit"  class="btn btn-fab btn-fab-mini">
                                            <i class="material-icons">search</i>
                                        </button>

                        </div>
                </div>
                </form>
            </div>
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
                        @if(count($productUpdatePrice) !=0)
                        @foreach($productUpdatePrice as $item)
                            <div class="col-md-4 col-sm-4 col-xs-12 profile_details box-detail">

                                <div class="well box_1">
                                    <div class="col-sm-12 ">
                                        <a href="?date={{$item->created_at->format('d-m-Y')}}">
                                            <h4 class="cod">Mã phiếu: #{{$item->created_at->format('dmY')}}</h4>

                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <ul class="list-unstyled">
                                                        <li><span class="label-box" style="width: 116px;">Số lần nhập kho:</span><span>{{$item->count}}</span></li>
                                                        <li><span class="label-box" style="width: 116px;">Tổng số lượng:</span><span>{{number_format($item->sum_number,0,'.',' ')}}</span> Kg </li>
                                                        <li><span class="label-box" style="width: 116px;">Tổng chi phí:</span><span>{!! \App\Util::FormatMoney($item->sum_price_in) !!}</span></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </a>
                                    </div>

                                </div>
                            </div>
                        @endforeach
                        <div class="clearfix"></div>
                        <div class="text-center">
                            {{ $productUpdatePrice->appends(array('from' => Request::get('from'),'to' => Request::get('to')))->links() }}
                        </div>
                        @else
                            <div>Không tìm thấy dữ liệu</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
@section('add_scripts')
    <script type="text/javascript" src="http://momentjs.com/downloads/moment-with-locales.min.js"></script>
    <script type="text/javascript" src="{{asset('/js/bootstrap-material-datetimepicker.js')}}"></script>
    <!-- jQuery Tags Input -->
    <script type="text/javascript">
        $(document).ready(function () {
            $('#date-start').bootstrapMaterialDatePicker
            ({
                format: 'DD-MM-YYYY',
                lang: 'vi',
                time: false,
            }).on('change', function (e, date) {
                $('#date-end').bootstrapMaterialDatePicker('setMinDate', date);
            });
            $('#date-end').bootstrapMaterialDatePicker({
                weekStart: 0,
                format: 'DD-MM-YYYY',
                lang: 'vi',
                time: false,
            });

        });
    </script>
@endsection