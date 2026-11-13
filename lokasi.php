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
        <img id="gambarLokasi" src="images/hospital.png">
        <div style="margin-left: 20px;">
            <h2 id="namaLokasi">hospital 1</h2>
            <div class="teksDeskripsi">
                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Doloribus ipsam ducimus asperiores, voluptas animi doloremque officiis corrupti eum, cumque, sunt id aspernatur. Repudiandae, ipsum odio et culpa nobis reiciendis sequi?</p>
            </div>
            <div style="display: flex;">
                <p>Senin-Jumat 08:00-16:00</p>
            </div>
        </div>
    </div>

    <form action="dataPribadi.php" style="display: grid; margin: 20px 20px;">
        <label for="kategori">Pilih Kategori Pemeriksaan</label>
        <select id="kategori" name="kategori" required>
            <option value="" disabled selected>Pilih kategori</option>
            <option value="pemeriksaanUmum">Pemeriksaan umum</option>
            <option value="rontgenTulang">Rontgen tulang</option>
            <option value="tesDarah">Tes darah</option>
        </select>

        <label for="inputJadwal">Pilih Jadwal</label>
        <input id="inputJadwal" type="date" name="jadwal" required>

        <input id="submit" type="submit">
    </form>

</body>
</html>