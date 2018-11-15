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
        @if(Request::is('admin/inventory/create'))
            <form action="{{route('inventory.store')}}" method="POST" enctype="multipart/form-data">
                @else
                    <form action="{{route('inventory.update',['id' => $id])}}" method="POST"
                          enctype="multipart/form-data">
                        {{ method_field('PUT') }}
                        <input type="hidden" name="id" value="{{$id}}">
                        @endif
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="col-md-8 col-xs-12">
                            <!-- Name and Description -->
                            <div class="x_panel">
                                <h2>Kiểm kho</h2>
                                <div class="form-group">
                                    <label for="ex4">Mã phiếu</label>
                                    @if(Request::is('admin/inventory/create'))
                                    <input type="text" class="form-control" disabled>
                                    <input type="hidden" name="code" id="code" value="">
                                    @else
                                        {{ $code }}
                                    @endif
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 pL-0">
                                    <select id="select-product" name="select-product"  class="form-control" placeholder="Thêm sản phấm">
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
                                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 text-right pR-0">
                                    <button type="button" id="btn_add_product" class="btn btn-raised btn-success">Thêm</button>
                                </div>
                                <table class="table table-condensed table-hover table-bordernontop">
                                <tbody class="list_product" style="width:100%;">
                                    <tr>
                                        <th class="non-dis">Mã</th>
                                        <th>Tên sản phẩm</th>
                                        <th>Tồn kho</th>
                                        <th>Kiểm thực tế</th>
                                        <th class="non-dis">Hiệu chỉnh</th>
                                        <th></th>
                                    </tr>
                                    @if(Request::is('admin/inventory/create'))
                                    @else
                                        @foreach($arrProduct as $itemProduct)
                                            <tr class="item-product">
                                                <td class="non-dis" style=""><span class="code-product"><span>{{ $itemProduct->productCode }} </span></span>
                                                </td>
                                                <td><span class="name-product"><span>{{ $itemProduct->nameproduct }} </span></span>
                                                    <input type="hidden" value="{!! $itemProduct->idproduct !!}" name="product_id[]">
                                                    <input type="hidden" value="{!! $itemProduct->nameproduct !!}" name="nameproduct[]">
                                                </td>
                                                <td><span class="inventory_num ">{{ ($itemProduct->inventory_num) }}</span>
                                                    <input type="hidden" value="{!! $itemProduct->inventory_num !!}" name="inventory_num[]">
                                                </td>
                                                <td><input type="text" class="inventory_real input-non-bTr" style="width:70px;" name="inventory_real[]" value="{{ $itemProduct->inventory_real }}">
                                                </td>
                                                <td class="non-dis">
                                                    <span class="inventory_change">
                                                    {{ number_format($itemProduct->inventory_real - $itemProduct->inventory_num) }} 
                                                    </span>
                                                </td>
                                                <td><i class="fa fa-times red delete" id="delete_product" style="cursor: pointer" aria-hidden="true"></i></td>
                                            </tr>
                                        @endforeach
                                    @endif
                                        
                                    </tbody>
                                    <tr>
                                        <td class="non-dis"></td>
                                        <td>Tổng</td>
                                        <td class="total_inventory_num fW-b">0</td>
                                        <td class="total_inventory_real fW-b">0</td>
                                        <td class="total_inventory_change fW-b non-dis">0</td>
                                    </tr>
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
                            </div>
                        </div>
                        <div class="col-md-4 col-xs-12">
                            <div class="x_panel">
                                <div class="text-center">
                                    @if(Request::is('admin/inventory/create'))
                                        <button type="submit" class="btn btn-raised btn-success">Tạo mới </button>
                                    @else
                                        <button type="submit" class="btn btn-raised btn-success">Cập nhật</button>
                                        <form action=""></form>
                                        <form action="{{route('inventory.destroy',['id' => $id])}}" method="post" class="form-delete" style="display: inline">
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
                                        <div class="col-md-12 col-xs-12">
                                            <label style="margin-bottom: 16px;">Ghi chú</label>
                                            <textarea class="form-control note-inventory-edit" rows="5" name="note">@if(!empty($itemProduct->note)){{$itemProduct->note}}@else{{old('note')}}@endif</textarea>

                                        </div>
                                    </div>
                                    <div class="clear"></div>
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
        $('#select-ck, #select-type, #select-product, #select-status').selectize({
            
        });
    </script>
    <script type="text/javascript">
        $(function(){
            getInventoryNum();
            getInventoryReal();
            getInventoryChange();
            $('.total_inventory_num').number(true, 0);
            $('.total_inventory_real').number(true, 0);
            // $('.total_inventory_change ').number(true, 0);
            $('.inventory_num').number(true, 0);
            $('.inventory_real').number(true, 0);

            // $('.inventory_change').number(true, 0);
        });
    </script>
    <!-- /jQuery Tags Input -->
    <script>
        $(document).on('click','#delete_product', function (e) {
            $(this).closest('.item-product').remove();
            getInventoryNum();
            getInventoryReal();
            getInventoryChange();
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
        $(document).on('change','.inventory_real', function (e) {
            var num = $(this).val();
            var inventory = $(this).closest('.item-product').find('.inventory_num').html();
            var change = parseInt(num) - parseInt(inventory);
            $(this).closest('.item-product').find('.inventory_change').html(change);
            getInventoryReal();
            getInventoryChange();
        });
        function getInventoryNum(){
            var inventory = 0;
            $('.inventory_num').each(function() {
                inventory = parseInt(inventory) + parseInt($(this).html());
            });
            $('.total_inventory_num').html(inventory); 
        }
        function getInventoryReal(){
            var inventoryReal = 0;
            $('.inventory_real').each(function() {
                inventoryReal = parseInt(inventoryReal) + parseInt($(this).val());
            });
            $('.total_inventory_real').html(inventoryReal); 
        }
        function getInventoryChange(){
            var inventoryChange = 0;
            $('.inventory_change').each(function() {
                inventoryChange = parseInt(inventoryChange) + parseInt($(this).html());
            });
            $('.total_inventory_change').html(inventoryChange); 
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
                                + '<td class="non-dis" style=""><span class="code-product">' + msg['code'] + '</span></span>'
                                + '<td><span class="name-product">' + msg['name'] + '</span></span>'
                                + '<input type="hidden" value="' + id + '" name="product_id[]">'
                                + '<input type="hidden" value="' + msg['name'] + '" name="nameproduct[]"></td>'
                                + '<td><span class="inventory_num">' + msg['inventory_num'] + '</span>'
                                + '<input type="hidden" value="' + msg['inventory_num'] + '" name="inventory_num[]">'
                                + '</td>'
                                + '<td><input type="text" class="inventory_real input-non-bTr" style="width:70px;" name="inventory_real[]" value=""></td>'
                                + '<td class="non-dis"><span class="inventory_change"><span></td>'
                                + '<td><i class="fa fa-times red delete" id="delete_product" style="cursor: pointer" aria-hidden="true"></i></td>'
                                + '</tr>'
                        );
                        price_total = price_total + parseInt(msg['price']);
                        //alert(price_total);
                        $('.allpaymoney').html(price_total);
                        getInventoryNum();
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

@endsection