@extends('layouts.admin')
@section('title', 'Bài viết ')
@section('pageHeader','Bài viết ')
@section('detailHeader','Thêm bài viết')
@section('content')
@section('add_styles')
        <!-- Datatables -->
<link href="{{asset('css/bootstrap-material-datetimepicker.css')}}" rel="stylesheet">

@endsection
    <br>
    <div class="row">
        @if(Request::is('admin/newscompany/create'))
            <form action="{{route('newscompany.store')}}" method="POST" enctype="multipart/form-data">
                @else
                    <form action="{{route('newscompany.update',['id' => $id])}}" method="POST" enctype="multipart/form-data">
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
                                    <textarea class="form-control" rows="5" required
                                              name="content">@if(!empty($article->content)){{$article->content}}@else{{old('content')}}@endif</textarea>
                                    <script type="text/javascript">ckeditor('content')</script>
                                </div>

                            </div>
                            <div class="x_panel">
                                <div class="form-group">
                                    <label>Yêu cầu chất lượng</label>
                                    <textarea class="form-control" rows="5" placeholder=" - Yêu cầu 1... 
 - Yêu cầu 2..." required name="require">@if(!empty($article->require)){{$article->require}}@else{{old('require')}}@endif</textarea>
                                </div>
                                <div class="form-group">
                                    <label>Hình thức thanh toán</label>
                                    <select name="type_pay" class="select2_single form-control" required>
                                        <option value="0" <?php if(!empty($article->type_pay) && $article->type_pay == 0) echo "selected"?> >Trả trước toàn bộ</option>
                                        <option value="1" <?php if(!empty($article->type_pay) && $article->type_pay == 1) echo "selected"?>>Đặt cọc - Thanh toán khi nhận hàng</option>
                                        <option value="2" <?php if(!empty($article->type_pay) && $article->type_pay == 2) echo "selected"?>>Đặt cọc - Công nợ</option>
                                    </select>
                                </div>
                            </div>
                            <div class="x_panel">
                                <div class="form-group">
                                    <label class="title-product-main text-no-bold mb20">Thông tin đơn hàng</label>
                                    <div class="form-group label-floating">
                                        <label class="control-label" for="focusedInput2">Số lượng (kg)</label>
                                        <input class="form-control" id="focusedInput2" required type="number" name="soluong" value="@if(!empty($article->soluong)){{$article->soluong}}@else{{old('soluong')}}@endif">
                                    </div>
                                    <div class="form-group label-floating">
                                        <label class="control-label" for="focusedInput2">Danh mục</label>
                                        <select name="category" class="select2_single form-control" tabindex="-1"
                                                required>
                                            <option value="0" >Chọn danh mục sản phẩm</option>
                                            @if(Request::is('admin/newscompany/create'))
                                                {{ \App\Category::CateMulti($category,0,$str="&nbsp&nbsp&nbsp&nbsp",old('parent')) }}
                                            @else
                                                {{ \App\Category::CateMulti($category,0,$str="&nbsp&nbsp&nbsp&nbsp",$article->category) }}
                                            @endif

                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="ex4">Giá thấp nhất</label>
                                                <input type="number" class="form-control" name="price_from" required
                                                       value="@if(!empty($article->price_to)){{$article->price_to}}@else{{old('price_to')}}@endif">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="ex4">Giá cao nhất</label>
                                                <input type="number" class="form-control" name="price_to" required
                                                       value="@if(!empty($article->price_from)){{$article->price_from}}@else{{old('price_from')}}@endif">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Thời gian giao hàng</label>
                                        <input type="text" id="date-delivery" name="time_delivery" required class="form-control" value="@if(!empty($article->time_delivery)){{$article->time_delivery}}@else{{old('time_delivery')}}@endif" required>

                                    </div>
                                </div>
                            </div>
                            
                            <div class="x_panel" style="">
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
                                    @if(Auth::user()->hasRole(\App\Util::$viewNewsCompany))

                                    <div class="pd-all-20">
                                        <label class="title-product-main text-no-bold">Hiển thị</label>
                                    </div>

                                    <div class="radio">
                                        <label>
                                            <input type="radio" @if(!empty($article))@if($article->status==1)checked @endif @else checked @endif value="1" id="optionsRadios1"
                                                   name="status">
                                            Hiển thị ngay
                                        </label>
                                    </div>

                                    <div class="radio">
                                        <label>
                                            <input type="radio" value="0" @if(!empty($article)) @if($article->status==0)checked @endif @endif id="optionsRadios2"
                                                   name="status"> Chờ duyệt
                                        </label>
                                    </div>
                                        <div class="ln_solid"></div>

                                    @else
                                        <input type="hidden" name="status" value="0" >

                                    @endif
                                    <!-- <div class="ln_solid"></div> -->
                                    <div class="form-group text-center">
                                        <a href="{{route('newscompany.index')}}" type="submit"
                                           class="btn btn-raised btn-primary">Hủy</a>
                                        <button type="submit" class="btn btn-raised btn-success">Lưu</button>
                                    </div>
                                </div>
                            </div>
                            <div class="x_panel">
                                <div class="wrapper-content mt20">
                                    <!-- <div class="pd-all-20 border-top-title-main">
                                        <div class="form-group">
                                            <label>Danh mục</label>
                                            <select name="category" class="select2_single form-control" tabindex="-1"
                                                    required>
                                                <option value="0" >Chọn danh mục sản phẩm</option>
                                                @if(Request::is('admin/newscompany/create'))
                                                    {{ \App\Category::CateMulti($category,0,$str="&nbsp&nbsp&nbsp&nbsp",old('parent')) }}
                                                @else
                                                    {{ \App\Category::CateMulti($category,0,$str="&nbsp&nbsp&nbsp&nbsp",$article->category) }}
                                                @endif
                                    
                                            </select>
                                        </div>
                                    
                                    </div> -->
                                    <div class="image-area">
                                        <label class="mb5">Hình sản phẩm</label>

                                        <div class="image-view">
                                            @if(!empty($article->image))
                                                <img src="{{url('/').$article->image}}" style="border-radius: 5px;" alt="" class="img-responsive">
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
    <script type="text/javascript" src="{{asset('/js/bootstrap-material-datetimepicker.js')}}"></script>
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
        $('.select2_single, .type_pay').selectize({});
    </script>
    <script type="text/javascript">
    $(document).ready(function () {
        $('#date-delivery').bootstrapMaterialDatePicker
        ({
            format: 'DD/MM/YYYY',
            lang: 'vi',
            time: false,
        });
        
    });
    </script>

@endsection