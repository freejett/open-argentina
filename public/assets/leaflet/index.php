<!DOCTYPE html>
<html>
<head>
    <title>A simple map with Geocoder PHP and Leaflet.js</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="leaflet.css" />
    <script src="leaflet.js"></script>
    <script src="//api-maps.yandex.ru/2.0/?load=package.map&lang=ru-RU" type="text/javascript"></script>

    <script src="//maps.google.com/maps/api/js?v=3.2&sensor=false"></script>
    <script src="tile/Google.js"></script>

    <script src="tile/Yandex.js"></script>
    <style>
        #map {width: 100%; height: 600px; }
    </style>
    <meta charset="utf-8" />
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-lg-12 1page-header">
            <h4 id="header">Map service</h4>
        </div>
        <div class="row-fluid">
            <div class="col-lg-12">
                <div id="map"></div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="row-fluid">
            <div class="col-lg-12">
                <h4>Координаты</h4>
                <div id="coords"></div>
                <br/><br/><br/>
            </div>
        </div>
    </div>
</div>
<script type='text/javascript'>
    jQuery(document).ready(function()
    {
        //Определяем карту, координаты центра и начальный масштаб
        // var map = L.map('map').setView([50.0755381, 14.4378005], 14);
        var map = new L.Map('map', {center: new L.LatLng(50.06777, 14.42101), zoom: 15, zoomAnimation: false });
        var osm = new L.TileLayer('//{s}.tile.openstreetmap.org/{z}/{x}/{y}.png');
        var yndx = new L.Yandex();
        var googleLayer = new L.Google('ROADMAP');

        map.addLayer(yndx);
        map.addControl(new L.Control.Layers({'OSM':osm, "Yandex":yndx, "Google":googleLayer}));

        // маркер на карте
        L.marker([50.07529, 14.41406], {draggable:'true'}).addTo(map).bindPopup("<strong>КАРО ФИЛЬМ Шоколад</strong><br />Адрес: ул. Белинского, 124").openPopup();

        // линия на карте
        var polyline = L.polyline([[50.07416, 14.40222],[50.08402, 14.42342],[50.07102, 14.42419]],
            {color: 'red',
                weight: 3,
                opacity: 0.5,
                smoothFactor: 1}).addTo(map);
        map.fitBounds(polyline.getBounds());

        // добавление маркера на клик
//    map.on('click', function(e) {
//        var popLocation= e.latlng;
//        var popup = L.popup()
//            .setLatLng(popLocation)
//            .setContent('<p>Hello world!<br />This is a nice popup.</p>')
//            .openOn(map);
//    });

//    map.on('click', function(e){
//        var newMarker = new L.marker(e.latlng).addTo(map);
//    });

        // добавление и перетаскивание маркера
        function onMapClick(e, div) {
            marker = new L.marker(e.latlng, {draggable:'true'});
            marker.on('dragend', function(event){
                var marker = event.target;
                var position = marker.getLatLng();
                marker.setLatLng(new L.LatLng(position.lat, position.lng),{draggable:'true'});
                //map.panTo(new L.LatLng(position.lat, position.lng));
                jQuery('#coords').text( marker.getLatLng() );
            });
            map.addLayer(marker);
            jQuery('#coords').text( marker.getLatLng() );
        };

        map.on('click', onMapClick);
    });
</script>
</body>
</html>