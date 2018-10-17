@extends('layouts.admin')
@if(Request::is('admin/orders/create'))
@section('title', 'Thêm đơn hàng')
@else
@section('title', 'Sửa đơn hàng')
@endif
@section('pageHeader','Đơn hàng')
@section('detailHeader','tạo/chỉnh sửa đơn hàng')
@section('content')
@section('add_styles')
        <!-- Datatables -->
<link href="{{asset('css/bootstrap-material-datetimepicker.css')}}" rel="stylesheet">

@endsection
<div class="row">
    <br>
    @if(Request::is('admin/orders/create'))
        <form action="{{route('orders.store')}}" method="POST" enctype="multipart/form-data">
            @else
                <form action="{{route('orders.update',['id' => $id])}}" method="POST" enctype="multipart/form-data">
                    {{ method_field('PUT') }}
                    <input type="hidden" name="id" value="{{ $id }}">
                    @endif
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="col-md-8 col-xs-12 col-lg-8">
                        <!-- Name and Description -->
                        <div class="x_panel">
                            @if(Request::is('admin/orders/create'))
                                <h2>Thông tin đơn hàng</h2>
                            @else
                            <?php 
                            // echo "<pre>";
                            // print_r($arrOrder);
                            // echo "</pre>";
                            // die();
                            ?>
                                <h2>Chi tiết đơn hàng {!! $arrOrder->order_code !!}</h2>
                            @endif
                            <div class="row col-xs-12 col-md-12 col-lg-12">
                                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                    <select id="select-category" name="category" class="form-control" data-placeholder="Danh mục sản phẩm">
                                        <option></option>
                                        <?php $category = \App\CategoryProduct::where('disable',0)->get();?>
                                        {{ \App\Category::CateMulti($category,0,$str="",old('parent')) }}
                                    </select>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                    <select id="select-product" name="select-product"  class="form-control " placeholder="Thêm sản phấm">
                                        <option value=""></option>
                                        @if(!empty($products))
                                            @foreach($products as $product)
                                                <option value="{{$product->id}}" data-image="dsa" data-name="dsa">
                                                    {{$product->title}} ({{\App\Util::ProductCode($product->id)}})
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                    <button type="button" id="btn_add_product" class="btn btn-raised btn-success">Thêm</button>
                                </div>
                                <input type="hidden" class="form-control" name="slug" placeholder="slug" id="txtSlug" required>
                            </div>
                            <table class="table table-condensed table-hover" style="    border-top-style: hidden;">
                                <tbody class="list_product" style="width:100%;">
                                    <tr>
                                        <th class="non-dis">Mã</th>
                                        <th>Tên sản phẩm</th>
                                        <th>Giá</th>
                                        <th>Số lượng</th>
                                        <th class="non-dis">Tồn kho</th>
                                        <th></th>
                                    </tr>
                                @if(Request::is('admin/orders/create'))
                                @else
                                    @foreach($arrProductOrders as $arrProductOrder)
                                        <tr class="item-product">
                                            <td  class="non-dis" style=""><span class="code-product"><span>{{ $arrProductOrder->code }} </span></span>
                                            </td>
                                            <td><span class="name-product"><span>{{ $arrProductOrder->title }} </span></span>
                                                <input type="hidden" value="{!! $arrProductOrder->id_product !!}" name="product_id[]">
                                            </td>
                                            <td><span class="price-product"><span>{!! \App\Util::FormatMoney($arrProductOrder->price_out) !!}</span> </span>
                                            <input type="hidden" name="price_product_tmp[]" value="{{ $arrProductOrder->price_out }}">
                                            </td>
                                            <td><span>x</span><input type="number" class="number-product" style="width:70px;" name="product_number[]" value="{{ $arrProductOrder->num }}">
                                                <input type="hidden" value="{{ $arrProductOrder->price }}" name="pricetotal[]">
                                            </td>
                                            <td class="non-dis">
                                                <span class="inventory_num">{{ number_format($arrProductOrder->inventory_num) }}</span>
                                                <!-- <span class="total"> <span>{!! \App\Util::FormatMoney($arrProductOrder->price) !!}</span></span> -->
                                                </td>
                                            <td><i class="fa fa-times red delete" id="delete_product" style="cursor: pointer" aria-hidden="true"></i></td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                            
                            <div class="row">
                                <hr>
                                <div class="col-md-8 col-md-offset-4 col-xs-12">
                                    <div class="form-group">
                                        <div class="row col-md-12 col-xs-12">
                                            <label class="col-md-6 col-xs-6 control-label text-right">Tổng giá trị sản phẩm</label>
                                            <div class="col-md-5 col-xs-5">
                                                <input type="text" name="allpaymoney" value="" class="form-control allpaymoney" disabled="" placeholder="10,000 "> 
                                            </div>
                                            <div class="col-md-1 col-xs-1 pT-7">VNĐ</div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row col-md-12 col-xs-12">
                                            <label class="col-md-6 col-xs-6 control-label text-right">Giảm giá</label>
                                            <div class="col-md-5 col-xs-5">
                                                <input type="text" name="discount" value="@if(!empty($arrOrder->discount)){{$arrOrder->discount}} @else{{old('discount')}} @endif" class="form-control discount" placeholder="10,000 ">
                                            </div>
                                            <div class="col-md-1 col-xs-1 pT-7">VNĐ</div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row col-md-12 col-xs-12">
                                            <label class="col-md-6 col-xs-6 control-label text-right">Thuế</label>
                                            <div class="col-md-5 col-xs-5">
                                                <input type="text" name="tax" value="@if(!empty($arrOrder->tax)){{$arrOrder->tax}} @else{{old('tax')}} @endif" class="form-control tax" placeholder="10,000 ">
                                            </div>
                                            <div class="col-md-1 col-xs-1 pT-7">VNĐ</div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row col-md-12 col-xs-12">
                                            <label class="col-md-6 col-xs-6 control-label text-right">Phí vận chuyển</label>
                                            <div class="col-md-5 col-xs-5">
                                                <input type="text" name="transport_pay" value="@if(!empty($arrOrder->transport_pay)){{$arrOrder->transport_pay}} @else{{old('transport_pay')}} @endif" class="form-control transport_pay" placeholder="10,000 ">
                                            </div>
                                            <div class="col-md-1 col-xs-1 pT-7">VNĐ</div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row col-md-12 col-xs-12">
                                            <label class="col-md-6 col-xs-6 control-label text-right">Tổng đơn hàng</label>
                                            <div class="col-md-5 col-xs-5">
                                                <input type="text" name="totalOrderTmp" value="" class="form-control totalOrderTmp" disabled="" placeholder="10,000 ">
                                            </div>
                                            <div class="col-md-1 col-xs-1 pT-7">VNĐ</div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="clear"></div>
                            <hr>
                            <div class="form-group">
                                <div class="col-md-6 col-xs-12">
                                    <label style="margin-bottom: 16px;">Ghi chú</label>
                                    <textarea class="form-control note-order-edit"  rows="10" name="note">@if(!empty($arrOrder->note)){{$arrOrder->note}}@else{{old('note')}}@endif</textarea>

                                </div>
                                
                                <div class="col-md-6 col-xs-12" style="margin-top: -10px;">
                                    <div class="form-group">
                                        <label>Thông tin vận chuyển</label>
                                        <select id="select-transport" name="select_transport" class="form-control" data-placeholder="Tên | Số điện thoại">
                                            <option></option>
                                            @foreach($driver as $itemDriver)
                                                <option style="width: 100%; white-space: nowrap;overflow: hidden;text-overflow: ellipsis;" value="{{$itemDriver->id}}">{{$itemDriver->name_driver}} - {{ $itemDriver->phone_driver }}</option>
                                            @endforeach
                                        </select>

                                        <!-- <div class="text-center">
                                            <button type="button" class="btn btn-raised btn-success col-xs-12" data-toggle="modal"
                                                    data-target=".modal-transport">Tạo thông tin vận chuyển mới
                                            </button>
                                        </div> -->
                                    </div>

                                    <div class="tmp_type_driver ">@if(!empty($arrOrder->name))
                                            <label for="" class="transport_tmp">Loại xe: </label>
                                            <span> {{$arrOrder->name}}@else{{old('name')}} </span> @endif
                                    </div>
                                    <div class="tmp_name_driver ">@if(!empty($arrOrder->name_driver))
                                            <label for="" class="transport_tmp">Tên tài xế: </label>
                                            <span> {{$arrOrder->name_driver}}@else{{old('name_driver')}} </span> @endif
                                    </div>
                                    <div class="tmp_phone_driver ">@if(!empty($arrOrder->phone_driver))
                                            <label for="" class="transport_tmp">Số điện thoại: </label>
                                            <span> {{$arrOrder->phone_driver}}@else{{old('phone_driver')}} </span> @endif
                                    </div>
                                    <div class="tmp_number_license_driver ">@if(!empty($arrOrder->number_license_driver))
                                            <label for="" class="transport_tmp">Biển số xe: </label>
                                            <span> {{$arrOrder->number_license_driver}}@else{{old('number_license_driver')}} </span> @endif
                                    </div>
                                    <input type="hidden" name="id_driver" class="id_driver" value="@if(!empty($arrOrder->id_driver)){{$arrOrder->id_driver}}@else{{old('id_driver')}}@endif">
                                    <input type="hidden" name="name_driver" class="name_driver" value="@if(!empty($arrOrder->name_driver)){{$arrOrder->name_driver}}@else{{old('name_driver')}}@endif">
                                    <input type="hidden" name="phone_driver" class="phone_driver" value="@if(!empty($arrOrder->phone_driver)){{$arrOrder->phone_driver}}@else{{old('phone_driver')}}@endif">
                                    <input type="hidden" name="number_license_driver" class="number_license_driver" value="@if(!empty($arrOrder->number_license_driver)){{$arrOrder->number_license_driver}}@else{{old('number_license_driver')}}@endif">
                                </div>
                            </div>
                            
                            <!-- <div class="clear"></div>
                            <hr>
                            <div class="footer_order">
                                <span><i class="fa fa-id-card-o" aria-hidden="true"></i>Xác nhận thanh toán</span>
                                <button type="button" class="btn btn-raised btn-success" data-toggle="modal"
                                        data-target=".modal-order" style="font-size: 12px">Đã thanh toán
                                </button>

                                <input type="hidden" value="@if(!empty($arrOrder->type_pay)){!! $arrOrder->type_pay !!} @else{!! "" !!} @endif" name="type_pay">
                                <button type="button" class="btn btn-raised btn-primary" id="thanhtoansau" data-toggle="modal"
                                        data-target=".modal-order-1" data-received_pay="@if(!empty($arrOrder->received_pay)){!! $arrOrder->received_pay !!} @else{!! "" !!} @endif" data-remain_pay="@if(!empty($arrOrder->remain_pay)){!! $arrOrder->remain_pay !!} @else{!! "" !!} @endif" style="font-size: 12px">Đặt cọc | Thanh toán sau
                                </button>
                                <input type="hidden" value="@if(!empty($arrOrder->type_pay)){!! $arrOrder->type_pay !!} @else{!! "" !!} @endif" name="type_pay">
                                <input type="hidden" value="@if(!empty($arrOrder->received_pay)){!! $arrOrder->received_pay !!} @else{!! "" !!} @endif" name="received_pay">
                                <input type="hidden" value="@if(!empty($arrOrder->remain_pay)){!! $arrOrder->remain_pay !!} @else{!! "" !!} @endif" name="remain_pay">
                            </div> -->
                        </div>

                    </div>
                    <div class="col-md-4 col-xs-12">
                        <!-- Show/Hide -->
                        <div class="x_panel">
                            <div class="wrapper-content">

                                <div class="text-center">
                                    @if(Request::is('admin/orders/create'))
                                        <button type="submit" class="btn btn-raised btn-success">Tạo mới </button>
                                    @else
                                        <button type="submit" class="btn btn-raised btn-success">Cập nhật</button>
                                        <form action=""></form>
                                        <form action="{{route('orders.destroy',['id' => $id])}}" method="post" class="form-delete" style="display: inline">
                                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                                            <input type="hidden" value="{{$id}}">
                                            {{method_field("DELETE")}}
                                            <a type="submit" class = "btn btn-raised btn-danger" name ="delete_modal" style="display: inline-block">Xóa</a>
                                        </form>

                                    @endif


                                </div>
                                <div class="form-group">
                                    <label> Thời gian đặt hàng</label>
                                    <input type="text" id="date-format" name="time_order" class="form-control" value="@if(!empty($arrOrder->time_order)){{$arrOrder->time_order}}@else{{old('time_order')}}@endif" required>

                                </div>

                                <div class="form-group">
                                    <label> Tình trạng đơn hàng</label>
                                    <select id="select-tracking" name="status" required="" class="form-control" data-placeholder="Chọn tình trạng đơn hàng">
                                        @foreach($order_status as $itemOrder_status)
                                            <option value="{{$itemOrder_status->id}}" @if(!empty($arrOrder->status) && ($arrOrder->status == $itemOrder_status->id)) selected='selected' @endif>{{$itemOrder_status->name}}</option>
                                        @endforeach

                                    </select>

                                    <div class="clear"></div>
                                </div>
                            </div>
                        </div>
                        <div class="x_panel">
                            <div class="wrapper-content mt20">
                                <div class="pd-all-20 border-top-title-main">
                                    <div class="form-group">
                                        <label> Thông tin thanh toán</label>
                                        <select id="type_pay" name="type_pay" required="" class="form-control" data-placeholder="Chọn thông tin thanh toán">
                                            <option value=""></option>
                                            <option value="1" @if(!empty($arrOrder->type_pay) && $arrOrder->type_pay == 1) selected @endif>Đã thanh toán</option>
                                            <option value="2" @if(!empty($arrOrder->type_pay) && $arrOrder->type_pay == 2) selected @endif>Đặt cọc | Thanh toán sau</option>
                                        </select>
                                        
                                        <div class="form-group received_pay_div" style="@if(!empty($arrOrder->type_pay) && $arrOrder->type_pay == 1) display: none; @endif">
                                            <label class="control-label" for="focusedInput1"> Đã nhận</label>
                                            <input class="form-control received_pay" value='' type="text" name="received_pay" placeholder="@if(!empty($arrOrder->received_pay)){!! number_format($arrOrder->received_pay) !!} @else{!! "0" !!} @endif">
                                            <input type="hidden" value="@if(!empty($arrOrder->received_pay)){!! $arrOrder->received_pay !!} @else{!! "" !!} @endif" name="received_pay_old">
                                        </div>
                                        <div class="form-group remain_pay_div" style="@if(!empty($arrOrder->type_pay) && $arrOrder->type_pay == 1) display: none; @endif">
                                            <label class="control-label" for="focusedInput2"> Còn lại</label>
                                            <input class="form-control remain_pay" value='@if(!empty($arrOrder->remain_pay)){!! $arrOrder->remain_pay !!} @else{!! "" !!} @endif' type="text" name="remain_pay" required readonly="readonly" >
                                        </div>
                                        
                                        <div class="clear"></div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label>Thông tin khách hàng</label>
                                            <select id="select-kh" name="select_kh" class="form-control" data-placeholder="Tên | số điện thoại">
                                                <option></option>
                                                @foreach($customer as $itemCustomer)
                                                    <option style="width: 100%; white-space: nowrap;overflow: hidden;text-overflow: ellipsis;" value="{{$itemCustomer->id}}" @if(!empty($arrOrder->id) && ($arrOrder->customer_id == $itemCustomer->id)) selected='selected' @endif>{{$itemCustomer->name}} - {{ $itemCustomer->phone_number }}</option>
                                                @endforeach
                                            </select>

                                            <div class="text-center">
                                                <button type="button" class="btn btn-raised btn-success" data-toggle="modal"
                                                        data-target=".modal-kh">Tạo khách hàng mới
                                                </button>
                                            </div>
                                        </div>
                                        <div class="cus_name">Họ tên: <span>@if(!empty($arrCustomerOrder->name)){{$arrCustomerOrder->name}}@else{{ "" }}@endif</span></div>
                                        <div class="cus_phone_number">Phone: <span>@if(!empty($arrCustomerOrder->phone_number)){{$arrCustomerOrder->phone_number}}@else{{ "" }}@endif</span></div>
                                        <div class="cus_email">Email: <span>@if(!empty($arrCustomerOrder->email)){{$arrCustomerOrder->email}}@else{{ "" }}@endif</span></div>
                                        <div class="cus_address">Địa chỉ: <span>@if(!empty($arrCustomerOrder->address)){{$arrCustomerOrder->address}}@else{{ "" }}@endif</span></div>
                                        <div class="col-md-6"><a href="" class="view_map" target="_blank">Xem bản đồ</a></div>
                                        <div class="col-md-6"><a href="" data-toggle="modal" data-target=".edit-kh" data-name="@if(!empty($arrCustomerOrder->name)){{$arrCustomerOrder->name}}@else{{ '' }}@endif" data-email="@if(!empty($arrCustomerOrder->email)){{$arrCustomerOrder->email}}@else{{ '' }}@endif" data-phone_number="@if(!empty($arrCustomerOrder->phone_number)){{$arrCustomerOrder->phone_number}}@else{{ '' }}@endif" data-address="@if(!empty($arrCustomerOrder->address)){{$arrCustomerOrder->address}}@else{{ '' }}@endif" data-province="@if(!empty($arrCustomerOrder->province)){{$arrCustomerOrder->province}}@else{{ '' }}@endif" data-district="@if(!empty($arrCustomerOrder->district)){{$arrCustomerOrder->district}}@else{{ '' }}@endif" id="editInfoCus" class="editInfoCus" >Sửa thông tin KH</a></div>

                                        <input type="hidden" name="provinceID" id="provinceIDCus" value="@if(!empty($arrCustomerOrder->province)){{$arrCustomerOrder->province}}@else{{ '' }}@endif">
                                        <input type="hidden" name="districtID" id="districtIDCus" value="@if(!empty($arrCustomerOrder->district)){{$arrCustomerOrder->district}}@else{{ '' }}@endif">
                                        <input type="hidden" name="customer_id" class="customer_id" value="@if(!empty($arrOrder->customer_id)){{$arrOrder->customer_id}}@else{{ "" }}@endif">
                                        <input type="hidden" class="cus_name" value="@if(!empty($arrCustomerOrder->name)){{$arrCustomerOrder->name}}@else{{ "" }}@endif">
                                        <input type="hidden" class="cus_phone_number" value="@if(!empty($arrCustomerOrder->phone_number)){{$arrCustomerOrder->phone_number}}@else{{ "" }}@endif">
                                        <input type="hidden" class="cus_email" value="@if(!empty($arrCustomerOrder->email)){{$arrCustomerOrder->email}}@else{{ "" }}@endif">
                                        <input type="hidden" class="cus_address" value="@if(!empty($arrCustomerOrder->address)){{$arrCustomerOrder->address}}@else{{ "" }}@endif">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
        </form>
                <!-- modals -->
                <!-- Large modal -->
