@extends('layouts.admin')
@section('title', 'Tồn kho')
@section('pageHeader','Tồn kho sản phẩm ')
@section('detailHeader','kiểm tra tồn kho')
@section('add_styles')
    @endsection
@section('content')
    <div class="row top-right">

        <div class="x_panel">
            <form action="" method="GET">
                <div class="x_content">
                    {{--<div class="clearfix"></div>--}}

                    <div class="row">
                        <div class="col-md-3 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <select id="select-ck" class="form-control" name="kho" data-placeholder="chọn kho">
                                    
                                    @if(Auth::user()->hasRole(\App\Util::$viewInventory))
                                        <option value="0"
                                                @if(!empty($article->category) && $article->category == 0) selected @endif >
                                            Mặc định
                                        </option>
                                        @foreach($wareHouses  as $itemData)
                                            <option value="{{$itemData->id}}"
                                                    @if(!empty($product->kho) && $product->kho == $itemData->id) selected @endif >
                                                {{$itemData->name}}({{$itemData->id}})
                                            </option>
                                        @endforeach
                                    @else
                                    <option value="{{Auth::user()->id}}">
                                        {{Auth::user()->name}}({{\App\Util::UserCode(Auth::user()->id)}})
                                    </option>
                                    @endif

                                    <!-- @foreach($wareHouses  as $wareHouse)
                                        <option value="{{$wareHouse->id}}" @if(Request::get('kho')==$wareHouse->id) selected @endif>#{{$wareHouse->id}}({{$wareHouse->name}})</option>

                                    @endforeach -->

                                </select>
                            </div>
                            <div class="clear"></div>
                        </div>
                        <div class="col-md-3 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <select id="select-cate" class="form-control" name="category" data-placeholder="chọn danh mục">
                                    <option value="0" >Tất cả</option>
                                    {{ \App\Category::CateMulti($category,0,$str="&nbsp&nbsp&nbsp&nbsp",old('parent')) }}
                                    <!-- @foreach($category  as $itemCategory)
                                        <option value="{{$itemCategory->id}}" @if(Request::get('category')==$itemCategory->id) selected @endif>{{$itemCategory->name}}
                                        </option>
                                    @endforeach -->
                                </select>
                            </div>
                            <div class="clear"></div>
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group label-floating">

                                <label class="control-label" for="addon2">Tên sản phẩm | Mã sản phẩm</label>

                                <div class="input-group text-center">
                                    <input type="text" id="addon2" class="form-control" name="name" value="{{Request::get('name')}}">
                                      <span class="input-group-btn">
                                        <button type="submit" class="btn btn-fab btn-fab-mini">
                                            <i class="material-icons">search</i>
                                        </button>
                                      </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

    </div>
    <div class="row">

        <div class="col-md-12">
            <div class="">
                <div class="x_content">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 text-center">

                        </div>

                        <div class="clearfix"></div>
                        @if(count($products) !=0)
                        @foreach($products as $product)

                        <div class="col-md-4 col-sm-4 col-xs-12 profile_details product-detail">

                                <div class="well box_1">


                                    <div class="img-product-view">
                                        <img src="{{url('/')}}/{{$product->image}}" alt="" class="img-circle img-responsive"
                                             data-pin-nopin="true">
                                    </div>
                                    <div class="col-sm-12">
                                        <p style="font-size: 16px;" class="cod limitcharacterWithImg">{{$product->title}}</p>
                                        <h2 class="cod">{{\App\Util::ProductCode($product->id)}}</h2>
                                        <div class="col-xs-12" style="padding-left: 0px;">
                                            <ul class="list-unstyled">
                                                <li class="limitcharacter"><span class="label-box">Tồn kho :</span>{{$product->inventory_num}}</li>
                                                <li class="limitcharacter"><span class="label-box">Chủ Kho</span><strong>{{\App\Util::UserCode($product->kho)}}</strong></li>
                                                <li class="limitcharacter"><span class="label-box">Danh mục:</span>{{\App\CategoryProduct::getNameCateById($product->category)}}</li>
                                                <li class="limitcharacter"><span class="label-box">Cập nhật:</span>{{$product->updated_at->format('d/m/Y')}}</li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 text-center">
                                        {{--<a href="#"  target="_blank" class="btn btn-primary btn-xs" >--}}
                                        {{--<i class="fa fa-eye" aria-hidden="true"></i> Xem--}}
                                        {{--</a>--}}
                                        <button  class="btn btn-raised btn-primary btn-xs check-product" data-toggle="modal" data-target=".modal-product-inventory" data-id="{{$product->id}}" data-title="{{$product->title}}(#{{$product->id}})" data-inventory="{{$product->inventory_num}}">
                                            <i class="fa fa-pencil" aria-hidden="true" ></i> Kiểm kho
                                        </button>

                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="clearfix"></div>
                        <div class="text-center">
                            {{ $products->appends(array('kho' => Request::get('kho'),'name' => Request::get('name'),'category' => Request::get('category')))->links() }}
                        </div>
                        @else
                            <div>Không tìm thấy dữ liệu</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade modal-product-inventory" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false"
         data-backdrop="static">
        <div class="modal-dialog modal-product-inventory">

            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title text-center title" id="myModalLabel"></h4>
                    <input type="hidden" name="id">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                </div>
                <div class="modal-body sroll">
                    <div class="form-group">
                        <div class="form-group">
                            <span>Tồn kho hiện tại: </span><span class="number-inventory"></span>
                        </div>
                        <div class="form-group label-floating">
                            <label class="control-label" for="focusedInput2"> Kiểm thực tế</label>
                            <input class="form-control check-num-product" id="focusedInput2" type="number"  name="check-num-product">
                        </div>
                        <div class="form-group">
                            <span>Hiệu chỉnh: </span><span class="number-fix"></span>
                        </div>
                        {{--<div class="form-group">--}}
                            {{--<div class="form-group label-floating">--}}
                                {{--<label class="control-label" for="focusedInputnote">Nguyên nhân hiệu chỉnh</label>--}}
                                {{--<textarea class="form-control" id="focusedInputnote" name="reason"></textarea>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-raised btn-primary" id="update-product">Lưu hiệu chỉnh</button>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('add_scripts')
    <script src="{{asset('js/selectize.js')}}"></script>
    <!-- Select2 -->
    <script>
        $('#select-ck,#select-cate,#parent-cate').selectize({
            create: true,
            /*sortField: 'text'*/
        });
    </script>
    <script>
        $(document).on("click", ".check-product", function () {
            var _self = $(this);
//            alert("ds");
            $('.modal-product-inventory input[name="id"]').val(_self.data('id'));
            $('.modal-product-inventory .title').text(_self.data('title'));
            $('.modal-product-inventory .number-inventory').text(_self.data('inventory'));
//            alert(_self.data('inventoryNum'));
        });
        $(document).on('change','input[name="check-num-product"]',function(){
            var number_inventory = $('.modal-product-inventory .number-inventory').text();
            var check_num_product = $('.modal-product-inventory .check-num-product').val();
//            alert(check_num_product);
            $('.number-fix').text(parseInt(check_num_product) - parseInt(number_inventory));
            });
    
    </script>
    <script>
        $('#update-product').on('click', function (e) {
            e.preventDefault();

            var id = $('.modal-product-inventory input[name="id"]').val();
            var num = $('.modal-product-inventory input[name="check-num-product"]').val();
//            var reason = $('.modal-product-cate textarea[name="reason"]').val();
            var _token = $('input[name="_token"]').val();
            if(num==""){
                new PNotify({
                    title: 'Vui lòng nhập thông tin',
                    text: '',
                    type: 'danger',
                    hide: true,
                    styling: 'bootstrap3'
                });
                return false;
            }
//            alert(id);
            $('.loading').css('display','block');
            $.ajax({
                type: "POST",
                url: '/product/checkProductAjax',
                data: {id: id, num: num,_token: _token},
                success: function( msg ) {
                    $('.loading').css('display','none');
                    $('.modal-product-cate input[name="check-num-product"]').val("");
//                    $('.modal-product-cate textarea[name="reason"]').val("");
//                    alert("Tạo thành công");
                    //show notify
                    new PNotify({
                        title: 'Cập nhật thành công',
                        text: '',
                        type: 'success',
                        hide: true,
                        styling: 'bootstrap3'
                    });
                    location.reload();
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    //show notify
                    var Data = JSON.parse(XMLHttpRequest.responseText);
                    new PNotify({
                        title: 'Lỗi',
                        text: Data['name'],
                        type: 'danger',
                        hide: true,
                        styling: 'bootstrap3'
                    });
                    $('.loading').css('display','none');

                }
            });
        });
    </script>
@endsection

