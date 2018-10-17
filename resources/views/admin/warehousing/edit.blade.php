@extends('layouts.admin')
@section('title', 'Kiểm kho')
@section('pageHeader','Kiểm kho')
@section('detailHeader','Kiểm kho')
@section('add_styles')
        <!-- Dropzone.js -->
<!-- <link href="{{asset('plugin/dropzone/dist/min/dropzone.min.css')}}" rel="stylesheet"> -->

@endsection
@section('content')
    <br>
    <div class="row">
        @if(Request::is('admin/warehousing/create'))
            <form action="{{route('warehousing.store')}}" method="POST" enctype="multipart/form-data">
                @else
                    <form action="{{route('warehousing.update',['id' => $id])}}" method="POST"
                          enctype="multipart/form-data">
                        {{ method_field('PUT') }}
                        <input type="hidden" name="id" value="{{$id}}">  
                        @endif
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="cate" value="{{$cate}}">
                        <div class="col-md-8 col-xs-12">
                            <!-- Name and Description -->
                            <div class="x_panel">
                                @if($cate == 'issue')
                                <h2>Phiếu xuất kho</h2>
                                @elseif($cate == 'receipt')
                                <h2>Phiếu nhập kho</h2>
                                @endif
                                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 pL-0">
                                    <select id="select-product" name="select-product"  class="form-control " placeholder="Thêm sản phấm">
                                        <option value=""></option>
                                        @if(!empty($products))
                                            @foreach($products as $product)
                                                <option value="{{$product->id}}">
                                                    {{$product->title}} ({{$product->code}} )
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                    <button type="button" id="btn_add_product" class="btn btn-raised btn-success">Thêm</button>
                                </div>
                                <table class="table table-condensed table-hover table-bordernontop">
                                <tbody class="list_product" style="width:100%;">
                                    <tr>
                                        <th class="">Mã</th>
                                        <th>Tên sản phẩm</th>
                                        <th class="">Số lượng</th>
                                        <th></th>
                                    </tr>
                                    @if(Request::is('admin/warehousing/create'))
                                    @else
                                        @foreach($arrProduct as $itemProduct)
                                            <tr class="item-product">
                                                <td class="" style=""><span class="code-product"><span>{{ $itemProduct->productCode }} </span></span>
                                                </td>
                                                <td><span class="name-product"><span>{{ $itemProduct->nameproduct }} </span></span>
                                                    <input type="hidden" value="{!! $itemProduct->idproduct !!}" name="product_id[]">
                                                    <input type="hidden" value="{!! $itemProduct->nameproduct !!}" name="nameproduct[]">
                                                </td>
                                                <td><input type="number" class="quantity input-non-bTr" style="width:70px;" name="quantity[]" value="{{ $itemProduct->quantity }}">
                                                </td>
                                                <td><i class="fa fa-times red delete" id="delete_product" style="cursor: pointer" aria-hidden="true"></i></td>
                                            </tr>
                                        @endforeach
                                    @endif
                                        
                                    </tbody>
                                </table>
                                <div class="clear"></div>
                                <hr>
                                <div class="form-group">
                                    <label> Trạng thái</label>
                                    <select id="select-status" name="status" required="" class="form-control" data-placeholder="Chọn trạng thái">
                                        <option value="0" @if(!empty($itemProduct->status) && $itemProduct->status == 0) selected @endif>Mới tạo</option>
                                        <option value="1" @if(!empty($itemProduct->status) && $itemProduct->status == 1) selected @endif>Đang xử lý</option>
                                        <option value="2" @if(!empty($itemProduct->status) && $itemProduct->status == 2) selected @endif>Hoàn thành</option>
                                        <option value="3" @if(!empty($itemProduct->status) && $itemProduct->status == 3) selected @endif>Hủy</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Ghi chú</label>
                                    <textarea class="form-control note" rows="5" name="note">@if(!empty($itemProduct->note)){{$itemProduct->note}}@else{{old('note')}}@endif</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-xs-12">
                            <div class="x_panel">
                                <div class="text-center">
                                    @if(Request::is('admin/warehousing/create'))
                                        <button type="submit" class="btn btn-raised btn-success">Tạo mới </button>
                                    @else
                                        <button type="submit" class="btn btn-raised btn-success">Cập nhật</button>
                                        <form action=""></form>
                                        <form action="{{route('warehousing.destroy',['id' => $id])}}" method="post" class="form-delete" style="display: inline">
                                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                                            <input type="hidden" value="{{$id}}">
                                            {{method_field("DELETE")}}
                                            <a type="submit" class = "btn btn-raised btn-danger" name ="delete_modal" style="display: inline-block">Xóa</a>
                                        </form>
                                    @endif
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label>Chủ kho</label>
                                        <select id="select-ck" name="id_kho" class="form-control"
                                                data-placeholder="Chọn kho">
                                            @if(Auth::user()->hasRole(\App\Util::$viewProduct))
                                                @foreach($wareHouses as $itemData)
                                                    <option value="{{$itemData->id}}"
                                                            @if(!empty($itemProduct->kho) && $itemProduct->kho == $itemData->id) selected @endif >
                                                        {{$itemData->name}}({{$itemData->id}})
                                                    </option>
                                                @endforeach
                                            @else
                                                <option value="{{Auth::user()->id}}">
                                                    {{Auth::user()->name}}({{\App\Util::UserCode(Auth::user()->id)}})
                                                </option>
                                            @endif

                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Loại</label>
                                        <select id="type" name="type" class="form-control"
                                                data-placeholder="Chọn Loại">
                                            @if($cate == 'receipt')
                                                <option></option>
                                                <option value="1" @if(!empty($itemProduct->type) && $itemProduct->type == 1) selected @endif>Mua hàng vào</option>
                                                <option value="2" @if(!empty($itemProduct->type) && $itemProduct->type == 2) selected @endif>Nhập hàng trả về</option>
                                                <option value="3" @if(!empty($itemProduct->type) && $itemProduct->type == 3) selected @endif>Cân bằng kho</option>
                                                <option value="4" @if(!empty($itemProduct->type) && $itemProduct->type == 4) selected @endif>Khác</option>
                                            @elseif($cate == 'issue')
                                                <option></option>
                                                <option value="1" @if(!empty($itemProduct->type) && $itemProduct->type == 1) selected @endif>Bán hàng</option>
                                                <option value="2" @if(!empty($itemProduct->type) && $itemProduct->type == 2) selected @endif>Xuất trả NCC</option>
                                                <option value="3" @if(!empty($itemProduct->type) && $itemProduct->type == 3) selected @endif>Cân bằng kho</option>
                                                <option value="4" @if(!empty($itemProduct->type) && $itemProduct->type == 4) selected @endif>Khác</option>
                                            @endif

                                        </select>
                                    </div>
                                    <div class="form-group orders" style="@if(!empty($itemProduct->type) && ($itemProduct->type > 1)) display: none; @endif">
                                        <label>Đơn hàng</label>
                                        <select id="order_id" name="order_id" class="form-control">
                                            <option></option>
                                            @foreach($arrOrder as $itemOrder)
                                            <option value="{{ $itemOrder->id }}" @if(!empty($itemProduct->order_id) && $itemProduct->order_id == $itemOrder->id) selected @endif>{{ $itemOrder->order_code }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="clear"></div>
                                    <h2>Thông tin nhận hàng</h2>
                                    <div class="form-group">
                                        <div class="col-md-12 col-xs-12">
                                            <label>Họ tên</label>
                                            <input type="text" name="name" value="@if(!empty($itemProduct->name)){{$itemProduct->name}} @else{{old('name')}} @endif" class="form-control" required="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-xs-12">
                                            <label>Email</label>
                                            <input type="email" name="email" value="@if(!empty($itemProduct->email)){{$itemProduct->email}} @else{{old('email')}} @endif" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-xs-12">
                                            <label>Số điện thoại</label>
                                            <input type="text" name="phone" value="@if(!empty($itemProduct->phone)){{$itemProduct->phone}} @else{{old('phone')}} @endif" class="form-control" required="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-xs-12">
                                            <label>Địa chỉ</label>
                                            <input type="text" name="addpress" value="@if(!empty($itemProduct->addpress)){{$itemProduct->addpress}} @else{{old('addpress')}} @endif" class="form-control">
                                        </div>
                                    </div>
                                    <input type="hidden" class="provinceID" name="provinceID" value="@if(!empty($itemProduct->provinceid)) {{$itemProduct->provinceid}} @endif">
                                    <input type="hidden" class="districtID" name="districtID" value="@if(!empty($itemProduct->districtid)) {{$itemProduct->districtid}} @endif">
                                    <div class="form-group">
                                        <div class="col-md-12 col-xs-12">
                                            <label>Tỉnh/TP</label>
                                            <select id="t" class="form-control" name="t">
                                                <option value="0">Chọn khu vực</option>
                                                @foreach($province as $item)
                                                    <option value="{{$item->provinceid}}" @if(!empty($itemProduct->provinceid) && $itemProduct->provinceid == $item->provinceid) selected @endif>{{$item->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>    
                                    <div class="form-group">
                                        <div class="col-md-12 col-xs-12">
                                            <label>Huyện/Thị trấn</label>
                                            <select id="q" class="form-control" name="q">
                                                <option value="0">Chọn phường xã</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
            </form>
@include('admin.partial.modal_delete')
    </div>

@endsection


@section('add_scripts')
    <!-- <script src="{{asset('plugin/dropzone/dist/min/dropzone.min.js')}}"></script> -->
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
    <script src="{{asset('js/selectize.js')}}"></script>
    <!-- Select2 -->
    <script>
        $('#type, #select-type, #select-product, #select-status, #order_id').selectize({
            
        });
    </script>
    
    <!-- /jQuery Tags Input -->
    <script>
        $(document).on('click','#delete_product', function (e) {
            $(this).closest('.item-product').remove();
            
        });
        function ProductIDExist(str){
            var count = 0;
            $('input[type="hidden"][name="product_id[]"]').each(function() {
                if ($(this).val() == str) {
                    count++;
                }
            });
            return count;
        }
        
        $('#btn_add_product').on('click', function (e) {
            var id = $('select[name="select-product"] :selected').val();
            $('select[name="select-product"]')[0].selectize.setValue();
            var _token = $('input[name="_token"]').val();
            var values = $("input[name='product_id']")
                    .map(function(){return $(this).val();}).get(); 
            var tmp_product = [];
            $('input[type="hidden"][name="product_id[]"]').each(function(){
                tmp_product.push($(this).val(),tmp_product);
            });
            var price_total = parseInt($('.allpaymoney').html());
            var checkExist = ProductIDExist(id);
            if(id == 0){
                alert("Vui lòng chọn sản phẩm");
            }
            if(checkExist >= 1){
                alert("Sản phẩm đã tồn tại! Vui lòng chọn sản phẩm khác");
            }
            else {
                $('.loading').css('display','block');
                $.ajax({
                    type: "POST",
                    url: '{!! url("/") !!}/admin/products/AjaxGetProduct',
                    data: {id: id, _token: _token},
                    success: function (msg) {
                        $('.loading').css('display', 'none');
                        $('.list_product').append('<tr class="item-product">'
                                + '<td class="" style=""><span class="code-product">' + msg['code'] + '</span></span>'
                                + '<td><span class="name-product">' + msg['name'] + '</span></span>'
                                + '<input type="hidden" value="' + id + '" name="product_id[]">'
                                + '<input type="hidden" value="' + msg['name'] + '" name="nameproduct[]"></td>'
                                + '<td><input type="number" class="quantity input-non-bTr" style="width:70px;" name="quantity[]" value=""></td>'
                                + '<td><i class="fa fa-times red delete" id="delete_product" style="cursor: pointer" aria-hidden="true"></i></td>'
                                + '</tr>'
                        );
                        
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        //show notify
                        var Data = JSON.parse(XMLHttpRequest.responseText);
                        $('.loading').css('display', 'none');
                    }
                });
            }
        });
    </script>
    <script type="text/javascript">
        var xhr;
        var select_state, $select_state;
        var select_city, $select_city;
        var _token = $('input[name="_token"]').val();
        $select_state = $('#t').selectize({
            onChange: function(value) {
                // alert(value.length);
                if (!value.length) return;
                select_city.clearOptions();
                select_city.load(function(callback) {
                    xhr && xhr.abort();
                    xhr = $.ajax({
                        type: 'POST',
                        url: '{{ url("/") }}/admin/orders/AjaxGetDistrictByProvince',
                        data: {name: value, _token: _token},
                        success: function(results) {
                            callback(results);
                            console.log(results);
                        },
                        error: function() {
                            callback();
                        }
                    })
                });
            }
        });

        $select_city = $('#q').selectize({valueField: 'districtid',
        labelField: 'name',
        searchField: ['name']});

        select_city  = $select_city[0].selectize;
        select_state = $select_state[0].selectize;
    </script>
    <script type="text/javascript">
        $('#type').on('change', function(){
            var type = $(this).val();
            if(type == 0 || type == 1) {
                $('.orders').show();
            } else {
                $('.orders').hide();
            }
        });
        // get update district, provinde
        $(function(){
            var districtID = $('.districtID').val();
            var provinceID = $('.provinceID').val();
            var _token = $('input[name="_token"]').val();
            if(provinceID){
                $.ajax({
                    type:'POST',
                    url:'{{ url("/") }}/admin/orders/AjaxLoadInfoAddress',
                    data: {id: provinceID, type: 'district', valueID: districtID , _token: _token},
                    success:function(html){
                        $('#q').selectize()[0].selectize.destroy();
                        $('#q').html(html);
                        $('#q').selectize();
                    }
                }); 
            } else {
                $('#q').html('<option value="">Chọn Huyện/Thị trấn</option>');
            }
        });
    </script>

@endsection