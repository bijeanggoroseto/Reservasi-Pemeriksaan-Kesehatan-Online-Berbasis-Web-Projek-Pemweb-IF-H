<?php
session_start();
include("connect.php");
if(isset($_POST['buatReservasi'])){
    $layananLokasiId = $_POST['layananLokasiId'];
    $jadwal = $_POST['jadwal'];
    $nama = $_POST['nama'];
    $tanggalLahir = $_POST['tanggalLahir'];
    $jenisKelamin = $_POST['jenisKelamin'];
    $penggunaId = $_SESSION['pengguna_id'];


    $query = $connect-> query(
        "INSERT INTO reservasi (pengguna_id, nama, tanggal_lahir, jenis_kelamin, layanan_lokasi_id, jadwal, status_pembayaran) 
        VALUES ($penggunaId, '$nama', '$tanggalLahir', '$jenisKelamin', $layananLokasiId, '$jadwal', 0)");

    if($query){
        $reservasiId = $connect->insert_id;
        header("location: pembayaran.php?id=" . $reservasiId);
        die();
    }
    else{
        echo "reservasi gagal";
    }
}
?>