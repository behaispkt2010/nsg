@extends('layouts.admin')
@section('title', 'Quản lý hãng xe')
@section('pageHeader','Quản lý hãng xe')

@section('new-btn')
    <!-- <a href="#" data-toggle="modal"
       data-target=".modal-product-cate" class="btn btn-warning btn-fab" title="Tạo mới Nhóm sản phẩm">
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
            <a href="#" data-toggle="modal" data-target=".modal-TypeNew" class="btn btn-warning btn-fab" title="Tạo mới hãng xe">
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
                        <div class="col-md-9 col-sm-12 col-xs-12">
                            <div class="form-group label-floating">
                                <label class="control-label" for="addon2">Tên hãng xe</label>
                                <div class="input-group text-center">
                                    <input type="text" id="addon2" class="form-control" name="name" value="{{Request::get('name')}}" >
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
                        <div class="col-md-12 col-sm-12 col-xs-12 text-center"></div>
                        <div class="clearfix"></div>
                        @if(count($arrType) != 0)
                        @foreach($arrType as $itemType)
                            <div class="col-md-4 col-sm-4 col-xs-12 profile_details product-detail">
                                <div class="well box_1">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <h2 class="cod text-center title-cate">{{$itemType->name}}</h2>
                                    </div>
                                    <div class="col-xs-12 text-center">
                                        <a href="#" data-toggle="modal"
                                           data-target=".modal-TypeUpdate"
                                           class="btn btn-raised btn-primary btn-xs editType" data-id="{{$itemType->id}}"
                                           data-name="{{$itemType->name}}">
                                            <i class="fa fa-pencil" aria-hidden="true"></i> sửa
                                        </a>
                                        <form action="{{route('cartype.destroy',['id' => $itemType->id])}}" method="post" class="form-delete" style="display: inline">
                                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                                            <input type="text" class="hidden" value="{{$itemType->id}}">
                                            {{method_field("DELETE")}}
                                            <a type="submit" class = "btn btn-raised  btn-xs btn-danger" name ="delete_modal" style="display: inline-block"><i class="fa fa-trash" aria-hidden="true"></i> Xóa</a>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="clearfix"></div>
                        <div class="text-center">
                            {{ $arrType->appends(array('name' => Request::get('name')))->links() }}
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
    <div class="modal fade modal-TypeNew" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false"
         data-backdrop="static">
        <div class="modal-dialog modal-TypeNew">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title text-center" id="myModalLabel">Thêm hãng xe</h4>
                </div>
                <div class="modal-body sroll">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <div class="form-group label-floating">
                            <label class="control-label" for="focusedInput2"> Tên hãng xe</label>
                            <input class="form-control" id="focusedInput2" type="text" name="name">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-raised btn-primary" id="typeNew">Tạo mới</button>
                </div>
             <div class="loading" style="display: none"><img src="{{url('/images/loading.gif')}}" class="img-reponsive" alt=""></div>
            </div>

        </div>
    </div>
    <!-- update type -->
    <div class="modal fade modal-TypeUpdate" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false"
         data-backdrop="static">
        <div class="modal-dialog modal-TypeUpdate">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title text-center" id="myModalLabel">Sửa hãng xe</h4>
                </div>
                <div class="modal-body sroll">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="text" class="hidden" name="id">
                    <div class="form-group">
                        <div class="form-group label-floating">
                            <label class="control-label" for="focusedInput2"> Tên hãng xe</label>
                            <input class="form-control" id="focusedInput2" type="text" name="name" value=" ">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-raised btn-primary" id="typeUpdate">Lưu</button>
                </div>
                <div class="loading" style="display: none"><img src="{{url('/images/loading.gif')}}" class="img-reponsive" alt=""></div>
            </div>

        </div>
    </div>
@endsection
@section('add_scripts')
    
    <script>
        $('#typeNew').on('click', function (e) {
            e.preventDefault();
            var name = $('.modal-TypeNew input[name="name"]').val();
            var _token = $('.modal-TypeNew input[name="_token"]').val();
            $('.loading').css('display','block');
            $.ajax({
                type: "POST",
                url: '{{ url('/') }}/admin/cartype/createAjax',
                data: {name: name, _token: _token},
                success: function( msg ) {
                    $('.loading').css('display','none');
                    $('.modal-TypeNew input[name="name"]').val("");
                    new PNotify({
                        title: 'Tạo thành công',
                        text: '',
                        type: 'success',
                        hide: true,
                        styling: 'bootstrap3'
                    });
                    location.reload();
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
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
        $('#typeUpdate').on('click', function (e) {
            e.preventDefault();
            var name = $('.modal-TypeUpdate input[name="name"]').val();
            var _token = $('.modal-TypeUpdate input[name="_token"]').val();
            var id = $('.modal-TypeUpdate input[name="id"]').val();
            $('.loading').css('display','block');
            $.ajax({
                type: "POST",
                url: '{{ url('/') }}/admin/cartype/updateAjax',
                data: {name: name, _token: _token,id: id},
                success: function( msg ) {
                    $('.loading').css('display','none');
                    $('.modal-TypeUpdate input[name="name"]').val("");
                    //show notify
                    new PNotify({
                        title: 'Lưu thành công',
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
        $(document).on("click", ".editType", function () {
            var _self = $(this);
            $('.modal-TypeUpdate input[name="name"]').val(_self.data('name'));
            $('.modal-TypeUpdate input[name="id"]').val(_self.data('id'));
        });
    </script>

@endsection


