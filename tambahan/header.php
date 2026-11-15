<?php 
    $namaHeader = "";
    $fotoHeader = "gambar/foto_profil/default.png";

    $idHeader = $_SESSION["pengguna_id"];
    $queryHeader = mysqli_query($connect, "SELECT * FROM pengguna WHERE id = '$idHeader'") or die(mysqli_error($connect));
    if($userHeader = mysqli_fetch_assoc($queryHeader)){
        $namaHeader = $userHeader["nama"];
        if(!empty($userHeader["foto_profil"])){
                $fotoHeader = "../gambar/foto_profil/" . $userHeader["foto_profil"];
        }
    }
?>

<head>
    <link rel="stylesheet" href="../style.css">
</head>
<header>
    <a href="index.php"><h1 class="judulUtamaHeader">Reservasi online</h1></a>
    <div class="profilPenggunaHeader">
        <h2 style="margin-right: 20px; transform: translateY(-50%);"><?= $namaHeader; ?></h2>
        <a href="profil.php"><img src="<?= $fotoHeader; ?>" id="fotoProfilHeader"></a>
    </div>
</header>