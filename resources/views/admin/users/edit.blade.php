@extends('layouts.admin')
@section('title', 'User')
@section('pageHeader','user')
@section('detailHeader','user')
@section('add_styles')
    <link href="{{asset('css/bootstrap-material-datetimepicker.css')}}" rel="stylesheet">
@endsection
@section('new-btn')
    <a href="{{route('users.create')}}" data-placement="top" title="" data-original-title="Tạo mới" class="btn btn-warning btn-fab">
        <i class="fa fa-paper-plane material-icons new-btn" aria-hidden="true"></i>
    </a>
@endsection

@section('content')
    <br>
    <div class="row">
        @if((Request::is('admin/users/create')) | (Request::is('admin/staffs/create')) | (Request::is('admin/customers/create')))
            <form action="{{route('users.store')}}" method="POST" enctype="multipart/form-data">
                @else
                    <form action="{{route('users.update',['id' => $id])}}" method="POST" enctype="multipart/form-data">
                        {{ method_field('PUT') }}
                        <input type="hidden" name="id" value="{{$id}}">
                        @endif
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="type_staff" value="@if(Request::is('admin/staffs'))staffs @else users @endif">
                        <div class="col-md-12 col-xs-12" style="top: -27px;">
                            <!-- Name and Description -->
                            <div class="text-right">
                                <button type="submit" class="btn-update btn btn-success btn-raised text-right btn-small"> Lưu</button>
                            </div>
                            <div class="">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12 col-xs-12 profile_details product-detail">

                                        <div class="well box1 info-warehouse" style="min-height: 440px;">
                                            <h4 class="text-center">Thông tin Tài khoản <i style="float: right"
                                                                                            class="fa fa-edit"
                                                                                            aria-hidden="true"></i></h4>
                                            <ul class="list-unstyled">
                                                <li>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <label for="code" class="col-md-3 col-xs-12 control-label">Mã</label>

                                                            <div class="col-md-9 col-xs-12">
                                                                <div  disabled class="form-control" id="code" >@if(!empty($user->id)){{\App\Util::UserCode($user->id)}}@endif</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <label for="name" class="col-md-3 col-xs-12 control-label">Tên</label>

                                                            <div class="col-md-9 col-xs-12 ">
                                                                <input type="text"  class="form-control" name="name" disabled required value="@if(!empty($user->name)){{$user->name}}@else{{old('name')}}@endif"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>

                                                <li>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <label for="name" class="col-md-3 col-xs-12 control-label">SDT</label>

                                                            <div class="col-md-9 col-xs-12 ">
                                                                <input type="number"  class="form-control" disabled  name="phone_number" value="@if(!empty($user->phone_number)){{$user->phone_number}}@else{{old('phone_number')}}@endif"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <label for="name" class="col-md-3 col-xs-12 control-label">Ngày sinh</label>

                                                            <div class="col-md-9 col-xs-12 ">
                                                                <input type="text" id="birthday" class="form-control" disabled  name="birthday" value="@if(!empty($user->birthday)){{$user->birthday}}@else{{old('birthday')}}@endif"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <label for="name" class="col-md-3 col-xs-12 control-label">Địa chỉ</label>
                                                            <div class="col-md-9 col-xs-12 ">
                                                                <input type="text"  class="form-control" disabled name="address" value="@if(!empty($user->address)){{$user->address}}@else{{old('address')}}@endif"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="listselect">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <label for="name" class="col-md-3 col-sm-3 control-label">Tỉnh/TP</label>
                                                            <div class="col-md-9 col-xs-12">
                                                                <div class="form-group">
                                                                    <select id="t" class="form-control" required name="province">
                                                                        <option value="0">Chọn khu vực</option>
                                                                        @foreach($province as $item)
                                                                            <option value="{{$item->provinceid}}" @if (!empty($user->province) && $user->province == $item->provinceid) selected="selected" @endif>{{$item->name}}</option>
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
                                                            <label for="name" class="col-md-3 col-xs-12 control-label">Phân quyền</label>

                                                            <div class="col-md-9 col-xs-12 ">
                                                                <div class="form-group">
                                                                    <select id="select-role" class="form-control"  name="role" data-placeholder="Phân quyền" >
                                                                        @if(Auth::user()->hasRole('admin'))
                                                                            @if (Request::is('admin/customers/create'))
                                                                                <option value="3">Khách hàng</option>  
                                                                            @elseif (Request::is('admin/staffs/create'))
                                                                                <option value="5">Nhân viên</option> 
                                                                            @endif     
                                                                            @foreach($roles as $itemRoles)
                                                                                <option value="{{$itemRoles->id}}" @if(!empty($roleUser))@if($roleUser->role_id==$itemRoles->id) selected @endif @endif>{{$itemRoles->display_name}}</option>
                                                                            @endforeach
                                                                        @elseif (Auth::user()->hasRole('staff'))
                                                                            <option value="5">Nhân viên</option>
                                                                        @elseif (Auth::user()->hasRole('user'))
                                                                            <option value="3">Khách hàng</option>
                                                                        @elseif (Auth::user()->hasRole('company'))
                                                                            <option value="6">Công ty</option>
                                                                        @elseif (Auth::user()->hasRole('kho'))
                                                                            <option value="4">Chủ kho</option>  
                                                                        @endif


                                                                        <!-- @if(!empty($role))
                                                                             @if($role=="staff")
                                                                             <option value="5">Nhân viên</option>
                                                                                 @elseif($role=="customer")
                                                                                 <option value="3">Khách hàng</option>
                                                                             @endif
                                                                         @else
                                                                             @foreach($roles as $itemRoles)
                                                                                 @if($itemRoles->id!=4)
                                                                             <option value="{{$itemRoles->id}}" @if(!empty($roleUser))@if($roleUser->role_id==$itemRoles->id) selected @endif @endif>{{$itemRoles->display_name}}</option>
                                                                             @endif
                                                                                     @endforeach
                                                                         @endif -->


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

                                        <div class="well box1 info-kho" style="min-height: 440px;">
                                            <h4 class="text-center">Thông tin đăng nhập <i style="float: right"
                                                                                           class="fa fa-edit"
                                                                                           aria-hidden="true"></i></h4>
                                            <ul class="list-unstyled">
                                                <li>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <label for="code" class="col-md-3 col-xs-12 control-label">Email</label>

                                                            <div class="col-md-9 col-xs-12 ">
                                                                <input type="email" required class="form-control" id="email" @if((Request::is('admin/users/create')) | (Request::is('admin/staffs/create')) | (Request::is('admin/customers/create'))) @else disabled @endif  name="email" value="@if(!empty($user->email)){{$user->email}}@else{{old('email')}}@endif"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <label for="code" class="col-md-3 col-xs-12 control-label">Mật khẩu</label>

                                                            <div class="col-md-9 col-xs-12 ">
                                                                <input type="password"  class="form-control" id="code" @if((Request::is('admin/users/create')) | (Request::is('admin/staffs/create')) | (Request::is('admin/customers/create'))) @else disabled @endif name="password"  value="{{old('password')}}" required/>
                                                            </div>
                                                            <input id="myIntroCode" type="hidden" class="form-control" name="myIntroCode" value="<?php echo str_random(8) ?>">
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
            </form>
    </div>



    @endsection


    @section('add_scripts')

    <script type="text/javascript" src="{{asset('/js/bootstrap-material-datetimepicker.js')}}"></script>
    <script src="{{asset('js/selectize.js')}}"></script>
    <!-- Select2 -->
    <script>
        $('select').selectize({
            create: true,
            sortField: 'text'
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#birthday').bootstrapMaterialDatePicker
            ({
                format: 'DD/MM/YYYY',
                lang: 'vi',
                time: false,
            });
        });
    </script>
    <script>
        /*$('.fa-edit').click(function(){
            $(this).parent().parent().parent().parent().find('input').removeAttr('disabled');
            $(this).parent().parent().find('.btn-update').css('display','inline-block');
        });*/
        $('.info-kho .fa-edit').click(function(){
            $(this).parent().parent().parent().parent().find('input').removeAttr('disabled');
            $(this).parent().parent().parent().find('.btn-update').css('display','inline-block');
        });
        $('.info-kho .fa-edit, .info-warehouse .fa-edit').click(function () {
            $(this).parent().parent().find('input').removeAttr('disabled');
            $(this).parent().parent().find('textarea').removeAttr('disabled');
            $(this).parent().parent().find('.btn-update').css('display', 'inline-block');

        });
    </script>
@endsection