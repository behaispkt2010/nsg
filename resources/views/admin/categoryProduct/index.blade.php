@extends('layouts.admin')
@section('title', 'Danh sách nhóm sản phẩm ')
@section('pageHeader','Danh sách nhóm sản phẩm ')

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
            <a href="#" data-toggle="modal" data-target=".modal-product-cate" class="btn btn-warning btn-fab" title="Tạo mới Nhóm sản phẩm">
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

                    {{--<div class="clearfix"></div>--}}
                    <div class="row">
                        <div class="col-md-3 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <select id="select-ck" class="form-control" name="kho" data-placeholder="Chọn kho">
                                    <option value="0" >Tất cả kho</option>
                                    @foreach($wareHouses  as $wareHouse)
                                        <option value="{{$wareHouse->id}}" @if(Request::get('kho')==$wareHouse->id) selected @endif>{{$wareHouse->id}}({{$wareHouse->name}})</option>

                                    @endforeach
                                </select>
                            </div>
                            <div class="clear"></div>
                        </div>
                        <div class="col-md-9 col-sm-12 col-xs-12">
                            <div class="form-group label-floating">

                                <label class="control-label" for="addon2">Tên nhóm sản phẩm</label>

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
                        <div class="col-md-12 col-sm-12 col-xs-12 text-center">

                        </div>

                        <div class="clearfix"></div>
                        @if(count($categoryProduct) != 0)

                        @foreach($categoryProduct as $itemCategoryProduct)
                            <div class="col-md-4 col-sm-4 col-xs-12 profile_details product-detail">

                                <div class="well box_1">

                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                            <h2 class="cod text-center title-cate">{{$itemCategoryProduct->name}}</h2>
                                            <div class="col-xs-12 ol-xs-12">
                                                <ul class="list-unstyled">
                                                    <li><span class="label-box">Số sản phẩm:</span> <span class="bold"> {{\App\CategoryProduct::getTonKho($itemCategoryProduct->id,Request::get('kho'))['numproduct']}}</span></li>
                                                    <li><span class="label-box">Số tồn kho:</span> <span class="bold"> {{\App\CategoryProduct::getTonKho($itemCategoryProduct->id,Request::get('kho'))['inventory_num']}}</span></li>
                                                    <li class="limitcharacter"><span class="label-box">Danh mục cha:</span> <span class="bold "> {{\App\CategoryProduct::getNameCateById($itemCategoryProduct->parent)}}</span></li>
                                                </ul>
                                            </div>
                                    </div>

                                    <div class="col-xs-12 text-center">
                                        
                                        <a href="{{url('/category-product').'/'.$itemCategoryProduct->slug}}"
                                           class="btn btn-raised btn-success btn-xs">
                                            <i class="fa fa-eye" aria-hidden="true"></i> Xem
                                        </a>
                                        <a href="#" data-toggle="modal"
                                           data-target=".modal-product-cate-edit"
                                           class="btn btn-raised btn-primary btn-xs" id="edit_cate" data-id="{{$itemCategoryProduct->id}}"
                                           data-name="{{$itemCategoryProduct->name}}" data-parent="{{$itemCategoryProduct->parent}}"
                                           data-note="{{$itemCategoryProduct->note}}" data-cate_code="{{$itemCategoryProduct->cate_code}}">
                                            <i class="fa fa-pencil" aria-hidden="true"></i> sửa
                                        </a>
                                        <form action="{{route('categoryProducts.destroy',['id' => $itemCategoryProduct->id])}}" method="post" class="form-delete" style="display: inline">
                                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                                            <input type="text" class="hidden" value="{{$itemCategoryProduct->id}}">
                                            {{method_field("DELETE")}}
                                            <a type="submit" class = "btn btn-raised  btn-xs btn-danger" name ="delete_modal" style="display: inline-block"><i class="fa fa-trash" aria-hidden="true"></i> Xóa</a>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="clearfix"></div>
                        <div class="text-center">
                            {{ $categoryProduct->appends(array('kho' => Request::get('kho'),'name' => Request::get('name')))->links() }}
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
    <div class="modal fade modal-product-cate" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false"
         data-backdrop="static">
        <div class="modal-dialog modal-product-cate">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title text-center" id="myModalLabel">Thêm nhóm sản phẩm</h4>
                </div>
                <div class="modal-body sroll">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <div class="form-group label-floating">
                            <label class="control-label" for="focusedInput2"> Tên nhóm sản phẩm</label>
                            <input class="form-control" id="focusedInput2" type="text" name="name">
                        </div>
                        <div class="form-group">
                            <select id="select-cate" name="parent" class="form-control" data-placeholder="Chọn Danh mục">
                                <option value="0">Mặc định</option>
                               @foreach($categoryProduct0 as $itemCategoryProduct0)
                                <option value="{{$itemCategoryProduct0->id}}">{{$itemCategoryProduct0->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group ">
                            <label class="control-label" for="focusedInput2">Code Nhóm sản phẩm</label>
                            <input class="form-control" id="focusedInput2" type="text" name="cate_code">
                        </div>

                        <!-- <div class="form-group">
                            <div class="radio">
                                <label>
                                    <input type="radio" checked="checked" value="0" id="optionsRadios1"
                                           name="disable">
                                    Hiển thị
                                </label>
                            </div>

                            <div class="radio">
                                <label>
                                    <input type="radio" value="1" id="optionsRadios2"
                                           name="disable"> Ẩn
                                </label>
                            </div>
                        </div> -->

                        <div class="form-group">
                            <div class="form-group label-floating">
                                <label class="control-label" for="focusedInputnote">Ghi chú</label>
                                <textarea class="form-control" id="focusedInputnote" name="note"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-raised btn-primary" id="create_cate_product">Tạo mới</button>
                </div>
             <div class="loading" style="display: none"><img src="{{url('/images/loading.gif')}}" class="img-reponsive" alt=""></div>
            </div>

        </div>
    </div>



    <div class="modal fade modal-product-cate-edit" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false"
         data-backdrop="static">
        <div class="modal-dialog modal-product-cate-edit">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title text-center" id="myModalLabel">Sửa Nhóm sản phẩm</h4>
                </div>
                <div class="modal-body sroll">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="text" class="hidden" name="id">
                    <div class="form-group">
                        <div class="form-group label-floating">
                            <label class="control-label" for="focusedInput2"> Tên nhóm sản phẩm</label>
                            <input class="form-control" id="focusedInput2" type="text" name="name" value=" ">
                        </div>
                        <div class="form-group">
                            <select id="select-cate" name="parent" class="form-control" data-placeholder="Chọn Danh mục">
                                <option value="0">Mặc định</option>
                                @foreach($categoryProduct0 as $itemCategoryProduct0)
                                    <option value="{{$itemCategoryProduct0->id}}">{{$itemCategoryProduct0->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="focusedInput2">Code Nhóm sản phẩm</label>
                            <input class="form-control" id="focusedInput2" type="text" name="cate_code">
                        </div>

                        <!-- <div class="form-group">
                            <div class="radio">
                                <label>
                                    <input type="radio" checked="checked" value="0" id="optionsRadios1"
                                           name="disable">
                                    Hiển thị
                                </label>
                            </div>

                            <div class="radio">
                                <label>
                                    <input type="radio" value="1" id="optionsRadios2"
                                           name="disable"> Ẩn
                                </label>
                            </div>
                        </div> -->

                        <div class="form-group">
                            <div class="form-group label-floating">
                                <label class="control-label" for="focusedInputnote">Ghi chú</label>
                                <textarea class="form-control" id="focusedInputnote" name="note"> </textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-raised btn-primary" id="edit_cate_product">Lưu</button>
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
        $('#select-ck').selectize({
            create: true,
        });
    </script>
    <script>
        $('#select-cate').selectize({
            create: true,
            sortField: 'text'
        });
    </script>

    <script>
        $('#create_cate_product').on('click', function (e) {
            e.preventDefault();

            var name = $('.modal-product-cate input[name="name"]').val();
            var cate_code = $('.modal-product-cate input[name="cate_code"]').val();
            var parent = $('.modal-product-cate select[name="parent"] :selected').val();
            var note = $('.modal-product-cate textarea[name="note"]').val();
            var _token = $('.modal-product-cate input[name="_token"]').val();
            $('.loading').css('display','block');
            $.ajax({
                type: "POST",
                url: '{{ url('/') }}/admin/categoryProducts/createAjax',
                data: {name: name, cate_code: cate_code, parent: parent, note: note,_token: _token},
                success: function( msg ) {
                    $('.loading').css('display','none');
                    $('.modal-product-cate input[name="name"]').val("");
                    $('.modal-product-cate input[name="cate_code"]').val("");
                    $('.modal-product-cate select[name="parent"]').val(0);
                    $('.modal-product-cate textarea[name="note"]').val("");
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
        $('#edit_cate_product').on('click', function (e) {
            e.preventDefault();

            var name = $('.modal-product-cate-edit input[name="name"]').val();
            var cate_code = $('.modal-product-cate-edit input[name="cate_code"]').val();
            var parent = $('.modal-product-cate-edit select[name="parent"] :selected').val();
            var note = $('.modal-product-cate-edit textarea[name="note"]').val();
            var _token = $('.modal-product-cate-edit input[name="_token"]').val();
            var id = $('.modal-product-cate-edit input[name="id"]').val();

            $('.loading').css('display','block');
            $.ajax({
                type: "POST",
                url: '{{ url('/') }}/admin/categoryProducts/updateAjax',
                data: {name: name, cate_code: cate_code, parent: parent, note: note,_token: _token,id: id},
                success: function( msg ) {
                    $('.loading').css('display','none');
                    $('.modal-product-cate-edit input[name="name"]').val("");
                    $('.modal-product-cate-edit input[name="cate_code"]').val("");
                    $('.modal-product-cate-edit select[name="parent"]').val(0);
                    $('.modal-product-cate-edit textarea[name="note"]').val("");
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
        $(document).on("click", "#edit_cate", function () {
            var _self = $(this);
            $('.modal-product-cate-edit input[name="name"]').val(_self.data('name'));
            $('.modal-product-cate-edit select[name="parent"]').val(_self.data('parent'));
            $('.modal-product-cate-edit textarea[name="note"]').val(_self.data('note'));
            $('.modal-product-cate-edit input[name="cate_code"]').val(_self.data('cate_code'));
            $('.modal-product-cate-edit input[name="id"]').val(_self.data('id'));
        });
    </script>

@endsection


