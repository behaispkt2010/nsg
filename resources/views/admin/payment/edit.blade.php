@extends('layouts.admin')
@section('title', 'Quản lí thu chi')
@section('pageHeader','Quản lí thu chi')
@section('detailHeader','Quản lí thu chi')
@section('add_styles')
<link href="{{asset('css/bootstrap-material-datetimepicker.css')}}" rel="stylesheet">

@endsection
@section('content')
    <br>
    <div class="row">
        @if(Request::is('admin/payment/create'))
            <form action="{{route('payment.store')}}" method="POST" enctype="multipart/form-data">
                @else
                    <form action="{{route('payment.update',['id' => $id])}}" method="POST"
                          enctype="multipart/form-data">
                        {{ method_field('PUT') }}
                        <input type="hidden" name="id" value="{{$id}}">
                        @endif
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="type" value="{{$type}}">
                        <div class="col-md-8 col-xs-12">
                            <!-- Name and Description -->
                            <div class="x_panel">
                                <div class="row">
                                    @if($type == 'payment')
                                    <h2>Phiếu chi</h2>
                                    @elseif($type == 'receipt')
                                    <h2>Phiếu thu</h2>
                                    @endif
                                </div>
                                <div class="row">
                                    <div class="form-group col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                        <label for="name">Mã phiếu</label>
                                        @if(Request::is('admin/payment/create'))
                                        <input type="text" class="form-control" disabled value="">
                                        <input type="hidden" name="code" id="code" value="">
                                        @else
                                            {{ $arrPayment->code }}
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                        <label for="name">Danh mục</label>
                                        <select name="cate" class="form-control cate" id="cate" placeholder="Chọn danh mục" required="">
                                            <option value=""></option>
                                            @if(!empty($catePayment))
                                                @foreach($catePayment as $itemCate)
                                                    <option value="{{$itemCate->id}}" @if(!empty($arrPayment->cate) && ($arrPayment->cate == $itemCate->id)) selected @endif>
                                                        {{$itemCate->name}}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 orders" style="@if(!empty($arrPayment->cate) && ($arrPayment->cate != 1)) display: none; @endif">
                                        <label>Đơn hàng</label>
                                        <select id="order_id" name="order_id" class="form-control">
                                            <option></option>
                                            @foreach($arrOrder as $itemOrder)
                                            <option value="{{ $itemOrder->id }}" @if(!empty($arrPayment->order_id) && $arrPayment->order_id == $itemOrder->id) selected @endif>{{ $itemOrder->order_code }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                        <label for="name">Giá trị</label>
                                        <input type="text" required="" class="form-control price" name="price" id="price" value="@if(!empty($arrPayment->price)) {{ $arrPayment->price }} @endif">
                                    </div>
                                    <div class="form-group col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                        <label for="name">Hình thức thanh toán</label>
                                        <select name="type_pay" required="" class="form-control type_pay" id="type_pay" placeholder="Chọn hình thức thanh toán">
                                            <option value=""></option>
                                            <option value="1" @if(!empty($arrPayment->type_pay) && $arrPayment->type_pay == 1) selected @endif>Tiền mặt</option>
                                            <option value="2" @if(!empty($arrPayment->type_pay) && $arrPayment->type_pay == 2) selected @endif>Chuyển khoản</option>
                                        </select>
                                        <input type="hidden" class="type_pay_old" value="@if(!empty($arrPayment->type_pay)) {{$arrPayment->type_pay}} @endif">
                                    </div>
                                    <div class="form-group col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                        <label for="name">Người nhận</label>
                                        <select name="type_pay_detail" class="form-control type_pay_detail" id="type_pay_detail" required=""></select>
                                        <input type="hidden" class="type_pay_detail_old" value="@if(!empty($arrPayment->type_pay_detail)) {{$arrPayment->type_pay_detail}} @endif">
                                    </div>
                                    <div class="form-group col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                        <label for="name">Kỳ thanh toán</label>
                                        <select name="period_pay" required="" class="form-control period_pay" id="period_pay" placeholder="Chọn kỳ thanh toán">
                                            <option value=""></option>
                                            <option value="1" @if(!empty($arrPayment->period_pay) && $arrPayment->period_pay == 1) selected @endif>Đặt cọc</option>
                                            <option value="2" @if(!empty($arrPayment->period_pay) && $arrPayment->period_pay == 2) selected @endif>Trả nợ</option>
                                            <option value="3" @if(!empty($arrPayment->period_pay) && $arrPayment->period_pay == 3) selected @endif>Thanh toán hết</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                        <label for="name">Thời gian</label>
                                        <input type="text" required="" name="time_pay" class="form-control time_pay" id="time_pay" value="@if(!empty($arrPayment->time_pay)){{$arrPayment->time_pay}}@else{{old('time_pay')}}@endif" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-xs-12">
                            <div class="x_panel">
                                <div class="text-center">
                                    @if(Request::is('admin/payment/create'))
                                        <button type="submit" class="btn btn-raised btn-success">Tạo mới </button>
                                    @else
                                        <button type="submit" class="btn btn-raised btn-success">Cập nhật</button>
                                    @endif
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label> Trạng thái</label>
                                        <select id="status" required="" name="status" required="" class="form-control" data-placeholder="Chọn trạng thái">
                                            <option value="1" @if(!empty($arrPayment->status) && $arrPayment->status == 1) selected @endif>Chưa thanh toán</option>
                                            <option value="2" @if(!empty($arrPayment->status) && $arrPayment->status == 2) selected @endif>Đã thanh toán</option>
                                            <option value="3" @if(!empty($arrPayment->status) && $arrPayment->status == 3) selected @endif>Hủy</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-xs-12">
                                            <label style="margin-bottom: 16px;">Ghi chú</label>
                                            <textarea class="form-control note-inventory-edit" rows="5" name="note">@if(!empty($arrPayment->note)){{$arrPayment->note}}@else{{old('note')}}@endif</textarea>

                                        </div>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                            </div>
                        </div>

                    </form>
            </form>
@include('admin.partial.modal_delete')
    </div>

@endsection


@section('add_scripts')
    <!-- <script src="{{asset('plugin/dropzone/dist/min/dropzone.min.js')}}"></script> -->
    <!-- jQuery Tags Input -->
    <script src="{{asset('plugin/jquery.tagsinput/src/jquery.tagsinput.js')}}"></script>
    <!-- jQuery Tags Input -->
    <script>
        function onAddTag(tag) {
            alert("Added a tag: " + tag);
        }

        function onRemoveTag(tag) {
            alert("Removed a tag: " + tag);
        }

        function onChangeTag(input, tag) {
            alert("Changed a tag: " + tag);
        }

        $(document).ready(function () {
            $('#tags_1').tagsInput({
                width: 'auto'
            });
            
        });

    </script>
    <script src="{{asset('js/selectize.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/bootstrap-material-datetimepicker.js')}}"></script>
    <!-- Select2 -->
    <script>
        $('#cate, #order_id, #type_pay, #type_pay_detail, #period_pay, #status').selectize({
            
        });
    </script>
    <script type="text/javascript">
        $(function(){
            $('#price').number(true, 0);
            $(document).ready(function () {
                $('#time_pay').bootstrapMaterialDatePicker
                ({
                    format: 'DD/MM/YYYY',
                    lang: 'vi',
                    time: false,
                });
            });
        });

    </script>
    <!-- /jQuery Tags Input -->
    <script>
        // get list detail payment
        $(function(){
            var type_pay_detail_old = $('.type_pay_detail_old').val();
            var type_pay_old = $('.type_pay_old').val();
            var _token = $('input[name="_token"]').val();
            if(type_pay_old){
                $.ajax({
                    type:'POST',
                    url:'{{ url("/") }}/admin/payment/getListOfType',
                    data: {type_pay: type_pay_old, type_pay_detail: type_pay_detail_old, _token: _token},
                    success:function(html){
                        $('#type_pay_detail').selectize()[0].selectize.destroy();
                        $('#type_pay_detail').html(html);
                        $('#type_pay_detail').selectize();
                    }
                }); 
            } else {
                $('#type_pay_detail').html('<option value="">Chọn Người nhận</option>');
            }
        });
        $(function() {
            $('#type_pay').on('change', function () {
                var type_pay = $(this).val();
                var _token = $('input[name="_token"]').val();
                if(type_pay){
                    $.ajax({
                        type:'POST',
                        url:'{{ url("/") }}/admin/payment/getListOfType',
                        data: {type_pay: type_pay, type_pay_detail: "", _token: _token},
                        success:function(html){
                            $('#type_pay_detail').selectize()[0].selectize.destroy();
                            $('#type_pay_detail').html(html);
                            $('#type_pay_detail').selectize();
                        }
                    }); 
                } else {
                    $('#type_pay_detail').html('<option value="">Chọn Người nhận</option>');
                }
            });
        });
        $('#cate').on('change', function(){
            var cate = $(this).val();
            if(cate == 1) {
                $('.orders').show();
            } else {
                $('.orders').hide();
            }
        });
    </script>

@endsection