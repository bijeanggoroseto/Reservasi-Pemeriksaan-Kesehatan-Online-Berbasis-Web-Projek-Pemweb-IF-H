<?php
    session_start();
    include("connect.php");

    if(!isset($_POST['lokasiLayanan'])){
        header("location: index.php");
        die();
    }
    $layananLokasiId = $_POST['layananLokasiId'];
    $jadwal = $_POST['jadwal'];
    $jamMulai = $_POST['jamMulai'];
    $jamSelesai = $_POST['jamSelesai'];
    $nama = $_POST['nama'];
    $tanggalLahir = $_POST['tanggalLahir'];
    $jenisKelamin = $_POST['jenisKelamin'];
    $penggunaId = $_SESSION['pengguna_id'];


    $query = $connect-> query(
        "INSERT INTO reservasi (pengguna_id, nama, tanggal_lahir, jenis_kelamin, layanan_lokasi_id, jam_mulai, jam_selesai, jadwal, status_pembayaran) 
        VALUES ($penggunaId, '$nama', '$tanggalLahir', '$jenisKelamin', $layananLokasiId, '$jamMulai', '$jamSelesai', '$jadwal', 0)");

    if($query){
        $reservasiId = $connect->insert_id;
        header("location: pembayaran.php?reservasiId=" . $reservasiId);
        die();
    }
    else{
        echo "reservasi gagal";
    }
?>