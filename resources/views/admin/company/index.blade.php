@extends('layouts.admin')
@section('title', 'Quản lý Chủ kho ')
@section('pageHeader','Quản lý chủ kho ')
@section('detailHeader','danh sách')
@section('new-btn')
    <!-- <a href="{{route('company.create')}}" data-placement="top" title="" data-original-title="Tạo mới" class="btn btn-warning btn-fab" title="Tạo Công ty mới">
        <i class="fa fa-paper-plane material-icons new-btn" aria-hidden="true"></i>
    </a> -->
    <div class="hover-new-btn h-hover">
        <div class="h-report">
            <a href="{!! url('/') !!}/report/export/company?q=@if(!empty($_REQUEST['q'])){{$_REQUEST['q']}} @endif" target="_blank" class="btn btn-warning btn-fab" title="Xuất excel Danh sách Công ty">
                <!-- <i class="fa fa-print material-icons print-btn" aria-hidden="true"></i> -->
                <i class="material-icons">archive</i>
            </a>
        </div>
        <div class="h-help">
            <a href="{{ url('/tro-giup') }}" target="_blank" class="btn btn-warning btn-fab" title="Thông tin trợ giúp">
                <i class="material-icons">help</i>
            </a>
        </div>
        <div class="h-plus">
            <a href="{{route('company.create')}}" class="btn btn-warning btn-fab" title="Tạo mới">
                <i class="material-icons iconPlus">add</i>
                <i class="fa fa-paper-plane material-icons new-btn iconCreate hidden-hover" aria-hidden="true"></i>
            </a>
        </div>
    </div>
@endsection
@section('content')
    <div class="row top-right">

        <form action="" method="GET">
            <div class="x_panel">
                <div class="x_content">
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3 col-sm-12 col-xs-12">
                            <div class="form-group label-floating">

                                <label class="control-label" for="addon2">Tên Công ty | Mã Công Ty | Số điện thoại</label>

                                <div class="input-group text-center">
                                    <input type="text" id="addon2" name="q" class="form-control" value="{{Request::get('q')}}">
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
            </div>
        </form>

    </div>
    <div class="row">

        <div class="col-md-12">
            <div class="">
                <div class="x_content">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                        </div>

                        <div class="clearfix"></div>
                        @if(count($company) != 0)
                        @foreach($company as $itemCompany)
                            <div class="col-md-4 col-sm-4 col-xs-12 profile_details box-detail">
                                <div class="well box_1">
                                    <div class="img-product-view">
                                        <img src="{{url('/')}}/images/1.png" alt="" class="img-circle img-responsive"
                                             data-pin-nopin="true">
                                    </div>
                                    <div class="col-sm-12 ">
                                        <a href="{{route('company.edit',['id' => $itemCompany->company_id])}}">
                                        <h4 class="cod">{{\App\Util::UserCode($itemCompany->userID)}}{{-- {{ $itemCompany->id }}--}}</h4>
                                            <div class="row">
                                        <div class="col-xs-12">
                                            <ul class="list-unstyled">
                                                <li class="limitcharacter"><span style="width: 70px;" class="label-box">Đại diện: </span>{{$itemCompany->name}}</li>
                                                <li>
                                                    <span style="width: 70px;" class="label-box">Dịch vụ:</span>
                                                    @if ($itemCompany->confirm == 1) <img src="{{url('/images')}}/xacthuc.png" alt=""> @endif 
                                                    @if ($itemCompany->quangcao == 1) <img src="{{url('/images')}}/xacthuc.png" alt=""> @endif 
                                                    @if ($itemCompany->user_test == 1) <img src="{{url('/images')}}/xacthuc.png" alt=""> @endif
                                                </li>
                                                <li><span style="width: 70px;" class="label-box">Cấp phép: </span>{{$itemCompany->created_at->format('d/m/Y')}}</li>
                                            </ul>
                                        </div>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-xs-12 text-center">

                                        <a href="{{route('company.edit',['id' => $itemCompany->company_id])}}"
                                           class="btn btn-raised btn-primary btn-xs">
                                            <i class="fa fa-pencil" aria-hidden="true"></i> Chỉnh sửa
                                        </a>

                                        <form action="{{route('company.destroy',['id' => $itemCompany->company_id])}}" method="post" class="form-delete" style="display: inline">
                                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                                            <input type="text" class="hidden" value="{{$itemCompany->company_id}}">
                                            {{method_field("DELETE")}}
                                            <a type="submit" class = "btn btn-raised  btn-xs btn-danger" name ="delete_modal" style="display: inline-block"><i class="fa fa-times" aria-hidden="true"></i> Xóa</a>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="clearfix"></div>
                        <div class="text-center">
                            {{ $company->appends(array('q' => Request::get('q')))->links() }}
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


@endsection
    @section('add_scripts')
            <!-- Datatables -->



@endsection