</div>
<div class="loading" style="display: none"><img src="{{url('/images/loading.gif')}}" class="img-reponsive" style="position: fixed;" alt=""></div>
@include('admin.partial.modal_delete')
<div class="modal fade bs-example-modal-km" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false"
     data-backdrop="static">
    <div class="modal-dialog bs-example-modal-km">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Thêm Thông tin vận chuyển</h4>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <label>Giảm giá đơn hàng theo</label>

                    <div id="gender" class="btn-group" data-toggle="buttons">
                        <label class="btn btn-default" data-toggle-class="btn-primary"
                               data-toggle-passive-class="btn-default">
                            <input type="radio" name="gender" value="male"> %
                        </label>
                        <label class="btn  btn-primary" data-toggle-class="btn-primary"
                               data-toggle-passive-class="btn-default">
                            <input type="radio" name="gender" value="female"> đ
                        </label>
                    </div>

                    <input class="form-control" type="text" id="last-name" name="last-name" required="required">
                </div>
                <div class="form-group">
                    <label>Lý do:</label>
                          <textarea id="message" required="required" class="form-control" name="message"
                                    data-parsley-trigger="keyup" data-parsley-minlength="20"
                                    data-parsley-maxlength="100"
                                    data-parsley-minlength-message="Come on! You need to enter at least a 20 caracters long comment.."
                                    data-parsley-validation-threshold="10"></textarea>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-raised btn-default" data-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-raised btn-primary">Thêm khuyến mãi</button>
            </div>

        </div>
    </div>
