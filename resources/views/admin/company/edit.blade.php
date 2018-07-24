@extends('layouts.admin')
@section('title', 'Chủ kho')
@section('pageHeader','Chủ kho')
@section('detailHeader','thông tin')
@section('rightHeader')
    <a href="{{route('company.create')}}" class="btn btn-raised btn-warning btn-md">
        <i class="fa fa-paper-plane" aria-hidden="true"></i> Tạo mới
    </a>
@endsection
@section('content')
@section('add_styles')
    <link href="{{asset('css/bootstrap-material-datetimepicker.css')}}" rel="stylesheet">
@endsection
    <br>
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <!-- Name and Description -->
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="id" value="{{$id}}">
            <input type="hidden" name="user_id" value="{{$userInfo->id}}">

            <div class="">
                <div class="row">
                    <div class="col-md-6 col-sm-12 col-xs-12 profile_details product-detail">

                        <div class="well box1 info-warehouse info-user" style="min-height: 846px; position: relative;">
                            <h4 class="text-center">Thông tin người đại diện <i style="float: right"
                                                                                class="fa fa-edit"
                                                                                aria-hidden="true"></i></h4>
                            <ul class="list-unstyled">
                                <li>
                                    <div class="form-group">
                                        <div class="row">
                                            <label for="code" class="col-md-3 col-xs-12 control-label">Mã</label>

                                            <div class="col-md-9 col-xs-12">
                                                <div  disabled class="form-control" id="code" placeholder="000">{{\App\Util::UserCode($userInfo->id)}}</div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-group">
                                        <div class="row">
                                            <label for="name" class="col-md-3 col-xs-12 control-label">Tên</label>

                                            <div class="col-md-9 col-xs-12 ">
                                                <input type="text" disabled class="form-control" name="name_company" value="{{$userInfo->name}}"/>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-group">
                                        <div class="row">
                                            <label for="name" class="col-md-3 col-xs-12 control-label">Email</label>

                                            <div class="col-md-9 col-xs-12 ">
                                                <input type="email" disabled class="form-control" name="email" value="{{$userInfo->email}}"/>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-group">
                                        <div class="row">
                                            <label for="name" class="col-md-3 col-xs-12 control-label">SDT</label>

                                            <div class="col-md-9 col-xs-12 ">
                                                <input type="number" disabled class="form-control" name="phone_number" value="{{$userInfo->phone_number}}"/>
                                            </div>
                                        </div>
                                    </div>
                                </li>

                                <li>
                                    <div class="form-group">
                                        <div class="row">
                                            <label for="pass" class="col-md-3 col-xs-12 "> Mật khẩu</label>

                                            <div class="col-md-9 col-xs-12">
                                                <a href="" data-toggle="modal"
                                                   data-target=".modal-change-pass"> Thay đổi mật khẩu</a>
                                            </div>
                                        </div>
                                    </div>
                                </li>

                                <li>
                                    <div class="form-group">
                                        <div class="row">
                                            <label for="name" class="col-md-3 col-xs-12 control-label">Cập nhật</label>

                                            <div class="col-md-9 col-xs-12"  style="margin-left: -10px;">
                                                <div class="col-md-9 col-xs-12"><label for="" disabled class="form-control">{{$userInfo->created_at->format('H:m:s - d/m/Y')}}</label></div>
                                            </div>
                                        </div>
                                    </div>
                                </li>

                                <li class="text-right " style="position: absolute;top: 778px;text-align: right;right: 20px;">
                                    <button id="update_info" class="btn-update btn btn-primary btn-raised text-right btn-small" style="display: none"> Cập nhật</button>
                                </li>

                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 col-xs-12 profile_details product-detail">

                        <div class="well box1 info-company" style="min-height: 846px;">
                            <h4 class="text-center">Thông tin Công ty <i style="float: right"
                                                                                    class="fa fa-edit"
                                                                                    aria-hidden="true"></i></h4>
                            <ul class="list-unstyled">
                                
                                <li>
                                    <div class="form-group">
                                        <div class="row">
                                            <label for="code" class="col-md-3 col-xs-12 control-label">Tên DN</label>

                                            <div class="col-md-9 col-xs-12 ">
                                                <input type="text"  class="form-control" disabled name="name" value="{{$company->name}}"/>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-group">
                                        <div class="row">
                                            <label for="code" class="col-md-3 col-xs-12 control-label">Địa chỉ</label>

                                            <div class="col-md-9 col-xs-12 ">
                                                <input type="text"  class="form-control" disabled name="address" value="{{$company->address}}"/>
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
                                                    <select id="provinceCom" class="form-control" required name="province">
                                                        <option value="0">Chọn khu vực</option>
                                                        @foreach($province as $item)
                                                            <option value="{{$item->provinceid}}" @if($company->province == $item->provinceid) selected @endif>{{$item->name}}</option>
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
                                            <label for="code" class="col-md-3 col-xs-12 control-label">MS thuế</label>

                                            <div class="col-md-9 col-xs-12">
                                                <input type="number"  class="form-control" disabled name="mst" value="{{$company->mst}}"/>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-group">
                                        <div class="row">
                                            <label for="code" class="col-md-3 col-xs-12 control-label">Người ĐD</label>

                                            <div class="col-md-9 col-xs-12">
                                                <input type="text"  class="form-control" disabled name="ndd" value="{{$company->ndd}}"/>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-group">
                                        <div class="row">
                                            <label for="name" class="col-md-3 col-xs-12 control-label">Fanpage fb</label>

                                            <div class="col-md-9 col-xs-12">
                                                <input type="text" disabled class="form-control" name="fanpage_fb" value="{{$company->fanpage_fb}}"/>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-group">
                                        <div class="row">
                                            <label for="name" class="col-md-3 col-xs-12 control-label" style="margin-top: 16px;">Loại Công ty</label>
                                            <div class="col-md-9 col-xs-12 ">
                                                <div class="form-group">
                                                    <select name="user_test" id="user_test" class="form-control" @if (Auth::user()->hasRole('com')) disabled @endif>
                                                        <option value="1" @if ($company->user_test == 1)selected="selected" @endif>Trả Phí</option>
                                                        <option value="2" @if ($company->user_test == 2)selected="selected" @endif>Dùng thử</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-group">
                                        <div class="row">
                                            <label for="code" class="col-md-4 col-xs-12 control-label">Thời gian hoạt động</label>
                                
                                            <div class="col-md-8 col-xs-12">
                                                <input type="text" id="date-format" class="form-control" name="time_active" value="@if(!empty($company->time_active)){{$company->time_active}}@else{{old('time_active')}}@endif"/>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-group">
                                        <label class="mb5">Ảnh đại diện</label>

                                        <div class="image-view">
                                            @if(!empty($company->image_company))
                                                <img src="{{url('/').$company->image_company}}" alt="" class="img-responsive" style="height: 169px;border-radius: 5px;">
                                                <div class="form-group">
                                                    <div class="col-md-8">
                                                        <input type="text" readonly="" class="form-control"
                                                               placeholder="Chọn ảnh đại diện">
                                                        <input type="file" name="image_company" id="inputFile">
                                                    </div>
                                                </div>

                                            @else
                                                <input type="file" style="display:none;" name="image_company" id="file-6"
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
                                            @endif
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <button class="btn btn-default btn-raised btn-sm" data-toggle="modal"
                                            data-target=".modal-hinhchitietkho">Thêm nhiều ảnh Công ty</button>
                                </li>
                                <li class="text-right btnCapNhat">
                                    <button id="update_detail" class="btn-update btn btn-primary btn-raised text-right btn-small" style="display: none"> Cập nhật</button>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-12 col-xs-12 profile_details product-detail">

                        <div class="well box1 " style="min-height: 440px; position: relative">
                            <h4 class="text-center">Tài khoản ngân hàng </h4>
                            <ul class="list-unstyled list_bank">
                                <?php $i=0 ;?>
                                @foreach($companyBank as $itemBankcompany)
                                    <?php $i++; ?>
                                <li>
                                    <div class="form-group">

                                        <div class="row">

                                            <label for="code" class="col-md-9 col-xs-12 control-label">   <span class="stt-num">{{$i}}</span> {{$itemBankcompany->card_name}}: {{$itemBankcompany->card_number}}</label>

                                            <div class="col-md-3 col-xs-12 ">
                                                <div class="togglebutton" style="padding-top: 10px;">
                                                    <i data-toggle="modal"
                                                       data-target=".modal-bank-edit"
                                                       class="fa fa-pencil edit_bank" data-id="{{$itemBankcompany->id}}"
                                                       data-bank="{{$itemBankcompany->bank}}" data-province="{{$itemBankcompany->province}}"
                                                       data-card_number="{{$itemBankcompany->card_number}}"data-check="{{$itemBankcompany->check}}"  data-card_name="{{$itemBankcompany->card_name}}" class="fa fa-pencil" {{--style="margin-right: 5px"--}}></i> &nbsp;&nbsp;
                                                    <label style="margin-bottom: -1px;">
                                                        <input style="display: none" name="bankHas"  type="checkbox" @if($itemBankcompany->check==1) checked @endif disabled>
                                                        <input type="hidden" name="bankcheck" value="{{ $itemBankcompany->check }}">
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </li>
                                    @endforeach
                            </ul>
                            <button class="btn-update btn btn-primary btn-raised text-right btn-small btn-new-bank" data-toggle="modal"
                                    data-target=".modal-bank"> Thêm mới</button>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 col-xs-12 profile_details product-detail">

                        <div class="well box1" style="min-height: 440px;">
                            <h4 class="text-center">Gói dịch vụ </h4>
                            <ul class="list-unstyled">
                                <li>

                                    <div class="row">
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-12 control-label"> Xác thực
                                                </label>

                                            <div class="col-md-8 col-xs-12">
                                                @if ($company->confirm == 0)
                                                    @if(Auth::user()->hasRole('com'))
                                                        <button class="btn btn-success btn-raised btn-sm" data-toggle="modal"
                                                                data-target=".modal-service"> Đăng ký</button>
                                                    @else
                                                        <button class="btn btn-success btn-raised btn-sm" data-toggle="modal"
                                                                data-target=".modal-confirmservice"> Đăng ký</button>
                                                    @endif
                                                @endif
                                                <button class="btn btn-info btn-raised btn-sm">
                                                    <a target="_blank" style="color: #fff;" href="{{url('/xac-thuc-kho')}}">Chi tiết</a>
                                                </button>
                                            </div>
                                        </div>
                                    </div>


                                </li>
                                <li>

                                    <div class="row">
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-12 control-label"> Quảng cáo
                                            </label>

                                            <div class="col-md-8 col-xs-12">
                                                @if ($company->quangcao == 0)
                                                    @if(Auth::user()->hasRole('com'))
                                                        <button class="btn btn-success btn-raised btn-sm" data-toggle="modal"
                                                                data-target=".modal-quangcao"> Đăng ký</button>
                                                    @else
                                                        <button class="btn btn-success btn-raised btn-sm" data-toggle="modal"
                                                                data-target=".modal-confirmquangcao"> Đăng ký</button>
                                                    @endif
                                                @endif
                                                <button class="btn btn-info btn-raised btn-sm" >
                                                    <a target="_blank" style="color: #fff;" href="{{url('/quang-cao')}}">Chi tiết</a>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                </li>
                                @if (Auth::user()->hasRole('com'))
                                <li>
                                    <div class="row">
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-12 control-label"> Đăng ký dùng trả phí
                                            </label>

                                            <div class="col-md-8 col-xs-12">
                                                @if ($company->user_test == 2)
                                                    <button class="btn btn-success btn-raised btn-sm" data-toggle="modal"
                                                            data-target=".modal-traphi"> Đăng ký</button>
                                                @endif
                                                <button class="btn btn-info btn-raised btn-sm" >
                                                    <a target="_blank" style="color: #fff;" href="{{url('/tra-phi')}}">Chi tiết</a>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                @endif
                                <!-- <li>
                                
                                    <div class="row">
                                        <div class="form-group">
                                            <label class="col-md-4  col-xs-12 control-label"> Cấp kho : <input type="number" class="form-control" name="levelkho" required min="1" max="3" value="@if(!empty($company->level)){{ $company->level }}" @endif></label>
                                            @if(Auth::user()->hasRole('kho'))
                                            <div class="col-md-8 col-xs-12">
                                                <button class="btn btn-success btn-raised btn-sm" data-toggle="modal"
                                                        data-target=".modal-upgrade"> Nâng cấp</button>
                                            </div>
                                            @else
                                            <div class="col-md-8 col-xs-12">
                                                <button class="btn btn-success btn-raised btn-sm confirmUpgradelevel" data-toggle="modal"
                                                        data-target=".modal-confirmlevel" data-level="{{ $company->level }}" data-timerequest="{{ $company->time_upgrade_level }}" data-timebonus="{{ $company->time_upgrade_bonus }}"> Nâng cấp</button>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </li> -->
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="loading" style="display: none"><img src="{{url('/images/loading.gif')}}" class="img-reponsive" alt=""></div>
    <!-- admin confirm các thông báo -->

    <div class="modal fade modal-confirmservice" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false"
         data-backdrop="static">
        <div class="modal-dialog modal-confirmservice">

            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title text-center" id="myModalLabel">Xác thực Công ty</h4>
                </div>
                <div class="modal-body sroll">
                    <div class="row">
                        <div class="col-md-12">
                            <p>Vui lòng chọn số tháng theo yêu cầu chủ kho</p>
                        </div>
                        <div class="col-md-5 col-xs-12">
                            <div class="form-group">
                                <select id="time_confirm" class="form-control" required name="time_confirm">
                                    <option value="">Chọn số tháng</option>
                                    <option value="6">6 tháng</option>
                                    <option value="12">12 tháng</option>
                                    <option value="24">24 tháng</option>
                                    <option value="36">36 tháng</option>
                                </select>
                            </div>
                        </div>
                        <label for="name" class="col-md-2 col-sm-2 control-label">Tặng thêm:</label>
                        <div class="col-md-5 col-xs-12">
                            <div class="form-group">
                                <select id="time_confirm_bonus" class="form-control" required name="time_confirm_bonus">
                                    <option value="0">Chọn số tháng</option>
                                    <?php for($i = 1; $i<=12 ;$i++){ ?>
                                    <option value="<?php echo $i ?>"><?php echo $i ?> tháng</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-raised btn-default" data-dismiss="modal">Hủy</button>
                    <button type="button" class="btn btn-raised btn-primary btnConfirmKho">Xác nhận</button>
                </div>

                </div>
                <div class="loading" style="display: none"><img src="{{url('/images/loading.gif')}}" class="img-reponsive" alt=""></div>
            </div>
        </div>
    </div>

    <div class="modal fade modal-confirmquangcao" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false"
         data-backdrop="static">
        <div class="modal-dialog modal-confirmquangcao">

            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title text-center" id="myModalLabel">Xác thực quảng cáo</h4>
                </div>
                <div class="modal-body sroll">
                    <div class="row">
                        <div class="col-md-12">
                            <p>Vui lòng chọn số tháng theo yêu cầu chủ kho</p>
                        </div>
                        <div class="col-md-5 col-xs-12">
                            <div class="form-group">
                                <select id="time_quangcao" class="form-control" required name="time_quangcao">
                                    <option value="">Chọn số tháng</option>
                                    <option value="6">6 tháng</option>
                                    <option value="12">12 tháng</option>
                                    <option value="24">24 tháng</option>
                                    <option value="36">36 tháng</option>
                                </select>
                            </div>
                        </div>
                        <label for="name" class="col-md-2 col-sm-2 control-label">Tặng thêm:</label>
                        <div class="col-md-5 col-xs-12">
                            <div class="form-group">
                                <select id="time_quangcao_bonus" class="form-control" required name="time_quangcao_bonus">
                                    <option value="0">Chọn số tháng</option>
                                    <?php for($i = 1; $i<=12 ;$i++){ ?>
                                    <option value="<?php echo $i ?>"><?php echo $i ?> tháng</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-raised btn-default" data-dismiss="modal">Hủy</button>
                    <button type="button" class="btn btn-raised btn-primary btnQuangCao">Xác nhận</button>
                </div>

                </div>
                <div class="loading" style="display: none"><img src="{{url('/images/loading.gif')}}" class="img-reponsive" alt=""></div>
            </div>
        </div>
    </div>

    <!-- <div class="modal fade modal-confirmlevel" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false"
         data-backdrop="static">
        <div class="modal-dialog modal-confirmlevel">
    
            <div class="modal-content">
    
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title text-center" id="myModalLabel">Xác thực nâng cấp kho</h4>
                </div>
                <div class="modal-body sroll">
                    <div class="row">
                        <div class="form-group">
                            <label for="code" class="col-md-3 control-label">Cấp kho: </label>
                            <div class="col-md-4">
                                <input type="number" class="form-control" name="levelkhoUpgrade" required min="1" max="3" value="@if(!empty($company->level)){{ $company->level }} " @endif />
                            </div>
                        </div>
                        <br>
                        <div class="col-md-12">
                            <p>Vui lòng chọn số tháng theo yêu cầu chủ kho</p>
                        </div>
                        <div class="col-md-5 col-xs-12">
                            <div class="form-group">
                                <select id="time_upgrade_level" class="form-control" required name="time_upgrade_level">
                                    <option value="">Chọn số tháng</option>
                                    <option value="6">6 tháng</option>
                                    <option value="12">12 tháng</option>
                                    <option value="24">24 tháng</option>
                                    <option value="36">36 tháng</option>
                                </select>
                            </div>
                        </div>
                        <label for="name" class="col-md-2 col-sm-2 control-label">Tặng thêm:</label>
                        <div class="col-md-5 col-xs-12">
                            <div class="form-group">
                                <select id="time_upgrade_bonus" class="form-control" required name="time_upgrade_bonus">
                                    <option value="0">Chọn số tháng</option>
                                    <?php for($i = 1; $i<=12 ;$i++){ ?>
                                    <option value="<?php echo $i ?>"><?php echo $i ?> tháng</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-raised btn-default" data-dismiss="modal">Hủy</button>
                    <button type="button" class="btn btn-raised btn-primary btnUpgrade">Xác nhận</button>
                </div>
    
                </div>
                <div class="loading" style="display: none"><img src="{{url('/images/loading.gif')}}" class="img-reponsive" alt=""></div>
            </div>
        </div>
    </div> -->


    <div class="modal fade modal-service" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false"
         data-backdrop="static">
        <div class="modal-dialog modal-service">

            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title text-center" id="myModalLabel">Xác thực Công ty</h4>
                </div>
                <div class="modal-body sroll">
                    <div class="row">
                        <div class="col-md-12">
                            <p>Thông tin xác thực sẽ được gửi tới Admin, bạn hãy chọn số tháng cần đăng ký sử dụng dịch vụ:</p>
                        </div>
                        <div class="col-md-5 col-xs-12">
                            <div class="form-group">
                                <select id="time_request_confirm" class="form-control" required name="time_request_confirm">
                                    <option value="">Chọn số tháng</option>
                                    <option value="6">6 tháng</option>
                                    <option value="12">12 tháng</option>
                                    <option value="24">24 tháng</option>
                                    <option value="36">36 tháng</option>
                                </select>
                            </div>
                        </div>  
                          
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-raised btn-default" data-dismiss="modal">Hủy</button>
                    <button type="button" class="btn btn-raised btn-primary btnReQuestConfirm">Xác nhận</button>
                </div>

                </div>
                <div class="loading" style="display: none"><img src="{{url('/images/loading.gif')}}" class="img-reponsive" alt=""></div>
            </div>
        </div>
    </div>

    <div class="modal fade modal-quangcao" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false"
         data-backdrop="static">
        <div class="modal-dialog modal-quangcao">

            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title text-center" id="myModalLabel">Đăng ký quảng cáo </h4>
                </div>
                <div class="modal-body sroll">
                    <div class="row">
                        <div class="col-md-12">
                            <p>Yêu cầu của bạn sẽ được gửi tới Admin, bạn hãy chọn số tháng cần đăng ký sử dụng dịch vụ:</p>
                        </div>
                        <div class="col-md-5 col-xs-12">
                            <div class="form-group">
                                <select id="time_request_quangcao" class="form-control" required name="time_request_quangcao">
                                    <option value="">Chọn số tháng</option>
                                    <option value="6">6 tháng</option>
                                    <option value="12">12 tháng</option>
                                    <option value="24">24 tháng</option>
                                    <option value="36">36 tháng</option>
                                </select>
                            </div>
                        </div>    
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-raised btn-default" data-dismiss="modal">Hủy</button>
                    <button type="button" class="btn btn-raised btn-primary btnReQuestQuangCao">Xác nhận</button>
                </div>

                </div>
                <div class="loading" style="display: none"><img src="{{url('/images/loading.gif')}}" class="img-reponsive" alt=""></div>
            </div>
        </div>
    </div>
    <div class="modal fade modal-hinhchitietkho" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false"
         data-backdrop="static">
        <div class="modal-dialog modal-hinhchitietkho">

            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title text-center" id="myModalLabel">Hình chi tiết Công ty</h4>
                </div>
                <div class="modal-body sroll">
                    <div class="row">
                        <label class="mb5">Hình chi tiết</label>
                        <br>
                        @if(!empty($detailImage))
                            @foreach($detailImage as $itemImage)
                                <div class="filediv" style="display: block;">
                                    <div id="abcd2" class="abcd">
                                        <img class="img-responsive"
                                             id="previewimg{{$itemImage->id}}"
                                             src="{{ url('/').$itemImage->company_image}}" style="height: 169px;border-radius: 5px;">
                                        <i id="img" data-id="{{$itemImage->id}}" class="fa fa-times red delete-img-ajax"></i>
                                    </div>
                                    <br>
                                </div>
                            @endforeach
                        @endif
                        <div class="filediv"><input name="image_detail[]" type="file" id="file"/></div>
                        <br>

                        <input type="button" id="add_more" class="upload btn btn-info btn-raised btn-xs"
                               value="Thêm nhiều hình"/>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-raised btn-primary btnLuuImageKho">Lưu</button>
                </div>

                </div>
            <div class="loading" style="display: none"><img src="{{url('/images/loading.gif')}}" class="img-reponsive" alt=""></div>
            </div>
        </div>
    </div>
    <div class="modal fade modal-traphi" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false"
         data-backdrop="static">
        <div class="modal-dialog modal-traphi">

            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title text-center" id="myModalLabel">Đăng ký dùng trả phí </h4>
                </div>
                <div class="modal-body sroll">
                    <div class="row">
                        <div class="col-md-12">
                            <p>Yêu cầu của bạn sẽ được gửi tới Admin, bạn hãy chọn số tháng cần đăng ký sử dụng dịch vụ:</p>
                        </div>
                        <div class="col-md-5 col-xs-12">
                            <div class="form-group">
                                <select id="month_required" class="form-control" required name="month_required">
                                    <option value="">Chọn số tháng</option>
                                    <option value="6">6 tháng</option>
                                    <option value="12">12 tháng</option>
                                    <option value="24">24 tháng</option>
                                    <option value="36">36 tháng</option>
                                </select>
                            </div>
                        </div>    
                    </div>
                    <br>
                    <div class="row">
                        <div class="form-group">
                            <h2>Thông tin chuyển khoản</h2>
                            <p>Quý khách có thể thanh toán cho chúng tôi bằng cách chuyển khoản trực tiếp tại ngân hàng, chuyển qua thẻ ATM, hoặc qua INTERNET BANKING của các ngân hàng sau:</p>
                            <p style="text-align: justify;">
                                @if (!empty(\App\Setting::getValue('stk1')))
                                    1. Chủ Tài Khoản: {{\App\Setting::getValue('chutk1')}}<br>
                                    Số tài khoản: <span style="font-family: Lucida Sans Unicode,Lucida Grande,sans-serif;"><span style="color:#d40c02"><strong>{{ \App\Setting::getValue('stk1') }}</strong></span></span><br>
                                    Ngân hàng : {{\App\Setting::getValue('chinhanh1')}}</p>
                            @endif
                            <p style="text-align: justify;">
                                @if (!empty(\App\Setting::getValue('stk2')))
                                    2. Chủ Tài Khoản: {{\App\Setting::getValue('chutk2')}}<br>
                                    Số tài khoản: <span style="font-family: Lucida Sans Unicode,Lucida Grande,sans-serif;"><span style="color:#d40c02"><strong>{{ \App\Setting::getValue('stk2') }}</strong></span></span><br>
                                    Ngân hàng : {{\App\Setting::getValue('chinhanh2')}}</p>
                            @endif
                            <span style="color: red; font-size: medium;">Lưu ý: Khi chuyển khoản Công ty sẽ ghi Mã Công ty – Trả phí.  Ví dụ: BC86890KJ – Trả phí</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-raised btn-default" data-dismiss="modal">Hủy</button>
                    <button type="button" class="btn btn-raised btn-primary btnReQuestTraphi">Xác nhận</button>
                </div>

                </div>
                <div class="loading" style="display: none"><img src="{{url('/images/loading.gif')}}" class="img-reponsive" alt=""></div>
            </div>
        </div>
    </div>

    <div class="modal fade modal-change-pass" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false"
         data-backdrop="static">
        <div class="modal-dialog modal-change-pass">

            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title text-center" id="myModalLabel">Thay đổi mật khẩu</h4>
                </div>
                <div class="modal-body sroll">
                                <div class="row">
                                    <div class="form-group">
                                        <label for="code" class="col-md-5 control-label">Mật khẩu hiện tại:</label>
                                        <div class="col-md-7">
                                            <input type="password" class="form-control" name="old_password"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                    <label for="code" class="col-md-5 control-label">Mật khẩu mới:</label>

                                    <div class="col-md-7">
                                        <input type="password" class="form-control" name="new_pass"/>
                                    </div>
                                        </div>
                                    <div class="form-group">
                                        <label for="code" class="col-md-5 control-label">Nhập lại mật khẩu</label>

                                        <div class="col-md-7">
                                            <input type="password" class="form-control" name="renew_pass"/>
                                        </div>
                                    </div>
                                </div>
                </div>
                <div class="modal-footer">
                    <button  id="changePassbtn" type="button" class="btn btn-raised btn-primary">Lưu</button>
                </div>
                <div class="loading" style="display: none"><img src="{{url('/images/loading.gif')}}" class="img-reponsive" alt=""></div>
            </div>
        </div>
    </div>
    <!-- <div class="modal fade modal-upgrade" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false"
         data-backdrop="static">
        <div class="modal-dialog modal-upgrade">
    
            <div class="modal-content">
    
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title text-center" id="myModalLabel">Nâng cấp kho</h4>
                </div>
                <div class="modal-body sroll">
                    <div class="row">
                        <div class="form-group">
                            <label for="code" class="col-md-4 control-label">Cấp kho: </label>
                            <div class="col-md-7 col-xs-8" style="padding-right: 24px;">
                                <input type="number" class="form-control" name="levelkhoUpgrade" required min="1" max="3" value="@if(!empty($company->level)){{ $company->level }} " @endif />
                            </div>
                        </div>
                        <div class="col-md-12 col-xs-12">
                            <div class="form-group">
                                <label for="code" class="control-label" style="float: left;">Thời gian sử dụng dịch vụ: </label>
                                <div class="col-md-7 col-xs-11">
                                    <select id="time_request_upgrade_level" class="form-control" required name="time_request_upgrade_level">
                                        <option value="">Chọn số tháng</option>
                                        <option value="6">6 tháng</option>
                                        <option value="12">12 tháng</option>
                                        <option value="24">24 tháng</option>
                                        <option value="36">36 tháng</option>
                                    </select>
                                </div>
                            </div>
                        </div>    
                    </div>
                    
                    <div class="row">
                        <div class="form-group">
                            <label for="code" class="col-md-5 control-label"><a href="{{url('/nang-cap-kho')}}" target="_blank">Quyền lợi khi nâng cấp kho</a></label>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="form-group">
                            <h2>Thông tin chuyển khoản</h2>
                            <p>Quý khách có thể thanh toán cho chúng tôi bằng cách chuyển khoản trực tiếp tại ngân hàng, chuyển qua thẻ ATM, hoặc qua INTERNET BANKING của các ngân hàng sau:</p>
                            <p style="text-align: justify;">
                            @if (!empty(\App\Setting::getValue('stk1')))
                                1. Chủ Tài Khoản: {{\App\Setting::getValue('chutk1')}}<br>
                                Số tài khoản: <span style="font-family: Lucida Sans Unicode,Lucida Grande,sans-serif;"><span style="color:#d40c02"><strong>{{ \App\Setting::getValue('stk1') }}</strong></span></span><br>
                                    Ngân hàng : {{\App\Setting::getValue('chinhanh1')}}</p>
                            @endif
                            <p style="text-align: justify;">
                            @if (!empty(\App\Setting::getValue('stk2')))
                                2. Chủ Tài Khoản: {{\App\Setting::getValue('chutk2')}}<br>
                                Số tài khoản: <span style="font-family: Lucida Sans Unicode,Lucida Grande,sans-serif;"><span style="color:#d40c02"><strong>{{ \App\Setting::getValue('stk2') }}</strong></span></span><br>
                                Ngân hàng : {{\App\Setting::getValue('chinhanh2')}}</p>
                            @endif
                            <span style="color: red; font-size: medium;">Lưu ý: Khi chuyển khoản chủ kho sẽ ghi Mã kho – Nâng cấp kho – Cấp muốn nâng lên.  Ví dụ: BC86890KJ – Nâng cấp kho – Cấp 3</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button  id="btnSendRequestUpgrade" type="button" class="btn btn-raised btn-primary">Gửi Yêu Cầu</button>
                </div>
                <div class="loading" style="display: none"><img src="{{url('/images/loading.gif')}}" class="img-reponsive" alt=""></div>
            </div>
        </div>
    </div> -->


    <div class="modal fade modal-bank" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false"
         data-backdrop="static">
        <div class="modal-dialog modal-bank">

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title text-center" id="myModalLabel">Tài khoản ngân hàng</h4>
                </div>
                <div class="modal-body">

                    <div class="frm-add">
                        <div class="row">
                            <div class="form-group">
                            <label for="name" class="col-md-4 col-sm-4 control-label">Tên ngân hàng</label>
                            <div class="col-md-8 col-sm-8">
                                <select  data-placeholder="Ngân hàng" class="form-control bank" name="bank">
                                    @foreach($bank as $itemBank)
                                    <option value="{{$itemBank->id}}">{{$itemBank->name}}</option>
                                        @endforeach
                                </select>

                            </div>
                                </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                            <label for="name" class="col-md-4 col-sm-4 control-label">Tỉnh/thành phố</label>
                            <div class="col-md-8 col-sm-8">
                                <select class="form-control province" name="province">
                                    @foreach($province as $itemProvince)
                                        <option value="{{$itemProvince->provinceid}}">{{$itemProvince->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                                </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                            <label  class="col-md-4 col-sm-4 control-label">Số tài khoản</label>
                            <div class="col-md-8 col-sm-8">
                                <input type="text" class="ng-valid ng-dirty ng-touched form-control"required  name="card_number">
                            </div>
                                </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                            <label  class="col-md-4 col-sm-4 control-label">Chủ tài khoản</label>

                            <div class="col-md-8 col-sm-8">
                                <input type="text" class="ng-valid ng-dirty ng-touched form-control card_name" required name="card_name">
                            </div>
                                </div>
                        </div>
                        <div class="row">

                            <div class="form-group">
                                <label  class="col-md-4 col-sm-4 control-label">Kích hoạt</label>
                                <div class="col-md-8 col-sm-8">
                                    <div class="togglebutton">
                                    <label>
                                        <input type="checkbox" name="check" class="checkBank">
                                    </label>
                                    </div>
                            </div>
                        </div>
                            </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="create_bank" type="button" class="btn btn-raised btn-primary">Lưu</button>
                </div>
            </div>
            <div class="loading" style="display: none"><img src="{{url('/images/loading.gif')}}" class="img-reponsive" alt=""></div>
        </div>
    </div>

    <div class="modal fade modal-bank-edit" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false"
         data-backdrop="static">
        <div class="modal-dialog modal-bank-edit">
            <input type="hidden" name="id_bank">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title text-center" id="myModalLabel">Tài khoản ngân hàng</h4>
                </div>
                <div class="modal-body">

                    <div class="frm-add">
                        <div class="row">
                            <div class="form-group">
                                <label for="name" class="col-md-4 col-sm-4 control-label">Tên ngân hàng</label>
                                <div class="col-md-8 col-sm-8">
                                    <select id="bank_select"  data-placeholder="Ngân hàng" class="form-control" name="bank">
                                        @foreach($bank as $itemBank)
                                            <option value="{{$itemBank->id}}">{{$itemBank->name}}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <label for="name" class="col-md-4 col-sm-4 control-label">Tỉnh/thành phố</label>
                                <div class="col-md-8 col-sm-8">
                                    <select class="form-control" name="province">
                                        @foreach($province as $itemProvince)
                                            <option value="{{$itemProvince->provinceid}}">{{$itemProvince->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <label  class="col-md-4 col-sm-4 control-label">Số tài khoản</label>
                                <div class="col-md-8 col-sm-8">
                                    <input type="text" class="ng-valid ng-dirty ng-touched form-control" required  name="card_number">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <label  class="col-md-4 col-sm-4 control-label">Chủ tài khoản</label>

                                <div class="col-md-8 col-sm-8">
                                    <input type="text" class="ng-valid ng-dirty ng-touched form-control card_name" required name="card_name">
                                </div>
                            </div>
                        </div>
                        <div class="row">

                            <div class="form-group">
                                <label  class="col-md-4 col-sm-4 control-label">Kích hoạt</label>
                                <div class="col-md-8 col-sm-8">
                                    <div class="togglebutton">
                                        <label>
                                            <input type="checkbox" name="check" class="checkBank">
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="edit_bank" type="button" class="btn btn-raised btn-primary">Lưu</button>
                </div>
            </div>
            <div class="loading" style="display: none"><img src="{{url('/images/loading.gif')}}" class="img-reponsive" alt=""></div>
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
    <script type="text/javascript" src="{{asset('plugin/moment/min/moment-with-locales.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/bootstrap-material-datetimepicker.js')}}"></script>
    <!-- Select2 -->
    <!-- #provinceCom, #category_company_id, -->
    <script>
        $('#time_upgrade_bonus, #provinceCom, #user_test, #category_company_id, #time_confirm, #time_confirm_bonus, #time_quangcao, #time_quangcao_bonus, #time_request_quangcao, #month_required, #time_request_confirm, .bank, .province').selectize({create: true,});
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
    <script>
        $('.info-warehouse .fa-edit,.info-company .fa-edit').click(function(){
            $(this).parent().parent().find('input').removeAttr('disabled');
            $(this).parent().parent().find('.btn-update').css('display','inline-block');

        })
        $('button.btn-update').click(function(){
//            alert("dsds");
//            $(this).closest().find('input').attr('disabled');
//            $('button.btn-update').css('display','none');
        })
    </script>
    <script>
        $(".card_name").keyup(function () {
            var text = $(this).val();
            var text_change;
            text_change = text.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g, "a").replace(/đ/g, "d").replace(/đ/g, "d").replace(/ỳ|ý|ỵ|ỷ|ỹ/g,"y").replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g,"u").replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ.+/g,"o").replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ.+/g, "e").replace(/ì|í|ị|ỉ|ĩ/g,"i");
            var car_name = text_change.toUpperCase();
            $(".card_name").val(car_name);
        });
    </script>
    <script>
        function CheckBankExist(){
            //console.log($('tr[id*=output_newrow]').length)
            //var testme = false;
            var count = 0;
            $('input[type="hidden"][name="bankcheck"]').each(function() {
                if ($(this).val() == 1) {
                    count++;
                }
            });
            return count;
        }
        /*$(".checkBank").on('click', function () {
            var ware_id = $('input[name="id"]').val();
            var checkbankEx = CheckBankExist();
            if(checkbankEx >= 1){
                alert('Đã có tài khoản đang được sử dụng');
                $('.modal-bank input[name="check"]').prop('checked', false);
                $('.modal-bank-edit input[name="check"]').prop('checked', false);
            }
        });*/
    </script>
    <script>
        $('#update_info').on('click', function (e) {
            e.preventDefault();

            var id = $('input[name="user_id"]').val();
            var name = $('.info-company input[name="name"]').val();
            var email = $('.info-company input[name="email"]').val();
            var phone_number = $('.info-company input[name="phone_number"]').val();
            var _token = $('input[name="_token"]').val();
            $('.loading').css('display','block');
            $.ajax({
                type: "POST",
                url: '{{ url('/') }}/admin/company/AjaxInfo',
                data: {name: name, email: email, phone_number: phone_number,_token: _token,id:id},
                success: function( msg ) {
                    $('.loading').css('display','none');
                    //show notify
                    new PNotify({
                        title: 'Cập nhật thành công',
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
        $('#changePassbtn').on('click', function (e) {
            e.preventDefault();

            var id = $('input[name="user_id"]').val();
            var old_password = $('.modal-change-pass input[name="old_password"]').val();
            var new_pass = $('.modal-change-pass input[name="new_pass"]').val();
            var renew_pass = $('.modal-change-pass input[name="renew_pass"]').val();

            var _token = $('input[name="_token"]').val();
            $('.loading').css('display','block');
            $.ajax({
                type: "POST",
                url: '{{ url('/') }}/admin/company/AjaxChangePass',
                data: {old_password: old_password,new_pass: new_pass,renew_pass: renew_pass,_token: _token,id:id},
                success: function( msg ) {
                    $('.loading').css('display','none');
                    //show notify
                    if(msg['status'] != "danger") {
                        new PNotify({
                            title: 'Cập nhật thành công',
                            text: '',
                            type: 'success',
                            hide: true,
                            styling: 'bootstrap3'
                        });
                        location.reload();
                    }
                    else{
                        new PNotify({
                            title: msg['msg'],
                            text: '',
                            type: msg['status'],
                            hide: true,
                            styling: 'bootstrap3'
                        });


                    }
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
        $('#create_bank').on('click', function (e) {
            e.preventDefault();
            var company_id = $('input[name="id"]').val();
            var bank = $('.modal-bank select[name="bank"] :selected').val();
            var province = $('.modal-bank select[name="province"] :selected').val();
            var card_number = $('.modal-bank input[name="card_number"]').val();
            var card_name = $('.modal-bank input[name="card_name"]').val();
            var check = 0;
            if($('.modal-bank input[name="check"]').is(':checked'))
              var check = 1;
            var _token = $('input[name="_token"]').val();
            $('.loading').css('display','block');
//            alert(check);
            $.ajax({
                type: "POST",
                url: '{{ url('/') }}/admin/company/AjaxBank',
                data: {bank: bank, province: province, card_number: card_number,card_name: card_name,check:check,_token: _token,company_id:company_id},
                success: function( msg ) {
                    $('.loading').css('display','none');
                    //show notify
                    if(msg['status'] != "danger") {
                        new PNotify({
                            title: 'Cập nhật thành công',
                            text: '',
                            type: 'success',
                            hide: true,
                            styling: 'bootstrap3'
                        });
                        location.reload();
                    }
                    else{
                        new PNotify({
                            title: msg['msg'],
                            text: '',
                            type: msg['status'],
                            hide: true,
                            styling: 'bootstrap3'
                        });
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    //show notify
                    var Data = JSON.parse(XMLHttpRequest.responseText);
                    new PNotify({
                        title: 'Lỗi',
                        text: 'Vui lòng điền đầy đủ thông tin',
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
        $('#edit_bank').on('click', function (e) {
            e.preventDefault();
            var ware_id = $('input[name="id"]').val();
            var id_bank = $('input[name="id_bank"]').val();
            var bank = $('.modal-bank-edit select[name="bank"] :selected').val();
            var province = $('.modal-bank-edit select[name="province"] :selected').val();
            var card_number = $('.modal-bank-edit input[name="card_number"]').val();
            var card_name = $('.modal-bank-edit input[name="card_name"]').val();
            var check = 0;
            if($('.modal-bank-edit input[name="check"]').is(':checked'))
                var check = 1;

            if(check=='on'){check=1};
            var _token = $('input[name="_token"]').val();
            $('.loading').css('display','block');
//            alert(check);
            $.ajax({
                type: "POST",
                url: '{{ url('/') }}/admin/company/AjaxEditBank',
                data: {bank: bank, province: province, card_number: card_number,card_name: card_name,check:check,_token: _token,ware_id:ware_id,id_bank:id_bank},
                success: function( msg ) {
                    $('.loading').css('display','none');
                    //show notify
                    if(msg['status'] != "danger") {
                        new PNotify({
                            title: 'Cập nhật thành công',
                            text: '',
                            type: 'success',
                            hide: true,
                            styling: 'bootstrap3'
                        });
                        location.reload();
                    }
                    else{
                        new PNotify({
                            title: msg['msg'],
                            text: '',
                            type: msg['status'],
                            hide: true,
                            styling: 'bootstrap3'
                        });
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    //show notify
                    var Data = JSON.parse(XMLHttpRequest.responseText);
                    new PNotify({
                        title: 'Lỗi',
                        text: 'Vui lòng điền đầy đủ thông tin',
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

        $('#update_detail').on('click', function (e) {
            e.preventDefault();
            var id = $('input[name="id"]').val();
            var user_id = $('input[name="user_id"]').val();
            var name_company = $('.info-company input[name="name_company"]').val();
            var province = $('#province').val();
            var address = $('.info-company input[name="address"]').val();
            var mst = $('.info-company input[name="mst"]').val();
            var ndd = $('.info-company input[name="ndd"]').val();
            var category_company_id = $('#category_company_id').val();
            var time_active = $('.info-company input[name="time_active"]').val();
            var image_company = document.getElementsByName("image_company");
            var fanpage_fb = $('.info-company input[name="fanpage_fb"]').val();
            var file_image_company = image_company[0].files[0];
            //console.log(file_image_company);
            var user_test = $('#user_test').val();
            var _token = $('input[name="_token"]').val();
            
            //alert(province);
            var data1 = new FormData();
            data1.append('name_company', name_company);
            data1.append('category_company_id', category_company_id);
            data1.append('address', address);
            data1.append('mst', mst);
            data1.append('image_company', file_image_company);
            data1.append('province', province);
            data1.append('ndd', ndd);
            data1.append('fanpage_fb', fanpage_fb);
            data1.append('mst', mst);
            data1.append('time_active', time_active);
            data1.append('user_test', user_test);
            data1.append('_token', _token);
            data1.append('id', id);
            data1.append('user_id', user_id);
            $('.loading').css('display','block');
            $.ajax({
                type: "Post",
                contentType: false,       // The content type used when sending data to the server.
                cache: false,             // To unable request pages to be cached
                processData:false,
                url: '{{ url('/') }}/company/AjaxDetail',
                data: data1,
                success: function( msg ) {
                    $('.loading').css('display','none');
                    new PNotify({
                        title: 'Cập nhật thành công',
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
    <script type="text/javascript">
        
        $(".btnConfirmKho").on('click',function(e){
            e.preventDefault();
            var id = $('input[name="id"]').val();
            var user_id = $('input[name="user_id"]').val();
            var _token = $('input[name="_token"]').val();
            var name_company = $('input[name="name_company"]').val();
            var address = $('input[name="address"]').val();
            var mst = $('input[name="mst"]').val();
            var time_confirm = $('#time_confirm').val();
            var time_confirm_bonus = $('#time_confirm_bonus').val();
            var ndd = $('input[name="ndd"]').val();
            var time_active = $('input[name="time_active"]').val();
            if (time_confirm == "") {
                alert("Vui lòng chọn số tháng theo yều cầu Chủ kho");
            }
            else {
                if(name_company == "" || address == "" || time_active == "" || mst == "" || ndd == ""){
                    alert("Vui lòng kiểm tra đầy đủ thông tin Kho")
                } else {
                    $('.loading').css('display', 'block');
                    $.ajax({
                        type: "POST",
                        url: '{{ url('/') }}/admin/company/AjaxConfirmKho',
                        data: {id: id, user_id: user_id, name_company: name_company, address:address, mst:mst,ndd:ndd, time_active:time_active, time_confirm: time_confirm, time_confirm_bonus: time_confirm_bonus, _token: _token},
                        success: function (msg) {
                            $('.loading').css('display', 'none');
                            if(msg['status'] != "danger") {
                                new PNotify({
                                    title: 'Xác nhận kho thành công',
                                    text: '',
                                    type: 'success',
                                    hide: true,
                                    styling: 'bootstrap3'
                                });
                                location.reload();
                            }
                            else {
                                new PNotify({
                                    title: msg['msg'],
                                    text: '',
                                    type: msg['status'],
                                    hide: true,
                                    styling: 'bootstrap3'
                                });
                            }
                        },
                        error: function (XMLHttpRequest, textStatus, errorThrown) {
                            var Data = JSON.parse(XMLHttpRequest.responseText);
                            new PNotify({
                                title: 'Lỗi',
                                text: 'Có lỗi xảy ra! Vui lòng kiểm tra lại thông tin',
                                type: 'danger',
                                hide: true,
                                styling: 'bootstrap3'
                            });
                            $('.loading').css('display', 'none');
                        }
                    });
                }
            }
        });
        $(".btnQuangCao").on('click',function(e){
            e.preventDefault();
            var id = $('input[name="id"]').val();
            var user_id = $('input[name="user_id"]').val();
            var time_quangcao = $('#time_quangcao').val();
            var time_quangcao_bonus = $('#time_quangcao_bonus').val();
            var _token = $('input[name="_token"]').val();
            if (time_quangcao == "") {
                alert("Vui lòng chọn số tháng để đăng ký");
            }
            else {
                $('.loading').css('display','block');
                $.ajax({
                    type: "POST",
                    url: '{{ url('/') }}/admin/company/AjaxQuangCao',
                    data: {id: id,user_id: user_id,time_quangcao: time_quangcao,time_quangcao_bonus: time_quangcao_bonus, _token: _token},
                    success: function( msg ) {
                        $('.loading').css('display','none');
                        //show notify
                        new PNotify({
                            title: 'Cập nhật thành công',
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
                            text: 'Có lỗi xảy ra! Vui lòng kiểm tra lại',
                            type: 'danger',
                            hide: true,
                            styling: 'bootstrap3'
                        });
                        $('.loading').css('display','none');

                    }
                });
            }
        });
    </script>
    <script>
        /*$("#btnSendRequestUpgrade").on('click', function (e) {
            var levelkho = $('.modal-upgrade input[name="levelkhoUpgrade"]').val();
            var time_request_upgrade_level = $('#time_request_upgrade_level').val();
            var _token = $('input[name="_token"]').val();
            if (time_request_upgrade_level == "") {
                alert("Vui lòng chọn số tháng để đăng ký");
            }
            else {
                $('.loading').css('display','block');
                $.ajax({
                    type: "POST",
                    url: '{{ url('/') }}/admin/company/AjaxSendRequestUpdateLevelKho',
                    data: {levelkho: levelkho,time_request_upgrade_level: time_request_upgrade_level, _token: _token},
                    success: function( msg ) {
                        $('.loading').css('display','none');
                        //show notify
                        new PNotify({
                            title: 'Gửi yêu cầu thành công',
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
                            text: 'Cấp kho không được nhỏ hơn 1 hoặc lớn hơn 3',
                            type: 'danger',
                            hide: true,
                            styling: 'bootstrap3'
                        });
                        $('.loading').css('display','none');

                    }
                });
            }
        });*/
        $(".btnReQuestConfirm").on('click', function (e) {
            var name_company = $('input[name="name_company"]').val();
            var address = $('input[name="address"]').val();
            var mst = $('input[name="mst"]').val();
            var ndd = $('input[name="ndd"]').val();
            var time_active = $('input[name="time_active"]').val();
            var _token = $('input[name="_token"]').val();
            var time_request_confirm = $('#time_request_confirm').val();

            if(name_company == "" || address == "" || time_active == "" || mst == "" || ndd == "" || time_request_confirm == ""){
                alert("Vui lòng kiểm tra đầy đủ thông tin Kho hoặc Chọn số tháng cần đăng ký");
            } else {
                $('.loading').css('display','block');
                $.ajax({
                    type: "POST",
                    url: '{{ url('/') }}/admin/company/AjaxReQuestConfirmKho',
                    data: {_token: _token, time_request_confirm: time_request_confirm},
                    success: function (msg) {
                        $('.loading').css('display', 'none');
                        //show notify
                        new PNotify({
                            title: 'Gửi yêu cầu thành công',
                            text: '',
                            type: 'success',
                            hide: true,
                            styling: 'bootstrap3'
                        });
                        location.reload();
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        //show notify
                        var Data = JSON.parse(XMLHttpRequest.responseText);
                        new PNotify({
                            title: 'Lỗi',
                            text: 'Không gửi được yêu cầu',
                            type: 'danger',
                            hide: true,
                            styling: 'bootstrap3'
                        });
                        $('.loading').css('display', 'none');

                    }
                });
            }
        });
        $(".btnReQuestQuangCao").on('click', function (e) {
            var _token = $('input[name="_token"]').val();
            var time_request_quangcao = $('#time_request_quangcao').val();
            if (time_request_quangcao == "") {
                alert("Vui lòng chọn số tháng để đăng ký");
            }
            else {
                $('.loading').css('display', 'block');
                $.ajax({
                    type: "POST",
                    url: '{{ url('/') }}/admin/company/AjaxReQuestQuangCao',
                    data: {_token: _token, time_request_quangcao: time_request_quangcao},
                    success: function (msg) {
                        $('.loading').css('display', 'none');
                        //show notify
                        new PNotify({
                            title: 'Gửi yêu cầu thành công',
                            text: '',
                            type: 'success',
                            hide: true,
                            styling: 'bootstrap3'
                        });
                        location.reload();
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        //show notify
                        var Data = JSON.parse(XMLHttpRequest.responseText);
                        new PNotify({
                            title: 'Lỗi',
                            text: 'Không gửi được yêu cầu',
                            type: 'danger',
                            hide: true,
                            styling: 'bootstrap3'
                        });
                        $('.loading').css('display', 'none');

                    }
                });
            }
        });
        $(".btnReQuestTraphi").on('click', function (e) {
            var _token = $('input[name="_token"]').val();
            $('.loading').css('display','block');
            $.ajax({
                type: "POST",
                url: '{{ url('/') }}/admin/company/AjaxReQuestTraphi',
                data: {_token: _token},
                success: function( msg ) {
                    $('.loading').css('display','none');
                    //show notify
                    new PNotify({
                        title: 'Gửi yêu cầu thành công',
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
                        text: 'Không gửi được yêu cầu',
                        type: 'danger',
                        hide: true,
                        styling: 'bootstrap3'
                    });
                    $('.loading').css('display','none');

                }
            });
        });
        $(".btnLuuImageKho").on('click', function (e) {
            var id = $('input[name="id"]').val();
            var _token = $('input[name="_token"]').val();
            var image_detail = document.getElementsByName("image_detail");
            var data1 = new FormData();

            $.each ($('.modal-hinhchitietkho input[type=file]'), function (i,obj) {
                $.each(obj.files, function (j, file) {
                    console.log(file);
                    data1.append('file[' + i + ']', file);
                })
            });
            $('.loading').css('display','block');

            data1.append('_token', _token);
            data1.append('id', id);
            $.ajax({
                type: "POST",
                contentType: false,
                cache: false,
                processData:false,
                url: '{{ url('/') }}/company/UploadImgDetail',
                data: data1,
                success: function( msg ) {
                    $('.loading').css('display','none');
                    new PNotify({
                        title: 'Lưu hình ảnh thành công.',
                        text: '',
                        type: 'success',
                        hide: true,
                        styling: 'bootstrap3'
                    });
                    // location.reload();
                    $('.modal-hinhchitietkho').modal('hide');
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    var Data = JSON.parse(XMLHttpRequest.responseText);
                    new PNotify({
                        title: 'Lỗi',
                        text: 'Không thể lưu hình ảnh.',
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
    var abc = 0;      // Declaring and defining global increment variable.
    $(document).ready(function () {
//  To add new input file field dynamically, on click of "Add More Files" button below function will be executed.
        $('#add_more').click(function () {
            $(this).before($("<div/>", {
                class: 'filediv'
            }).fadeIn('slow').append($("<input/>", {
                name: 'image_detail[]',
                type: 'file',
                id: 'file'
            }), $("<br>")));
        });
// Following function will executes on change event of file input to select different file.
        $('body').on('change', '#file', function () {
            if (this.files && this.files[0]) {
                abc += 1; // Incrementing global variable by 1.
                var z = abc - 1;
                var x = $(this).parent().find('#previewimg' + z).remove();
                $(this).before("<div id='abcd" + abc + "' class='abcd'><img class='img-responsive' id='previewimg" + abc + "' src=''/></div>");
                var reader = new FileReader();
                reader.onload = imageIsLoaded;
                reader.readAsDataURL(this.files[0]);
                $(this).hide();
                $("#abcd" + abc).append('<i id="img" class="fa fa-times red delete-img"></i>').click(function () {
                    $(this).parent().remove();
                });
            }
        });
// To Preview Image
        function imageIsLoaded(e) {
            $('#previewimg' + abc).attr('src', e.target.result);
        };
        $('#upload').click(function (e) {
            var name = $(":file").val();
            if (!name) {
                alert("First Image Must Be Selected");
                e.preventDefault();
            }
        });
    });
</script>
<script>
    $(document).on('click','.delete-img-ajax',function(e){
        e.preventDefault();
        var _token = $('input[name="_token"]').val();
        var id = $(this).attr('data-id');
        $(this).parent().remove();
        $('.loading').css('display','block');
        $.ajax({
            type: "POST",
            url: '{{url('/')}}/company/deleteDetailImage',
            data: {_token: _token,id: id},
            success: function( msg ) {
                $('.loading').css('display','none');
                //show notify
                new PNotify({
                    title: 'Xóa thành công',
                    text: '',
                    type: 'success',
                    hide: true,
                    styling: 'bootstrap3'
                });
//                    location.reload();
                $('.modal-hinhchitietkho').modal('hide');
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                //show notify
                var Data = JSON.parse(XMLHttpRequest.responseText);
                new PNotify({
                    title: 'Lỗi',
                    text: "Xóa không thành công",
                    type: 'danger',
                    hide: true,
                    styling: 'bootstrap3'
                });
                $('.loading').css('display','none');

            }
        });
    })
</script>

    <script>
        $(document).on('click', '.edit_bank', function () {
            _self = $(this);
            var $bank = $('.modal-bank-edit select[name="bank"]').selectize();
            var $province = $('.modal-bank-edit select[name="province"]').selectize();
            $bank[0].selectize.setValue(_self.data('bank'));
            $province[0].selectize.setValue(_self.data('province'));
            $('.modal-bank-edit input[name="id_bank"]').val(_self.data('id'));
            $('.modal-bank-edit input[name="card_number"]').val(_self.data('card_number'));
            $('.modal-bank-edit input[name="card_name"]').val(_self.data('card_name'));
            if(_self.data('check') == 1) {
                $('.modal-bank-edit input[name="check"]').prop('checked', true);
            }
            else{
                $('.modal-bank-edit input[name="check"]').prop('checked', false);
            }
            /*$('.modal-bank-edit select[name="bank"]')[0].selectize.setValue(_self.data('bank'));
            $('.modal-bank-edit select[name="province"]')[0].selectize.setValue(_self.data('province'));*/
        });
    </script>
    <script>
        /*$(document).on('click', '.confirmUpgradelevel', function () {
            _self = $(this);
            $('.modal-confirmlevel select[name="levelkhoUpgrade"]').val(_self.data('level'));
            $('.modal-confirmlevel select[name="time_upgrade_level"]').val(_self.data('timerequest'));
            $('.modal-confirmlevel select[name="time_upgrade_bonus"]').val(_self.data('timebonus'));
        });*/
    </script>

@endsection