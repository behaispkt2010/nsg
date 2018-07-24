@extends('layouts.admin')
@section('title', 'Thông báo')
@section('pageHeader','Thông báo')
@section('detailHeader','Thông báo')

@section('content')
    <div class="row top-right">
        <div class="x_panel">
            <div class="x_content">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        @if(count($arrNotification) !=0)
                        <h2>Thông báo của bạn</h2>
                        <ul id="" class="list_notify">
                            @foreach ($arrNotification as $itemNotification)
                                <li class="notify @if($itemNotification->is_read == 1)notifyIsRead @endif">
                                    <a href="{{ url('/').$itemNotification->link }}" target="_blank">
                                        <span class="image"><img src="@if (!empty($itemNotification->image)){{ url('/').$itemNotification->image }} @else {{url('/').'/images/user_default.png'}} @endif " alt="Profile Image"/></span>
                                        <span class="notification_title">{{$itemNotification->title}}</span>
                                        <br>
                                        <span class="message">{{$itemNotification->content}}</span>
                                        <br>
                                        <span class="time">{{ $itemNotification->created_at}}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                        <div class="clearfix"></div>
                        <div class="text-center">
                            {{ $arrNotification->appends(array('q' => Request::get('q')))->links() }}
                        </div>
                        @else
                            Bạn không có thông báo mới.
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection