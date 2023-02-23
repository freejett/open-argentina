<script src="/assets/leaflet/leaflet.js"></script>
<link rel="stylesheet" href="/assets/leaflet/leaflet.css" />
<link rel="stylesheet" href="/assets/leaflet/markerCluster/MarkerCluster.css">
<link rel="stylesheet" href="/assets/leaflet/markerCluster/MarkerCluster.Default.css" />
<script src="/assets/leaflet/markerCluster/leaflet.markercluster-src.js"></script>

<div id="map" style="height: 700px;"></div>
<script>
    let tiles = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Points &copy 2012 LINZ'
        }),
        latlng = L.latLng(-34.61, -58.43);

    let map = L.map('map', {center: latlng, zoom: 13, layers: [tiles], scrollWheelZoom: false});
    let markers = L.markerClusterGroup();
    let addressPoints = [@foreach ($apartments as $apartment)@if($apartment->lng)[{{ $apartment->lng }}, {{ $apartment->lat }}, "<a href='{{ route('front.aparts.show', $apartment->id) }}' target='_blank'><b>{{ $apartment->title }}</b></a><br />{{ $apartment->price }} USD"],@endif @endforeach
    ];

    for (let i = 0; i < addressPoints.length; i++) {
        let a = addressPoints[i];
        let title = a[2];
        let marker = L.marker(new L.LatLng(a[0], a[1]), { title: title });
        marker.bindPopup(title);
        markers.addLayer(marker);
    }

    map.addLayer(markers);

</script>


