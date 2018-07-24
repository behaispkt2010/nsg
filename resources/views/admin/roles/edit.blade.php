@extends('layouts.admin')
@section('title', 'Role')
@section('pageHeader','Role ')
@section('detailHeader','Role')
@section('content')
    <br>
    <div class="row">
        @if(Request::is('admin/role/create'))
            <form action="{{route('role.store')}}" method="POST" enctype="multipart/form-data">
                @else
                    <form action="{{route('role.update',['id' => $id])}}" method="POST" enctype="multipart/form-data">
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
                                           value="@if(!empty($role->display_name)){{$role->display_name}}@else{{old('display_name')}}@endif">
                                </div>
                                <div class="form-group">
                                    <label for="name">Mã Phân quyền</label>
                                    <input type="text" class="form-control" name="name" id="name" required
                                           value="@if(!empty($role->name)){{$role->name}}@else{{old('name')}}@endif">
                                </div>

                                <div class="form-group">
                                    <label>Mô tả</label>
                                    <textarea class="form-control" rows="5"
                                              name="description">@if(!empty($role->description)){{$role->description}}@else{{old('description')}}@endif</textarea>
                                    <script type="text/javascript">ckeditor('description')</script>
                                </div>
                                <div class="form-group">
                                    <label for="">Quyền hạn truy cập</label>
                                    <div class="comlum2">
                                    @foreach($permissions as $permission)
                                        @if(!empty($rolePerms))
                                         <?php $checked = in_array($permission->id, $rolePerms); ?>
                                        @endif
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="perms[]" value="{{$permission->id}}"   @if(!empty($checked)) checked @endif>  {{ $permission->display_name }}
                                            </label>
                                        </div>
                                    @endforeach
                                    </div>
                                </div>

                            </div>

                        </div>
                    </form>
    </div>

    @endsection

