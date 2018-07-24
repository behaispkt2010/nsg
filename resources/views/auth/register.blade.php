@extends('layouts.app')

@section('content')
<div class="container">
    <div class="">
        <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-12 ">
            <div class="panel panel-default">
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="panel-body sologen">
                    Mạng lưới kho nông sản Việt Nam
                </div>
                <div class="panel-body login-register-form">
                    <form class="form" role="form" method="POST" action="{{ url('/register') }}">
                        {{ csrf_field() }}
                        <div class="link-login">
                            <ul class="h-ul-li">
                                <li ><a href="{{url('/')}}/login">Đăng nhập</a></li>
                                <li class="active"><a href="{{url('/')}}/register">Đăng ký</a></li>
                            </ul>
                        </div>
                    {{--<div class="clear"></div>--}}
                        <br><br>
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">

                            <div class="col-md-12 col-xs-12 col-sm-12">
                                <div class="form-group label-floating">
                                    <label class="control-label" for="name">Tên</label>
                                    <input id="name" type="text" oninvalid="InvalidName(this);" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>

                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">

                            <div class="col-md-12 col-xs-12 col-sm-12">
                                <div class="form-group label-floating">
                                    <label class="control-label" for="email">Email</label>
                                    <input id="email" type="email" oninvalid="InvalidEmail(this);" class="form-control" name="email" value="{{ old('email') }}" required>
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>

                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">

                            <div class="col-md-12 col-xs-12 col-sm-12">
                                <div class="form-group label-floating">
                                    <label class="control-label" for="email">Mật khẩu</label>
                                    <input id="" type="password" oninvalid="InvalidPwd(this);" class="form-control" name="password" required>
                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>

                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">

                            <div class="col-md-12 col-xs-12 col-sm-12">
                                <div class="form-group label-floating">
                                    <label class="control-label" for="email">Xác nhận mật khẩu</label>
                                    <input id="password-confirm" oninvalid="InvalidPwdCfm(this);" type="password" class="form-control" name="password_confirmation" required>
                                    @if ($errors->has('password_confirmation'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                    @endif

                                </div>

                            </div>
                        </div>
                        <?php
                        $province = \App\Province::get();
                        ?>
                        <div class="form-group">
                            <div class="col-md-12 col-xs-12 col-sm-12">
                                <div class="form-group label-floating">
                                    <label class="control-label" for="">Tỉnh/TP</label>
                                    <div class="form-group">
                                        <select id="t" class="form-control" required name="province">
                                            <option value="">Chọn khu vực</option>
                                            @foreach($province as $item)
                                                <option value="{{$item->provinceid}}">{{$item->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12 col-xs-12 col-sm-12">
                                <div class="form-group label-floating">
                                    <label class="control-label" for="">Mã giới thiệu</label>
                                    <input id="introCode" type="text" class="form-control" name="introCode" value="">
                                    <input id="myIntroCode" type="hidden" class="form-control" name="myIntroCode" value="<?php echo str_random(8) ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12 col-xs-12 col-sm-12">
                                <div class="form-group label-floating">
                                    <div class="g-recaptcha" data-sitekey="{{ env('RE_CAP_SITE') }}"></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12 col-xs-12 col-sm-12 text-center">
                                <button type="submit" class="btn btn-success btn-raised btn-large" style="font-weight: bold; font-size: 16px;">
                                    Đăng ký
                                </button>
                            </div>
                            <div class="col-md-12 col-xs-12 col-sm-12 text-center">
                                <p style="font-size: 11px;">Bằng việc bấm chọn đăng ký tức là bạn đã đồng ý với những
                                    <a href="#" style="color: #59b75c; ">chính sách và điều khoản</a> của nongsan.shop</p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('add_scripts')
    <script type="text/javascript">
        function InvalidEmail(textbox) {
            if (textbox.value == '') {
                textbox.setCustomValidity('Vui lòng nhập địa chỉ email');
            }
            else if(textbox.validity.typeMismatch){
                textbox.setCustomValidity('Vui lòng nhập đúng địa chỉ email có chứa ký tự “ @ “.');
            }
            else {
                textbox.setCustomValidity('');
            }
            return true;
        }
        function InvalidPwd(textbox) {
            if (textbox.value == '') {
                textbox.setCustomValidity('Vui lòng nhập mật khẩu');
            }
            else {
                textbox.setCustomValidity('');
            }
            return true;
        }
        function InvalidName(textbox) {
            if (textbox.value == '') {
                textbox.setCustomValidity('Vui lòng nhập tên');
            }
            else {
                textbox.setCustomValidity('');
            }
            return true;
        }
        function InvalidPwdCfm(textbox) {
            if (textbox.value == '') {
                textbox.setCustomValidity('Vui lòng nhập xác nhận mật khẩu ');
            }
            else {
                textbox.setCustomValidity('');
            }
            return true;
        }
    </script>
@endsection