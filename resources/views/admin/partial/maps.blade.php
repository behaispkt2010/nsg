<?php
echo '<script type="text/javascript">
    //dropdown example
    var LocsA = ['?>
@foreach($location as $item)
    {
    lat:{{$item->maps_maplat}},
    lon:{{$item->maps_maplng}},
    title: '{{$item->name}}',
    @if($item->level == 1)
        icon: '{{url('/images')}}/cap1.png',
    @elseif($item->level == 2)
        icon: '{{url('/images')}}/cap2.png',
    @elseif($item->level == 3)
        icon: '{{url('/images')}}/cap3.png',
    @else
        icon: 'http://maps.google.com/mapfiles/markerA.png',    
    @endif
    
    
    html: [
    '<div class="view overlay hm-white-slight"><img src="{{url("/images")}}/preview.png" class="img-fluid" alt="" style="width: 300px;border-radius: 5px;"><a><div class="mask waves-effect waves-light"></div></a></div>',
    '<h3>{{$item->name}}</h3>',
    '<p>{{$item->phone_number}}</p>',
    '<p>{{$item->address}}</p>',
    '<p>{{\App\Util::UserCode($item->users_id)}}</p>',
    '<p><a target="_blank" href="{{$item->maps_link}}">Xem trên Google Maps</a></p>'
    ].join(''),
    zoom: 16,
    },
@endforeach
<?php echo'];
    </script>'?>