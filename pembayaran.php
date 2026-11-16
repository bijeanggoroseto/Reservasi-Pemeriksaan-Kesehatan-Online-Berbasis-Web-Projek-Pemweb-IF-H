<?php
    include("tambahan/auth.php");
    include("tambahan/connect.php");

    $penggunaId = $_SESSION["pengguna_id"];
    if(!isset($_GET['reservasiId'])){
        header("location: index.php");
        die();
    }

    $penggunaId = $_SESSION["pengguna_id"];
    $reservasiId = $_GET["reservasiId"];

    $queryDetail = mysqli_query($connect,
    "SELECT reservasi.nama AS nama_pasien, 
    reservasi.status_pembayaran,
    layanan.nama AS nama_layanan, 
    layanan_lokasi.harga FROM reservasi 
    JOIN layanan_lokasi ON reservasi.layanan_lokasi_id = layanan_lokasi.id 
    JOIN layanan ON layanan_lokasi.layanan_id = layanan.id 
    WHERE reservasi.id = '$reservasiId' 
    AND reservasi.pengguna_id = '$penggunaId'") or die(mysqli_error($connect));
    
    $detail = mysqli_fetch_assoc($queryDetail);
    if(!$detail || $detail["status_pembayaran"] == 1) {
        header("location: index.php");
        die();
    }

    if(isset($_POST["bayar"])){
        $jumlah = $detail["harga"];
        $metode = $_POST["metode"];

        $queryInsertBayar = mysqli_query($connect, "INSERT INTO pembayaran (reservasi_id, jumlah, metode, dibayar_pada) 
        VALUES ('$reservasiId', '$jumlah', '$metode', NOW()) ") or die(mysqli_error($connect));

        $queryBayar = mysqli_query($connect,"UPDATE reservasi SET status_pembayaran = 1 
        WHERE id = '$reservasiId' AND pengguna_id = '$penggunaId'") or die(mysqli_error($connect));

        if($queryInsertBayar && $queryBayar){
            header("location: index.php");
            die();
        }
    }

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include("tambahan/header.php"); ?>

    <div class="kartu kartu-lebar">
        <h2 class="judul-kartu">Konfirmasi Pembayaran</h2>

        <div class="ringkasan">
            <p class="baris-data"><b>Pasien</b> <span><?= $detail["nama_pasien"]; ?></span></p>
            <p class="baris-data"><b>Layanan</b> <span><?= $detail["nama_layanan"]; ?></span></p>
            <p class="baris-data"><b>Nominal</b> <span class="nominal">Rp <?= number_format($detail["harga"], 0, ",", "."); ?></span></p>
        </div>

        <form method="POST">
            <div class="kolom">
                <label for="metode">Metode Pembayaran</label>
                <select class="isian" name="metode" id="metode" required>
                    <option value="qris">QRIS</option>
                    <option value="tunai">Tunai</option>
                </select>
            </div>
            <input class="tombol tombol-penuh" type="submit" name="bayar" value="BAYAR">
        </form>

        <p class="teks-bawah"><a href="reservasi.php" class="beranda">Kembali</a></p>
    </div>
</body>
</html>
