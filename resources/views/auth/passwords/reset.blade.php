@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-12">
            <div class="panel panel-default">
                <div class="panel-body sologen" >Khôi phục mật khẩu</div>

                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/reset') }}">
                        {{ csrf_field() }}

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-5 col-xs-5 control-label">Địa chỉ Email:</label>

                            <div class="col-md-7 col-xs-7">
                                <input id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-5 col-xs-5 control-label">Mật khẩu mới:</label>

                            <div class="col-md-7 col-xs-7">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label for="password-confirm" class="col-md-5 col-xs-5 control-label">Xác nhận mật khẩu:</label>
                            <div class="col-md-7 col-xs-7">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-xs-6 col-md-offset-3 col-xs-offset-3">
                                <button type="submit" class="btn btn-success btn-raised btn-large">
                                    Khôi phục Mật khẩu
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
