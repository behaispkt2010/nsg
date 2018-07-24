@extends('layouts.admin')
@section('title', 'Danh sách bài viết ')
@section('pageHeader','Danh sách bài viết ')
@section('detailHeader','danh sách')
@section('add_styles')
        <!-- Datatables -->
<link href="{{asset('plugin/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
<link href="{{asset('plugin/datatables.net-buttons-bs/css/buttons.bootstrap.min.css')}}" rel="stylesheet">
<link href="{{asset('plugin/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet">
<link href="{{asset('plugin/datatables.net-responsive-bs/css/responsive.bootstrap.min.css')}}" rel="stylesheet">
<link href="{{asset('plugin/datatables.net-scroller-bs/css/scroller.bootstrap.min.css')}}" rel="stylesheet">
@endsection
@section('content')


    <div class="row">
        <div class="col-md-12 col-xs-12">
            <!-- Name and Description -->
            <div class="x_panel">
                <div class="circle">
                    <div class="front front-popular">
                        <div class="title color-2-font glyphicon glyphicon-plus"></div>
                    </div><!-- end div .front -->
                    <div class="popular color-2-font glyphicon glyphicon-plus"></div>
                    <div class="back color-2-bg info">
                        <a href="{{route('news.create')}}">
                            <div class="title color-2-font glyphicon glyphicon-pencil"></div>
                        </a>
                        <div class="description">
                            <p>Tạo đơn hàng</p>
                        </div><!-- end div .description -->
                    </div><!-- end div .back color-1-bg info -->
                </div><!-- end div .circle -->



                <table id="example" class="display" cellspacing="0" width="100%">

                <thead>
                    <tr>
                        {{--<th><input type="checkbox" id="check-all" class="flat"></th>--}}
                        <th></th>
                        <th>Mã</th>
                        <th>Ngày đặt </th>
                        <th>Khách hàng </th>
                        <th>Mã vận đơn</th>
                        <th>Giao hàng </th>
                        <th>Thanh toán</th>

                        <th>Tổng tiền</th>
                        <th></th>
                    </tr>
                    </thead>


                    <tbody>

                    @for($i = 0; $i<50; $i++)
                        <tr>
                            {{--<td><input type="checkbox" class="flat" name="table_records"></td>--}}
                            <td class=" details-control"></td>
                            <td><a href="{{route('orders.create')}}">#111 </a></td>
                            <td>13/11/2016 3:16 CH</td>
                            <td>nguyễn văn a</td>
                            <td></td>
                            <td>chưa</td>
                            <td>chưa</td>
                            <td>23 ₫</td>
                            <td width="100px" class="text-center">
                                <a href="" style="margin-right: 10px;display: inline-block"><i class="fa fa-pencil"  aria-hidden="true"></i></a>
                                <a href="" style="display: inline-block"><i class="fa fa-trash" aria-hidden="true"></i></a>
                            </td>
                        </tr>
                    @endfor


                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>

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
    <script>
        /* Formatting function for row details - modify as you need */
        function format(d) {
            // `d` is the original data object for the row
            return ' <div class="row edit-f">'
                   + '<div class="col-md-3">'
                    + '<div class="media-left">'
                    + ' <a href="#">'
                    + ' <img class="media-object img-product" src="data:image/gif;base64,/9j/4QAYRXhpZgAASUkqAAgAAAAAAAAAAAAAAP/sABFEdWNreQABAAQAAABaAAD/4QMqaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLwA8P3hwYWNrZXQgYmVnaW49Iu+7vyIgaWQ9Ilc1TTBNcENlaGlIenJlU3pOVGN6a2M5ZCI/PiA8eDp4bXBtZXRhIHhtbG5zOng9ImFkb2JlOm5zOm1ldGEvIiB4OnhtcHRrPSJBZG9iZSBYTVAgQ29yZSA1LjUtYzAyMSA3OS4xNTQ5MTEsIDIwMTMvMTAvMjktMTE6NDc6MTYgICAgICAgICI+IDxyZGY6UkRGIHhtbG5zOnJkZj0iaHR0cDovL3d3dy53My5vcmcvMTk5OS8wMi8yMi1yZGYtc3ludGF4LW5zIyI+IDxyZGY6RGVzY3JpcHRpb24gcmRmOmFib3V0PSIiIHhtbG5zOnhtcD0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLyIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bXA6Q3JlYXRvclRvb2w9IkFkb2JlIFBob3Rvc2hvcCBDQyAoV2luZG93cykiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6ODZBMEEwQkUxRTA5MTFFNThENzU5MDdDMzBFRDI3MDQiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6ODZBMEEwQkYxRTA5MTFFNThENzU5MDdDMzBFRDI3MDQiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDo4NkEwQTBCQzFFMDkxMUU1OEQ3NTkwN0MzMEVEMjcwNCIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDo4NkEwQTBCRDFFMDkxMUU1OEQ3NTkwN0MzMEVEMjcwNCIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/Pv/uAA5BZG9iZQBkwAAAAAH/2wCEAAEBAQEBAQEBAQECAQEBAgICAQECAgICAgICAgIDAgMDAwMCAwMEBAQEBAMFBQUFBQUHBwcHBwgICAgICAgICAgBAQEBAgICBQMDBQcFBAUHCAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICP/AABEIABIAGAMBEQACEQEDEQH/xAB1AAEAAwEAAAAAAAAAAAAAAAAFAwYICgEBAQEBAAAAAAAAAAAAAAAAAgMFARAAAQQBAQUGBgMAAAAAAAAAAgEDBAUGEQBBURIzITFhIjI0cYFiIzUHFCQWEQACAgICAwAAAAAAAAAAAAABAgADETESIkETBP/aAAwDAQACEQMRAD8A7SMcxzHbPHaGwsKEbq+uhsH5cuRYSYgEESSQkqkJEnNoSaJy9vaqqiIq7a9ljBiAcAYmTXWpUEjJMuR4T+rY9RDu59YFbCmNtONk/MmNr90EcQdFe15tNydu0ffaTgS3pqAyYFl+IYXV4bNybF4otyoyxjrrRmXJdQVKW22qjzOkOuiqnh8dqU3OX4tBdSgTkshxi6hphGK4/Fp2clv5ayXItW8AG0wKTXvvOqSLyCm7eu3bUPMnOBOVOOAGMmNUC/6DLpwZuAt31QmlJjpD/UFlR8z7XMqo4S6d693y8s7OqddHzHX2ftsQn9kY3Mx+ivJFEYhjlsTK3NOXpjvfyGyF5hNyESIJCnHh3P5rQzDOxD9NZVTjRmf7X8nP6HWc9t7f1L0/p4eG2gmpntuH7KGI1H5Su6PWb9x0PWnU+njsX1Em5//Z" alt="...">'
                    +  '</a>'
                    +  '</div>'
                    +  '<div class="media-body">'
                    +  '<h4 class="media-heading">Media heading</h4>'
                    +  '<p>1 x 23 ₫</p>'
                    +  '<p>1 chưa hoàn thành</p>'
                    +  '</div>'

                    +  '</div>'
                    +  '<div class="col-md-3">'
                    +          '<span class="bold">Thông tin đặt hàng: </span><button type="button" class="btn btn-success">chỉnh sửa</button>'
                    +  '<p>nguyễn văn a</p>'
                    +  '<p>37 Nguyễn Thị Minh Khai Quận 1 Hồ Chí Minh</p>'
                    +  '<p>01662457843</p>'
                    +  '</div>'
                    +  '<div class="col-md-3">'
                    +      '<textarea id="textarea" required="required" name="textarea" class="form-control"></textarea>'
                    +    '<textarea id="textarea" required="required" name="textarea" class="form-control "></textarea>'

                    +   '<br><button type="button" class="btn btn-success" style="margin-top: 10px;">Lưu ghi chú và tags</button>'
                    + '</div>'
                    + '<div class="col-md-3">'
                    +  '<button type="button" class="btn btn-success" style="width: 100%">Giao hàng</button>'
                    + '<button type="button" class="btn btn-success" style="width: 100%">Lưu trữ</button>'
                    + '<button type="button" class="btn btn-success" style="width: 100%">Hủy đơn hàng</button>'
                    + '</div>'
                    + '</div>';
        }

        $(document).ready(function () {
            var table = $('#example').DataTable({
                "language": {
                    "url": "/plugin/datatable-lang/Vietnamese.json"
                },
                'columnDefs': [
                    { orderable: false, targets: [0,8] }
                ],
//            "ajax": "../ajax/data/objects.txt",
//            "columns": [
//                {
//                    "className":      'details-control',
//                    "orderable":      false,
//                    "data":           null,
//                    "defaultContent": ''
//                },
//                { "data": "name" },
//                { "data": "position" },
//                { "data": "office" },
//                { "data": "salary" }
//            ],
                "order": [[1, 'asc']]
            });

            // Add event listener for opening and closing details
            $('#example tbody').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = table.row(tr);

                if (row.child.isShown()) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                }
                else {
                    // Open this row
                    row.child(format(row.data())).show();
                    tr.addClass('shown');
                }
            });
        });
    </script>
    <!-- /Datatables -->

@endsection

