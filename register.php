<?php
session_start();
include("tambahan/connect.php");
if(isset($_SESSION["pengguna_id"])){
        header("location: index.php");
        die();
}


if (isset($_POST["register"])) {
    $nama = $_POST["nama"];
    $email = $_POST["email"];
    $no_hp = $_POST["no_hp"];
    $password = $_POST["password"];

    $cek = mysqli_query($connect, "SELECT id FROM pengguna WHERE email = '$email'") or die(mysqli_error($connect));

    if (mysqli_num_rows($cek) > 0) {
        $error = "Email sudah terdaftar!";
    } else {
        $query = mysqli_query($connect, "INSERT INTO pengguna (nama, email, no_hp, password, foto_profil) VALUES ('$nama', '$email', '$no_hp', '$password', 'default.png')");

        if ($query) {
            header("Location: login.php");
            die();
        } else {
            $error = "Registrasi gagal!" . mysqli_error($connect);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="kartu">
        <h1 class="judul-kartu">Daftar Akun</h1>

        <?php if (isset($error)): ?>
            <p class="error"><?= $error; ?></p>
        <?php endif; ?>

        <form method="POST">
            <div class="kolom">
                <label for="nama">Nama</label>
                <input class="isian" id="nama" type="text" name="nama" placeholder="Masukkan nama" required>
            </div>
            <div class="kolom">
                <label for="email">Email</label>
                <input class="isian" id="email" type="email" name="email" placeholder="Masukkan email" required>
            </div>
            <div class="kolom">
                <label for="no_hp">No. HP</label>
                <input class="isian" id="no_hp" type="tel" name="no_hp" placeholder="Masukkan nomor HP" required>
            </div>
            <div class="kolom">
                <label for="password">Password</label>
                <input class="isian" id="password" type="password" name="password" placeholder="Masukkan password" required>
            </div>
            <input class="tombol tombol-penuh" type="submit" value="Daftar" name="register">
        </form>

        <p class="teks-bawah">
            Sudah punya akun? <a href="login.php" class="login">Masuk</a>
        </p>
    </div>
</body>

</html>