</div>


<div class="modal fade modal-transport" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false"
     data-backdrop="static">
    <div class="modal-dialog modal-transport">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Thêm thông tin vận chuyển</h4>
            </div>
            <div class="modal-body">

                <div class="form-group">

                    <div class="form-group label-floating">
                        <label class="control-label" for="focusedInput2"> Phương thức vận chuyển</label>
                        <input class="form-control" id="focusedInput2" type="text" name="type_driver" value=" ">
                    </div>
                    <div class="form-group label-floating">
                        <label class="control-label" for="focusedInput2"> Tên tài xế</label>
                        <input class="form-control" id="focusedInput2" type="text" name="name_driver" value=" ">
                    </div>
                    <div class="form-group label-floating">
                        <label class="control-label" for="focusedInput2"> Số điện thoại</label>
                        <input class="form-control" id="focusedInput2" type="text" name="phone_driver" value=" ">
                    </div>
                    <div class="form-group label-floating">
                        <label class="control-label" for="focusedInput2"> Biển số xe</label>
                        <input class="form-control" id="focusedInput2" type="text" name="number_license_driver" value=" ">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-raised btn-default" data-dismiss="modal">Đóng</button>
                <button type="button" id="create_transport" class="btn btn-raised btn-success">Thêm thông tin vận chuyển</button>
            </div>
        </div>
    </div>
    <div class="loading" style="display: none"><img src="{{url('/images/loading.gif')}}" class="img-reponsive" alt=""></div>
