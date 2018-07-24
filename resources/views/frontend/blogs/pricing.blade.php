@extends('layouts.blogs')
@section('title', 'Thông tin giá cả thị trường')
@section('description','Thông tin giá cả thị trường')

@section('url_seo', url('/').$_SERVER['REQUEST_URI'] )
@section('type_seo','article')
@section('title_seo', 'Thông tin giá cả thị trường' )
@section('description_seo', 'Thông tin giá cả thị trường' )
@section('image_seo', url('/').'/frontend/images/nosago1.png' )

@section('add_style')

@endsection
@section('content')
    <div class="secondary_page_wrapper col-md-12 col-sm-12">
        <div class="container col-md-12 col-sm-12">
            <ul class="breadcrumbs">
                <li><a href="/">Trang chủ</a></li>
                <li><a href="/blogs">Blogs</a></li>
                <li>Thông tin giá cả thị trường</li>
            </ul>
            <div class="row col-md-10 col-sm-10 col-xs-12 col-md-offset-1 col-sm-offset-1">
                <main class="col-md-9 col-sm-8 col-xs-12">
                    <div class="box_blog_large">
                        <div class="text-center">
                            <h2>Giá cả thị trường</h2>
                        </div>
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Tên sản phẩm</th>
                                    <th>Giá</th>
                                    <th>Biến động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pricing as $itemPricing)
                                <tr>
                                    <td>{{ $itemPricing->product_name }}</td>
                                    <td>{!! App\Util::FormatMoney($itemPricing->price_new) !!}</td>
                                    <td class="@if(!empty($itemPricing->change) && ($itemPricing->price_new > $itemPricing->price_old)) increasePrice @else decreasePrice @endif">{!! App\Util::FormatMoney($itemPricing->change) !!}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
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