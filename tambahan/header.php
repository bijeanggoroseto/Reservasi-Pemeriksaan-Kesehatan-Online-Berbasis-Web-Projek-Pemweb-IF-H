<?php 
    $namaHeader = "";
    $fotoHeader = "gambar/foto_profil/default.png";

    $idHeader = $_SESSION["pengguna_id"];
    $queryHeader = mysqli_query($connect, "SELECT * FROM pengguna WHERE id = '$idHeader'") or die(mysqli_error($connect));
    if($userHeader = mysqli_fetch_assoc($queryHeader)){
        $fotoHeader = "gambar/foto_profil/" . $userHeader["foto_profil"];
    }
?>

<head>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        header {
            position: sticky;
            top: 0;
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: var(--primary);
            min-height: 110px;
            padding: 10px 20px;
            gap: 15px;
            box-sizing: border-box;
        }

        #juduldanLogo {
            display: flex;
            align-items: center;
            gap: 20px;
            min-width: 0;
        }

        #logo {
            width: 90px;
            height: 90px;
            flex-shrink: 0;
        }

        #container-judul {

        }

        #judul {
            margin: 0;
            font-size: 34px;
            font-family: 'Poppins', sans-serif;
            color: var(--primary-light);
            transform: translateY(+10%);
        }

        #slogan {
            margin: 0;
            font-size: 18px;
            font-family: 'Poppins', sans-serif;
            color: var(--secondary-light);
            transform: translateY(-25%);
        }

        #profilPenggunaHeader {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 80px;
            height: 80px;
            background-color: var(--background-dark);
            border-radius: 50%;
            flex-shrink: 0;
        }

        #fotoProfilHeader {
            width: 78px;
            height: 78px;
            border-radius: 50%;
            object-fit: cover;
            display: block;
        }
    </style>
</head>
<header>
    <a href="index.php">
        <div id="juduldanLogo" style="display: flex;">
            <img src="gambar/logo.png" id="logo">
            <div class="container-judul">
                <h1 id="judul">Reservasi Layanan Kesehatan Online</h1>
                <h1 id="slogan">simple dan praktis</h1>
            </div>
        </div>
    </a>
    <div id="profilPenggunaHeader">
        <a href="profil.php"><img src="<?= $fotoHeader; ?>" id="fotoProfilHeader"></a>
    </div>
</header>