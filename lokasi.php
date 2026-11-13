<?php 
    include("connect.php");
    $lokasiId = $_GET['id'];
    $dataLokasi = $connect->query("SELECT * FROM lokasi WHERE id = $lokasiId")->fetch_object();
    $queryLayananLokasi = $connect->query("SELECT layanan_lokasi.*, layanan.nama FROM layanan_lokasi JOIN layanan ON layanan_lokasi.layanan_id = layanan.id WHERE layanan_lokasi.lokasi_id = $lokasiId;");
    $dataLayananLokasi = [];

    $i = 0;
    while ($data = $queryLayananLokasi->fetch_object()) {
        $dataLayananLokasi[$i++] = $data;
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <style>
        #gambarLokasi {
            width: 300px;
            height: 300px;
        }

        #namaLokasi {
            font-size: 40px;
            margin: 0px;
            align-self: center;
        }

        #inputJadwal {
            margin: 20px 0px;
            padding: 10px;
            width: 200px;
            border-radius: 5px;
            border: 1px solid gray;
        }
        
        #submit {
            width: 100px;
        }

        p {
            font-size: 20px;
        }

        label {
            font-size: 20px;
        }

        select {
            margin: 20px 0px;
            margin: 20px 0px;
            padding: 10px;
            width: 200px;
            border-radius: 5px;
            border: 1px solid gray;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <?php include("header.php") ?>

    <div style="display: flex; margin: 20px 0px 20px 20px;">
        <img id="gambarLokasi" src="<?php echo $dataLokasi->gambar ?>">
        <div style="margin-left: 20px;">
            <h2 id="namaLokasi"><?php echo $dataLokasi->nama ?></h2>
            <div class="teksDeskripsi">
                <p><?php echo $dataLokasi->deskripsi ?></p>
            </div>
            <div style="display: flex;">
                <p>Alamat: <?php echo $dataLokasi->alamat ?></p>
            </div>
        </div>
    </div>

    <form action="dataPribadi.php" method="POST" style="display: grid; margin: 20px 20px;">
        <div style="display: flex;">
            <div style="display: grid;">
                <label for="jenisLayanan">Pilih Jenis Pemeriksaan</label>
                <select id="jenisLayanan" name="jenisLayanan" required>
                    <option value="" disabled selected>Pilih</option>
                    <?php $j = 0; while($j < $i){ ?>
                    <option value="<?= $j ?>"><?= $dataLayananLokasi[$j]->nama ?></option>
                    <?php $j++; } ?>
                </select>
            </div>
            <p id="durasi" style="margin-left: 30px;">Durasi: </p>
            <p id="harga" style="margin-left: 30px;">Harga: </p>
        </div>

        <label for="inputJadwal">Pilih Jadwal</label>
        <input id="inputJadwal" type="date" name="jadwal" required>

        <input type="hidden" name="layananLokasiId" id="layananLokasiId">

        <input id="submit" type="submit" name="lokasiLayanan" value="lokasiLayanan">
    </form>

    <script>
        const dataLayananLokasi = <?= json_encode($dataLayananLokasi) ?>;
        const jenisLayanan = document.getElementById("jenisLayanan");
        const durasi = document.getElementById("durasi");
        const harga = document.getElementById("harga");
        const layananLokasiId = document.getElementById("layananLokasiId");
        
        jenisLayanan.addEventListener("change", function() {
            let layananId = parseInt(jenisLayanan.value);
            durasi.textContent = "Durasi: " + dataLayananLokasi[layananId].durasi_menit + "menit";
            harga.textContent = "Harga: " + dataLayananLokasi[layananId].harga;
            layananLokasiId.value = dataLayananLokasi[layananId].id;
        });
    </script>
</body>
</html>