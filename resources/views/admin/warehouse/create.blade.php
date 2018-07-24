@extends('layouts.admin')
@section('title', 'Chủ kho')
@section('pageHeader','Chủ kho')
@section('detailHeader','thông tin')

@section('add_styles')
    <link href="{{asset('css/bootstrap-material-datetimepicker.css')}}" rel="stylesheet">
@endsection
@section('content')
    <br>
    <div class="row">
        <form action="{{route('warehouse.store')}}" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="col-md-12 col-xs-12">
            <!-- Name and Description -->
            <div class="text-right">
            <button type="submit" class="btn-update btn btn-success btn-raised text-right btn-small" > Lưu</button>
            </div>
            <div class="">
                <div class="row">
                    <div class="col-md-6 col-sm-12 col-xs-12 profile_details product-detail">

                        <div class="well box1 info-warehouse" style="min-height: 636px;">
                            <h4 class="text-center">Thông tin người đại diện </h4>
                            <ul class="list-unstyled">
                                <li>
                                    <div class="form-group">
                                        <div class="row">
                                            <label for="code" class="col-md-3 col-xs-12 control-label">Mã</label>

                                            <div class="col-md-9 col-xs-12">
                                                <input type="text"  class="form-control" id="code" disabled  placeholder="#000"/>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-group">
                                        <div class="row">
                                            <label for="name" class="col-md-3 col-xs-12 control-label">Tên</label>

                                            <div class="col-md-9 col-xs-12 ">
                                                <input type="text"  class="form-control" required name="name" value="{{old('name')}}"/>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-group">
                                        <div class="row">
                                            <label for="name" class="col-md-3 col-xs-12 control-label">Email</label>

                                            <div class="col-md-9 col-xs-12 ">
                                                <input type="email" required  class="form-control" name="email" value="{{old('email')}}"/>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-group">
                                        <div class="row">
                                            <label for="name" class="col-md-3 col-xs-12 control-label">Mật khẩu</label>

                                            <div class="col-md-9 col-xs-12 ">
                                                <input type="password"  class="form-control" name="password" value="{{old('password')}}" required minlength="6"/>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-group">
                                        <div class="row">
                                            <label for="name" class="col-md-3 col-xs-12 control-label">SDT</label>

                                            <div class="col-md-9 col-xs-12 ">
                                                <input type="number"  class="form-control" name="phone_number" required value="{{old('sdt')}}"/>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-group">
                                        <div class="row">
                                            <label for="name" class="col-md-3 col-xs-12 control-label" style="margin-top: 16px;">Loại Chủ kho</label>

                                            <div class="col-md-9 col-xs-12 ">
                                                <div class="form-group">
                                                    <select name="user_test" id="user_test" class="form-control">
                                                        <option value="1" selected="selected">Trả Phí</option>
                                                        <option value="2">Dùng thử</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 col-xs-12 profile_details product-detail">

                        <div class="well box1 info-kho" style="min-height: 636px;">
                            <h4 class="text-center">Thông tin Kho / doanh nghiệp </h4>

                            <ul class="list-unstyled">
                                <li>
                                    <div class="form-group">
                                        <div class="row">
                                            <label for="name" class="col-md-4 col-xs-12 control-label" style="margin-top: 16px;">Mô hình kinh doanh</label>

                                            <div class="col-md-8 col-xs-12 ">
                                                <div class="form-group">
                                                    <select name="category_warehouse_id" id="category_warehouse_id" class="form-control">
                                                        @foreach($arrCategoryWarehouse as $itemCategoryWarehouse)
                                                            <option value="{{$itemCategoryWarehouse->id}}">{{$itemCategoryWarehouse->category_warehouse_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-group">
                                        <div class="row">
                                            <label for="code" class="col-md-3 col-xs-12 control-label">Tên DN</label>

                                            <div class="col-md-9 col-xs-12 ">
                                                <input type="text"  class="form-control" name="name_company" value="{{old('name_company')}}"/>
                                            </div>
                                        </div>
                                    </div>
                                </li>

                                <li>
                                    <div class="form-group">
                                        <div class="row">
                                            <label for="code" class="col-md-3 col-xs-12 control-label">Địa chỉ</label>

                                            <div class="col-md-9 col-xs-12 ">
                                                <input type="text" required class="form-control" name="address" value="{{old('address')}}"/>
                                            </div>
                                        </div>
                                    </div>
                                </li>

                                <li>
                                    <div class="form-group">
                                        <div class="row">
                                            <label for="name" class="col-md-3 col-sm-3 control-label">Tỉnh/TP</label>

                                            <div class="col-md-9 col-xs-12">
                                                <div class="form-group">
                                                    <select id="t" class="form-control" required name="province" data-placeholder="Tỉnh/Thành Phố">
                                                        <option value="0"></option>
                                                        @foreach($province as $item)
                                                            <option value="{{$item->provinceid}}">{{$item->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>

                                <li>
                                    <div class="form-group">
                                        <div class="row">
                                            <label for="code" class="col-md-3 col-xs-12 control-label">Người ĐD</label>

                                            <div class="col-md-9 col-xs-12">
                                                <input type="text"  class="form-control" name="ndd" value="{{old('ndd')}}"/>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-group">
                                        <div class="row">
                                            <label for="code" class="col-md-4 col-xs-12 control-label">Thời gian hoạt động</label>
                                            <div class="col-md-8 col-xs-12">
                                                <input type="text" id="date-format" class="form-control" name="time_active" value="{{ old('time_active') }}"/>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-group">
                                        <label class="mb5">Hình ảnh kho/doanh nghiệp</label>
                                        <div class="row">
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
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        </form>
    </div>

    @endsection


    @section('add_scripts')
            <!-- jQuery Tags Input -->
    <script src="{{asset('plugin/jquery.tagsinput/src/jquery.tagsinput.js')}}"></script>
    <script type="text/javascript" src="{{asset('plugin/moment/min/moment-with-locales.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/bootstrap-material-datetimepicker.js')}}"></script>
    <script src="{{asset('js/selectize.js')}}"></script>
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
    <script type="text/javascript">
        $(document).ready(function () {
            $('#date-format').bootstrapMaterialDatePicker
            ({
                format: 'DD/MM/YYYY',
                lang: 'vi',
                time: false,
            });
        });
    </script>
    <!-- /jQuery Tags Input -->

    
    <!-- Select2 -->
    <script>
        $('select').selectize({
            create: true,
            sortField: 'text'
        });
    </script>
    <!-- <script>
        $('#select-kh,#t,#q,.select-payment,#select-product').selectize({});
    </script> -->
@endsection