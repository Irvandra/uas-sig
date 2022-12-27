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
    var map = L.map('maps').setView({ lat : -5.3971, lon : 105.2668}, 11);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="https://openstreetmap.org/copyright">OpenStreetMap contributors</a>'
    }).addTo(map);

    L.marker({ lat : -5.3971, lon : 105.2668}).bindPopup('Bandar Lampung').addTo(map);

    var geojson = L.geoJson(features).addTo(map);
</script>
<?= $this->endSection(); ?>