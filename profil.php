<?php
include("tambahan/auth.php");
include("tambahan/connect.php");

$penggunaId = $_SESSION["pengguna_id"];

$queryUSer = mysqli_query($connect, "SELECT * FROM pengguna WHERE id = '$penggunaId'") or die(mysqli_error($connect));
$user = mysqli_fetch_assoc($queryUSer);

if (isset($_POST["simpanProfil"])) {
    $nama = $_POST["nama"];
    $email = $_POST["email"];
    $no_hp = $_POST["no_hp"];
    $password = $_POST["password"];

    $queryUpdate = mysqli_query(
        $connect,
        "UPDATE pengguna SET
        nama = '$nama',
        email = '$email',
        no_hp = '$no_hp',
        password = '$password'
        WHERE id = '$penggunaId'"
    ) or die(mysqli_error($connect));

    if ($queryUpdate) {
        $_SESSION["nama"] = $nama;
        $pesan = "Profil diperbarui!";

        $queryUSer = mysqli_query($connect, "SELECT * FROM pengguna WHERE id = '$penggunaId'") or die(mysqli_error($connect));
        $user = mysqli_fetch_assoc($queryUSer);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>profil</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include("tambahan/header.php"); ?>
    <?php if (isset($pesan)): {
        echo $pesan;
    } ?>
    <?php endif; ?>
    <p>Nama: <?= $user['nama']; ?></p>
    <p>Email: <?= $user['email']; ?></p>
    <p>No HP: <?= $user['no_hp']; ?></p>
    <p><a href="index.php" class="beranda">Kembali ke Beranda</a></p>
    <p><a href="reservasi.php" class="beranda">Reservasi anda</a></p>
    <p><a href="editProfil.php" class="beranda">Edit Profil</a></p>
    <p><a href="logout.php" class="beranda">Logout</a></p>
</body>

</html>