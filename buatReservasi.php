<?php
include("connect.php");
if(isset($_POST['buatReservasi'])){
    $layananLokasiId = $_POST['layananLokasiId'];
    $jadwal = $_POST['jadwal'];
    $jamMulai = $_POST['jamMulai'];
    $jamSelesai = $_POST['jamSelesai'];
    $nama = $_POST['nama'];
    $tanggalLahir = $_POST['tanggalLahir'];
    $jenisKelamin = $_POST['jenisKelamin'];
    $penggunaId = 1;


    $query = $connect-> query(
        "INSERT INTO reservasi (pengguna_id, nama, tanggal_lahir, jenis_kelamin, layanan_lokasi_id, jam_mulai, jam_selesai, jadwal, status_pembayaran) 
        VALUES ($penggunaId, '$nama', '$tanggalLahir', '$jenisKelamin', $layananLokasiId, '$jamMulai', '$jamSelesai', '$jadwal', 0)");

    if($query){
        header("location: pembayaran.php");
    }
    else{
        echo "reservasi gagal";
    }
}
?>