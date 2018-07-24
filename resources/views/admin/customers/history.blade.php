<div class="modal-content" >
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
        </button>
        <h4 class="modal-title text-center" id="myModalLabel">Lịch sử giao dịch của khách hàng <span style="color: tomato; font-weight: bold;">{{ $customer_name }}</span></h4>
    </div>
    <div class="modal-body sroll">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <table class="table table-hover">
                    @if (count($history) != 0)
                    <thead>
                    <tr>
                        <th>Ngày giao dịch</th>
                        <th>Mã đơn hàng</th>
                        <th>Tên sản phầm</th>
                        <th>Số lượng</th>
                        <th>Giá tiền</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($history as $itemHistory)
                            <tr>
                                <td>{{ $itemHistory->time_order }}</td>
                                <td>{{ $itemHistory->order_id }}</td>
                                <td>{{ $itemHistory->name }}</td>
                                <td>{{ $itemHistory->num }}</td>
                                <td>{{ $itemHistory->price }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    @else
                        Không có giao dịch
                    @endif
                </table>
            </div>
        </div>

    </div>
    <div class="modal-footer">

    </div>
</div>
<script>
    $(function(){
        $(document).on("hidden.bs.modal", ".modal:not(.local-modal)", function (e) {
            //$(e.target).removeData("bs.modal").find(".modal-content").empty().html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw margin-bottom"></i><span class="sr-only">Loading...</span>');
            $(this).modal('hide');
            $(e.target).removeData("bs.modal").find(".modal-content").empty();
        });
    });
</script>
