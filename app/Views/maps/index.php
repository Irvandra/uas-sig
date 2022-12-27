<?= $this->extend('layout'); ?>

<?= $this->section('head'); ?>
    <script src="<?= base_url('leaflet/leaflet.js') ?>"></script>
    <link rel="stylesheet" href="<?= base_url('leaflet/leaflet.css'); ?>">
    <style>
        #maps {
            height: 500px;
        }
    </style>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div id="maps"></div>
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>
    var features = <?= json_encode($features) ?>;
    var nilaiMax = <?= $nilaiMax ?>;

    var map = L.map('maps').setView({ lat : -5.3971, lon : 105.2668}, 11);

    function getColor(d) {
        return d > (nilaiMax/8)*7 ? '#800026' :
        d > (nilaiMax/8)*6 ? '#BD0026' :
        d > (nilaiMax/8)*5 ? '#E31A1C' :
        d > (nilaiMax/8)*4 ? '#FC4E2A' :
        d > (nilaiMax/8)*3 ? '#FDBD3C' :
        d > (nilaiMax/8)*2 ? '#FEB24C' :
        d > (nilaiMax/8)*1 ? '#FED976' :
                            '#FFEDA0'
    }

    function style(feature) {
       return{
        weight : 2,
        opacity : 1,
        color : 'white',
        dashArray : '3',
        fillOpacity : 0.7,
        fillColor : getColor(parseInt(feature.properties.nilai))
       }; 
    }

    function onEachFeature(feature, layer){
        layer.bindPopup("<h4>Sumber Daya Alam</h4><br>"+"Kecamatan : "+feature.properties.nama+"<br>"+"Jenis Sumber Daya : "+feature.properties.jenis_sumber_daya+"<br>Kondisi : "+feature.properties.kondisi+"<br>Ketersediaan : "+feature.properties.nilai);
    }

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="https://openstreetmap.org/copyright">OpenStreetMap contributors</a>'
    }).addTo(map);

    L.marker({ lat : -5.3971, lon : 105.2668}).bindPopup('Bandar Lampung').addTo(map);

    var geojson = L.geoJson(features, {
        style: style,
        onEachFeature: onEachFeature,
    }).addTo(map);
</script>
<?= $this->endSection(); ?>