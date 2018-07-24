@extends('layouts.app')
@section('content')
<div class="container">
    <div class="">
        <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-12 ">
            <div class="panel panel-default">

                @if (count($errors) > 0)
                    <div class="alert alert-danger" style="border: none; border-top-right-radius: 5px !important;border-top-left-radius: 5px !important;">
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
                    <form class="" role="form" method="POST" action="{{ url('/login') }}">
                        {{ csrf_field() }}

                        <div class="link-login">
                            <ul class="h-ul-li">
                                <li class="active"><a href="{{url('/')}}/login">Đăng nhập</a></li>
                                <li><a href="{{url('/')}}/register">Đăng ký</a></li>
                            </ul>
                        </div>
                        <div class="clear"></div>
                        <br><br>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">

                            <div class="col-md-12 col-xs-12 col-sm-12">
                                <div class="form-group label-floating">
                                    <label class="control-label" for="email">Email</label>
                                    <input class="form-control" oninvalid="InvalidEmail(this);" type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
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
                                    <label class="control-label" for="password">Mật khẩu</label>
                                    <input class="form-control" oninvalid="InvalidPwd(this);" type="password" name="password" required>
                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>

                            </div>
                        </div>

                        {{--<div class="form-group">--}}
                            {{--<div class="col-md-6 col-md-offset-4">--}}
                                {{--<div class="checkbox">--}}
                                    {{--<label>--}}
                                        {{--<input type="checkbox" name="remember"> Nhớ đăng nhập--}}
                                    {{--</label>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        <div class="form-group col-md-12 text-center">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-success btn-raised btn-large" style="font-weight: bold; font-size: 16px;">
                                    Đăng nhập
                                </button>
                            </div>
                            Hoặc
                            <div class="col-md-12 text-center">
                                <a href="{{ url('/login/facebook') }}" class="" >
                                    <i class="fa fa-facebook-square login_fb" aria-hidden="true"></i>
                                </a>
                            </div>
                            <div class="col-md-12 text-center">
                                <a class="" href="{{ url('/password/reset') }}">
                                    Quên mật khẩu?
                                </a>
                            </div>
                            <!-- <div class="fb-login-button" data-max-rows="1" data-size="large" data-button-type="continue_with" data-show-faces="false" data-auto-logout-link="false" data-use-continue-as="false"></div> -->
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{--<div id="bg">--}}
    {{--<div class="visible top" style="background-image: url(https://5sao.ghn.vn/content/ontime/img/login/bg01.jpg?v=3.9.0.4);background-position: 50% 50%;"></div>--}}
    {{--<div class="" style="background-image: url(https://5sao.ghn.vn/content/ontime/img/login/bg02.jpg?v=3.9.0.4); background-position: 50% 50%;"></div>--}}
    {{--<div class="visible" style="background-image: url(https://5sao.ghn.vn/content/ontime/img/login/bg03.jpg?v=3.9.0.4); background-position: 50% 50%;"></div>--}}
{{--</div>--}}
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
    </script>

    

@endsection

