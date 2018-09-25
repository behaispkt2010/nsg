@extends('layouts.admin')
@section('title', 'User')
@section('pageHeader','user')
@section('detailHeader','user')
@section('add_styles')
    <link href="{{asset('css/bootstrap-material-datetimepicker.css')}}" rel="stylesheet">
@endsection
@section('new-btn')
    <a href="{{route('customers.create')}}" data-placement="top" title="" data-original-title="Tạo mới" class="btn btn-warning btn-fab">
        <i class="fa fa-paper-plane material-icons new-btn" aria-hidden="true"></i>
    </a>
@endsection

@section('content')
    <br>
    <div class="row">
        @if((Request::is('admin/customers/create')))
            <form action="{{route('users.store')}}" method="POST" enctype="multipart/form-data">
                @else
                    <form action="{{route('users.update',['id' => $id])}}" method="POST" enctype="multipart/form-data">
                        {{ method_field('PUT') }}
                        <input type="hidden" name="id" value="{{$id}}">
                        @endif
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="role" value="3"> <!-- role khách hàng -->
                        <div class="col-md-12 col-xs-12" style="top: -27px;">
                            <!-- Name and Description -->
                            <div class="text-right">
                                <button type="submit" class="btn-update btn btn-success btn-raised text-right btn-small"> Lưu</button>
                            </div>
                            <div class="">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12 col-xs-12 profile_details product-detail">
                                        <div class="well box1 info-warehouse" style="min-height: 440px;">
                                            <h4 class="text-center">Thông tin Tài khoản <i style="float: right" class="fa fa-edit" aria-hidden="true"></i></h4>
                                            <ul class="list-unstyled">
                                                <li>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <label for="code" class="col-md-3 col-xs-12 control-label">Mã</label>
                                                            <div class="col-md-9 col-xs-12">
                                                                <div disabled class="form-control" id="code" >@if(!empty($user->code)){{($user->code)}}@endif</div>
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
                                                                <input type="number"  class="form-control" disabled max="9999999999" name="phone_number" value="@if(!empty($user->phone_number)){{$user->phone_number}}@else{{old('phone_number')}}@endif"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <label for="name" class="col-md-3 col-xs-12 control-label">Email</label>
                                                            <div class="col-md-9 col-xs-12 ">
                                                                <input type="email" class="form-control" disabled name="email" value="@if(!empty($user->email)){{$user->email}}@else{{old('email')}}@endif"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <label for="name" class="col-md-3 col-xs-12 control-label">Ngày sinh</label>
                                                            <div class="col-md-9 col-xs-12 ">
                                                                <input type="text" id="birthday" class="form-control" disabled name="birthday" value="@if(!empty($user->birthday)){{$user->birthday}}@else{{old('birthday')}}@endif"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <label for="name" class="col-md-3 col-xs-12 control-label">Địa chỉ</label>
                                                            <div class="col-md-9 col-xs-12 ">
                                                                <input type="text" placeholder="Địa chỉ số nhà, tên đường,..." class="form-control" disabled name="address" value="@if(!empty($user->address)){{$user->address}}@else{{old('address')}}@endif"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <div class="row">
                                                    <input type="hidden" class="provinceID" name="provinceID" value="@if(!empty($user->province)) {{$user->province}} @endif">
                                                    <input type="hidden" class="districtID" name="districtID" value="@if(!empty($user->district)) {{$user->district}} @endif">
                                                    <div class="col-md-6 col-xs-12">
                                                        <div class="form-group">
                                                            <select id="province" class="form-control select2_single" required name="province" >
                                                                <option value="0">Chọn Tỉnh/TP</option>
                                                                @foreach($province as $item)
                                                                    <option value="{{$item->provinceid}}" @if(!empty($user->province) && $user->province == $item->provinceid) selected @endif>{{$item->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                            
                                                    <div class="col-md-6 col-xs-12">
                                                        <div class="form-group">
                                                            <select id="district" class="form-control" required name="district" >
                                                                <option value="0">Chọn Huyện/Thị trấn</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <li>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <label class="mb5">Hình đại diện</label>
                                                                <div class="image-view">
                                                                @if(!empty($user->image))
                                                                    <img src="{{url('/').$user->image}}" alt="" class="img-avatar">
                                                                    <div class="form-group">
                                                                        <div class="col-md-8">
                                                                            <input type="text" readonly="" class="form-control" placeholder="Chọn hình ảnh">
                                                                            <input type="file" name="image" id="inputFile">
                                                                        </div>
                                                                    </div>
                                                                @else
                                                                    <input type="file" style="display:none;" name="image" id="file-6"
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
                                                                        <span></span>
                                                                    </label>
                                                                @endif
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12 col-xs-12 profile_details product-detail">
                                        <div class="well box1 info-kho" style="min-height: 640px;">
                                            <h4 class="text-center">Phân loại khách hàng<i style="float: right" class="fa fa-edit" aria-hidden="true"></i></h4>
                                            <ul class="list-unstyled">
                                                <li>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <label for="code" class="col-md-3 col-xs-12 control-label">Nhóm</label>
                                                            <textarea class="form-control tagType" rows="5" name="tagType" placeholder="Tag cách nhau bằng dấu ','">@if(!empty($user->tagType)){{$user->tagType}}@else{{old('tagType')}}@endif</textarea>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <label for="code" class="col-md-3 col-xs-12 control-label">Ghi chú</label>
                                                            <textarea class="form-control note" rows="5" name="note">@if(!empty($user->note)){{$user->note}}@else{{old('note')}}@endif</textarea>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-xs-12" style="top: -27px;">
                            <div class="">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12 col-xs-12 profile_details product-detail">
                                        <div class="well box1 info-warehouse" style="min-height: 440px;">
                                            <h4 class="text-center">Thông tin hóa đơn <i style="float: right" class="fa fa-edit" aria-hidden="true"></i></h4>
                                            <ul class="list-unstyled">
                                                <li>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <label for="code" class="col-md-3 col-xs-12 control-label">Tên Cty/KH</label>
                                                            <div class="col-md-9 col-xs-12">
                                                                <input type="text" class="form-control" name="invoice_name" disabled required value="@if(!empty($user->invoice_name)){{$user->invoice_name}}@else{{old('invoice_name')}}@endif"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <label for="name" class="col-md-3 col-xs-12 control-label">Mã số thuế</label>
                                                            <div class="col-md-9 col-xs-12 ">
                                                                <input type="text" class="form-control" name="invoice_tax" disabled required value="@if(!empty($user->invoice_tax)){{$user->invoice_tax}}@else{{old('invoice_tax')}}@endif"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <label for="name" class="col-md-3 col-xs-12 control-label">Địa chỉ</label>
                                                            <div class="col-md-9 col-xs-12 ">
                                                                <input type="text" class="form-control" disabled  name="invoice_address" value="@if(!empty($user->invoice_address)){{$user->invoice_address}}@else{{old('invoice_address')}}@endif"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    @if((!Request::is('admin/customers/create')))
                                    <div class="col-md-6 col-sm-12 col-xs-12 profile_details product-detail">
                                        <div class="well box1 info-kho" style="min-height: 440px;">
                                            <h4 class="text-center">Thông tin đơn hàng</h4>
                                            <ul class="list-unstyled">
                                                <li>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <label for="code" class="col-md-4 col-xs-12 control-label">Tổng số đơn hàng</label>
                                                            <div class="col-md-8 col-xs-12">
                                                                <div disabled class="form-control" id="totalOrder">@if(!empty($countOrder)){{($countOrder)}} @else 0 @endif</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <label for="code" class="col-md-4 col-xs-12 control-label">Tổng giá trị</label>
                                                            <div class="col-md-8 col-xs-12">
                                                                <div disabled class="form-control" id="totalPrice">@if(!empty($totalPrice)){{($totalPrice)}} @else 0 @endif</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <label for="code" class="col-md-4 col-xs-12 control-label">KH đang nợ</label>
                                                            <div class="col-md-8 col-xs-12">
                                                                <div disabled class="form-control" id="totalRemain">@if(!empty($totalRemain)){{($totalRemain)}} @else 0 @endif</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    @endif
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
    <script type="text/javascript">
        $('#province').on('change',function(){
            var countryID = $(this).val();
            var _token = $('input[name="_token"]').val();

            if(countryID){
                $.ajax({
                    type:'POST',
                    url:'{{ url("/") }}/admin/orders/AjaxGetDistrictByProvinceID',
                    data: {id: countryID, _token: _token},
                    success:function(html){
                        $('#district').selectize()[0].selectize.destroy();
                        $('#district').html(html);
                        $('#district').selectize(); 
                    }
                }); 
            } else {
                $('#district').html('<option value="">Chọn Huyện/Thị trấn</option>');
            }
        });
        // get update district, provinde
        $(function(){
            var districtID = $('.districtID').val();
            var provinceID = $('.provinceID').val();
            var _token = $('input[name="_token"]').val();
            if(provinceID){
                $.ajax({
                    type:'POST',
                    url:'{{ url("/") }}/admin/orders/AjaxLoadInfoAddress',
                    data: {id: provinceID, type: 'district', valueID: districtID , _token: _token},
                    success:function(html){
                        $('#district').selectize()[0].selectize.destroy();
                        $('#district').html(html);
                        $('#district').selectize();
                    }
                }); 
            } else {
                $('#district').html('<option value="">Chọn Huyện/Thị trấn</option>');
            }
            /*if(districtID){
                $.ajax({
                    type:'POST',
                    url:'{{ url("/") }}/admin/orders/AjaxLoadInfoAddress',
                    data: {id: districtID, type: 'village', valueID: villageID , _token: _token},
                    success:function(html){
                        $('#x').selectize()[0].selectize.destroy();
                        $('#x').html(html);
                        $('#x').selectize();
                    }
                }); 
            } else {
                $('#x').html('<option value="">Chọn Phường/Xã</option>'); 
            }*/
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