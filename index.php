<?php 
    include("tambahan/auth.php");
    include("tambahan/connect.php");
    $daftarLayanan = $connect->query("SELECT * FROM layanan");
    $layananId = isset($_GET['layananId']) ? (int)$_GET['layananId'] : 0;

    if($layananId > 0){
        $query = $connect->query("SELECT * FROM lokasi WHERE id IN (SELECT lokasi_id FROM layanan_lokasi WHERE layanan_id = $layananId)");
    } else {
        $query = $connect->query("SELECT * FROM lokasi");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Antrean online</title>
    <link rel="stylesheet" href="style.css">
    <style>
        p {
            margin: 10px 0px;
            font-family: 'Inter';
            color: var(--text);
        }

        #body-title {
            margin: 20px 100px 10px 100px;
            padding: 5px 10px;
            align-items: center;
            font-size: 28px;
            font-family: 'Poppins', sans-serif;
            color: var(--primary-dark);
        }

        .body-title-2 {
            margin: 10px 0px;
            font-size: 20px;
            font-family: 'Poppins', sans-serif;
            color: var(--secondary-dark);
        }

        .container-luar {
            display: flex; 
            align-items: center;
            margin: 10px 100px;
            padding: 10px;
            height: 280px;
            background-color: var(--surface);
            border: solid var(--border);
            border-width: 2px;
            border-radius: 20px;
        }

        .container-dalam {
            display: flex; 
            align-items: center;
            margin-top: 10px;
        }

        .gambar-lokasi {
            margin-left: 20px;
            width: 200px;
            height: 200px;
            border: solid var(--border);
            border-width: 3px;
            border-radius: 20px;
        }

        .detail-lokasi {
            margin-left: 20px;
            max-height: 240px;
            overflow-y: auto;
        }

        .container-layanan {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .layanan {
            display: inline-block;
            background-color: var(--primary-dark);
            border-radius: 10px;
            padding: 4px 10px;
            color: var(--primary-light);
        }
        

        .filter-layanan {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 0px 100px 10px 100px;
            padding: 0px 10px;
        }

        .filter-layanan label {
            font-family: 'Poppins', sans-serif;
            font-weight: bold;
            color: var(--primary-dark);
        }

        .filter-layanan select {
            min-width: 220px;
            padding: 10px;
            border: 1px solid var(--border);
            border-radius: 8px;
            background-color: white;
            color: var(--text);
            font: inherit;
            cursor: pointer;
        }

        .filter-layanan select:hover {
            background-color: var(--primary-light);
        }

    </style>
</head>
<body>
    <?php include("tambahan/header.php"); ?>

    <h2 id="body-title">Pilih Lokasi Pelayanan</h2>

    <form method="GET" action="index.php" class="filter-layanan">
        <label for="layananId">Kategori layanan</label>
        <select id="layananId" name="layananId" onchange="this.form.submit()">
            <option value="0">Semua layanan</option>
            <?php while($kategori = $daftarLayanan->fetch_object()){ ?>
            <option value="<?= $kategori->id ?>" <?= $layananId == $kategori->id ? 'selected' : '' ?>><?= $kategori->nama ?></option>
            <?php } ?>
        </select>
    </form>

    <?php if($query->num_rows == 0){ ?>
    <p class="kosong" style="margin: 10px 100px; padding: 0px 10px;">Belum ada lokasi yang menyediakan layanan ini.</p>
    <?php } ?>

    <div style="display: grid; justify-content: center">
        <?php while($data = $query->fetch_object()){ ?>
        <div class="container-luar">
            <a href="lokasi.php?lokasiId=<?= $data->id; ?>">
                <div class="container-dalam">
                <img class="gambar-lokasi" src="<?= $data->gambar ?>">
                    <div class="detail-lokasi">
                        <h2 class="body-title-2"><?= $data->nama ?></h2>
                        <p><?= $data->alamat ?></p>
                        <h2 class="body-title-2" style="font-size: 17px;">Layanan tersedia</h2>
                        <div class="container-layanan">
                            <?php
                                $dataLayanan = $connect->query("SELECT * FROM layanan WHERE id IN (SELECT layanan_id FROM layanan_lokasi WHERE lokasi_id = {$data->id})");
                                while($layanan = $dataLayanan->fetch_object()){
                                    ?>
                            <p class="layanan"><?=  $layanan->nama ?></p>
                            <?php } ?>
                        </div>
                        <p><?= $data->deskripsi ?></p>
                    </div>
                </div>
            </a>
        </div>
        <?php } ?>
    </div>
</body>
</html>