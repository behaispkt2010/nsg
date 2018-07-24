@extends('layouts.admin')
@section('title', 'Vận chuyển')
@section('pageHeader','Vận chuyển')
@section('detailHeader','Vận chuyển')
@section('new-btn')
    <!-- <a href="{{route('driver.create')}}" class="btn btn-warning btn-fab" title="Tạo mới Tài xế">
        <i class="fa fa-paper-plane material-icons new-btn" aria-hidden="true"></i>
    </a> -->
    <div class="hover-new-btn h-hover">
        <div class="h-report">
            <a href="{!! url('/') !!}/report/export/driver?kho=@if(!empty($_REQUEST['kho'])){{$_REQUEST['kho']}} @endif&name=@if(!empty($_REQUEST['name'])){{$_REQUEST['name']}} @endif" target="_blank" class="btn btn-warning btn-fab" title="Xuất excel Danh sách Tài xế">
                <i class="material-icons">archive</i>
            </a>
        </div>
        <div class="h-help">
            <a href="{{ url('/tro-giup') }}" target="_blank" class="btn btn-warning btn-fab" title="Thông tin trợ giúp">
                <i class="material-icons">help</i>
            </a>
        </div>
        <div class="h-plus">
            <a href="{{route('driver.create')}}" class="btn btn-warning btn-fab" title="Tạo mới Tài xế">
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
                        <div class="col-md-3 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <select id="select-driver" class="form-control" name="kho" data-placeholder="Chọn kho">
                                    @if(!Auth::user()->hasRole('kho'))
                                        <option value="0" >Chọn kho</option>
                                        @foreach($user as $user)
                                            <option value="{{$user->id}}" @if(Request::get('kho')==$user->id) selected @endif>{{$user->name}}</option>
                                        @endforeach
                                    @else
                                        <option value="{{Auth::user()->id}}" selected >{{Auth::user()->name}}</option>
                                    @endif

                                </select>
                            </div>
                            <div class="clear"></div>
                        </div>
                        
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group label-floating">

                                <label class="control-label" for="addon2">Tên tài xế | Số điện thoại</label>

                                <div class="input-group text-center">
                                    <input type="text" id="addon2" class="form-control" name="name" value="{{Request::get('name')}}">
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
                        @if(count($driver) != 0)
                        @foreach($driver as $itemDriver)
                            <div class="col-md-4 col-sm-4 col-xs-12">

                                <div class="well box_1">
                                    
                                    <div id="driver" class="col-sm-12">

                                        <div class="col-xs-12 " style="padding-left: 0px;">
                                            <ul class="list-unstyled " style="font-size: 16px;">
                                                <li class="limitcharacter"><span class="label-box">Tên tài xế:</span>{{ $itemDriver['name_driver'] }}</li>
                                                <li class="limitcharacter"><span class="label-box">Loại xe:</span>{{ $itemDriver['type_driver'] }}</li>
                                                <li class="limitcharacter"><span class="label-box">Số điện thoại:</span>{{ $itemDriver['phone_driver'] }}</li>
                                                <li class="limitcharacter"><span class="label-box">Biển số xe:</span>{{ $itemDriver['number_license_driver'] }}</li>
                                            </ul>
                                        </div>

                                    </div>
                                    <div class="col-sm-12 text-center">
                                        <a href="{{route('driver.edit',['id' => $itemDriver->id])}}"
                                           class="btn btn-raised btn-primary btn-xs">
                                            <i class="fa fa-pencil" aria-hidden="true"></i> Sửa
                                        </a>
                                        <form action="{{route('driver.destroy',['id' => $itemDriver->id])}}" method="post" class="form-delete" style="display: inline">
                                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                                            <input type="text" class="hidden" value="{{$itemDriver->id}}">
                                            {{method_field("DELETE")}}
                                            <a type="submit" class = "btn btn-raised  btn-xs btn-danger" name ="delete_modal" style="display: inline-block"><i class="fa fa-times" aria-hidden="true"></i> Xóa</a>
                                        </form>
                                    </div>
                                    
                                </div>
                            </div>
                        @endforeach
                        <div class="clearfix"></div>
                        <div class="text-center">
                            {{ $driver->appends(array('kho' => Request::get('kho'),'name' => Request::get('name')))->links() }}
                        </div>
                        @else
                        <div>không tìm thấy dữ liệu</div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admin.partial.modal_delete')

@endsection
@section('add_scripts')
            <!-- Datatables -->
    <script src="{{asset('js/selectize.js')}}"></script>        
    <script>
        $('#select-driver').selectize({
            //create: true,
            //sortField: 'text'
        });
    </script>
@endsection

