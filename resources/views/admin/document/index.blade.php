@extends('layouts.admin')
@section('title', 'Thông tin giá cả')
@section('pageHeader','Thông tin giá cả')
@section('detailHeader','danh sách')
@section('new-btn')
    <!-- <a href="{{route('news.create')}}" class="btn btn-warning btn-fab" title="Tạo mới Tin tức">
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
            <a href="#" data-toggle="modal" data-target=".modal-document" class="btn btn-warning btn-fab" title="Tạo mới Thông tin về giá">
                <i class="material-icons iconPlus">add</i>
                <i class="fa fa-paper-plane material-icons new-btn iconCreate hidden-hover" aria-hidden="true"></i>
            </a>
        </div>
    </div>
    @endsection
@section('add_styles')
        <!-- Datatables -->
<link href="{{asset('plugin/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
<link href="{{asset('plugin/datatables.net-buttons-bs/css/buttons.bootstrap.min.css')}}" rel="stylesheet">
<link href="{{asset('plugin/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet">
<link href="{{asset('plugin/datatables.net-responsive-bs/css/responsive.bootstrap.min.css')}}" rel="stylesheet">
<link href="{{asset('plugin/datatables.net-scroller-bs/css/scroller.bootstrap.min.css')}}" rel="stylesheet">

    @endsection
@section('content')
    <br>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <!-- Name and Description -->
        </div>
    </div>
    <div class="x_panel">
        <table id="table" class="table table-striped table-hover table-bordered bulk_action" data-form="deleteForm">
            <thead>
            <tr>
                <th>Tên Tài liệu</th>
                <th>Tác giả</th>
                <th>Mô tả</th>
                <th>Link</th>
                <th width="50px"></th>
            </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
    @include('admin.partial.modal_delete')
    <div class="modal fade modal-document" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title text-center" id="myModalLabel">Thêm Tài liệu</h4>
                </div>
                <div class="modal-body sroll">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <div class="form-group label-floating">
                            <label class="control-label" for="focusedInput2"> Tên Tài liệu</label>
                            <input class="form-control" id="focusedInput2" type="text" name="name">
                        </div>
                        <div class="form-group label-floating">
                            <label class="control-label" for="focusedInput2"> Mô tả</label>
                            <input class="form-control" id="focusedInput2" type="text" name="description">
                        </div>
                        <div class="form-group">
                            <div class="form-group label-floating">
                                <label class="control-label" for="focusedInputnote">Link</label>
                                <input class="form-control" id="focusedInput2" type="text" name="link">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-group label-floating">
                                <label class="control-label" for="focusedInputnote">Tác giả</label>
                                <input class="form-control" id="focusedInput2" type="text" name="author">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-raised btn-primary" id="create_document">Tạo mới</button>
                </div>
             <div class="loading" style="display: none"><img src="{{url('/images/loading.gif')}}" class="img-reponsive" alt=""></div>
            </div>

        </div>
    </div>
    <div class="modal fade modal-document_edit" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-document_edit">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title text-center" id="myModalLabel">Sửa Tài liệu</h4>
                </div>
                <div class="modal-body sroll">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="text" class="hidden" name="id">
                    <div class="form-group">
                        <div class="form-group">
                            <label class="control-label" for="focusedInput2"> Tên Tài liệu</label>
                            <input class="form-control" id="focusedInput2" type="text" name="name">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="focusedInput2"> Mô tả</label>
                            <input class="form-control" id="focusedInput2" type="text" name="description">
                        </div>
                        <div class="form-group">
                            <div class="form-group">
                                <label class="control-label" for="focusedInputnote"> Link</label>
                                <input class="form-control" id="focusedInput2" type="text" name="link">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-group">
                                <label class="control-label" for="focusedInputnote"> Tác giả</label>
                                <input class="form-control" id="focusedInput2" type="text" name="author">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-raised btn-primary" id="edit_document">Cập nhật</button>
                </div>
             <div class="loading" style="display: none"><img src="{{url('/images/loading.gif')}}" class="img-reponsive" alt=""></div>
            </div>

        </div>
    </div>

@endsection

