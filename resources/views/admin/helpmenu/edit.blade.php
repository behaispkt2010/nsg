@extends('layouts.admin')
@section('title', 'Bài viết ')
@section('pageHeader','Bài viết ')
@section('detailHeader','Thêm bài viết')
@section('content')
    <br>
    <div class="row">
        @if(Request::is('admin/help-menu/create'))
        <form action="{{route('help-menu.store')}}" method="POST" enctype="multipart/form-data">
            @else
        <form action="{{route('help-menu.update',['id' => $id])}}" method="POST" enctype="multipart/form-data">
            {{ method_field('PUT') }}
            <input type="hidden" name="id" value="{{$id}}">
            @endif
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="col-md-8 col-xs-12">
                <!-- Name and Description -->
                <div class="x_panel">
                    <div class="form-group">
                        <label for="name">Tiêu đề</label>
                        <input type="text" class="form-control" name="text" id="text" required
                               value="@if(!empty($helpmenuContent->text)){{$helpmenuContent->text}}@else{{old('text')}}@endif">
                    </div>
                    <div class="form-group">
                        <label>Nội dung</label>
                        <textarea class="form-control" rows="5"
                                  name="content">@if(!empty($helpmenuContent->content)){{$helpmenuContent->content}}@else{{old('content')}}@endif</textarea>
                        <script type="text/javascript">ckeditor('content')</script>
                    </div>

                </div>
                
            </div>
            <div class="col-md-4 col-xs-12">
                <!-- Show/Hide -->
                <div class="x_panel">
                    <div class="wrapper-content">
                        <div class="pd-all-20">
                            <label class="title-product-main text-no-bold">Hiển thị</label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" @if(!empty($helpmenuContent) && $helpmenuContent->status == 1) checked @else checked @endif   value="1"
                                       name="status">
                                Hiển thị ngay
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" @if(!empty($helpmenuContent) && $helpmenuContent->status == 0) checked @endif value="0"
                                       name="status"> Ẩn đi
                            </label>
                        </div>
                        <div class="ln_solid"></div>
                        <div class="form-group text-center">
                            <a href="{{route('help-menu.index')}}" type="submit"
                               class="btn btn-raised btn-primary">Hủy</a>
                            <button type="submit" class="btn btn-raised btn-success">Lưu</button>
                        </div>
                    </div>
                </div>
                <div class="x_panel">
                    <div class="wrapper-content mt20">
                        <div class="pd-all-20 border-top-title-main">
                            <div class="form-group">
                                <label>Nhóm tin</label>
                                <select name="parent_id" class="select2_single form-control" tabindex="-1"
                                        required>
                                    <option value="0"
                                            @if(!empty($helpmenuContent->parent_id) && $helpmenuContent->parent_id == 0) selected @endif >
                                        Mặc định
                                    </option>
                                    @foreach($helpmenu  as $itemData)
                                        <option value="{{$itemData->id}}"
                                                @if(!empty($helpmenuContent->parent_id) && $helpmenuContent->parent_id == $itemData->id) selected @endif >
                                            {{$itemData->text}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
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
    <script>
        $('.select2_single').selectize({});

    </script>

@endsection