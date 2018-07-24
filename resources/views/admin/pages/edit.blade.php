@extends('layouts.admin')
@section('title', 'Trang ')
@section('pageHeader','Trang ')
@section('detailHeader','Trang')
@section('content')
    <br>
    <div class="row">
        @if(Request::is('admin/pages/create'))
            <form action="{{route('pages.store')}}" method="POST" enctype="multipart/form-data">
                @else
                    <form action="{{route('pages.update',['id' => $id])}}" method="POST" enctype="multipart/form-data">
                        {{ method_field('PUT') }}
                        <input type="hidden" name="id" value="{{$id}}">
                        @endif
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="col-md-8 col-xs-12">
                            <!-- Name and Description -->
                            <div class="x_panel">
                                <div class="form-group">
                                    <label for="name">{{trans('article.title')}}</label>
                                    <input type="text" class="form-control" name="title" id="title" required
                                           value="@if(!empty($page->title)){{$page->title}}@else{{old('title')}}@endif">
                                </div>

                                <div class="form-group">
                                    <label>{{trans('article.content')}}</label>
                                    <textarea class="form-control" rows="5"
                                              name="content">@if(!empty($page->content)){{$page->content}}@else{{old('content')}}@endif</textarea>
                                    <script type="text/javascript">ckeditor('content')</script>
                                </div>

                            </div>
                            <div class="x_panel">
                                <!-- SEO -->
                                <div class="wrapper-content mt20 mb20">
                                    <div class="pd-all-20 ps-relative">
                                        <label class="title-product-main text-no-bold mb20">Tối ưu SEO</label>

                                        <p class="mb0">Thiết lập các thẻ mô tả giúp khách hàng dễ dàng tìm thấy trang
                                            trên công cụ
                                            tìm
                                            kiếm
                                            như Google.</p>

                                        <div>
                                            <span class="page-title-seo"></span>

                                            <div class="page-description-seo ws-nm"><span>{{url('/')}}/@if(!empty($page->slug)){{$page->slug}}@endif</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pd-all-20 border-top-title-main">
                                        <div class="form-group">
                                            <label class="inline">Tiêu đề trang</label>
                                            <label class="inline note pull-right"> <span>0</span> trên 70 kí tự</label>
                                            <input type="text" class="form-control" name="title_seo"
                                                   value="@if(!empty($page->title_seo)){{$page->title_seo}}@else{{old('title_seo')}}@endif">
                                        </div>
                                        <div class="form-group">
                                            <label class="inline" for="inputmetadescription">Mô tả trang</label>
                                            <label class="inline note pull-right"> <span
                                                        data-bind="text: MetaDescLength">0</span>
                                                trên 160 kí tự</label>
                                            <input type="text" class="form-control" name="description"
                                                   value="@if(!empty($page->description)){{$page->description}}@else{{old('description')}}@endif">

                                        </div>
                                        <div class="form-group mb0">
                                            <label for="inputurlhandle">
                                                Đường dẫn
                                            </label>

                                            <div class="input-group">
                                                <span class="input-group-addon drop-price-addon border-color-input-group">
                                                   {{url('/')}}/</span>
                                                <input type="hidden" class="form-control" name="slug" value="@if(!empty($page->slug)){{$page->slug}}@endif"/>
                                                <input type="text" class="form-control" name="slug_seo"
                                                       placeholder="ten-bai-viet-1"
                                                       value="{{old('slug_seo')}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End SEO -->
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
                                            <input type="radio" @if(!empty($page) && $page->status == 1) checked @else checked @endif   value="1"
                                                   name="status">
                                            Hiển thị ngay
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" @if(!empty($page) && $page->status == 0) checked @endif value="0"
                                                   name="status"> Ẩn đi
                                        </label>
                                    </div>
                                    <div class="ln_solid"></div>
                                    <div class="form-group text-center">
                                        <a href="{{route('pages.index')}}" type="submit"
                                           class="btn btn-raised btn-primary">Hủy</a>
                                        <button type="submit" class="btn btn-raised btn-success">Lưu</button>
                                    </div>
                                </div>
                            </div>
                            <div class="x_panel">
                                <div class="wrapper-content mt20">
                                    <div class="pd-all-20 border-top-title-main">
                                        <div class="form-group">
                                            <label>Template</label>
                                            <select name="template" class="select2_single form-control" tabindex="-1"
                                                    required>
                                                <option value="0"
                                                        @if(!empty($page->category) && $page->category == 0) selected @endif >
                                                    Mặc định
                                                </option>

                                            </select>
                                        </div>

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