</div>


<div class="modal fade modal-kh" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false"
     data-backdrop="static">
    <div class="modal-dialog modal-kh">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Thêm Thông tin khách hàng</h4>
            </div>
            <div class="modal-body">


                <div class="form-group">
                    <div class="form-group label-floating">
                        <label class="control-label" for="focusedInput2"> Họ và tên</label>
                        <input class="form-control" id="focusedInput2" type="text" name="name">
                    </div>
                    <div class="form-group label-floating">
                        <label class="control-label" for="focusedInput1"> Email</label>
                        <input class="form-control" id="focusedInput1" type="email" name="email">
                    </div>
                    <div class="form-group label-floating">
                        <label class="control-label" for="focusedInput1"> Số điện thoại</label>
                        <input class="form-control" id="focusedInput1" type="number" name="phone_number">
                    </div>

                    <div class="form-group label-floating">
                        <label class="control-label" for="focusedInput3">Địa chỉ</label>
                        <input class="form-control" id="focusedInput3" type="text" name="address">
                    </div>
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <select id="t" class="form-control" name="t">
                                    <option value="0">Chọn khu vực</option>
                                    @foreach($province as $item)
                                        <option value="{{$item->provinceid}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <select id="q" class="form-control" name="q">
                                    <option value="0">Chọn phường xã</option>
                                    <!-- @foreach($district as $item)
                                        <option value="{{$item->name}}">{{$item->name}}</option>
                                    @endforeach -->
                                </select>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-raised btn-default" data-dismiss="modal">Đóng</button>
                <button id="create_cusommer"  type="button" class="btn btn-raised btn-primary">Thêm khách hàng</button>
            </div>

        </div>
    </div>
    <div class="loading" style="display: none"><img src="{{url('/images/loading.gif')}}" class="img-reponsive" alt=""></div>
</div>
<!-- edit info customer -->
<div class="modal fade edit-kh" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false"
     data-backdrop="static">
    <div class="modal-dialog edit-kh">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Sửa Thông tin khách hàng</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="form-group">
                        <label class="control-label" for="focusedInput2"> Họ và tên</label>
                        <input class="form-control" id="focusedInput2" type="text" name="name">
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="focusedInput1"> Email</label>
                        <input class="form-control" id="focusedInput1" type="email" name="email">
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="focusedInput1"> Số điện thoại</label>
                        <input class="form-control" id="focusedInput1" type="number" name="phone_number">
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="focusedInput3">Địa chỉ</label>
                        <input class="form-control" id="focusedInput3" type="text" name="address">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <select id="province" class="form-control select2_single" name="province">
                                    <option value="0">Chọn khu vực</option>
                                    @foreach($province as $item)
                                        <option value="{{$item->provinceid}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <select id="district" class="form-control" name="district">
                                    <option value="0">Chọn phường xã</option>
                                    <!-- @foreach($district as $item)
                                        <option value="{{$item->name}}">{{$item->name}}</option>
                                    @endforeach -->
                                </select>
                            </div>
                        </div>
                        <!-- <input type="hidden" name="provinceID" class="provinceID" value="">
                        <input type="hidden" name="districtID" class="districtID" value=""> -->
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-raised btn-default" data-dismiss="modal">Đóng</button>
                <button id="edit_cusommer" type="button" class="btn btn-raised btn-primary">Sửa thông tin khách hàng</button>
            </div>

        </div>
    </div>
    <div class="loading" style="display: none"><img src="{{url('/images/loading.gif')}}" class="img-reponsive" alt=""></div>
