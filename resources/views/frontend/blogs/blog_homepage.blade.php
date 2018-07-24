@extends('layouts.blogs')
@section('title', 'liên hệ')
@section('description','liên hệ')

@section('url_seo', url('/').$_SERVER['REQUEST_URI'] )
@section('type_seo','article')
@section('title_seo', 'Liên hệ' )
@section('description_seo', 'Giải đáp thắc mắc khách hàng - Phụng sự khách hàng là trách nhiệm của chúng tôi' )
@section('image_seo', url('/').'/frontend/images/nosago1.png' )

@section('add_style')

@endsection
@section('content')

<div class="col-md-12 col-xs-12 col-sm-12 wrap_homeblog">
    <div class="row">
        <div class="col-md-6 col-sm-6 col-xs-12 blog_left">
            <div class="box_blog">
                <div class="title_box_homeblog">
                    <p class="title_box uppercase"><b>{{ $cateNews->name }}</b></p>
                    <p class="read_more_blog"><a href="{{ url('/category-blog/'.$cateNews->slug) }}" title="">Xem thêm <i class="material-icons">fast_forward</i></a></p>
                </div>
                <div class="clearfix"></div>
                <div class="list_news">
                    <div id="listNews">
                        <ul>
                            @foreach($news as $itemNews)
                            <li>
                                <span class="time">{{ $itemNews->created_at->format('Y-m-d H:i') }}</span>
                                <span class="split"></span>
                                <a href="{{url('/blog')}}/{{\App\Category::getSlugCategory($itemNews->category)}}/{{$itemNews->slug}}" class="content_title" title="">{!! $itemNews->title !!}</a>
                                <!-- <span class="count_views"><i class="material-icons icon_views">visibility</i> 1 </span> -->
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12 blog_right">
            <div class="box_blog_small">
                <div class="box_nongdan">
                    <div class="title_box_homeblog">
                        <p class="title_box uppercase"><b>{{ $arrFamer->name }}</b></p>
                        <p class="read_more_blog"><a href="{{ url('/category-blog/'.$arrFamer->slug) }}" title="">Xem thêm <i class="material-icons">fast_forward</i></a></p>
                    </div>
                </div>
               
            </div>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12 blog_right">
            <div class="box_blog_small">
                <div class="box_tailieu">
                    <a href="{{ url('/tai-lieu') }}" title="">
                        <div class="title_box_homeblog">
                            <p class="title_box uppercase"><b>Tài liệu</b></p>
                            <p class="read_more_blog"><a href="{{ url('/tai-lieu') }}" title="">Xem thêm <i class="material-icons">fast_forward</i></a></p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="box_blog_technical">
                <div class="box_congnghe">
                    <div class="title_box_homeblog">
                        <p class="title_box uppercase"><b>Công nghệ</b></p>
                        <!-- <p class="read_more_blog"><a href="#" title="">Xem thêm <i class="material-icons">fast_forward</i></a></p> -->
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-3 col-sm-3 img_cover" style="">
                        <img src="{{ asset('frontend/images/img_cover_congnghe_blog.jpg') }}">
                    </div>
                    <div class="col-md-6 col-sm-6 news_technical" style="">
                        <ul>
                            @foreach($category_technical as $itemCateTech)
                            <li>
                                <a href="{{ url('/category-blog/'.$itemCateTech->slug) }}" class="content_cate">{{ $itemCateTech->name }}</a>
                                <a href="{{ url('/category-blog/'.$itemCateTech->slug) }}" class="read_more_blog floatleft" title="">Xem thêm <i class="material-icons">fast_forward</i></a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-md-3 col-sm-3 img_cover" style="">
                        <img src="{{ asset('frontend/images/img_cover_congnghe_a_blog.jpg') }}">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-5 col-sm-5 col-xs-12 blog_left">
            <div class="box_blog_pricing">
                <div class="title_box_homeblog">
                    <p class="title_box uppercase"><b>Giá cả</b></p>
                    <p class="read_more_blog"><a href="{{ url('/gia-ca-thi-truong') }}" title="">Xem thêm <i class="material-icons">fast_forward</i></a></p>
                    <table class="table table-striped table-hover ">
                        <thead>
                            <tr>
                              <th>Tên sản phẩm</th>
                              <th>Giá</th>
                              <th>Biến động</th>
                              <th>Nguồn</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pricing as $itemPricing)
                            <tr>
                              <td>{{ $itemPricing->product_name }}</td>
                              <td>{!! App\Util::FormatMoney($itemPricing->price_new) !!}</td>
                              <td class="@if(!empty($itemPricing->change) && ($itemPricing->price_new > $itemPricing->price_old)) increasePrice @else decreasePrice @endif">{!! App\Util::FormatMoney($itemPricing->change) !!}</td>
                              <td>{{ $itemPricing->source }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-7 col-sm-7 col-xs-12 blog_right">
            <div class="box_blog_small">
                <div class="box_nongdan">
                    <div class="title_box_homeblog">
                        <p class="title_box uppercase"><b>Liên kết website</b></p>
                    </div>
                    <div class="clearfix"></div>
                    <div class="list_website">
                        <div id="listWebsites">
                            <ul style="padding-left: 10px;">
                               @foreach($website as $itemWebsite)
                                    <li style="width: 180px; display: inline-block;">
                                        <img src="{{url('/')}}{!! $itemWebsite->website_image !!}" width="25" height="25" alt="" class="img-circle" data-pin-nopin="true">
                                        <a href="{!! $itemWebsite->website_url !!}" class="" title="">{!! $itemWebsite->website_name !!}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                        
                        <!-- <p class="read_more_blog"><a href="#" title="">Xem thêm <i class="material-icons">fast_forward</i></a></p> -->
                    </div>
            </div>
        </div>
        <div class="col-md-7 col-sm-7 col-xs-12 blog_right">
            <div class="box_blog_small">
                <div class="clearfix"></div>
                <div class="box_tailieu">
                    <div class="title_box_homeblog">
                        <p class="title_box uppercase"><b>Contact Us</b></p>
                        <div class="clearfix"></div>
                        <div class="col-md-3 col-sm-3 img_cover" style="">
                            <img src="{{ asset('images/contact-us.png') }}">
                        </div>
                        <!-- <p class="read_more_blog"><a href="#" title="">Xem thêm <i class="material-icons">fast_forward</i></a></p> -->
                    </div>
                </div>
            </div>
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