@extends('layouts.admin')
@section('title', 'Chi tiết nhập hàng')
@section('pageHeader','Chi tiết nhập hàng')
@section('detailHeader','Chi tiết nhập hàng')
@section('new-btn')
    <!-- <a href="{{route('historyInput.create')}}" class="btn btn-warning btn-fab" title="Tạo thêm lịch sử nhập hàng">
        <i class="fa fa-paper-plane material-icons new-btn" aria-hidden="true"></i>
    </a> -->
    <div class="hover-new-btn h-hover">
        <!-- <div class="h-report">
            <a href="{!! url('/') !!}/report/orders" target="_blank" class="btn btn-warning btn-fab" title="Danh sách đơn hàng">
                <i class="fa fa-print material-icons print-btn" aria-hidden="true"></i>
            </a>
        </div> -->
        <div class="h-help">
            <a href="{{ url('/tro-giup') }}" target="_blank" class="btn btn-warning btn-fab" title="Thông tin trợ giúp">
                <i class="material-icons">help</i>
            </a>
        </div>
        <div class="h-plus">
            <a href="{!! url('/') !!}/report/product/hisInput/{{$date}}" target="_blank" class="btn btn-warning btn-fab" title="In Nhập hàng ngày {{$date}}">
                <i class="fa fa-print material-icons print-btn" aria-hidden="true"></i>
            </a>
        </div>
    </div>
@endsection
@section('content')

    <div class="row">
        <br>
        <div class="col-md-12 col-xs-12">
            <!-- Name and Description -->
            <div class="">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 profile_details product-detail">
                        
                        <div class="well box1 info-kho">
                            <h4 class="text-center">Chi tiết nhập hàng ngày {{$date}}</h4>
                            <table class="table table-striped table-hover ">
                                <thead>
                                <tr>
                                    <th>Thời gian</th>
                                    <th>Mã sản phẩm</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Số lượng nhập</th>
                                    <th>Số tiền nhập</th>
                                    <th>Tổng số tiền nhập</th>
                                    <th>Tên nhà cung cấp</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $total_price_in=0;
                                    $total_num=0;
                                ?>
                              @foreach($productUpdatePrice as $item)
                                <tr>
                                    <td>{{$item->created_at->format('h:i')}}</td>
                                    <td>#{{\App\Util::ProductCode($item->product_id)}}</td>
                                    <td>{{\App\Product::getNameById($item->product_id)}}</td>
                                    <td>{{$item->number}}</td>
                                    <td>{!! \App\Util::FormatMoney($item->price_in) !!}</td>
                                    <td>{!! \App\Util::FormatMoney($item->price_in * $item->number) !!}</td>
                                    <td>@if($item->supplier != "create"){{ $item->supplier }} @endif</td>
                                    <td><a href="#" id="input-hisinput" class="btn btn-raised btn-primary btn-xs" data-toggle="modal"
                                           data-target=".modal-hisinput" data-title="{{\App\Product::getNameById($item->product_id)}} ({{\App\Util::ProductCode($item->product_id)}})" 
                                           data-gia="{{$item->price_in}}" data-number="{{$item->number}}" data-supplier="{{$item->supplier}}" data-id="{{$item->product_id}}" data-historyid="{{$item->id}}" >
                                        <i class="fa fa-pencil" aria-hidden="true"></i> </a>
                                    </td>
                                    <?php
                                    $total_num +=$item->number;
                                    $total_price_in = $total_price_in + ($item->price_in * $item->number);
                                    ?>
                                </tr>
                                    @endforeach
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>{{$total_num}}</td>
                                    <td></td>
                                    <td>{!! \App\Util::FormatMoney($total_price_in) !!}</td>
                                    <td></td>
                                    <td></td>
                                    
                                </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                        <div class="text-center">
                            {{ $productUpdatePrice->appends(array('date' => Request::get('date')))->links() }}
                        </div>
                </div>

            </div>
        </div>

    </div>
    <!-- modal -->
    <div class="modal fade modal-hisinput" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false"
         data-backdrop="static">
        <div class="modal-dialog modal-tracking">

            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h2 class="modal-title text-center title" id="myModalLabel" style="font-weight: 300;"></h2>
                    <input type="hidden" name="id">
                    <input type="hidden" name="historyid">
                    <input type="hidden" name="numberold">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                </div>
                <div class="modal-body sroll">
                    <div class="form-group">
                        <div class="col-md-12 col-xs-12">
                            <div class="form-group ">
                                <label class="control-label" for="focusedInput2"> Giá mua</label>
                                <input class="form-control" id="focusedInput2" type="number" name="price_in">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6 col-xs-12">
                            <div class="form-group ">
                                <label class="control-label" for="focusedInput2"> Số lượng</label>
                                <input class="form-control" id="focusedInput2" type="number" name="number">
                            </div>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <div class="form-group ">
                                <label class="control-label" for="focusedInput2"> Nhà cung cấp</label>
                                <input class="form-control" id="focusedInput2" type="text" name="supplier">
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-raised btn-primary" id="histinput">Sửa</button>
                </div>
                <div class="loading" style="display: none"><img src="{{url('/images/loading.gif')}}" class="img-reponsive" alt=""></div>
            </div>
        </div>
    </div>
    @endsection


    @section('add_scripts')
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
    <!-- Select2 -->
    
    <script>
        $('#histinput').on('click', function (e) {
            e.preventDefault();

            var id = $('.modal-hisinput input[name="id"]').val();
            var numberold = $('.modal-hisinput input[name="numberold"]').val();
            var historyid = $('.modal-hisinput input[name="historyid"]').val();
            var price_in = $('.modal-hisinput input[name="price_in"]').val();
            var number = $('.modal-hisinput input[name="number"]').val();
            var supplier = $('.modal-hisinput input[name="supplier"]').val();

            var _token = $('input[name="_token"]').val();
            if ( price_in=="" || number=="") {
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
                url: '{{url('/')}}/product/UpdateProductHistoryInput',
                data: {id: id, numberold: numberold, historyid: historyid, price_in: price_in,number: number,supplier: supplier,_token: _token},
                success: function( msg ) {
                    $('.loading').css('display','none');
                    $('.modal-hisinput input[name="price_in"]').val("");
                    $('.modal-hisinput input[name="number"]').val("");
                    $('.modal-hisinput input[name="supplier"]').val("");

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
        $(document).on("click", "#input-hisinput", function () {
            var _self = $(this);
            $('.modal-hisinput input[name="id"]').val(_self.data('id'));
            $('.modal-hisinput input[name="historyid"]').val(_self.data('historyid'));
            $('.modal-hisinput input[name="supplier"]').val(_self.data('supplier'));
            $('.modal-hisinput input[name="number"]').val(_self.data('number'));
            $('.modal-hisinput input[name="numberold"]').val(_self.data('number'));
            $('.modal-hisinput input[name="price_in"]').val(_self.data('gia'));
            $('.modal-hisinput .title').text(_self.data('title'));
        });
    </script>
@endsection