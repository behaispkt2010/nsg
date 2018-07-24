@extends('layouts.app')

<!-- Main Content -->
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="text-center">
                        <img src="{{asset('/images/forgetpwd.jpg')}}" alt="">
                        <h4>BẠN ĐÃ QUÊN MẬT KHẨU</h4>
                    </div>
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">

                            <div class="col-md-8 col-md-offset-2 col-xs-10 col-xs-offset-1">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required placeholder="Nhập lại email của bạn">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-raised" style="font-weight: bold; font-size: 16px;">
                                   Khôi phục
                                </button>
                            </div>
                            <div class="text-center">
                                <i class="fa fa-arrow-left" aria-hidden="true"></i><a href="{{ route('login') }}"> Quay về trang đăng nhập</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
