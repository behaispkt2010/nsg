@extends('layouts.admin')
@section('title', 'permissions ')
@section('pageHeader','permissions ')
@section('detailHeader','danh sách')
@section('add_styles')
        <!-- Datatables -->
<link href="{{asset('plugin/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
<link href="{{asset('plugin/datatables.net-buttons-bs/css/buttons.bootstrap.min.css')}}" rel="stylesheet">
<link href="{{asset('plugin/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet">
<link href="{{asset('plugin/datatables.net-responsive-bs/css/responsive.bootstrap.min.css')}}" rel="stylesheet">
<link href="{{asset('plugin/datatables.net-scroller-bs/css/scroller.bootstrap.min.css')}}" rel="stylesheet">
@endsection
@section('new-btn')
    <a href="{{route('permission.create')}}" class="btn btn-warning btn-fab" title="Tạo Phân quyền mới">
        <i class="fa fa-paper-plane material-icons new-btn" aria-hidden="true"></i>
    </a>
@endsection
@section('content')
    <br>
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <!-- Name and Description -->
        </div>
    </div>
    <div class="x_panel">
        <table id="table" class="table table-striped table-bordered bulk_action" data-form="deleteForm">
            <thead>
            <tr>
                <th>Tên</th>
                {{--<th>Route</th>--}}
                <th>Route</th>
                <th>Mô tả</th>

                <th></th>
            </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
    @include('admin.partial.modal_delete')

    @endsection

    @section('add_scripts')
            <!-- Datatables -->
    <script src="{{asset('plugin/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('plugin/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{asset('plugin/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('plugin/datatables.net-buttons-bs/js/buttons.bootstrap.min.js')}}"></script>
    <script src="{{asset('plugin/datatables.net-buttons/js/buttons.flash.min.js')}}"></script>
    <script src="{{asset('plugin/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('plugin/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
    <script src="{{asset('plugin/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js')}}"></script>
    <script src="{{asset('plugin/datatables.net-keytable/js/dataTables.keyTable.min.js')}}"></script>
    <script src="{{asset('plugin/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('plugin/datatables.net-responsive-bs/js/responsive.bootstrap.js')}}"></script>
    <script src="{{asset('plugin/datatables.net-scroller/js/datatables.scroller.min.js')}}"></script>
    <script src="{{asset('plugin/jszip/dist/jszip.min.js')}}"></script>
    <script src="{{asset('plugin/pdfmake/build/pdfmake.min.js')}}"></script>
    <script src="{{asset('plugin/pdfmake/build/vfs_fonts.js')}}"></script>


    <script type="text/javascript">
                @if(isset($type))
                var oTable;
        $(document).ready(function () {
            oTable = $('#table').DataTable({
                "language": {
                    "url": "/plugin/datatable-lang/Vietnamese.json"
                },
                "processing": true,
                "serverSide": true,
                "order": [],
                "ajax": "{{ url('admin/'.$type.'/data/json') }}",
            });
        });
        @endif
    </script>
@endsection

