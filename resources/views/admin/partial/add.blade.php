<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin - Add Địa điểm của Chủ kho</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="{{url('/')}}/maps/css/libs.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
    <script src="{{url('/')}}/maps/js/maplace.min.js"></script>
</head>
<body>
<style>
    #position{
        display: inline-block;
    }
    #position p{
        cursor: pointer;
    }
    #position p:hover{
        background: #5bc0de;
    }
</style>

<form action="{{ url('/mapsadd') }}" method="POST" enctype="multipart/form-data" style="width: 70%; margin: 0px auto;">
  <input type="hidden" name="_token" value="{{ csrf_token() }}">
  <h2>Thêm địa điểm Chủ kho</h2>
  <label for="">Id User. VD: KHO-BRI-54 -> Id User là 54</label>
  
  <div class="col-xs-6 col-md-12" style="padding: 0px;">
    <div class="form-group">
      <div class="input-group">
          <span class="input-group-addon">Id User</span>
          <input type="text" class="form-control" name="id_user" id="id_user" value="" required="required">
      </div>
     </div>
  </div> 
  <input type="hidden" class="form-control" name="maps_link" id="maps_link" value="" required="required">
  
  <br>
  <br>
  <div class="col-xs-6 col-md-12" style="padding: 0px;">
    <div class="form-group">
      <div class="input-group">
          <span class="input-group-addon">L</span>
          <input type="text" class="form-control" name="maps_maplat" id="maps_maplat" value="{maps_maplat}" readonly="readonly">
      </div>
     </div>
    </div>
  <div class="col-xs-6 col-md-12" style="padding: 0px;">
    <div class="form-group">
      <div class="input-group">
          <span class="input-group-addon">N</span>
          <input type="text" class="form-control" name="maps_maplng" id="maps_maplng" value="{maps_maplng}" readonly="readonly">
      </div>
      </div>
    </div>
  <input type="submit" class="btn btn-raised btn-primary btnAdd" value="Thêm mới" style=" width: 100px; height: 30px; color: #fff; background: #00BCD4;">
  <br>
  <br>
  <input type="text" class="form-control" name="maps_address" id="maps_address" value="" placeholder="Nhập tên địa điểm cần tìm">
  <div id="maps_maparea">
      <div id="maps_mapcanvas" style="margin-top:10px;" class="form-group"></div>
      <div class="row">
          <!-- <div class="col-xs-6">
            <div class="form-group">
              <div class="input-group">
                  <span class="input-group-addon">L</span>
                  <input type="text" class="form-control" name="maps[maps_mapcenterlat]" id="maps_mapcenterlat" value="{maps_mapcenterlat}" readonly="readonly">
              </div>
            </div>
          </div> -->
          <br>
          <br>
          
      </div>
      <!-- <div class="row">
          <div class="col-xs-12">
            <div class="form-group">
              <div class="input-group">
                  <span class="input-group-addon">Z</span>
                  <input type="text" class="form-control" name="maps[maps_mapzoom]" id="maps_mapzoom" value="{maps_mapzoom}" readonly="readonly">
              </div>
             </div>
          </div>
      </div> -->
  </div>
</form>
<script>
    $(document).ready(function(){
        $('#position p').click(function(){
           var lat = $(this).find('.p1').html();
            var lon = $(this).find('.p2').html();
            $('#lat').val(lat);
            $('#lon').val(lon);

        });
    });
</script>

<script type="text/javascript">
    var map, ele, mapH, mapW, addEle, mapL, mapN, mapZ;

ele = 'maps_mapcanvas';
addEle = 'maps_address';
mapLat = 'maps_maplat';
mapLng = 'maps_maplng';
mapZ = 'maps_mapzoom';
mapArea = 'maps_maparea';
mapCenLat = 'maps_mapcenterlat';
mapCenLng = 'maps_mapcenterlng';
maps_link = 'maps_link';

// Call Google MAP API
if( ! document.getElementById('googleMapAPI') ){
    var s = document.createElement('script');
    s.type = 'text/javascript';
    s.id = 'googleMapAPI';
    // https://maps.google.com/maps/api/js?sensor=false&libraries=geometry&v=3.22&key=AIzaSyBLcEsjlc0sBoDPAYnPI_Y-_6nQFiX_C50
    s.src = 'https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&key=AIzaSyBLcEsjlc0sBoDPAYnPI_Y-_6nQFiX_C50&libraries=places&callback=controlMap';
    document.body.appendChild(s);
}else{
    controlMap();
}

