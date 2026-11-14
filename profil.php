<?php
session_start();
include("connect.php");

if (!isset($_SESSION["pengguna_id"])) {
    header("Location: login.php");
    die();
}

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
    <title>Dummy Data</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include("header.php"); ?>
    <h2>Edit Profil</h2>
    <?php if (isset($pesan)): {
        echo $pesan;
    } ?>
    <?php endif; ?>
    <form method="post">
        <div>
            <label>Nama</label> <br>
            <input type="text" name="nama" value="<?= $user['nama']; ?>" required>
        </div>
        <br>
        <div>
            <label>Email</label> <br>
            <input type="email" name="email" value="<?= $user['email']; ?>" required>
        </div>
        <br>
        <div>
            <label>No. Hp</label> <br>
            <input type="text" name="no_hp" value="<?= $user['no_hp']; ?>" required>
        </div>
        <br>
        <div>
            <label>Password</label> <br>
            <input type="text" name="password" value="<?= $user['password']; ?>" required>
        </div>
        <br>
        <button type="submit" name="simpanProfil">Simpan Perubahan</button>
    </form>

    <p><a href="index.php" class="beranda">Kembali ke Beranda</a></p>
</body>

</html>