<?php
session_start();
include("connect.php");
if (isset($_POST["register"])) {
    $nama = $_POST["nama"];
    $email = $_POST["email"];
    $no_hp = $_POST["no_hp"];
    $password = $_POST["password"];

    $cek = mysqli_query($connect, "SELECT id FROM pengguna WHERE email = '$email'") or die(mysqli_error($connect));

    if (mysqli_num_rows($cek) > 0) {
        $error = "Email sudah terdaftar!";
    } else {
        $query = mysqli_query($connect, "INSERT INTO pengguna (nama, email, no_hp, password) VALUES ('$nama', '$email', '$no_hp', '$password')");

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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dummy Data</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php 
        if (isset($error)): {
            echo $error;
        } ?>
    <?php 
        endif;
    ?>
    <h1>Register</h1>
    <form method="POST">
        nama :
        <input type="text" name="nama" placeholder="input nama">
        <br>
        email :
        <input type="email" name="email" placeholder="input email">
        <br>
        no_hp :
        <input type="text" name="no_hp" placeholder="input no_hp">
        <br>
        password :
        <input type="password" name="password" placeholder="input password">
        <br>
        <input type="submit" value="register" name="register">
    </form>
    <p>
        Sign In -> <a href="login.php" class="login">Login</a>
    </p>
</body>

</html>