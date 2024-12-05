<?php
include('koneksi.php');

$koordinat_x = $_GET['koordinat_x'];
$koordinat_y = $_GET['koordinat_y'];
$nama_tempat = $_GET['nama_tempat'];

$query = "Insert into koordinat_gis (x, y, nama_tempat) values (?, ?, ?)";
$stmt = $koneksi->prepare($query);
$stmt->bind_param("dds", $koordinat_x, $koordinat_y,$nama_tempat);
$stmt->execute();

echo "Data Berhasil Disimpan"
?>
