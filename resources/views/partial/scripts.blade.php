

    <!-- Bootstrap -->
    <script src="{{asset('plugin/bootstrap/dist/js/bootstrap.min.js')}}"></script>
    <!-- FastClick -->
    <script src="{{asset('plugin/fastclick/lib/fastclick.js')}}"></script>
    <!-- NProgress -->
    <script src="{{asset('plugin/nprogress/nprogress.js')}}"></script>

    <script src="{{asset('plugin/gauge.js/dist/gauge.min.js')}}"></script>
    <!-- bootstrap-progressbar -->
    <script src="{{asset('plugin/bootstrap-progressbar/bootstrap-progressbar.min.js')}}"></script>
    <!-- iCheck -->
    <script src="{{asset('plugin/iCheck/icheck.min.js')}}"></script>
    <!-- Skycons -->
    <script src="{{asset('plugin/skycons/skycons.js')}}"></script>
    <!-- Flot -->
    <script src="{{asset('plugin/Flot/jquery.flot.js')}}"></script>
    <script src="{{asset('plugin/Flot/jquery.flot.pie.js')}}"></script>
    <script src="{{asset('plugin/Flot/jquery.flot.time.js')}}"></script>
    <script src="{{asset('plugin/Flot/jquery.flot.stack.js')}}"></script>
    <script src="{{asset('plugin/Flot/jquery.flot.resize.js')}}"></script>
    <!-- Flot plugins -->
    <script src="{{asset('plugin/flot.orderbars/js/jquery.flot.orderBars.js')}}"></script>
    <script src="{{asset('plugin/flot-spline/js/jquery.flot.spline.min.js')}}"></script>
    <script src="{{asset('plugin/flot.curvedlines/curvedLines.js')}}"></script>
    <!-- DateJS -->
    <script src="{{asset('plugin/DateJS/build/date.js')}}"></script>
    <!-- JQVMap -->
    <script src="{{asset('plugin/jqvmap/dist/jquery.vmap.js')}}"></script>
    <script src="{{asset('plugin/jqvmap/dist/maps/jquery.vmap.world.js')}}"></script>
    <script src="{{asset('plugin/jqvmap/examples/js/jquery.vmap.sampledata.js')}}"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="{{asset('js/moment/moment.min.js')}}"></script>
    <script src="{{asset('js/datepicker/daterangepicker.js')}}"></script>
<!-- jQuery custom content scroller -->
    <script src="{{asset('plugin/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js')}}"></script>
    <!-- Custom Theme Scripts -->
    <script src="{{asset('/js/custom.js')}}"></script>
<!-- iCheck -->
<script src="{{asset('plugin/iCheck/icheck.min.js')}}"></script>
<!-- PNotify -->
<script src="{{asset('plugin/pnotify/dist/pnotify.js')}}"></script>
<script src="{{asset('plugin/pnotify/dist/pnotify.buttons.js')}}"></script>
<script src="{{asset('plugin/pnotify/dist/pnotify.nonblock.js')}}"></script>
	<script src="{{asset('js/custom-file-input.js')}}"></script>
    <!-- /Datatables -->
    <script>
        $(document).on('click', '.form-delete', function(e){
            e.preventDefault();
            var $form=$(this);
            $('#confirm').modal({ backdrop: 'static', keyboard: false })
                    .on('click', '#delete-btn', function(){
                        $form.submit();
                    });
        });
    </script>
<script>
    (function () {

        var $button = $("<div id='source-button' class='btn btn-primary btn-xs'>&lt; &gt;</div>").click(function () {
            var index = $('.bs-component').index($(this).parent());
            $.get(window.location.href, function (data) {
                var html = $(data).find('.bs-component').eq(index).html();
                html = cleanSource(html);
                $("#source-modal pre").text(html);
                $("#source-modal").modal();
            })

        });

        $('.bs-component [data-toggle="popover"]').popover();
        $('.bs-component [data-toggle="tooltip"]').tooltip();

        $(".bs-component").hover(function () {
            $(this).append($button);
            $button.show();
        }, function () {
            $button.hide();
        });

        function cleanSource(html) {
            var lines = html.split(/\n/);

            lines.shift();
            lines.splice(-1, 1);

            var indentSize = lines[0].length - lines[0].trim().length,
                    re = new RegExp(" {" + indentSize + "}");

            lines = lines.map(function (line) {
                if (line.match(re)) {
                    line = line.substring(indentSize);
                }

                return line;
            });

            lines = lines.join("\n");

            return lines;
        }

        $(".icons-material .icon").each(function () {
            $(this).after("<br><br><code>" + $(this).attr("class").replace("icon ", "") + "</code>");
        });

    })();

