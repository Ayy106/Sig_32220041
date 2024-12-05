<?php
include('koneksi.php');

if(isset($_POST['nomor'])) {
    $nomor = $_POST['nomor'];

    $query = "DELETE FROM kordinat_gis WHERE nomor = ?";
    $stmt = mysqli_prepare($conn, $query);

    mysqli_stmt_bind_param($stmt, 'i', $nomor);

    if(mysqli_stmt_execute($stmt)) {
        echo "success";
    } else {
        echo "error";
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($conn);
?>
