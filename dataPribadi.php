<?php
    include("header.php");

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
        <h2>Isi Data Pribadi</h2>
        <form action="buatReservasi.php" method="POST">
            <div>
                <label for="nama">nama lengkap:</label>
                <input id="nama" type="text" placeholder="nama lengkap" name="nama" required>
            </div>
            <div>
                <label for="tanggalLahir">tanggal lahir:</label>
                <input id="tanggalLahir" type="date" name="tanggalLahir" required>
            </div>
            <div>
                <label for="jenisKelamin">jenis kelamin:</label><br>
                <label>Laki-laki</label>
                <input id="jenisKelamin" name="jenisKelamin" type="radio" value="male" required>
                <label>Perempuan</label>
                <input id="jenisKelamin" name="jenisKelamin" type="radio" value="female" required>
            </div>

            <input type="hidden" name="layananLokasiId" value="<?= $layananLokasiId ?>">
            <input type="hidden" name="jadwal" value="<?= $jadwal ?>">
            <input type="hidden" name="jamMulai" id="inputJamMulai" value="<?= $jamMulai ?>">
            <input type="hidden" name="jamSelesai" id="inputJamSelesai" value="<?= $jamSelesai ?>">

            <input type="submit" name="buatReservasi" value="buatReservasi">
        </form>
    </div>
</body>
</html>