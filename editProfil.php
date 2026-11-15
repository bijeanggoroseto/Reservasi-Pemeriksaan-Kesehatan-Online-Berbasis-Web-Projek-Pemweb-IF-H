<?php
include("tambahan/auth.php");
include("tambahan/connect.php");

$penggunaId = $_SESSION["pengguna_id"];

$queryUser = mysqli_query($connect, "SELECT * FROM pengguna WHERE id = '$penggunaId'") or die(mysqli_error($connect));
$user = mysqli_fetch_assoc($queryUser);

if (isset($_POST["simpanProfil"])) {
    $nama = $_POST["nama"];
    $email_baru = $_POST["email_baru"];
    $email_lama = $_POST["email_lama"];
    $no_hp = $_POST["no_hp"];
    $password = $_POST["password"];

    if($email_baru != $email_lama){
        $cek = mysqli_query($connect, "SELECT id FROM pengguna WHERE email = '$email_baru'") or die(mysqli_error($connect));
    
        if (mysqli_num_rows($cek) > 0) {
            $error = "Email sudah terdaftar!";
        }
    }
    if(!isset($error)){
        $queryUpdate = mysqli_query(
            $connect,
            "UPDATE pengguna SET
            nama = '$nama',
            email = '$email_baru',
            no_hp = '$no_hp',
            password = '$password'
            WHERE id = '$penggunaId'"
        ) or die(mysqli_error($connect));
    
        header("Location: profil.php?pesan=profil di perbarui");
        die();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>edit profil</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
        if (isset($error)) {
            echo $error;
        }
    ?>
    <form method="post">
        <div>
            <label>Nama</label> <br>
            <input type="text" name="nama" value="<?= $user['nama']; ?>" required>
        </div>
        <br>
        <div>
            <label>Email</label> <br>
            <input type="email" name="email_baru" value="<?= $user['email']; ?>" required>
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
        <input type="hidden" value="<?= $user['email']; ?>" name="email_lama">
        <button type="submit" name="simpanProfil">Simpan Perubahan</button>
    </form>
    <p><a href="profil.php" class="beranda">Kembali</a></p> 
</body>
</html>