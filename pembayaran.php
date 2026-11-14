<?php
    session_start();
    include("connect.php");

    if(!isset($_SESSION["pengguna_id"])){
        header("location: login.php");
        die();
    }

    $penggunaId = $_SESSION["pengguna_id"];
    $reservasiId = $_GET["id"];
    
    $queryDetail = mysqli_query($connect,
    "SELECT reservasi.nama AS nama_pasien, 
    layanan.nama AS nama_layanan, 
    layanan_lokasi.harga FROM reservasi 
    JOIN layanan_lokasi ON reservasi.layanan_lokasi_id = layanan_lokasi.id 
    JOIN layanan ON layanan_lokasi.layanan_id = layanan.id 
    WHERE reservasi.id = '$reservasiId' 
    AND reservasi.pengguna_id = '$penggunaId'") or die(mysqli_error($connect));
    
    $detail = mysqli_fetch_assoc($queryDetail);
    if(!$detail) {
        header("location: reservasi.php");
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
            header("location: reservasi.php");
            die();
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dummy Data</title>
    <link rel="stylesheet" href="style.css">
    <style>
        #kotakInput {
            margin-top: 50px;
            width: 600px;
            height: 350px;
            border-radius: 5px;
            border: 1px solid gray;
            justify-self: center;
        }

        #nominal {
            margin-left: 20px;
            font-size: 20px;
        }

        h2 {
            height: 20px;
            justify-self: center;
            font-size: 30px;
        }

        input {
            margin: 20px 0px 20px 20px;
            width: 100px;
            height: 20px;
        }

        label {
            margin: 20px 0px 20px 20px;
            font-size: 20px;
        }
    </style>
</head>
<body>
    <?php include("header.php") ?>

    <div id="kotakInput">
        <h2>Konfirmasi Pembayaran</h2>
        <div style="display: flex;">
            <p id="nominal">
                Pasien: <?= $detail["nama_pasien"]; ?> 
                (<?= $detail["nama_layanan"]; ?>) <br>
                Nominal Pembayaran: <br>
                <strong>Rp <?=number_format($detail["harga"], 0, ",", "."); ?></strong>
            </p>
        </div>
        <form method="POST">
            <label for="metode">Metode Pembayaran</label>
            <select name="metode" id="metode" required>
                <option value="qris">QRIS</option>
                <option value="tunai">Tunai</option>
            </select><br>
            <input type="submit" name="bayar" value="BAYAR">
        </form>
    </div>
</body>
</html>