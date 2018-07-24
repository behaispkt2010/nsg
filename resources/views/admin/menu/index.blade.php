@extends('layouts.admin')
@section('title', 'Danh sách bài viết ')
@section('pageHeader','Menu ')
@section('detailHeader','Menu ')
@section('add_styles')
    <style type="text/css">

        .cf:after {
            visibility: hidden;
            display: block;
            font-size: 0;
            content: " ";
            clear: both;
            height: 0;
        }

        *:first-child + html .cf {
            zoom: 1;
        }

        .dd {
            position: relative;
            display: block;
            margin: 0;
            padding: 0;
            max-width: 600px;
            list-style: none;
            font-size: 13px;
            line-height: 20px;
        }

        .dd-list {
            display: block;
            position: relative;
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .dd-list .dd-list {
            padding-left: 30px;
        }

        .dd-collapsed .dd-list {
            display: none;
        }

        .dd-item,
        .dd-empty,
        .dd-placeholder {
            display: block;
            position: relative;
            margin: 0;
            padding: 0;
            min-height: 20px;
            font-size: 13px;
            line-height: 20px;
        }

        .dd-handle {
            display: block;
            height: 36px;
            margin: 7px 0;
            padding: 5px 10px;
            color: #333;
            text-decoration: none;
            font-weight: bold;
            border: 1px solid #e6e9ed;
            background: white;
            -webkit-border-radius: 3px;
            border-radius: 3px;
            box-sizing: border-box;
            -moz-box-sizing: border-box;
        }

        .dd-handle:hover {
            color: #2ea8e5;
            background: #fff;
        }

        .dd-item > button {
            display: block;
            position: relative;
            cursor: pointer;
            float: left;
            width: 25px;
            height: 20px;
            margin: 5px 0;
            padding: 0;
            text-indent: 100%;
            white-space: nowrap;
            overflow: hidden;
            border: 0;
            background: transparent;
            font-size: 12px;
            line-height: 1;
            text-align: center;
            font-weight: bold;
        }

        .dd-item > button:before {
            content: '+';
            display: block;
            position: absolute;
            width: 100%;
            text-align: center;
            text-indent: 0;
        }

        .dd-item > button[data-action="collapse"]:before {
            content: '-';
        }

        .dd-placeholder,
        .dd-empty {
            margin: 5px 0;
            padding: 0;
            min-height: 30px;
            background: #f2fbff;
            border: 1px dashed #b6bcbf;
            box-sizing: border-box;
            -moz-box-sizing: border-box;
        }

        .dd-empty {
            border: 1px dashed #bbb;
            min-height: 100px;
            background-color: #e5e5e5;
            background-image: -webkit-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
            -webkit-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
            background-image: -moz-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
            -moz-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
            background-image: linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
            linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
            background-size: 60px 60px;
            background-position: 0 0, 30px 30px;
        }

        .dd-dragel {
            position: absolute;
            pointer-events: none;
            z-index: 9999;
        }

        .dd-dragel > .dd-item .dd-handle {
            margin-top: 0;
        }

        .dd-dragel .dd-handle {
            -webkit-box-shadow: 2px 4px 6px 0 rgba(0, 0, 0, .1);
            box-shadow: 2px 4px 6px 0 rgba(0, 0, 0, .1);
        }

        /**
         * Nestable Extras
         */

        .nestable-lists {
            display: block;
            clear: both;
            /*padding: 30px 0;*/
            width: 100%;
            border: 0;

        }

        #nestable-menu {
            padding: 0;
            margin: 20px 0;
        }

        #nestable-output,
        #nestable2-output {
            width: 100%;
            height: 7em;
            font-size: 0.75em;
            line-height: 1.333333em;
            font-family: Consolas, monospace;
            padding: 5px;
            box-sizing: border-box;
            -moz-box-sizing: border-box;
        }

        #nestable2 .dd-handle {
            color: #fff;
            border: 1px solid #999;
            background: #bbb;
            background: -webkit-linear-gradient(top, #bbb 0%, #999 100%);
            background: -moz-linear-gradient(top, #bbb 0%, #999 100%);
            background: linear-gradient(top, #bbb 0%, #999 100%);
        }

        #nestable2 .dd-handle:hover {
            background: #bbb;
        }

        #nestable2 .dd-item > button:before {
            color: #fff;
        }

        @media only screen and (min-width: 700px) {



            .dd + .dd {
                margin-left: 2%;
            }

        }

        .dd-hover > .dd-handle {
            background: #2ea8e5 !important;
        }

        /**
         * Nestable Draggable Handles
         */

        .dd3-content {
            display: block;
            height: 30px;
            margin: 5px 0;
            padding: 5px 10px 5px 40px;
            color: #333;
            text-decoration: none;
            font-weight: bold;
            border: 1px solid #ccc;
            background: #fafafa;
            background: -webkit-linear-gradient(top, #fafafa 0%, #eee 100%);
            background: -moz-linear-gradient(top, #fafafa 0%, #eee 100%);
            background: linear-gradient(top, #fafafa 0%, #eee 100%);
            -webkit-border-radius: 3px;
            border-radius: 3px;
            box-sizing: border-box;
            -moz-box-sizing: border-box;
        }

        .dd3-content:hover {
            color: #2ea8e5;
            background: #fff;
        }

        .dd-dragel > .dd3-item > .dd3-content {
            margin: 0;
        }

        .dd3-item > button {
            margin-left: 30px;
        }

        .dd3-handle {
            position: absolute;
            margin: 0;
            left: 0;
            top: 0;
            cursor: pointer;
            width: 30px;
            text-indent: 100%;
            white-space: nowrap;
            overflow: hidden;
            border: 1px solid #aaa;
            background: #ddd;
            background: -webkit-linear-gradient(top, #ddd 0%, #bbb 100%);
            background: -moz-linear-gradient(top, #ddd 0%, #bbb 100%);
            background: linear-gradient(top, #ddd 0%, #bbb 100%);
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
        }

        .dd3-handle:before {
            content: '≡';
            display: block;
            position: absolute;
            left: 0;
            top: 3px;
            width: 100%;
            text-align: center;
            text-indent: 0;
            color: #fff;
            font-size: 20px;
            font-weight: normal;
        }

        .dd3-handle:hover {
            background: #ddd;
        }
        .delete-menu{
            position: absolute;
            right: 10px;
            top: 12px;
        }
        .delete-menu:hover{
           color:red;
            cursor: pointer;
        }
    </style>
@endsection
@section('content')
    <br>
    <div class="row">

        <div class="text-right">
            <button type="submit" id="save_menu" class="btn-update btn btn-success btn-raised " > Lưu Menu</button>
        </div>
        <div class="col-md-4 col-xs-12 col-sm-12 ">
            <div class="x_panel">
                <form action="" onsubmit="return false;">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="form-group">
                <label for="name">Tên hiển thị</label>
                <input type="text" maxlength="20"  class="form-control" name="label" id="label" required>
            </div>
            <div class="form-group">
                <label for="url">Đường dẫn</label>
                <input type="text" class="form-control" name="url" id="url" required
                       value="">
            </div>
            <div class="form-group">
                <label for="class">Class</label>
                <input type="text" class="form-control" name="menu_class" id="class"
                       value="">
            </div>
                <button type="button" class="btn btn-raised btn-success" id="btn-add-menu"> Thêm menu</button>
                </form>
            </div>

        </div>
        <div class="col-md-8 col-xs-12 col-sm-12">
        <div class="cf nestable-lists">
            Danh sách Menu
            <div class="dd" id="nestable">

                    <ol class="dd-list dd-list-top">
                    {{\App\Menu::get_menu($menu)}}
                    </ol>
            </div>

        </div>
        </div>
        <input type="hidden" id="nestable-output"/>

    </div>
    <div class="loading" style="display: none"><img src="{{url('/images/loading.gif')}}" class="img-reponsive" style="position: fixed;" alt=""></div>
    @endsection

    @section('add_scripts')
            <!-- Datatables -->

    <script src="{{url('/js/jquery.nestable.js')}}"></script>
    <script>



            var updateOutput = function (e) {
                var list = e.length ? e : $(e.target),
                        output = list.data('output');
                if (window.JSON) {
                    output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
                } else {
                    output.val('JSON browser support required for this demo.');
                }
            };

            // activate Nestable for list 1
            $('#nestable').nestable({
                group: 1,
                maxLevels:2
            })
                    .on('change', updateOutput);

            // output initial serialised data
            updateOutput($('#nestable').data('output', $('#nestable-output')));

        $(document).on('click','.delete-menu', function () {
           $(this).closest('.dd-item').remove();
            updateOutput($('#nestable').data('output', $('#nestable-output')));

        });
            $(document).on('click','#btn-add-menu', function (e) {
//                e.preventDefault();
                var menu_label = $('input[name="label"]').val();
                var menu_url =  $('input[name="url"]').val();
                var menu_class =  $('input[name="menu_class"]').val();
                if(menu_label != "" && menu_url != "") {

                    $('ol.dd-list-top').append('<li class="dd-item" data-label="'+menu_label+'" data-url="'+menu_url+'" data-class="'+menu_class+'">' +
                            '<div class="dd-handle">' + menu_label + '</div>' +
                            ' <i class="fa fa-times delete-menu"></i> </li>');
                    updateOutput($('#nestable').data('output', $('#nestable-output')));
                    $('input[name="label"]').val("");
                    $('input[name="url"]').val("");
                    $('input[name="menu_class"]').val("");
                }
                else{
                    alert('Tên hiển thị và đường dẫn không được bỏ trống');
                }


            });


    </script>
    <script>
        $('#save_menu').on('click', function (e) {
            e.preventDefault();

            var jsonMenu = $('#nestable-output').val();
            var _token = $('input[name="_token"]').val();

            $('.loading').css('display','block');
            $.ajax({
                type: "POST",
                url: '{{ url('/') }}/admin/menu/AjaxSave',
                data: {jsonMenu: jsonMenu,_token: _token},
                success: function( msg ) {
                    $('.loading').css('display','none');
                    new PNotify({
                        title: 'Lưu thành công',
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

