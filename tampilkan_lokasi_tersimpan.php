<?php
include('koneksi.php'); 

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error()); 
} else {
    echo "Koneksi berhasil!<br>";
}

$query = "SELECT * FROM kordinat_gis";
$result = mysqli_query($koneksi, $query);  

if ($result) {
    echo "Query berhasil dijalankan!<br>";
    while ($koor = mysqli_fetch_array($result)) {
        ?>
        <ul>
            <li class="content">
                <a href="javascript:carikordinat(new google.maps.LatLng(<?php echo $koor['x']; ?>, <?php echo $koor['y']; ?>))">
                    <?php echo $koor['nama_tempat']; ?>
                </a> - 
                <a href="#" class="delbutton" id="<?php echo $koor['nomor']; ?>">(Hapus)</a>
            </li>
        </ul>
        <?php
    }
} else {
    // Menampilkan error jika query gagal
    echo "Error dalam query: " . mysqli_error($koneksi);
}
?>
