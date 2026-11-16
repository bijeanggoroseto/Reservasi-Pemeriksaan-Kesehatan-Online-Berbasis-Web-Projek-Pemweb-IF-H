<?php
session_start();
include("tambahan/connect.php");
if(isset($_SESSION["pengguna_id"])){
        header("location: index.php");
        die();
}

if (isset($_POST["login"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $query = mysqli_query($connect, "SELECT * FROM pengguna WHERE email = '$email' AND password = '$password' ") or die (mysqli_error($connect));
    
    if (mysqli_num_rows($query) > 0) {
        $data= mysqli_fetch_array($query);

        $_SESSION["pengguna_id"] = $data["id"];
        $_SESSION["nama"] = $data["nama"];

        header("Location: index.php");
        die();
    } else {
        $error = "Email atau Password Salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="kartu">
        <h1 class="judul-kartu">Masuk</h1>

        <?php if (isset($error)): ?>
            <p class="error"><?= $error; ?></p>
        <?php endif; ?>

        <form method="POST">
            <div class="kolom">
                <label for="email">Email</label>
                <input class="isian" id="email" type="email" name="email" placeholder="Masukkan email" required>
            </div>
            <div class="kolom">
                <label for="password">Password</label>
                <input class="isian" id="password" type="password" name="password" placeholder="Masukkan password" required>
            </div>
            <input class="tombol tombol-penuh" type="submit" name="login" value="Masuk">
        </form>

        <p class="teks-bawah">
            Belum punya akun? <a href="register.php" class="register">Daftar di sini</a>
        </p>
    </div>
</body>

</html>
