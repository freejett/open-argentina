<script src="/assets/leaflet/leaflet.js"></script>
<link rel="stylesheet" href="/assets/leaflet/leaflet.css" />

<div id="map" style="height: 700px;"></div>
<script>
    var map = L.map('map').setView([{{ $apartment->lng }}, {{ $apartment->lat }}], 14);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    L.marker([{{ $apartment->lng }}, {{ $apartment->lat }}]).addTo(map)
        .bindPopup('{!! $apartment->title . '<br />'. $apartment->price .' USD' !!}')
        .openPopup();
</script>


