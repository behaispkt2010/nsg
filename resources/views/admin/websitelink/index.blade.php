@extends('layouts.admin')
@section('title', 'Liên kết Website')
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
            <a href="#" data-toggle="modal" data-target=".modal-pricing" class="btn btn-warning btn-fab" title="Tạo mới Thông tin về giá">
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
                <th>Tên Website</th>
                <th>URL</th>
                <th>Logo</th>
                <th width="50px"></th>
            </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
    @include('admin.partial.modal_delete')
    <div class="modal fade modal-pricing" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-pricing">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title text-center" id="myModalLabel">Thêm Liên kết Website</h4>
                </div>
                <div class="modal-body sroll">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <div class="form-group label-floating">
                            <label class="control-label" for="focusedInput2"> Tên Website</label>
                            <input class="form-control" id="focusedInput2" type="text" name="product_name">
                        </div>
                        <div class="form-group label-floating">
                            <label class="control-label" for="focusedInput2"> URL</label>
                            <input class="form-control" id="focusedInput2" type="text" name="price_new">
                        </div>
                        <div class="form-group">
                            <div class="form-group label-floating">
                                <label class="control-label" for="focusedInputnote">Logo</label>
                                <!-- <div class="row">
                                            <input type="file" style="display:none;" name="image_kho" id="file-6"
                                                   class="inputfile inputfile-5"
                                                   data-multiple-caption="{count} files selected"/>
                                            <label class="file-view" for="file-6">
                                                <figure>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                         height="17"
                                                         viewBox="0 0 20 17">
                                                        <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/>
                                                    </svg>
                                                </figure>
                                                <span></span></label>
                                        </div> -->
                                <input class="form-control" id="focusedInput2" type="text" name="source">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-raised btn-primary" id="create_pricing">Tạo mới</button>
                </div>
             <div class="loading" style="display: none"><img src="{{url('/images/loading.gif')}}" class="img-reponsive" alt=""></div>
            </div>

        </div>
    </div>
    <div class="modal fade modal-pricing_edit" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-pricing_edit">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title text-center" id="myModalLabel">Sửa Thông tin Website</h4>
                </div>
                <div class="modal-body sroll">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="text" class="hidden" name="id">
                    <div class="form-group">
                        <div class="form-group">
                            <label class="control-label" for="focusedInput2"> Tên Website</label>
                            <input class="form-control" id="focusedInput2" type="text" name="product_name">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="focusedInput2"> URL</label>
                            <input class="form-control" id="focusedInput2" type="text" name="price_new">
                        </div>
                        <div class="form-group">
                            <div class="form-group">
                                <label class="control-label" for="focusedInputnote">Logo</label>
                                @if(!empty($product->image))
                                    <img src="{{url('/').$product->image}}" alt="" class="img-responsive">
                                    <div class="form-group">
                                        {{--<label for="inputFile" class="col-md-4 control-label">Thay
                                            đổi</label>--}}

                                        <div class="col-md-8">
                                            <input type="text" readonly="" class="form-control"
                                                   placeholder="Chọn hình ảnh">
                                            <input type="file" name="image" id="inputFile">
                                        </div>
                                    </div>
                                    <input class="form-control" id="focusedInput2" type="text" name="source">
                                @else
                                <input class="form-control" id="focusedInput2" type="text" name="source">
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-raised btn-primary" id="edit_pricing">Cập nhật</button>
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
                /*"aoColumnDefs" : [ {
                    'bSortable' : false,
                    'aTargets' : [ 4 ]
                } ],*/
                "ajax": "{{ url('admin/'.$type.'/data/json') }}",
            });
        });
        @endif
    </script>
    <script>
        $(document).on("click", "#pricing_edit_modal", function () {
            var _self = $(this);
            $('.modal-pricing_edit input[name="product_name"]').val(_self.data('website_name'));
            $('.modal-pricing_edit input[name="price_new"]').val(_self.data('website_url'));
            $('.modal-pricing_edit input[name="source"]').val(_self.data('website_image'));
            $('.modal-pricing_edit input[name="id"]').val(_self.data('id'));
        });
    </script>
    <script>
        $('.close').on('click', function(){
            location.reload();
        });
    </script>
    <script>
        $('#create_pricing').on('click', function (e) {
            e.preventDefault();

            var website_name = $('.modal-pricing input[name="product_name"]').val();
            var website_url = $('.modal-pricing input[name="price_new"]').val();
            var website_image = $('.modal-pricing input[name="source"]').val();
            var _token = $('.modal-pricing input[name="_token"]').val();
            $('.loading').css('display','block');
            $.ajax({
                type: "POST",
                url: '{{ url('/') }}/admin/websitelink/AjaxCreateWebsiteLink',
                data: {website_name: website_name, website_url: website_url, website_image: website_image, _token: _token},
                success: function( msg ) {
                    $('.loading').css('display','none');
                    $('.modal-pricing input[name="product_name"]').val("");
                    $('.modal-pricing input[name="price_new"]').val("");
                    $('.modal-pricing input[name="source"]').val("");
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
        $('#edit_pricing').on('click', function (e) {
            e.preventDefault();
            var website_name = $('.modal-pricing_edit input[name="product_name"]').val();
            var website_url = $('.modal-pricing_edit input[name="price_new"]').val();
            var website_image = $('.modal-pricing_edit input[name="source"]').val();
            var _token = $('.modal-pricing_edit input[name="_token"]').val();
            var id = $('.modal-pricing_edit input[name="id"]').val();
            $('.loading').css('display','block');
            $.ajax({
                type: "POST",
                url: '{{ url('/') }}/admin/websitelink/AjaxUpdateWebsiteLink',
                data: {website_name: website_name, website_url: website_url, website_image: website_image, _token: _token,id: id},
                success: function( msg ) {
                    $('.loading').css('display','none');
                    $('.modal-pricing_edit input[name="product_name"]').val("");
                    $('.modal-pricing_edit input[name="price_new"]').val("");
                    $('.modal-pricing_edit input[name="source"]').val("");
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

