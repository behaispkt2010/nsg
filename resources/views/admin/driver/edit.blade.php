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

                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <div class="x_panel">
                                <div class="form-group">
                                    <label>Phương thức vận chuyển</label>
                                    <select id="type_driver" name="type_driver" class="form-control type_driver" data-placeholder="Tên | số điện thoại">
                                        @foreach($transport as $item)
                                            <option value="{{$item->name}}" @if(!empty($driver->type_driver) && ($driver->type_driver == $item->name)) selected='selected' @endif>{{$item->name}}</option>
                                        @endforeach 
                                    </select>
                                    
                                </div>
                                <div class="form-group">
                                    <label>Tên tài xế</label>
                                    <input type="text" name="name_driver" class="form-control" id="name_driver" required 
                                            value="@if(!empty($driver->name_driver)){{$driver->name_driver}}@else{{old('name_driver')}}@endif">
                                </div>
                                <div class="form-group">
                                    <label>Số điện thoại</label>
                                    <input type="text" name="phone_driver" class="form-control" id="phone_driver" required 
                                            value="@if(!empty($driver->phone_driver)){{$driver->phone_driver}}@else{{old('phone_driver')}}@endif">
                                </div>
                                <div class="form-group">
                                    <label>Biển số xe</label>
                                    <input type="text" name="number_license_driver" class="form-control" id="number_license_driver" required 
                                            value="@if(!empty($driver->number_license_driver)){{$driver->number_license_driver}}@else{{old('number_license_driver')}}@endif">
                                </div>
                                <div class="form-group text-center">
                                    <a href="{{route('driver.index')}}" type="submit"
                                       class="btn btn-raised btn-primary">Hủy</a>
                                    <button type="submit" class="btn btn-raised btn-success">Lưu</button>
                                </div>
                            </div>    
                        </div>
                        
                    </form>
    </div>

@endsection

@section('add_scripts')
<script src="{{asset('js/selectize.js')}}"></script>
<script>
    $('#type_driver').selectize({});
</script>

@endsection