</div>

<div class="modal fade modal-order" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-order">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Xác nhận</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <p>Xác nhận đã thanh toán cho đơn hàng này?
                    </p>
                    <p> Trạng thái thanh toán của đơn hàng này là ĐÃ THANH TOÁN. Nghĩa là bạn đã nhận đầy đủ tiền từ khách hàng bằng tiền mặt hoặc chuyển khoản.
                        Sau khi đơn hàng đã tạo, bạn không thể thay đổi trạng thái thanh toán.
                    </p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-raised btn-default" data-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-raised btn-primary btnPayAll">Xác nhận</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade modal-order-1 datcoc" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-order-1">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Xác nhận</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <p>Xác nhận đã thanh toán cho đơn hàng này?
                    </p>

                    <p> Trạng thái thanh toán của đơn hàng này là ĐẶT CỌC | THANH TOÁN SAU. Nghĩa là bạn đã nhận 1 khoản tiền đặt cọc hoặc chưa nhận từ khách hàng và họ sẽ thanh toán khoản còn lại sau khi giao hàng.
                        Sau khi đơn hàng đã tạo, bạn không thể thay đổi trạng thái thanh toán.
                    </p>

                    <p> Nhập thông tin thanh toán cho đơn hàng này</p>
                    <div class="form-group">
                        <label class="control-label" for="focusedInput1"> Đã nhận</label>
                        <input class="form-control received_pay" value="" type="number" name="received_pay" required >
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="focusedInput2"> Còn lại</label>
                        <input class="form-control remain_pay" value="" type="number" name="remain_pay" required readonly="readonly" >
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-raised btn-default" data-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-raised btn-primary btnPay">Xác nhận</button>
            </div>

        </div>
    </div>
</div>
@endsection

@section('add_scripts')
        <!-- jQuery autocomplete -->
<script src="{{asset('plugin/devbridge-autocomplete/dist/jquery.autocomplete.min.js')}}"></script>
<script type="text/javascript" src="{{asset('plugin/moment/min/moment-with-locales.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/bootstrap-material-datetimepicker.js')}}"></script>
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
<!-- Select2 -->
<script>
    $('#select-tracking, #type_pay').selectize({});
</script>
<script type="text/javascript">
    function pricetotal(){
        var price = 0;
        $('input[type="hidden"][name="pricetotal[]"]').each(function() {
            price = parseInt(price) + parseInt($(this).val());
        });
        $('.allpaymoney').val(price);
        $('.discount').number( true, 0 );
        $('.allpaymoney').number( true, 0 );
        $('.tax').number( true, 0 );
        $('.transport_pay').number( true, 0 );
        $('.received_pay').number( true, 0 );
        $('.remain_pay').number( true, 0 );
        
    }
    $(document).ready(function () {
        $('#date-format').bootstrapMaterialDatePicker
        ({
            format: 'DD/MM/YYYY',
            lang: 'vi',
            time: false,
        });
        
    });
</script>
<!-- Select2 -->
<script>
    $('#select-kh,.select-payment,#select-product,#select-category,#select-transport').selectize({
        create: true,
        sortField: 'text'
    });
</script>
<script type="text/javascript">
    function pricecaculator(){
        var price = 0;
        var discount = ($(".discount").val() > 0) ? $(".discount").val() : 0;
        var tax = ($(".tax").val() > 0) ? $(".tax").val() : 0;
        var transport_pay =($(".transport_pay").val() > 0) ? $(".transport_pay").val() : 0;
        $('input[type="hidden"][name="pricetotal[]"]').each(function() {
            price = parseInt(price) + parseInt($(this).val());
        });
        var totalOder = parseInt(price) - parseInt(discount) + parseInt(tax) + parseInt(transport_pay);
        return totalOder;
    }
    $('.received_pay').on('change', function() {
        var allpaymoney = pricecaculator();
        var pay_receive = $(this).val();
        var received = $('input[type="hidden"][name="received_pay_old"]').val();
        pay_remain = allpaymoney - pay_receive - received;
        $('.remain_pay').val(pay_remain);
        /*alert(allpaymoney);
        console.log(allpaymoney);*/
    });
