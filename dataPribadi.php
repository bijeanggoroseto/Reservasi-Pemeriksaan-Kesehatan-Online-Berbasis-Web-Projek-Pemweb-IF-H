<?php
    include("tambahan/auth.php");
    include("tambahan/connect.php");

    if(!isset($_POST['lokasiLayanan'])){
        header("location: index.php");
        die();
    }

    $layananLokasiId = $_POST["layananLokasiId"];
    $jadwal = $_POST["jadwal"];
    $jamMulai = $_POST['jamMulai'];
    $jamSelesai = $_POST['jamSelesai'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pribadi</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include("tambahan/header.php"); ?>

    <div class="kartu kartu-lebar">
        <h2 class="judul-kartu">Isi Data Pribadi</h2>

        <div class="ringkasan">
            <p class="baris-data">
                <b>Jadwal</b>
                <span><?= $jadwal ?>, <?= $jamMulai ?> - <?= $jamSelesai ?></span>
            </p>
        </div>

        <form action="buatReservasi.php" method="POST">
            <div class="kolom">
                <label for="nama">Nama lengkap</label>
                <input class="isian" id="nama" type="text" placeholder="Nama lengkap" name="nama" required>
            </div>
            <div class="kolom">
                <label for="tanggalLahir">Tanggal lahir</label>
                <input class="isian" id="tanggalLahir" type="date" name="tanggalLahir" required>
            </div>
            <div class="kolom">
                <label>Jenis kelamin</label>
                <div class="pilihan">
                    <label><input name="jenisKelamin" type="radio" value="male" required> Laki-laki</label>
                    <label><input name="jenisKelamin" type="radio" value="female" required> Perempuan</label>
                </div>
            </div>

            <input type="hidden" name="layananLokasiId" value="<?= $layananLokasiId ?>">
            <input type="hidden" name="jadwal" value="<?= $jadwal ?>">
            <input type="hidden" name="jamMulai" id="inputJamMulai" value="<?= $jamMulai ?>">
            <input type="hidden" name="jamSelesai" id="inputJamSelesai" value="<?= $jamSelesai ?>">

            <input class="tombol tombol-penuh" type="submit" name="buatReservasi" value="Buat Reservasi">
        </form>
    </div>
</body>
</html>