@section('add_scripts')
        <!-- Datatables -->
    <script src="{{asset('plugin/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('plugin/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{asset('plugin/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('plugin/datatables.net-buttons-bs/js/buttons.bootstrap.min.js')}}"></script>
    <script src="{{asset('plugin/datatables.net-buttons/js/buttons.flash.min.js')}}"></script>
    <script src="{{asset('plugin/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('plugin/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
    <script src="{{asset('plugin/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js')}}"></script>
    <script src="{{asset('plugin/datatables.net-keytable/js/dataTables.keyTable.min.js')}}"></script>
    <script src="{{asset('plugin/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('plugin/datatables.net-responsive-bs/js/responsive.bootstrap.js')}}"></script>
    <script src="{{asset('plugin/datatables.net-scroller/js/datatables.scroller.min.js')}}"></script>
    <script src="{{asset('plugin/jszip/dist/jszip.min.js')}}"></script>
    <script src="{{asset('plugin/pdfmake/build/pdfmake.min.js')}}"></script>
    <script src="{{asset('plugin/pdfmake/build/vfs_fonts.js')}}"></script>



    <script type="text/javascript">
                @if(isset($type))
                var oTable;
        $(document).ready(function () {
            oTable = $('#table').DataTable({
                "language": {
                    "url": "/plugin/datatable-lang/Vietnamese.json"
                },
                "processing": true,
                "serverSide": true,
                "responsive": true,
                "order": [],
                "aoColumnDefs" : [ {
                    'bSortable' : false,
                    'aTargets' : [ 4 ]
                } ],
                "ajax": "{{ url('admin/'.$type.'/data/json') }}",
            });
        });
        @endif
    </script>
    <script>
        $(document).on("click", "#document_edit_modal", function () {
            var _self = $(this);
            $('.modal-document_edit input[name="name"]').val(_self.data('name'));
            $('.modal-document_edit input[name="link"]').val(_self.data('link'));
            $('.modal-document_edit input[name="description"]').val(_self.data('description'));
            $('.modal-document_edit input[name="author"]').val(_self.data('author'));
            $('.modal-document_edit input[name="id"]').val(_self.data('id'));
        });
    </script>
    <script>
        $('.close').on('click', function(){
            location.reload();
        });
    </script>
    <script>
        $('#create_document').on('click', function (e) {
            e.preventDefault();

            var name = $('.modal-document input[name="name"]').val();
            var link = $('.modal-document input[name="link"]').val();
            var description = $('.modal-document input[name="description"]').val();
            var author = $('.modal-document input[name="author"]').val();
            var _token = $('.modal-document input[name="_token"]').val();
            $('.loading').css('display','block');
            $.ajax({
                type: "POST",
                url: '{{ url('/') }}/admin/document/AjaxCreateDocument',
                data: {name: name, link: link, description: description, author: author, _token: _token},
                success: function( msg ) {
                    $('.loading').css('display','none');
                    $('.modal-document input[name="name"]').val("");
                    $('.modal-document input[name="link"]').val("");
                    $('.modal-document input[name="description"]').val("");
                    $('.modal-document input[name="author"]').val("");
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
        $('#edit_document').on('click', function (e) {
            e.preventDefault();
            var name = $('.modal-document_edit input[name="name"]').val();
            var link = $('.modal-document_edit input[name="link"]').val();
            var description = $('.modal-document_edit input[name="description"]').val();
            var author = $('.modal-document_edit input[name="author"]').val();
            var _token = $('.modal-document_edit input[name="_token"]').val();
            var id = $('.modal-document_edit input[name="id"]').val();
            $('.loading').css('display','block');
            $.ajax({
                type: "POST",
                url: '{{ url('/') }}/admin/document/AjaxUpdateDocument',
                data: {name: name, link: link, description: description, author: author, _token: _token,id: id},
                success: function( msg ) {
                    $('.loading').css('display','none');
                    $('.modal-document_edit input[name="name"]').val("");
                    $('.modal-document_edit input[name="link"]').val("");
                    $('.modal-document_edit input[name="description"]').val("");
                    $('.modal-document_edit input[name="author"]').val("");
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
@endsection