</script>
<script>
    $('#select-kh').on('change', function (e) {
        e.preventDefault();
        var id_select_kh = $('select[name="select_kh"] :selected').val();
        var _token = $('input[name="_token"]').val();
        $('.loading').css('display', 'block');
        $.ajax({
            type: "POST",
            url: '{!! url("/") !!}/admin/users/AjaxGetDataCustomer',
            data: {id_select_kh: id_select_kh, _token: _token},
            success: function (msg) {
                $('.loading').css('display', 'none');
                $('.cus_name span').text(msg['name']);
                $('.cus_phone_number span').text(msg['phone_number']);
                $('.cus_email span' ).text(msg['email']);
                $('.cus_address span').text(msg['address']);
                $('.customer_id').val(msg['customer_id']);
                // add info edit customer
                
                $('#editInfoCus').attr('data-name', msg['name']);
                $('#editInfoCus').attr('data-email', msg['email']);
                $('#editInfoCus').attr('data-phone_number', msg['phone_number']);
                $('#editInfoCus').attr('data-address', msg['address']);
                $('#editInfoCus').attr('data-province', msg['province']);
                $('#editInfoCus').attr('data-district', msg['district']);
                $('#provinceIDCus').val(msg['province']);
                $('#districtIDCus').val(msg['district']);

                $('.view_map').attr('href','https://www.google.com/maps/search/'+msg['address']);
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                //show notify
                var Data = JSON.parse(XMLHttpRequest.responseText);
                new PNotify({
                    title: 'Lỗi',
                    text: 'Không tải được thông tin',
                    type: 'danger',
                    hide: true,
                    styling: 'bootstrap3'
                });
                $('.loading').css('display', 'none');
            }
        });
    });
    $('#select-transport').on('change', function (e) {
        e.preventDefault();
        var id_select_transport = $('select[name="select_transport"] :selected').val();
        var _token = $('input[name="_token"]').val();
        $('.loading').css('display', 'block');
        $.ajax({
            type: "POST",
            url: '{!! url("/") !!}/admin/driver/AjaxGetDataTransport',
            data: {id_select_transport: id_select_transport, _token: _token},
            success: function (msg) {
                $('.loading').css('display', 'none');
                $('.tmp_type_driver').html('<label class="transport_tmp">Phương thức vận chuyển: </label>' + '<span>' + msg['name'] + '</span>');
                $('.tmp_name_driver').html('<label class="transport_tmp">Tên tài xế: </label>' + '<span>' + msg['name_driver'] + '</span>');
                $('.tmp_phone_driver').html('<label class="transport_tmp">Số điện thoại: </label>' + '<span>' + msg['phone_driver'] + '</span>');
                $('.tmp_number_license_driver').html('<label class="transport_tmp">Biển số xe: </label>' + '<span>' + msg['number_license_driver'] + '</span>');
                $('.id_driver').val(msg['id_driver']);
                $('.name_driver').val(msg['name_driver']);
                $('.phone_driver').val(msg['phone_driver']);
                $('.number_license_driver').val(msg['number_license_driver']);
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                //show notify
                var Data = JSON.parse(XMLHttpRequest.responseText);
                new PNotify({
                    title: 'Lỗi',
                    text: 'Không tải được thông tin',
                    type: 'danger',
                    hide: true,
                    styling: 'bootstrap3'
                });
                $('.loading').css('display', 'none');
            }
        });
    });
    $("#select-category").on('change', function(e) {
        e.preventDefault();
        var id_select_cate = $('select[name="category"] :selected').val();
        var _token = $('input[name="_token"]').val();
        $.ajax({
            type: "POST",
            url: '{!! url("/") !!}/admin/categoryProducts/AjaxGetCategory',
            data: {id_select_cate: id_select_cate, _token: _token},
            success: function (msg) {
                $('#select-product').selectize()[0].selectize.destroy();
                $('#select-product').html(msg);
                $('#select-product').selectize();
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                //show notify
                var Data = JSON.parse(XMLHttpRequest.responseText);
                new PNotify({
                    title: 'Lỗi',
                    text: 'Không tải được thông tin',
                    type: 'danger',
                    hide: true,
                    styling: 'bootstrap3'
                });
                $('.loading').css('display', 'none');
            }
        });
    });
</script>

<script type="text/javascript">
    $(document).on("click", ".editInfoCus", function () {
        var _self = $(this);
        _self.removeData();
        $('.edit-kh input[name="name"]').val(_self.data('name'));
        $('.edit-kh input[name="email"]').val(_self.data('email'));
        $('.edit-kh input[name="phone_number"]').val(_self.data('phone_number'));
        $('.edit-kh input[name="address"]').val(_self.data('address'));
        $('.edit-kh input[name="provinceID"]').val(_self.data('province'));
        $('.edit-kh input[name="districtID"]').val(_self.data('district'));
    });
