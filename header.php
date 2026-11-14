<?php 
    session_start();
    if(!isset($_SESSION["pengguna_id"])){
        header("location: login.php");
        die();
    }
    include_once("connect.php");

    $namaHeader = "";
    $fotoHeader = "gambar/foto_profil/default.png";

    if(isset($_SESSION["pengguna_id"])){
        $idHeader = $_SESSION["pengguna_id"];
        $queryHeader = mysqli_query($connect, "SELECT * FROM pengguna WHERE id = '$idHeader'") or die(mysqli_error($connect));
        if($userHeader = mysqli_fetch_assoc($queryHeader)){
            $namaHeader = $userHeader["nama"];
            if(!empty($userHeader["foto_profil"])){
                    $fotoHeader = "gambar/foto_profil/" . $userHeader["foto_profil"];
            }
        }
    }

?>

<head>
    <link rel="stylesheet" href="style.css">
</head>
<header>
    <h1 class="judulUtamaHeader">Reservasi online</h1>
    <div class="profilPenggunaHeader">
        <h2 style="margin-right: 20px; transform: translateY(-50%);"><?= $namaHeader; ?></h2>
        <a href="profil.php"><img src="<?= $fotoHeader; ?>" id="fotoProfilHeader"></a>
    </div>
</header>