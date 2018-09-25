@extends('layouts.admin')
@section('title', 'Vận chuyển')
@section('pageHeader','Vận chuyển')
@section('detailHeader','Thêm thông tin vận chuyển')
@section('content')
    <br>
    <div class="row">
        @if(Request::is('admin/driver/create'))
            <form action="{{route('driver.store')}}" method="POST" enctype="multipart/form-data">
                @else
                    <form action="{{route('driver.update',['id' => $id])}}" method="POST" enctype="multipart/form-data">
                        {{ method_field('PUT') }}
                        <input type="hidden" name="id" value="{{$id}}">
                        @endif
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="text-right">
                            <a href="{{route('driver.index')}}" type="submit"
                               class="btn btn-raised btn-primary">Hủy</a>
                            <button type="submit" class="btn btn-raised btn-success">Lưu</button>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="x_panel">
                                <fieldset>
                                    <legend>Thông tin tài xế</legend>
                                    <div class="form-group">
                                        <label>Tên tài xế</label>
                                        <input type="text" name="name_driver" class="form-control" id="name_driver" required 
                                                value="@if(!empty($driver->name_driver)){{$driver->name_driver}}@else{{old('name_driver')}}@endif">
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                            <label>Số điện thoại 1</label>
                                            <input type="text" name="phone_driver" class="form-control" id="phone_driver" required 
                                                    value="@if(!empty($driver->phone_driver)){{$driver->phone_driver}}@else{{old('phone_driver')}}@endif">
                                        </div>
                                        <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                            <label>Số điện thoại 2</label>
                                            <input type="text" name="phone_driver2" class="form-control" id="phone_driver2" value="@if(!empty($driver->phone_driver2)){{$driver->phone_driver2}}@else{{old('phone_driver2')}}@endif">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" name="email" class="form-control" id="email" value="@if(!empty($driver->email)){{$driver->email}}@else{{old('email')}}@endif">
                                    </div>
                                    <div class="form-group">
                                        <label>Địa chỉ</label>
                                        <input type="text" name="address" class="form-control" id="address" required value="@if(!empty($driver->address)){{$driver->address}}@else{{old('address')}}@endif">
                                    </div>
                                    <div class="row">
                                        <input type="hidden" class="provinceID" name="provinceID" value="@if(!empty($driver->province)) {{$driver->province}} @endif">
                                        <input type="hidden" class="districtID" name="districtID" value="@if(!empty($driver->district)) {{$driver->district}} @endif">
                                        <div class="col-md-6 col-xs-12">
                                            <div class="form-group">
                                                <select id="province" class="form-control select2_single"  name="province" >
                                                    <option value="0">Chọn Tỉnh/TP</option>
                                                    @foreach($province as $item)
                                                        <option value="{{$item->provinceid}}" @if(!empty($driver->province) && $driver->province == $item->provinceid) selected @endif>{{$item->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-xs-12">
                                            <div class="form-group">
                                                <select id="district" class="form-control"  name="district" >
                                                    <option value="0">Chọn Huyện/Thị trấn</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Số CMND</label>
                                        <input type="text" name="identity" class="form-control" id="identity" value="@if(!empty($driver->identity)){{$driver->identity}}@else{{old('identity')}}@endif">
                                    </div>
                                    <div class="form-group">
                                        <label>Ảnh CMND</label>
                                        <div class="image-view">
                                            @if(!empty($driver->image_identity))
                                                <img src="{{url('/').$driver->image_identity}}" alt="" class="img-avatar">
                                                <div class="form-group">
                                                    <div class="col-md-8">
                                                        <input type="text" readonly="" class="form-control" placeholder="Chọn hình ảnh">
                                                        <input type="file" name="image_identity" id="inputFile">
                                                    </div>
                                                </div>
                                            @else
                                                <input type="file" style="display:none;" name="image_identity" id="file-6"
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
                                </fieldset>
                            </div>    
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="x_panel">
                                <fieldset>
                                    <legend>Thông tin xe</legend>
                                    <div class="form-group">
                                        <label>Hãng xe</label>
                                        <select id="carmarker" name="carmarker" class="form-control carmarker" data-placeholder="Chọn hãng xe">
                                            @foreach($cartype as $item)
                                                <option value="{{$item->id}}" @if(!empty($driver->carmarker) && ($driver->carmarker == $item->id)) selected='selected' @endif>{{$item->name}}</option>
                                            @endforeach 
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Loại xe</label>
                                        <select id="type_driver" name="type_driver" class="form-control type_driver" data-placeholder="Chọn Loại xe">
                                            @foreach($transport as $item)
                                                <option value="{{$item->id}}" @if(!empty($driver->type_driver) && ($driver->type_driver == $item->id)) selected='selected' @endif>{{$item->name}}</option>
                                            @endforeach 
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Biển số xe</label>
                                        <input type="text" name="number_license_driver" class="form-control" id="number_license_driver" required 
                                                value="@if(!empty($driver->number_license_driver)){{$driver->number_license_driver}}@else{{old('number_license_driver')}}@endif">
                                    </div>
                                    <div class="form-group">
                                        <label>Hình ảnh xe</label>
                                        <div class="image-view">
                                            @if(!empty($driver->image_car))
                                                <img src="{{url('/').$driver->image_car}}" alt="" class="img-avatar">
                                                <div class="form-group">
                                                    <div class="col-md-8">
                                                        <input type="text" readonly="" class="form-control" placeholder="Chọn hình ảnh">
                                                        <input type="file" name="image_car" id="inputFile">
                                                    </div>
                                                </div>
                                            @else
                                                <input type="file" style="display:none;"  name="image_car" id="file-7"
                                                       class="inputfile inputfile-5"
                                                       data-multiple-caption="{count} files selected"/>
                                                <label class="file-view" for="file-7">
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
                                </fieldset>
                            </div>    
                        </div>
                    </form>
    </div>

@endsection

@section('add_scripts')
<script src="{{asset('js/selectize.js')}}"></script>
<script>
    $('#type_driver, #province, #district, #carmarker').selectize({});
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
    });
</script>

@endsection