</script>
<script>
    $('#create_cusommer').on('click', function (e) {
        e.preventDefault();
        var name = $('.modal-kh input[name="name"]').val();
        var phone_number = $('.modal-kh input[name="phone_number"]').val();
        var t = $('.modal-kh select[name="t"] :selected').val();
        var provinceName = $('.modal-kh select[name="t"] :selected').html();
        var q = $('.modal-kh select[name="q"] :selected').val();
        var districstName = $('.modal-kh select[name="q"] :selected').html();
        var email = $('.modal-kh input[name="email"]').val();
        var address = $('.modal-kh input[name="address"]').val() +', '+ districstName +', '+ provinceName;
        var addressDB = $('.modal-kh input[name="address"]').val();
        var _token = $('input[name="_token"]').val();
        $('.loading').css('display','block');
        $.ajax({
            type: "POST",
            url: '{!! url("/") !!}/admin/users/AjaxCreateCustomer',
            data: {name: name,t: t,q: q, phone_number: phone_number, email: email, address: addressDB,_token: _token},
            success: function( msg ) {
                $('.loading').css('display','none');
                //show notify
                new PNotify({
                    title: 'Cập nhật thành công',
                    text: '',
                    type: 'success',
                    hide: true,
                    styling: 'bootstrap3'
                });
//                location.reload();
                $('.cus_name span').text(name);
                $('.cus_phone_number span').text(phone_number);
                $('.cus_email span' ).text(email);
                $('.cus_address span').text(address);
                $('.customer_id').val(msg['customer_id']);
                $('.view_map').attr('href','https://www.google.com/maps/search/'+msg['address']);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                //show notify
                var Data = JSON.parse(XMLHttpRequest.responseText);
                new PNotify({
                    title: 'Lỗi',
                    text: 'Vui lòng kiểm tra lại thông tin',
                    type: 'danger',
                    hide: true,
                    styling: 'bootstrap3'
                });
                $('.loading').css('display','none');
            }
        }).done(function () {
            $('.modal-kh').modal('hide');
        });
    });
    $('#edit_cusommer').on('click', function (e) {
        e.preventDefault();
        var name = $('.edit-kh input[name="name"]').val();
        var phone_number = $('.edit-kh input[name="phone_number"]').val();
        var t = $('.edit-kh select[name="province"] :selected').val();
        var provinceName = $('.edit-kh select[name="province"] :selected').html();
        var q = $('.edit-kh select[name="district"] :selected').val();
        var districstName = $('.edit-kh select[name="district"] :selected').html();
        var email = $('.edit-kh input[name="email"]').val();
        var address = $('.edit-kh input[name="address"]').val() +', '+ districstName +', '+ provinceName;
        var addressDB = $('.edit-kh input[name="address"]').val();
        var customer_id = $('.customer_id').val();
        var _token = $('input[name="_token"]').val();
        $('.loading').css('display','block');
        $.ajax({
            type: "POST",
            url: '{!! url("/") !!}/admin/users/AjaxEditCustomer',
            data: {name: name,customer_id: customer_id,t: t,q: q, phone_number: phone_number, email: email, address: addressDB,_token: _token},
            success: function( msg ) {
                $('.loading').css('display','none');
                //show notify
                new PNotify({
                    title: 'Cập nhật thành công',
                    text: '',
                    type: 'success',
                    hide: true,
                    styling: 'bootstrap3'
                });
//                location.reload();
                $('.cus_name span').text(name);
                $('.cus_phone_number span').text(phone_number);
                $('.cus_email span' ).text(email);
                $('.cus_address span').text(address);
                $('.customer_id').val(msg['customer_id']);
                $('.view_map').attr('href','https://www.google.com/maps/search/'+msg['address']);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                //show notify
                var Data = JSON.parse(XMLHttpRequest.responseText);
                new PNotify({
                    title: 'Lỗi',
                    text: 'Vui lòng kiểm tra lại thông tin',
                    type: 'danger',
                    hide: true,
                    styling: 'bootstrap3'
                });
                $('.loading').css('display','none');
            }
        }).done(function () {
            $('.edit-kh').modal('hide');
        });
    });

    //Add infomation transport
    $("#create_transport").on('click', function (e) {
        e.preventDefault();
        var type_driver = $('.modal-transport input[name="type_driver"]').val();
        var tmp_type_driver = '<label class="transport_tmp">Phương thức vận chuyển: </label>' + '<span>' + type_driver + '</span>';
        var name_driver = $('.modal-transport input[name="name_driver"]').val();
        var tmp_name_driver = '<label class="transport_tmp">Tên tài xế: </label>' + '<span>' + name_driver + '</span>';
        var phone_driver = $('.modal-transport input[name="phone_driver"]').val();
        var tmp_phone_driver = '<label class="transport_tmp">Số điện thoại: </label>' + '<span>' + phone_driver + '</span>';
        var number_license_driver = $('.modal-transport input[name="number_license_driver"]').val();
        var tmp_number_license_driver = '<label class="transport_tmp">Biển số xe: </label>' + '<span>' + number_license_driver + '</span>';
        
        var _token = $('input[name="_token"]').val();
        $('.loading').css('display','block');
       
        $.ajax({
            type: "POST",
            url: '{!! url("/") !!}/admin/driver/AjaxCreateTransport',
            data: {type_driver: type_driver,name_driver: name_driver, phone_driver: phone_driver, number_license_driver: number_license_driver,_token: _token},
            success: function( msg ) {
                //console.log(msg);
                $('.loading').css('display','none');
                //show notify
                new PNotify({
                    title: 'Tạo mới thành công',
                    text: '',
                    type: 'success',
                    hide: true,
                    styling: 'bootstrap3'
                });
//                location.reload();
                $('.tmp_type_driver').html('<p>' + tmp_type_driver + '</p>');
                $('.tmp_name_driver').html('<p>' + tmp_name_driver + '</p>');
                $('.tmp_phone_driver').html('<p>' + tmp_phone_driver + '</p>');
                $('.tmp_number_license_driver').html('<p>' + tmp_number_license_driver + '</p>');
                
                $('.type_driver').val(type_driver);
                $('.name_driver').val(name_driver);
                $('.phone_driver').val(phone_driver);
                $('.number_license_driver').val(number_license_driver);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                //show notify
                var Data = JSON.parse(XMLHttpRequest.responseText);
                new PNotify({
                    title: 'Lỗi',
                    text: 'Vui lòng kiểm tra lại thông tin',
                    type: 'danger',
                    hide: true,
                    styling: 'bootstrap3'
                });
                $('.loading').css('display','none');
            }
        }).done(function () {
            $('.modal-transport').modal('hide');
        });
    });