</script>
<!-- Bootstrap Material Design -->
<script  src="{{asset('js/material.js')}}"></script>
<script  src="{{asset('js/ripples.js')}}"></script>
{{--<script src="http://fezvrasta.github.io/snackbarjs/dist/snackbar.min.js"></script>--}}


{{--<script src="http://cdnjs.cloudflare.com/ajax/libs/noUiSlider/6.2.0/jquery.nouislider.min.js"></script>--}}
<script>
    $('.btn-new').hover(function() {
        $('.h-report').addClass('show-hover');
        $('.h-help').addClass('show-hover');
        $('.h-create').addClass('show-hover');
        $('.iconPlus').addClass('hidden-hover');
        $('.iconCreate').removeClass('hidden-hover');
        // $('.h-plus').addClass('hidden-hover');
    }, function() {
        $('.h-report').removeClass('show-hover');
        $('.h-help').removeClass('show-hover');
        $('.h-create').removeClass('show-hover');
        $('.iconPlus').removeClass('hidden-hover');
        $('.iconCreate').addClass('hidden-hover');
        // $('.h-plus').removeClass('hidden-hover');
    });
</script>

<script>
    $(function () {
        $.material.init();

    });
</script>
<!-- Custom Notification -->
<script>
    $(document).ready(function() {
        var cnt = 10;

        TabbedNotification = function(options) {
            var message = "<div id='ntf" + cnt + "' class='text alert-" + options.type + "' style='display:none'><h2><i class='fa fa-bell'></i> " + options.title +
                    "</h2><div class='close'><a href='javascript:;' class='notification_close'><i class='fa fa-close'></i></a></div><p>" + options.text + "</p></div>";

            if (!document.getElementById('custom_notifications')) {
                alert('doesnt exists');
            } else {
                $('#custom_notifications ul.notifications').append("<li><a id='ntlink" + cnt + "' class='alert-" + options.type + "' href='#ntf" + cnt + "'><i class='fa fa-bell animated shake'></i></a></li>");
                $('#custom_notifications #notif-group').append(message);
                cnt++;
                CustomTabs(options);
            }
        };

        CustomTabs = function(options) {
            $('.tabbed_notifications > div').hide();
            $('.tabbed_notifications > div:first-of-type').show();
            $('#custom_notifications').removeClass('dsp_none');
            $('.notifications a').click(function(e) {
                e.preventDefault();
                var $this = $(this),
                        tabbed_notifications = '#' + $this.parents('.notifications').data('tabbed_notifications'),
                        others = $this.closest('li').siblings().children('a'),
                        target = $this.attr('href');
                others.removeClass('active');
                $this.addClass('active');
                $(tabbed_notifications).children('div').hide();
                $(target).show();
            });
        };

        CustomTabs();

        var tabid = idname = '';

        $(document).on('click', '.notification_close', function(e) {
            idname = $(this).parent().parent().attr("id");
            tabid = idname.substr(-2);
            $('#ntf' + tabid).remove();
            $('#ntlink' + tabid).parent().remove();
            $('.notifications a').first().addClass('active');
            $('#notif-group div').first().css('display', 'block');
        });
    });
</script>
<!-- /Custom Notification -->
<script type="text/javascript">
    var baseURL="{!!url('/')!!}";
    //alert(baseURL)
</script>
<script>
      window.fbAsyncInit = function() {
        FB.init({
          appId      : '95100348886',
          xfbml      : true,
          version    : 'v2.6'
        });
      };

      (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));
    </script>
    <script >
    $('.pageface').click(function() {
    $(this).toggleClass('show');
    })
</script>
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});
</script>
<script >
$(".alert-success").fadeTo(5000, 500).slideUp(500, function(){
    $(".alert").slideUp(50);
});
$(".alert-danger").fadeTo(15000, 500).slideUp(500, function(){
    $(".alert").slideUp(50);
});

</script>
<script>
$(document).on('click','.bs-example-modal-avata .avarta-item img',function(){
        var img=$(this).attr('data-value');
        //save by ajax
            var _token = $('input[name="_token"]').val();

            $('.loading').css('display','block');
            $.ajax({
                type: "Post",
                url: '{{ url("/") }}/users/changeAvata',

                data: {img: img,_token: _token},
                success: function( msg ) {
                    $('.loading').css('display','none');

                    //show notify
                    new PNotify({
                        title: 'Thay đổi thành công',
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