// Creat map and map tools
function initializeMap(){
    var zoom = parseInt($("#" + mapZ).val()), lat = parseFloat($("#" + mapLat).val()), lng = parseFloat($("#" + mapLng).val()), Clat = parseFloat($("#" + mapCenLat).val()), Clng = parseFloat($("#" + mapCenLng).val());
    Clat || (Clat = 20.984516000000013, $("#" + mapCenLat).val(Clat));
    Clng || (Clng = 105.79547500000001, $("#" + mapCenLng).val(Clng));
    lat || (lat = Clat, $("#" + mapLat).val(lat));
    lng || (lng = Clng, $("#" + mapLng).val(lng));
    zoom || (zoom = 17, $("#" + mapZ).val(zoom));

    mapW = $('#' + ele).innerWidth();
    mapH = mapW * 3 / 4;

    // Init MAP
    $('#' + ele).width(mapW).height(mapH > 500 ? 500 : mapH);
    map = new google.maps.Map(document.getElementById(ele),{
        zoom: zoom,
        center: {
            lat: Clat,
            lng: Clng
        }
    });

    // Init default marker
    var markers = [];
    markers[0] = new google.maps.Marker({
        map: map,
        position: new google.maps.LatLng(lat,lng),
        draggable: true,
        animation: google.maps.Animation.DROP
    });
    markerdragEvent(markers);
    
    // Init search box
    var searchBox = new google.maps.places.SearchBox(document.getElementById(addEle));

    google.maps.event.addListener(searchBox, 'places_changed', function(){
        var places = searchBox.getPlaces();

        if (places.length == 0) {
            return;
        }

        for (var i = 0, marker; marker = markers[i]; i++) {
            marker.setMap(null);
        }

        markers = [];
        var bounds = new google.maps.LatLngBounds();
        for (var i = 0, place; place = places[i]; i++) {
            var marker = new google.maps.Marker({
                map: map,
                position: place.geometry.location,
                draggable: true,
                animation: google.maps.Animation.DROP
            });

            markers.push(marker);
            bounds.extend(place.geometry.location);
        }

        markerdragEvent(markers);
        map.fitBounds(bounds);
        console.log( places );
    });

    // Add marker when click on map
    google.maps.event.addListener(map, 'click', function(e) {
        for (var i = 0, marker; marker = markers[i]; i++) {
            marker.setMap(null);
        }

        markers = [];
        markers[0] = new google.maps.Marker({
            map: map,
            position: new google.maps.LatLng(e.latLng.lat(), e.latLng.lng()),
            draggable: true,
            animation: google.maps.Animation.DROP
        });

        markerdragEvent(markers);
        
    });

    // Event on zoom map
    google.maps.event.addListener(map, 'zoom_changed', function() {
        $("#" + mapZ).val(map.getZoom());
    });

    // Event on change center map
    google.maps.event.addListener(map, 'center_changed', function() {
        $("#" + mapCenLat).val(map.getCenter().lat());
        $("#" + mapCenLng).val(map.getCenter().lng());
        console.log( map.getCenter() );
    });
    
}

// Show, hide map on select change
function controlMap(manual){
    $('#' + mapArea).slideDown(100, function(){
        initializeMap();
    });

    return !1;
}

// Map Marker drag event
function markerdragEvent(markers){
    for (var i = 0, marker; marker = markers[i]; i++) {
        $("#" + mapLat).val(marker.position.lat());
        $("#" + mapLng).val(marker.position.lng());

        google.maps.event.addListener(marker, 'drag', function(e) {
            $("#" + mapLat).val(e.latLng.lat());
            $("#" + mapLng).val(e.latLng.lng());
        });
    }
}

</script>
<script type="text/javascript">
  $('.btnAdd').on('click',function (){
    var la = $('#maps_maplat').val();
    var lo = $('#maps_maplng').val();
    var maps_link = "https://www.google.com/maps/place//@"+ la +","+ lo +",15z/data=!3m1!4b1!4m5!3m4!1s0x0:0x0!8m2!3d"+ la +"!4d"+ lo +"?hl=vi";
    $('#maps_link').val(maps_link);
  });
</script>
</body>
</html>