</script>
<script>
    $('.btnPayAll').on('click', function () {
        $('input[type="hidden"][name="type_pay"]').val('1');
        $('.modal-order').modal('hide');
    });
    $('.btnPay').on('click', function () {
        $('input[type="hidden"][name="type_pay"]').val('2');
        var received_pay = $('.received_pay').val();
        var remain_pay = $('.remain_pay').val();
        $('input[type="hidden"][name="received_pay"]').val(received_pay);
        $('input[type="hidden"][name="remain_pay"]').val(remain_pay);
        if(received_pay== "" | remain_pay==""){
            alert("Vui lòng nhập số tiền Đã thanh toán và số tiền Còn lại !");
        }
        else {
            $('.modal-order-1').modal('hide');
        }
    });

    $(document).on('click','#delete_product', function (e) {
        $(this).closest('.item-product').remove();
        pricetotal();
        countTotalOrder();
    });
    $(document).on('change','.number-product', function (e) {
        var num = $(this).val();
        var price = $(this).closest('.item-product').find('input[type="hidden"][name="price_product_tmp[]"]').val();
        
        var total = num*price;
        $(this).closest('.item-product').find('.total span').text(total);
        $('.total span').number(true, 0);
        $(this).closest('.item-product').find('input[type="hidden"][name="pricetotal[]"]').val(total);
        pricetotal();
        countTotalOrder();
    });
    function ProductIDExist(str){
        //console.log($('tr[id*=output_newrow]').length)
        //var testme = false;
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
                    var inventory_num = msg['inventory_num'];
                    if(inventory_num <= 10) {
                        alert('Sản phẩm này sắp hết hàng, vui lòng kiểm tra lại kho !!!');
                    }
                    $('.loading').css('display', 'none');
                    $('.list_product').append('<tr class="item-product">'
                            + '<td class="non-dis" style=""><span class="code-product">' + msg['code'] + '</span></span>'
                            + '<td><span class="name-product">' + msg['name'] + '</span></span><input type="hidden" value="' + id + '" name="product_id[]"></td>'
                            + '<td><span class="price-product"><span>' + msg['price'] + '</span>VNĐ </span><input type="hidden" value="' + msg['price'] + '" name="price_product_tmp[]"></td>'
                            + '<td><span>x</span><input type="number" class="number-product" style="width:70px;" name="product_number[]" value="1"><input type="hidden" value="' + msg['price'] + '" name="pricetotal[]"></td>'
                            + '<td class="non-dis"><span class="inventory_num">' + msg['inventory_num'] + ' <span></td>'
                            + '<td><i class="fa fa-times red delete" id="delete_product" style="cursor: pointer" aria-hidden="true"></i></td>'
                            + '</tr>'
                    );
                    
                    /*$('.list_product_respone').append('<div class="clear"></div>'
                            +'<hr>'
                            +'<div class="item-product ">'
                            + '<div class="img_product_respone col-xs-3">'
                            +    '<img src="{{url('/')}}/' + msg['image'] + '" class="img-responsive img-thumbnail" alt="">'
                            +    '<i class="fa fa-times red delete-img-order" id="delete_product" style="cursor: pointer" aria-hidden="true"></i>'
                            +'</div>'
                            +'<div class="name-product col-xs-7">'
                            +    '<p><span>' + msg['name'] + '(#' + id + ')</span></span><input type="hidden" value="' + id + '" name="product_id[]"></p>'
                            +    '<span class="total"> <span>' + msg['price'] + '</span>VNĐ</span>'
                            +    '<input type="hidden" name="pricetotal[]" value="'+ msg['price'] +'" >'
                            +    '<input type="hidden" name="price_product_tmp[]" value="' + msg['price'] + '">'
                            +'</div>'
                            +'<div class="col-xs-2">'
                            +    '<span>x</span><input type="number" class="number-product" style="width:21px;" name="product_number[]" value="1">'
                            +'</div>'
                            +'</div>'
                    );*/
                    price_total = price_total + parseInt(msg['price']);
                    //alert(price_total);
                    $('.allpaymoney').html(price_total);
                    pricetotal();
                    countTotalOrder();
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
<script>
    $(document).on("click", "#transport_info", function () {
        var _self = $(this);
        $('.modal-transport input[name="name_driver"]').val(_self.data('name_driver'));
        $('.modal-transport input[name="type_driver"]').val(_self.data('type_driver'));
        $('.modal-transport input[name="phone_driver"]').val(_self.data('phone_driver'));
        $('.modal-transport input[name="number_license_driver"]').val(_self.data('number_license_driver'));
    });
</script>
<script type="text/javascript">
    $(document).on("click", "#thanhtoansau", function () {
        var _self = $(this);
        // alert(_self.data('received_pay'));
        /*var received_pay = _self.data('received_pay');
        var remain_pay = _self.data('remain_pay');*/
        $('.datcoc input[name="received_pay"]').val(_self.data('received_pay'));
        $('.datcoc input[name="remain_pay"]').val(_self.data('remain_pay'));
        // $('.received_pay').val(received_pay);
        // $('.remain_pay').val(remain_pay);
    });
</script>
<script type="text/javascript">

    $(document).ready(function () {
        updateContainer();
        pricetotal();
        countTotalOrder();
        $('.discount').on('change', function(){
            countTotalOrder();
        });
        $('.tax').on('change', function(){
            countTotalOrder();
        });
        $('.transport_pay').on('change', function(){
            countTotalOrder();
        });
    });
    var rtime;
    var timeout = false;
    var delta = 200;
    $(window).resize(function() {
        rtime = new Date();
        if (timeout === false) {
            timeout = true;
            setTimeout(resizeend, delta);
        }
    });

    function resizeend() {
        if (new Date() - rtime < delta) {
            setTimeout(resizeend, delta);
        } else {
            timeout = false;
            updateContainer();
        }
    }
    function updateContainer() {
        var width = $('.right_col').width();
        var y=0;
        if (width <= 767) {
            y=1;
        }
        else {
            y=2;
        }
        if ( y == 1 ) {
            $('.visible_xs_list_product').css('display','inline-block');
            $('.hidden_xs_list_product').remove();
            $('.hidden_xs_list_product').css('display','none');
        }
        else {
            $('.hidden_xs_list_product').css('display','inline-block');
            $('.visible_xs_list_product').remove();
            $('.visible_xs_list_product').css('display','none');
        }
    }
    function countTotalOrder() {
        var allpaymoney = $(".allpaymoney").val();
        var discount = ($(".discount").val() > 0) ? $(".discount").val() : 0;
        var tax = ($(".tax").val() > 0) ? $(".tax").val() : 0;
        var transport_pay =($(".transport_pay").val() > 0) ? $(".transport_pay").val() : 0;
        var totalOder = parseInt(allpaymoney) - parseInt(discount) + parseInt(tax) + parseInt(transport_pay);
        $(".totalOrderTmp").val(totalOder);
        $(".totalOrderTmp").number(true, 0);
        var received = $('input[type="hidden"][name="received_pay_old"]').val();
        pay_remain = totalOder - received;
        $('.remain_pay').val(pay_remain);
    }
    $('#type_pay').on('change', function(){
        var type_pay = $(this).val();
        if(type_pay == 2) {
            $('.received_pay_div').show();
            $('.remain_pay_div').show();
        } else {
            $('.received_pay_div').hide();
            $('.remain_pay_div').hide();
        }
    });
</script>
<script type="text/javascript">
    $('#province').on('change',function(){
        var countryID = $(this).val();
        var _token = $('input[name="_token"]').val();

        if(countryID){
            $.ajax({
                type:'POST',
                url:'{{ url("/") }}/admin/orders/AjaxGetDistrictByProvinceID',
                data: {id: countryID, _token: _token},
                success:function(html){
                    $('#district').selectize()[0].selectize.destroy();
                    $('#district').html(html);
                    $('#district').selectize(); 
                }
            }); 
        } else {
            $('#district').html('<option value="">Chọn Huyện/Thị trấn</option>');
        }
    });
    // get update district, provinde
    $(function(){
        $('.editInfoCus').on('click', function(){
            var districtID = $('#districtIDCus').val();
            var provinceID = $('#provinceIDCus').val();
            var _token = $('input[name="_token"]').val();
            if(provinceID){
                $.ajax({
                    type:'POST',
                    url:'{{ url("/") }}/admin/orders/AjaxLoadInfoAddress',
                    data: {id: provinceID, type: 'district', valueID: districtID , _token: _token},
                    success:function(html){
                        $('#district').selectize()[0].selectize.destroy();
                        $('#district').html(html['q']);
                        $('#district').selectize();
                        $('#province').selectize()[0].selectize.destroy();
                        $('#province').html(html['t']);
                        $('#province').selectize();
                    }
                }); 
            } else {
                $('#district').html('<option value="">Chọn Huyện/Thị trấn</option>');
            }
        });
        
    });
</script>

@endsection