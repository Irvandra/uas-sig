<?php
    $dropDownMenu = [
        'name' => 'master',
        'options' => $masterDataMenu,
        'class' => 'form-control'
    ];

    $submit = [
        'name' => 'submit',
        'id' => 'submit',
        'value' => 'Pilih Data',
        'class' => 'btn btn-primary',
        'type' => 'submit'
    ];
?>
<?= $this->extend('layout'); ?>

<?= $this->section('head'); ?>
    <script src="<?= base_url('leaflet/leaflet.js') ?>"></script>
    <link rel="stylesheet" href="<?= base_url('leaflet/leaflet.css'); ?>">
    <style>
        #maps {
            height: 700px;
        }
        .info {
            padding: 6px 8px;
            font: 14px/16px Arial, Helvetica, sans-serif;
            background: white;
            background: rgba(255,255,255,0.8);
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
            border-radius: 5px;
        }
        .info h4 {
            margin: 0 0 5px;
            color: #777;
        }
        .legend {
            line-height: 18px;
            color: #555;
        }
        .legend i {
            width: 18px;
            height: 18px;
            float: left;
            margin-right: 8px;
            opacity: 0.7;
        }
    </style>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <?= form_open('Maps/index') ?>
                <div class="row">
                    <div class="col-md-6">
                        <?= form_dropdown($dropDownMenu) ?>
                    </div>
                    <div class="col-md-6">
                        <?= form_submit($submit) ?>
                    </div>
                </div>
                <?= form_close() ?>
                <div id="maps"></div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>
    var features = <?= json_encode($features) ?>;
    var nilaiMax = <?= $nilaiMax ?>;

    var map = L.map('maps').setView({ lat : -5.3971, lon : 105.2668}, 11);

    var sumberDayaAlam = <?= json_encode($sumberDayaAlam) ?>;
    var kondisiLingkungan = <?= json_encode($kondisiLingkungan) ?>;
    var aktivitasManusia = <?= json_encode($aktivitasManusia) ?>;
    var hubunganSDAKL = <?= json_encode($hubunganSDAKL) ?>;
    var hubunganSDAAM = <?= json_encode($hubunganSDAAM) ?>;

    if (sumberDayaAlam) {
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
    } else if (aktivitasManusia) {
        function getColor(d) {
            return d == 3 ? '#800026' :
            d == 2 ? '#E31A1C' :
                    '#FDBD3C'
        }
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

    if (sumberDayaAlam) {
        function onEachFeature(feature, layer){
            layer.bindPopup("<h4>Sumber Daya Alam</h4><br>"+"Kecamatan : "+feature.properties.nama+"<br>"+"Jenis Sumber Daya : "+feature.properties.jenis_sumber_daya+"<br>Kondisi : "+feature.properties.kondisi+"<br>Ketersediaan : "+feature.properties.nilai + ' Ton');
            layer.on({
                mouseover: highlightFeature,
                mouseout: resetHighlight,
            });
        }
    } else if (kondisiLingkungan) {
        function onEachFeature(feature, layer){
            layer.bindPopup("<h4>Kondisi Lingkungan</h4><br>"+"Kecamatan : "+feature.properties.nama+"<br>"+"Kualitas Air : "+feature.properties.kualitas_air+"<br>Kualitas Udara : "+feature.properties.kualitas_udara+"<br>Keanekaragaman Hayati: "+feature.properties.keanekaragaman_hayati);
            layer.on({
                mouseover: highlightFeature,
                mouseout: resetHighlight,
            });
        }
    } else if (aktivitasManusia) {
        function onEachFeature(feature, layer){
            layer.bindPopup("<h4>Aktivitas Manusia</h4><br>"+"Kecamatan : "+feature.properties.nama+"<br>"+"Jenis Aktivitas : "+feature.properties.jenis_aktivitas+"<br>Intensitas : "+feature.properties.nilai+"<br>Dampak Potensial : "+feature.properties.dampak_potensial);
            layer.on({
                mouseover: highlightFeature,
                mouseout: resetHighlight,
            });
        }
    } else if (hubunganSDAKL) {
        function onEachFeature(feature, layer){
            layer.bindPopup("<h4>Hubungan Sumber Daya Alam - Kondisi Lingkungan </h4><br>"+"Kecamatan : "+feature.properties.nama+"<br>"+"Dampak : "+feature.properties.dampak_SDAKL+"<br>Pengelolaan : "+feature.properties.pengelolaan_SDAKL);
            layer.on({
                mouseover: highlightFeature,
                mouseout: resetHighlight,
            });
        }
    } else if (hubunganSDAAM) {
        function onEachFeature(feature, layer){
            layer.bindPopup("<h4>Hubungan Sumber Daya Alam - Aktivitas Manusia </h4><br>"+"Kecamatan : "+feature.properties.nama+"<br>"+"Dampak : "+feature.properties.dampak_SDAAM+"<br>Pengelolaan : "+feature.properties.pengelolaan_SDAAM);
            layer.on({
                mouseover: highlightFeature,
                mouseout: resetHighlight,
            });
        }
    }

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="https://openstreetmap.org/copyright">OpenStreetMap contributors</a>'
    }).addTo(map);

    L.marker({ lat : -5.3971, lon : 105.2668}).bindPopup('Bandar Lampung').addTo(map);

    if (sumberDayaAlam || aktivitasManusia) {
        var geojson = L.geoJson(features, {
            style : style,
            onEachFeature : onEachFeature
        }).addTo(map);
    } else if (kondisiLingkungan || hubunganSDAKL || hubunganSDAAM) {
        var geojson = L.geoJson(features, {
            onEachFeature : onEachFeature
        }).addTo(map);
    }

    function highlightFeature(e) {
        var layer = e.target;

        layer.setStyle({
            weight: 1,
            color: '#666',
            dashArray: '',
            fillOpacity: 0.7
        });

        if (!L.Browser.ie && !L.Browser.opera && !L.Browser.edge) {
            layer.bringToFront();
        }

        info.update(layer.feature.properties);
    }

    function resetHighlight(e) {
        geojson.resetStyle(e.target);
        info.update();
    }

    var info = L.control();

    info.onAdd = function (map) {
        this._div = L.DomUtil.create('div', 'info'); 
        this.update();
        return this._div;
    };

    if (sumberDayaAlam) {
        info.update = function (props) {
            this._div.innerHTML = '<h4><?= $masterData->nama ?></h4>' +  (props ?
                '<b>' + props.nama + '</b><br/>' + props.jenis_sumber_daya + '<br/>' + props.kondisi +'<br/>' + props.nilai + ' Ton'
                : 'Hover di atas wilayah');
        };
    }else if (kondisiLingkungan) {
        info.update = function (props) {
            this._div.innerHTML = '<h4><?= $masterData->nama ?></h4>' +  (props ?
                '<b>' + props.nama + '</b><br/>' + props.kualitas_air + '<br/>' + props.kualitas_udara +'<br/>' + props.keanekaragaman_hayati
                : 'Hover di atas wilayah');
        };
    } else if (aktivitasManusia) {
        info.update = function (props) {
            this._div.innerHTML = '<h4><?= $masterData->nama ?></h4>' +  (props ?
                '<b>' + props.nama + '</b><br/>' + props.jenis_aktivitas + '<br/>' + props.nilai + '<br/>' + props.dampak_potensial
                : 'Hover di atas wilayah');
        };
    } else if (hubunganSDAKL) {
        info.update = function (props) {
            this._div.innerHTML = '<h4><?= $masterData->nama ?></h4>' +  (props ?
                '<b>' + props.nama + '</b><br/>' + props.dampak_SDAKL + '<br/>' + props.pengelolaan_SDAKL 
                : 'Hover di atas wilayah');
        };
    } else if (hubunganSDAAM) {
        info.update = function (props) {
            this._div.innerHTML = '<h4><?= $masterData->nama ?></h4>' +  (props ?
                '<b>' + props.nama + '</b><br/>' + props.dampak_SDAAM + '<br/>' + props.pengelolaan_SDAAM 
                : 'Hover di atas wilayah');
        };
    } 

    info.addTo(map);

    if (sumberDayaAlam || aktivitasManusia) {
        var legend = L.control({position: 'bottomright'});
        if (sumberDayaAlam) {
            legend.onAdd = function (map) {

                var div = L.DomUtil.create('div', 'info legend'),
                    grades = [0, (nilaiMax/8)*1, (nilaiMax/8)*2, (nilaiMax/8)*3, (nilaiMax/8)*4, (nilaiMax/8)*5, (nilaiMax/8)*6, (nilaiMax/8)*7],
                    labels = [];

                // loop through our density intervals and generate a label with a colored square for each interval
                for (var i = 0; i < grades.length; i++) {
                    div.innerHTML +=
                        '<i style="background:' + getColor(grades[i] + 1) + '"></i> ' +
                        grades[i] + (grades[i + 1] ? '&ndash;' + grades[i + 1] + '<br>' : '+');
                }

                return div;
            };
        } else if (aktivitasManusia) {
            legend.onAdd = function (map) {

                var div = L.DomUtil.create('div', 'info legend'),
                    grades = [1, 2, 3],
                    labels = ['Rendah', 'Sedang', 'Tinggi'];

                // loop through our density intervals and generate a label with a colored square for each interval
                for (var i = 0; i < grades.length; i++) {
                    div.innerHTML +=
                        '<i style="background:' + getColor(grades[i]) + '"></i> ' +
                        labels[i] + (grades[i + 1] ? '<br>' : '');
                }

                return div;
            };
        }
        legend.addTo(map);
    }
</script>
<?= $this->endSection(); ?>