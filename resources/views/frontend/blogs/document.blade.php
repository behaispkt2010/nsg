@extends('layouts.blogs')
@section('title', 'Tài liệu')
@section('description','Tài liệu')

@section('url_seo', url('/').$_SERVER['REQUEST_URI'] )
@section('type_seo','article')
@section('title_seo', 'Tài liệu' )
@section('description_seo', 'Tài liệu' )
@section('image_seo', url('/').'/frontend/images/nosago1.png' )

@section('add_style')

@endsection
@section('content')
    <div class="secondary_page_wrapper col-md-12 col-sm-12">
        <div class="container col-md-12 col-sm-12">
            <ul class="breadcrumbs">
                <li><a href="/">Trang chủ</a></li>
                <li><a href="/blogs">Blogs</a></li>
                <li>Tài liệu</li>
            </ul>
            <div class="row col-md-10 col-sm-10 col-xs-12 col-md-offset-1 col-sm-offset-1">
                <main class="col-md-9 col-sm-8 col-xs-12">
                    <div class="box_blog_large">
                        <?php $i = 1;?>
                        @foreach($document as $itemDocument)
                        <div class="documentItem">
                            <h3>{{ $i }}. {{ $itemDocument->name }}</h3> <br>
                            <p>{!! $itemDocument->description !!}</p>
                            <p>Nguồn/Tác giả: {{ $itemDocument->author }}</p>
                            <span>Link download</span>
                            <div>
                                <a class="btn btn-raised btn-dangtin col-xs-12 btnMenuTop text-center" style="width: auto;" href="{{ $itemDocument->link }}" target="_blank">Tải ngay</a>
                            </div>
                            <?php $i++; ?>
                        </div>    
                        <div class="clearfix"></div>
                        @endforeach

                    </div>
                    
                </main>
                <aside class="col-md-3 col-sm-4" style="margin-top: -10px;">

                @include('frontend.witgets.hot-post')
                @include('frontend.panner.blog-banner')

                </aside>
            </div>
        </div>
    </div>

@endsection

@section('add_script')
<script src="{{asset('frontend/js/blogs/jquery.slimscroll.min.js')}}"></script>
<script type="text/javascript">
    $('#listNews').slimScroll({
        height: '270px'
    });
</script>
@endsection