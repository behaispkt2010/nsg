<div class="modal" id="login_xs">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-center" id="myModalLabel">Xin chào !!!</h4>
            </div>
            <div class="modal-body">
                <div class="col-xs-12 col-sm-12 col-md-6 text-center">
                    <a style="line-height: 26px;width: 150px; font-size: 16px;font-weight: bold;" class="btn btn-success" href="{{url('/')}}/login">
                        Đăng nhập
                    </a>
                </div>
                <br>
                <br>
                <div class="col-xs-12 col-sm-12 col-md-6 text-center">
                    <a style="line-height: 26px;width: 150px; font-size: 16px;font-weight: bold;" class="btn btn-warning" href="{{url('/')}}/register">
                        Đăng ký
                    </a>
                </div>
                <br>
                <br>
                <!-- <p class="text-center" style="padding-top: 30px;">----- Hỗ trợ và chăm sóc khách hàng -----</p> -->
                <div style="text-align:center;margin-top:10px" class="col-sm-6 col-md-6">
                    <i class="fa fa-phone" aria-hidden="true" style="margin-top: 4px; margin-right: 4px;"></i>
                    <span>Hotline - {{\App\Setting::getValue('phone')}}</span>
                </div>
                <div style="text-align:center;margin-top:10px" class="col-sm-6 col-md-6">
                    <i class="fa fa-envelope-o" aria-hidden="true" style="margin-top: 4px; margin-right: 4px;"></i>
                    <span>{{\App\Setting::getValue('email')}}</span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-raised btn-default" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>