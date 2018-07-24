@extends('layouts.admin')
@section('title', 'permission')
@section('pageHeader','Permission ')
@section('detailHeader','Permission')
@section('content')
    <br>
    <div class="row">
        @if(Request::is('admin/permission/create'))
            <form action="{{route('permission.store')}}" method="POST" enctype="multipart/form-data">
                @else
                    <form action="{{route('permission.update',['id' => $id])}}" method="POST" enctype="multipart/form-data">
                        {{ method_field('PUT') }}
                        <input type="hidden" name="id" value="{{$id}}">
                        @endif
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="col-md-12 col-xs-12">
                            <div class="text-right">
                                <button type="submit" class="btn-update btn btn-success btn-raised text-right btn-small" > Lưu</button>
                            </div>
                            <!-- Name and Description -->
                            <div class="x_panel">
                                <div class="form-group">
                                    <label for="name">Tên hiển thị</label>
                                    <input type="text" class="form-control" name="display_name" id="display_name" required
                                           value="@if(!empty($permission->display_name)){{$permission->display_name}}@else{{old('display_name')}}@endif">
                                </div>
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" name="name" id="name" required
                                           value="@if(!empty($permission->name)){{$permission->name}}@else{{old('name')}}@endif">
                                </div>
                                <div class="form-group">
                                    <label for="name">Route</label>
                                    <input type="text" class="form-control" name="route" id="name" required
                                           value="@if(!empty($permission->route)){{$permission->route}}@else{{old('route')}}@endif">
                                </div>

                                <div class="form-group">
                                    <label>Mô tả</label>
                                    <textarea class="form-control" rows="5"
                                              name="description">@if(!empty($permission->description)){{$permission->description}}@else{{old('description')}}@endif</textarea>
                                    <script type="text/javascript">ckeditor('description')</script>
                                </div>

                            </div>

                        </div>
                    </form>
    </div>

    @endsection

