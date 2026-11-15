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
if (isset($_POST["hapusAkun"])) {
    mysqli_query($connect, "DELETE FROM pembayaran WHERE reservasi_id IN (SELECT id FROM reservasi WHERE pengguna_id = '$penggunaId')") or die(mysqli_error($connect));
    mysqli_query($connect, "DELETE FROM reservasi WHERE pengguna_id = '$penggunaId'") or die(mysqli_error($connect));
    mysqli_query($connect, "DELETE FROM pengguna WHERE id = '$penggunaId'") or die(mysqli_error($connect));

    if (!empty($user["foto_profil"]) && $user["foto_profil"] != "default.png") {
        $fotoLama = __DIR__ . "/gambar/foto_profil/" . basename($user["foto_profil"]);
        if (file_exists($fotoLama)) {
            unlink($fotoLama);
        }
    }

    $_SESSION = [];
    session_destroy();

    header("Location: login.php");
    die();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include("tambahan/header.php"); ?>

    <div class="kartu">
        <img class="foto-profil"
            src="gambar/foto_profil/<?= $user['foto_profil'] ?? ''; ?>"
            alt="Foto profil"
            onerror="this.src='gambar/foto_profil/default.png'">

        <h2 class="judul-kartu">Profil Saya</h2>

        <?php if (isset($pesan) || isset($_GET["pesan"])): ?>
            <p class="sukses"><?= htmlspecialchars($pesan ?? $_GET["pesan"]); ?></p>
        <?php endif; ?>

        <p class="baris-data"><b>Nama</b> <span><?= $user['nama'] ?? ''; ?></span></p>
        <p class="baris-data"><b>Email</b> <span><?= $user['email'] ?? ''; ?></span></p>
        <p class="baris-data"><b>No. HP</b> <span><?= $user['no_hp'] ?? ''; ?></span></p>

        <div class="tombol-kolom">
            <a href="editProfil.php" class="beranda">Edit Profil</a>
            <a href="reservasi.php" class="beranda">Reservasi Anda</a>
            <a href="index.php" class="beranda">Beranda</a>
            <a href="logout.php" class="beranda keluar" onclick="return confirm('Yakin ingin keluar?')">Logout</a>
            <form method="POST" onsubmit="return confirm('Hapus akun? Semua data akun dan reservasi Anda akan dihapus permanen.')">
                <button type="submit" name="hapusAkun" class="tombol tombol-merah tombol-penuh">Hapus Akun</button>
            </form>
        </div>
    </div>
</body>

</html>
