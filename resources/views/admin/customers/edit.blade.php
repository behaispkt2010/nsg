@extends('layouts.admin')
@section('title', 'khách hàng')
@section('pageHeader','khách hàng')
@section('detailHeader','thông tin')
@section('rightHeader')
    <a href="{{route('customers.create')}}" class="btn btn-raised btn-warning btn-md">
        <i class="fa fa-paper-plane material-icons" aria-hidden="true"></i> Tạo mới
    </a>
@endsection
@section('content')
    <div class="row">
        <br>
        <div class="col-md-12 col-xs-12">
            <!-- Name and Description -->
            <div class="">
                <div class="row">
                    <div class="col-md-6 col-sm-12 col-xs-12 profile_details product-detail">

                        <div class="well box1 info-warehouse" style="min-height: 440px;">
                            <h4 class="text-center">Thông tin khách hàng <i style="float: right"
                                                                                class="fa fa-edit"
                                                                                aria-hidden="true"></i></h4>
                            <ul class="list-unstyled">
                                <li>
                                    <div class="form-group">
                                        <div class="row">
                                            <label for="code" class="col-md-3 col-xs-12 control-label">Mã</label>

                                            <div class="col-md-9 col-xs-12">
                                                <input type="email" disabled class="form-control" id="code"
                                                       placeholder="#000"/>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-group">
                                        <div class="row">
                                            <label for="name" class="col-md-3 col-xs-12 control-label">Tên</label>

                                            <div class="col-md-9 col-xs-12 ">
                                                <input type="text" disabled class="form-control" name="name"/>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-group">
                                        <div class="row">
                                            <label for="name" class="col-md-3 col-xs-12 control-label">Email</label>

                                            <div class="col-md-9 col-xs-12 ">
                                                <input type="text" disabled class="form-control" name="name"/>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-group">
                                        <div class="row">
                                            <label for="name" class="col-md-3 col-xs-12 control-label">SDT</label>

                                            <div class="col-md-9 col-xs-12 ">
                                                <input type="text" disabled class="form-control" name="name"/>
                                            </div>
                                        </div>
                                    </div>
                                </li>



                                <li>
                                    <div class="form-group">
                                        <div class="row">
                                            <label for="name" class="col-md-3 col-xs-12control-label">Cập nhật</label>

                                            <div class="col-md-9 col-xs-12 ">
                                                <div>22/11/2016 23:25</div>
                                            </div>
                                        </div>
                                    </div>
                                </li>

                                <li class="text-right">
                                    <button class="btn-update btn btn-primary btn-raised text-right btn-small"
                                            style="display: none"> Cập nhật
                                    </button>
                                </li>

                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 col-xs-12 profile_details product-detail">

                        <div class="well box1 info-kho" style="min-height: 440px;">
                            <h4 class="text-center">Thông tin bổ sung<i style="float: right"
                                                                                    class="fa fa-edit"
                                                                                    aria-hidden="true"></i></h4>
                            <ul class="list-unstyled">
                                <li>
                                    <div class="form-group">
                                        <div class="row">
                                            <label for="code" class="col-md-3 col-xs-12 control-label">Địa chỉ 1</label>

                                            <div class="col-md-9 col-xs-12 ">
                                                <input type="text" disabled class="form-control" id="code"/>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-group">
                                        <div class="row">
                                            <label for="code" class="col-md-3 col-xs-12 control-label">Địa chỉ 2</label>

                                            <div class="col-md-9 col-xs-12 ">
                                                <input type="text" disabled class="form-control" id="code"/>
                                            </div>
                                        </div>
                                    </div>
                                </li>

                                <li>
                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-md-3 col-xs-12 control-label">Ghi chú</label>

                                            <div class="col-md-9 col-xs-12">
                                                <textarea type="text" disabled class="form-control" id="code"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="text-right">
                                    <button class="btn-update btn btn-primary btn-raised text-right btn-small"
                                            style="display: none"> Cập nhật
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 profile_details product-detail">

                        <div class="well box1 info-kho">
                            <h4 class="text-center">Lịch sử giao dịch </h4>
                            <ul class="list-unstyled">
                                <li>
                                    <div class="form-group">
                                        <div class="row">
                                            <label for="code" class="col-md-4 col-xs-12 control-label">16/11/2016
                                                20:38</label>

                                            <div class="col-md-4 col-xs-12 ">
                                                <a href="">Đơn hàng 1KS93UQX</a>
                                            </div>
                                            <div class="col-md-4 col-xs-12 ">
                                                2.000.000 VNĐ
                                            </div>
                                        </div>
                                    </div>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
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
    <!-- /jQuery Tags Input -->

    <script src="{{asset('js/selectize.js')}}"></script>
    <!-- Select2 -->
    <script>
        $('select').selectize({
            create: true,
            sortField: 'text'
        });
    </script>
    <script>
        $('.info-kho,.info-warehouse').click(function () {
            $(this).find('input').removeAttr('disabled');
            $(this).find('textarea').removeAttr('disabled');
            $(this).find('.btn-update').css('display', 'inline-block');

        });
        /*$('.info-warehouse .fa-edit').click(function(){
            $(this).parent().parent().find('input').removeAttr('disabled');
            $(this).parent().parent().find('.btn-update').css('display','inline-block');
        });
        $('.info-kho .fa-edit').click(function(){
            $(this).parent().parent().parent().parent().find('input').removeAttr('disabled');
            $(this).parent().parent().find('.btn-update').css('display','inline-block');
        });*/
        $('button.btn-update').click(function () {
//            alert("dsds");
//            $(this).closest().find('input').attr('disabled');
//            $('button.btn-update').css('display','none');
        })
    </script>

@endsection