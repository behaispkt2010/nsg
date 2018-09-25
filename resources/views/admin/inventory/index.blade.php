@extends('layouts.admin')
@section('title', 'Tồn kho')
@section('pageHeader','Tồn kho sản phẩm ')
@section('detailHeader','kiểm tra tồn kho')
@section('new-btn')
<div class="hover-new-btn h-hover">
    <div class="h-report">
        <!-- <a href="{!! url('/') !!}/report/export/product?kho=@if(!empty($_REQUEST['kho'])){{$_REQUEST['kho']}} @endif&category=@if(!empty($_REQUEST['category'])){{$_REQUEST['category']}} @endif&name=@if(!empty($_REQUEST['name'])){{$_REQUEST['name']}} @endif" target="_blank" class="btn btn-warning btn-fab" title="Xuất excel Danh sách sản phẩm">
            <i class="material-icons">archive</i>
        </a> -->
    </div>
    <div class="h-help">
        <a href="{{ url('/tro-giup') }}" target="_blank" class="btn btn-warning btn-fab" title="Thông tin trợ giúp">
            <i class="material-icons">help</i>
        </a>
    </div>
    <div class="h-plus">
        <a href="{{route('inventory.create')}}" class="btn btn-warning btn-fab" title="Kiểm kho">
            <i class="material-icons iconPlus">add</i>
            <i class="fa fa-paper-plane material-icons new-btn iconCreate hidden-hover" aria-hidden="true"></i>
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
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group label-floating">
                                <label class="control-label" for="addon2">Tên sản phẩm | Mã sản phẩm</label>
                                <div class="input-group text-center">
                                    <input type="text" id="addon2" class="form-control" name="name" value="{{Request::get('name')}}">
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
                        @if(count($inventorys) !=0)
                        @foreach($inventorys as $inventory)

                        <div class="col-md-4 col-sm-4 col-xs-12 profile_details product-detail">
                            <div class="well box_1">
                                <div class="col-sm-12">
                                    <h2 class="cod">{{ $inventory->code }}</h2>
                                    <div class="col-xs-12" style="padding-left: 0px;">
                                        <ul class="list-unstyled">
                                            <li class="limitcharacter"><span class="label-box1">Số sản phẩm: </span><?php 
                                                $arrID = explode(',', $inventory->id_product); 
                                                ?>
                                                {{ count($arrID) }}
                                            </li>
                                            <li class="limitcharacter"><span class="label-box1">Trạng thái</span>
                                                <strong>
                                                    @if($inventory->status == 0)
                                                    Mới tạo
                                                    @elseif($inventory->status == 1)
                                                    Đang xử lý
                                                    @elseif($inventory->status == 2)
                                                    Hoàn thành
                                                    @elseif($inventory->status == 3)
                                                    Hủy
                                                    @endif
                                                </strong>
                                            </li>
                                            <li class="limitcharacter"><span class="label-box1">Người tạo:</span>{{ \App\NewsCompany::getUserName($inventory->author_id) }}</li>
                                            <li class="limitcharacter"><span class="label-box1">Thời gian:</span><?php echo (date_format($inventory->created_at ,"d/m/Y - H:i:s")) ?></li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="col-xs-12 text-center">
                                    <a href="{{route('inventory.edit',['id' => $inventory->id])}}" class="btn btn-raised btn-primary btn-xs">
                                        <i class="fa fa-pencil" aria-hidden="true" ></i> Sửa
                                    </a>
                                    <form action="{{route('inventory.destroy',['id' => $inventory->id])}}" method="post" class="form-delete" style="display: inline">
                                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                                        <input type="text" class="hidden" value="{{$inventory->id}}">
                                        {{method_field("DELETE")}}
                                        <a type="submit" class = "btn btn-raised  btn-xs btn-danger" name ="delete_modal" style="display: inline-block"><i class="fa fa-times" aria-hidden="true"></i> Xóa</a>
                                    </form>

                                </div>
                            </div>
                        </div>
                        @endforeach
                        <div class="clearfix"></div>
                        <div class="text-center">
                            {{ $inventorys->appends(array('name' => Request::get('name'),'dateview' => Request::get('dateview')))->links() }}
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

    <div class="modal fade modal-product-inventory" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false"
         data-backdrop="static">
        <div class="modal-dialog modal-product-inventory">

            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title text-center title" id="myModalLabel"></h4>
                    <input type="hidden" name="id">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                </div>
                <div class="modal-body sroll">
                    <div class="form-group">
                        <div class="form-group">
                            <span>Tồn kho hiện tại: </span><span class="number-inventory"></span>
                        </div>
                        <div class="form-group label-floating">
                            <label class="control-label" for="focusedInput2"> Kiểm thực tế</label>
                            <input class="form-control check-num-product" id="focusedInput2" type="number"  name="check-num-product">
                        </div>
                        <div class="form-group">
                            <span>Hiệu chỉnh: </span><span class="number-fix"></span>
                        </div>
                        {{--<div class="form-group">--}}
                            {{--<div class="form-group label-floating">--}}
                                {{--<label class="control-label" for="focusedInputnote">Nguyên nhân hiệu chỉnh</label>--}}
                                {{--<textarea class="form-control" id="focusedInputnote" name="reason"></textarea>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-raised btn-primary" id="update-product">Lưu hiệu chỉnh</button>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('add_scripts')
    <script src="{{asset('js/selectize.js')}}"></script>
    <!-- Select2 -->
    <script>
        $('#select-ck,#select-cate,#parent-cate').selectize({
            create: true,
            /*sortField: 'text'*/
        });
    </script>
    <script>
        $(document).on("click", ".check-product", function () {
            var _self = $(this);
//            alert("ds");
            $('.modal-product-inventory input[name="id"]').val(_self.data('id'));
            $('.modal-product-inventory .title').text(_self.data('title'));
            $('.modal-product-inventory .number-inventory').text(_self.data('inventory'));
//            alert(_self.data('inventoryNum'));
        });
        $(document).on('change','input[name="check-num-product"]',function(){
            var number_inventory = $('.modal-product-inventory .number-inventory').text();
            var check_num_product = $('.modal-product-inventory .check-num-product').val();
//            alert(check_num_product);
            $('.number-fix').text(parseInt(check_num_product) - parseInt(number_inventory));
            });
    
    </script>
    <script>
        $('#update-product').on('click', function (e) {
            e.preventDefault();

            var id = $('.modal-product-inventory input[name="id"]').val();
            var num = $('.modal-product-inventory input[name="check-num-product"]').val();
//            var reason = $('.modal-product-cate textarea[name="reason"]').val();
            var _token = $('input[name="_token"]').val();
            if(num==""){
                new PNotify({
                    title: 'Vui lòng nhập thông tin',
                    text: '',
                    type: 'danger',
                    hide: true,
                    styling: 'bootstrap3'
                });
                return false;
            }
//            alert(id);
            $('.loading').css('display','block');
            $.ajax({
                type: "POST",
                url: '/product/checkProductAjax',
                data: {id: id, num: num,_token: _token},
                success: function( msg ) {
                    $('.loading').css('display','none');
                    $('.modal-product-cate input[name="check-num-product"]').val("");
//                    $('.modal-product-cate textarea[name="reason"]').val("");
//                    alert("Tạo thành công");
                    //show notify
                    new PNotify({
                        title: 'Cập nhật thành công',
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
                        text: Data['name'],
                        type: 'danger',
                        hide: true,
                        styling: 'bootstrap3'
                    });
                    $('.loading').css('display','none');

                }
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
            $("#dateview").val(data);
        });
    </script>
@endsection

