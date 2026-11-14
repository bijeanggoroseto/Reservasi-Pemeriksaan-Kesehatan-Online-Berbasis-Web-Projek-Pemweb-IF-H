<?php 
    include("header.php");
    $query = $connect->query("SELECT * FROM lokasi");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Antrean online</title>
    <link rel="stylesheet" href="style.css">
    <style>
        #kolomPencarian {
            margin: 20px 0px 10px 20px;
        }

        .gambarLokasi {
            margin-left: 20px;
            width: 200px;
            height: 200px;
        }
    </style>
</head>
<body>

    <input id="kolomPencarian" type="text" placeholder="search location">

    <div style="display: grid;">

        <?php while($data = $query->fetch_object()){ ?>
        <a href="lokasi.php?lokasiId=<?php  echo $data->id; ?>"><div style="display: flex; margin-top: 10px;">
            <img class="gambarLokasi" src="<?php echo $data->gambar ?>">
            <div style="margin-left: 10px;">
                <h2><?php echo $data->nama ?></h2>
                <p><?php echo $data->deskripsi ?></p>
                <div style="display: flex;">
                    <p>Senin-Jumat 08:00-16:00</p>
                </div>
            </div>
        </div></a>
        <?php } ?>

    </div>
</body>
</html>