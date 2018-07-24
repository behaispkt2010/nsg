@extends('layouts.admin')
@section('title', 'Bài viết ')
@section('pageHeader','Bài viết ')
@section('detailHeader','Thêm bài viết')
@section('content')
    <br>
    <div class="row">
        @if(Request::is('admin/news/create'))
            <form action="{{route('news.store')}}" method="POST" enctype="multipart/form-data">
                @else
                    <form action="{{route('news.update',['id' => $id])}}" method="POST" enctype="multipart/form-data">
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
                                           value="@if(!empty($article->title)){{$article->title}}@else{{old('title')}}@endif">
                                </div>

                                <div class="form-group">
                                    <label>{{trans('article.content')}}</label>
                                    <textarea class="form-control" rows="5"
                                              name="content">@if(!empty($article->content)){{$article->content}}@else{{old('content')}}@endif</textarea>
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

                                            <div class="page-description-seo ws-nm"><span>{{url('blogs')}}/@if(!empty($article->slug)){{$article->slug}}@endif</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pd-all-20 border-top-title-main">
                                        <div class="form-group">
                                            <label class="inline">Tiêu đề trang</label>
                                            <label class="inline note pull-right"> <span>0</span> trên 70 kí tự</label>
                                            <input type="text" class="form-control" name="title_seo"
                                                   value="@if(!empty($article->title_seo)){{$article->title_seo}}@else{{old('title_seo')}}@endif">
                                        </div>
                                        <div class="form-group">
                                            <label class="inline" for="inputmetadescription">Mô tả trang</label>
                                            <label class="inline note pull-right"> <span
                                                        data-bind="text: MetaDescLength">0</span>
                                                trên 160 kí tự</label>
                                            <input type="text" class="form-control" name="description"
                                                   value="@if(!empty($article->description)){{$article->description}}@else{{old('description')}}@endif">

                                        </div>
                                        <div class="form-group mb0">
                                            <label for="inputurlhandle">
                                                Đường dẫn
                                            </label>

                                            <div class="input-group">
                                                <span class="input-group-addon drop-price-addon border-color-input-group">
                                                   {{url('blogs')}}/</span>
                                                <input type="hidden" class="form-control" name="slug" value="@if(!empty($article->slug)){{$article->slug}}@endif"/>
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
                                            <input type="radio" @if(!empty($article) && $article->status == 1) checked @else checked @endif   value="1"
                                                   name="status">
                                            Hiển thị ngay
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" @if(!empty($article) && $article->status == 0) checked @endif value="0"
                                                   name="status"> Ẩn đi
                                        </label>
                                    </div>
                                    <div class="ln_solid"></div>
                                    <div class="form-group text-center">
                                        <a href="{{route('news.index')}}" type="submit"
                                           class="btn btn-raised btn-primary">Hủy</a>
                                        <button type="submit" class="btn btn-raised btn-success">Lưu</button>
                                    </div>
                                </div>
                            </div>
                            <div class="x_panel">
                                <div class="wrapper-content mt20">
                                    <div class="pd-all-20 border-top-title-main">
                                        <div class="form-group">
                                            <label>Nhóm bài viết</label>
                                            <select name="category" class="select2_single form-control" tabindex="-1"
                                                    required>
                                                <option value="0"
                                                        @if(!empty($article->category) && $article->category == 0) selected @endif >
                                                    Mặc định
                                                </option>
                                                @foreach($category  as $itemData)
                                                    <option value="{{$itemData->id}}"
                                                            @if(!empty($article->category) && $article->category == $itemData->id) selected @endif >
                                                        {{$itemData->name}}
                                                    </option>
                                                @endforeach

                                            </select>
                                        </div>

                                    </div>
                                    <div class="image-area">
                                        <label class="mb5">Hình đại diện</label>

                                        <div class="image-view">
                                            @if(!empty($article->image))
                                                <img src="{{url('/').$article->image}}" alt="" style="border-radius: 4px;" class="img-responsive">
                                                <div class="form-group">
                                                    <label for="inputFile" class="col-md-4 control-label">Thay đổi</label>

                                                    <div class="col-md-8">
                                                        <input type="text" readonly="" class="form-control" placeholder="Browse...">
                                                        <input type="file" name="image"  id="inputFile">
                                                    </div>
                                                </div>

                                            @else
                                                <input type="file" style="display:none;" name="image" id="file-6"
                                                       class="inputfile inputfile-5"
                                                       data-multiple-caption="{count} files selected"/>
                                                <label class="file-view" for="file-6">
                                                    <figure>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17"
                                                             viewBox="0 0 20 17">
                                                            <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/>
                                                        </svg>
                                                    </figure>
                                                    <span></span></label>
                                            @endif

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