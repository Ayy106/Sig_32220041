<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Aplikasi Peta GIS Sederhana Dengan Google Map API</title>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB760b8C1q4_lkvWn3kJsyqUQW3_-NYtYk"></script>
<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript">
var peta;
var koorAwal = new google.maps.LatLng(-7.329579339811421, 108.2196256616021);

function peta_awal() {
    loadDataLokasiTersimpan();
    var settingpeta = {
        zoom: 15,
        center: koorAwal,
        mapTypeId: google.maps.MapTypeId.HYBRID 
    };
    peta = new google.maps.Map(document.getElementById("kanvaspeta"), settingpeta);
    google.maps.event.addListener(peta, 'click', function(event) {
        tandai(event.latLng);
    });
}

function tandai(lokasi) {
    $("#koorX").val(lokasi.lat());
    $("#koorY").val(lokasi.lng());
    var tanda = new google.maps.Marker({
        position: lokasi,
        map: peta
    });
}

$(document).ready(function() {
    $("#simpanpeta").click(function() {
        var koordinat_x = $("#koorX").val();
        var koordinat_y = $("#koorY").val();
        var nama_tempat = $("#namaTempat").val();    
        $.ajax({
            url: "simpan_lokasi_baru.php",
            data: "koordinat_x=" + koordinat_x + "&koordinat_y=" + koordinat_y + "&nama_tempat=" + nama_tempat,
            success: function(msg) {
                $("#namaTempat").val(null);
            }
        });
    });
});

function loadDataLokasiTersimpan() {
    $('#kordinattersimpan').load('tampilkan_lokasi_tersimpan.php');
}
setInterval(loadDataLokasiTersimpan, 3000);

function carikordinat(lokasi) {
    var settingpeta = {
        zoom: 15,
        center: lokasi,
        mapTypeId: google.maps.MapTypeId.HYBRID        
    };
    peta = new google.maps.Map(document.getElementById("kanvaspeta"), settingpeta);
    var tanda = new google.maps.Marker({
        position: lokasi,
        map: peta
    });
    google.maps.event.addListener(tanda, 'click', function() {
        infowindow.open(peta, tanda);
    });
    google.maps.event.addListener(peta, 'click', function(event) {
        tandai(event.latLng);
    });
}

function gantipeta() {
    loadDataLokasiTersimpan();
    var isi = document.getElementById('cmb').value;
    var settingpeta;
    if (isi == '1') {
        settingpeta = {
            zoom: 15,
            center: koorAwal,
            mapTypeId: google.maps.MapTypeId.HYBRID
        };
    } else if (isi == '2') {
        settingpeta = {
            zoom: 15,
            center: koorAwal,
            mapTypeId: google.maps.MapTypeId.TERRAIN 
        };
    } else if (isi == '3') {
        settingpeta = {
            zoom: 15,
            center: koorAwal,
            mapTypeId: google.maps.MapTypeId.SATELLITE  
        };
    } else if (isi == '4') {
        settingpeta = {
            zoom: 15,
            center: koorAwal,
            mapTypeId: google.maps.MapTypeId.HYBRID  
        };
    }
    peta = new google.maps.Map(document.getElementById("kanvaspeta"), settingpeta);
    google.maps.event.addListener(peta, 'click', function(event) {
        tandai(event.latLng);
    });
}
</script>

<style>

body {
    font-size: 14px;
    font-family: Arial, sans-serif;
    background-color: #f4f7fa;
    color: #333;
    margin: 0;
    padding: 0;
}

h1 {
    text-align: center;
    color: #0066cc;
}

.container {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    padding: 20px;
}

/* Peta */
#kanvaspeta {
    flex: 2;
    height: 500px;
    border: 2px solid #ccc;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}


#form_lokasi {
    flex: 1;
    padding: 20px;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

table {
    width: 100%;
    margin: 10px 0;
}

table td {
    padding: 8px;
}

input, select, button {
    width: 100%;
    padding: 10px;
    margin: 5px 0;
    border: 1px solid #ccc;
    border-radius: 5px;
}

input, select {
    background-color: #fafafa;
}

button {
    background-color: #28a745;
    color: white;
    font-size: 16px;
    cursor: pointer;
}

button:hover {
    background-color: #218838;
}

select {
    background-color: #e9ecef;
}

#kordinattersimpan {
    margin-top: 20px;
}

@media (max-width: 768px) {
    .container {
        flex-direction: column;
    }
    #kanvaspeta {
        width: 100%;
        height: 400px;
    }

    #form_lokasi {
        width: 100%;
        margin-top: 20px;
    }
}
</style>

</head>
<body onload="peta_awal()">
<h1>Aplikasi Peta GIS Sederhana</h1>
<div class="container">
    <div id="kanvaspeta"></div>
    <div id="form_lokasi">
        <table>
            <tr>
                <td>Ganti Jenis Peta:</td>
                <td>
                    <select id="cmb" onchange="gantipeta()">
                        <option value="1">Peta Roadmap</option>
                        <option value="2">Peta Terrain</option>
                        <option value="3">Peta Satelite</option>
                        <option value="4">Peta Hybrid</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Koordinat X:</td>
                <td><input type="text" name="koordinatx" id="koorX" readonly="readonly"></td>
            </tr>
            <tr>
                <td>Koordinat Y:</td>
                <td><input type="text" name="koordinaty" id="koorY" readonly="readonly"></td>
            </tr>
            <tr>
                <td>Nama Lokasi:</td>
                <td><input type="text" name="namatempat" id="namaTempat"></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <button id="simpanpeta">Simpan</button>
                    <button onclick="javascript:carikordinat(koorAwal);">Koordinat Awal</button>
                </td>
            </tr>
        </table>
        <div id="kordinattersimpan"></div>
    </div>
</div>

</body>
</html>
