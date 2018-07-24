@extends('layouts.admin')
@section('title', 'Danh sách nhóm tin hỗ trợ ')
@section('pageHeader','Danh sách tin hỗ trợ ')

@section('new-btn')
    <!-- <a href="{{route('help-menu.create')}}" class="btn btn-warning btn-fab" title="Tạo mới Nhóm tin hỗ trợ">
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
            <a href="{{route('help-menu.create')}}" class="btn btn-warning btn-fab" title="Tạo mới Nhóm tin hỗ trợ">
                <i class="material-icons iconPlus">add</i>
                <i class="fa fa-paper-plane material-icons new-btn iconCreate hidden-hover" aria-hidden="true"></i>
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="">
                <div class="x_content">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                        </div>
                        <div class="clearfix"></div>
                        @if(count($helpmenu) != 0)
                        @foreach($helpmenu as $itemHelpMenu)
                            <div class="col-md-4 col-sm-4 col-xs-12 profile_details product-detail">
                                <div class="well box_1">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <h2 class="cod text-center title-cate limitcharacter" title="{{$itemHelpMenu->text}}">{{$itemHelpMenu->text}}</h2>
                                        <div class="col-xs-12 ol-xs-12 text-center">
                                            <ul class="list-unstyled">
                                                <li class="limitcharacter"><span class="label-box">Danh mục cha:</span> <span class="bold "> {{\App\HelpMenu::getHelpMenuById($itemHelpMenu->parent_id)}} </span></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 text-center">
                                        <a href="{{route('help-menu.edit',['id' => $itemHelpMenu->id])}}" 
                                           class="btn btn-raised btn-primary btn-xs">
                                            <i class="fa fa-pencil" aria-hidden="true"></i> sửa
                                        </a>
                                        <form action="{{route('help-menu.destroy',['id' => $itemHelpMenu->id])}}" method="post" class="form-delete" style="display: inline">
                                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                                            <input type="text" class="hidden" value="{{$itemHelpMenu->id}}">
                                            {{method_field("DELETE")}}
                                            <a type="submit" class = "btn btn-raised  btn-xs btn-danger" name ="delete_modal" style="display: inline-block"><i class="fa fa-trash" aria-hidden="true"></i> Xóa</a>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="clearfix"></div>
                        <div class="text-center">
                            {{ $helpmenu->appends(array('q' => Request::get('q')))->links() }}
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
    <div class="modal fade modal-help-menu" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false"
         data-backdrop="static">
        <div class="modal-dialog modal-help-menu">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title text-center" id="myModalLabel">Thêm nhóm tin hỗ trợ</h4>
                </div>
                <div class="modal-body sroll">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <div class="form-group label-floating">
                            <label class="control-label" for="focusedInput2"> Tên nhóm tin hỗ trợ</label>
                            <input class="form-control" id="focusedInput2" type="text" name="text">
                        </div>
                        <div class="form-group">
                            <select id="select-menu" name="parent" class="form-control" data-placeholder="Chọn Danh mục">
                                <option value="0">Mặc định</option>
                               @foreach($helpmenu0 as $itemHelpMenu0)
                                <option value="{{$itemHelpMenu0->id}}">{{$itemHelpMenu0->text}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Nội dung</label>
                            <textarea class="form-control" rows="5"
                                      name="content">@if(!empty($helpmenu->content)){{$helpmenu->content}}@else{{old('content')}}@endif</textarea>
                            <script type="text/javascript">ckeditor('content')</script>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-raised btn-primary" id="create_menu_hotro">Tạo mới</button>
                </div>
             <div class="loading" style="display: none"><img src="{{url('/images/loading.gif')}}" class="img-reponsive" alt=""></div>
            </div>

        </div>
    </div>



    <div class="modal fade modal-help-menu-edit" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false"
         data-backdrop="static">
        <div class="modal-dialog modal-help-menu-edit">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title text-center" id="myModalLabel">Sửa Nhóm tin hỗ trợ</h4>
                </div>
                <div class="modal-body sroll">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="text" class="hidden" name="id">
                    <div class="form-group">
                        <div class="form-group label-floating">
                            <label class="control-label" for="focusedInput2"> Tên nhóm tin hỗ trợ</label>
                            <input class="form-control" id="focusedInput2" type="text" name="text" value=" ">
                        </div>
                        <div class="form-group">
                            <select id="select-menu" name="parent" class="form-control" data-placeholder="Chọn Danh mục">
                                <option value="0">Mặc định</option>
                                @foreach($helpmenu0 as $itemHelpMenu0)
                                    <option value="{{$itemHelpMenu0->id}}">{{$itemHelpMenu0->text}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Nội dung</label>
                            <textarea class="form-control" rows="5"
                                      name="content">@if(!empty($helpmenu->content)){{$helpmenu->content}}@else{{old('content')}}@endif</textarea>
                            <script type="text/javascript">ckeditor('content')</script>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-raised btn-primary" id="edit_menu_hotro">Lưu</button>
                </div>
                <div class="loading" style="display: none"><img src="{{url('/images/loading.gif')}}" class="img-reponsive" alt=""></div>
            </div>

        </div>
    </div>



@endsection

@section('add_scripts')
    <script src="{{asset('js/selectize.js')}}"></script>
    <!-- Select2 -->
    <script>
        $('#select-menu').selectize({
            create: true,
            sortField: 'text'
        });
    </script>

    <script>
        $('#create_menu_hotro').on('click', function (e) {
            e.preventDefault();

            var text = $('.modal-help-menu input[name="text"]').val();
            var content = $('.modal-help-menu textarea[name="content"]').val();
            var parent = $('.modal-help-menu select[name="parent"] :selected').val();
            var _token = $('.modal-help-menu input[name="_token"]').val();
            $('.loading').css('display','block');
            $.ajax({
                type: "POST",
                url: '{{ url('/') }}/admin/help-menu/createAjax',
                data: {text: text, content: content, parent: parent, _token: _token},
                success: function( msg ) {
                    $('.loading').css('display','none');
                    $('.modal-help-menu input[name="text"]').val("");
                    $('.modal-help-menu select[name="parent"]').val(0);
                    new PNotify({
                        title: 'Tạo thành công',
                        text: '',
                        type: 'success',
                        hide: true,
                        styling: 'bootstrap3'
                    });
                    // location.reload();
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
        $('#edit_menu_hotro').on('click', function (e) {
            e.preventDefault();

            var text = $('.modal-help-menu-edit input[name="text"]').val();
            var content = $('.modal-help-menu-edit textarea[name="content"]').val();
            var parent = $('.modal-help-menu-edit select[name="parent"] :selected').val();
            var _token = $('.modal-help-menu-edit input[name="_token"]').val();
            var id = $('.modal-help-menu-edit input[name="id"]').val();

            $('.loading').css('display','block');
            $.ajax({
                type: "POST",
                url: '{{ url('/') }}/admin/help-menu/updateAjax',
                data: {text: text,content: content, parent: parent, _token: _token, id: id},
                success: function( msg ) {
                    $('.loading').css('display','none');
                    $('.modal-help-menu-edit input[name="text"]').val("");
                    $('.modal-help-menu-edit select[name="parent"]').val(0);
                    //show notify
                    new PNotify({
                        title: 'Lưu thành công',
                        text: '',
                        type: 'success',
                        hide: true,
                        styling: 'bootstrap3'
                    });
                    // location.reload();
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
        $(document).on("click", "#edit_menu", function () {
            var _self = $(this);
            $('.modal-help-menu-edit input[name="text"]').val(_self.data('text'));
            $('.modal-help-menu-edit input[name="content"]').val(_self.data('content'));
            $('.modal-help-menu-edit select[name="parent"]').val(_self.data('parent'));
            $('.modal-help-menu-edit input[name="id"]').val(_self.data('id'));
        });
    </script>

@endsection


