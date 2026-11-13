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
    <?php include("header.php") ?>

    <input id="kolomPencarian" type="text" placeholder="search location">

    <div style="display: grid;">
        <a href="lokasi.php"><div style="display: flex; margin-top: 10px;">
            <img class="gambarLokasi" src="images/hospital.png">
            <div style="margin-left: 10px;">
                <h2>hospital 1</h2>
                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Doloribus ipsam ducimus asperiores, voluptas animi doloremque officiis corrupti eum, cumque, sunt id aspernatur. Repudiandae, ipsum odio et culpa nobis reiciendis sequi?</p>
                <div style="display: flex;">
                    <p>Senin-Jumat 08:00-16:00</p>
                </div>
            </div>
        </div></a>
        
        <a href="lokasi.php"><div style="display: flex; margin-top: 10px;">
            <img class="gambarLokasi" src="images/hospital.png">
            <div style="margin-left: 10px;">
                <h2>hospital 2</h2>
                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Doloribus ipsam ducimus asperiores, voluptas animi doloremque officiis corrupti eum, cumque, sunt id aspernatur. Repudiandae, ipsum odio et culpa nobis reiciendis sequi?</p>
                <div style="display: flex;">
                    <p>Senin-Jumat 08:00-16:00</p>
                </div>
            </div>
        </div></a>
    </div>
</body>
</html>