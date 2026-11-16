<?php
include("tambahan/auth.php");
include("tambahan/connect.php");

$penggunaId = $_SESSION["pengguna_id"];

$queryUser = mysqli_query($connect, "SELECT * FROM pengguna WHERE id = '$penggunaId'") or die(mysqli_error($connect));
$user = mysqli_fetch_assoc($queryUser);
$fotoPreview = "gambar/foto_profil/" . $user["foto_profil"];
$pathFotoBaru = "";

if (isset($_POST["simpanProfil"])) {
    $hapusFoto = $_POST["hapusFoto"];
    $nama = $_POST["nama"];
    $email_baru = $_POST["email_baru"];
    $email_lama = $_POST["email_lama"];
    $no_hp = $_POST["no_hp"];
    $password = $_POST["password"];

    if(!$_FILES["foto"]["error"] == UPLOAD_ERR_NO_FILE || $hapusFoto == "hapus"){
        if($hapusFoto == "hapus"){
            $pathFotoBaru = "default.png";
        }
        else{
            $foto = $_FILES["foto"];
            if ($foto["size"] > 2 * 1024 * 1024) {
               $error = "Ukuran foto terlalu besar!";
            }
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_file($finfo, $foto["tmp_name"]);
            $tipeDiizinkan = [
                "image/jpeg" => "jpg",
                "image/png" => "png",
                "image/webp" => "webp"
            ];
            if (!isset($tipeDiizinkan[$mime])) {
                $error = "Format foto tidak diizinkan!";
            }
            $fotoBaru = $penggunaId . "." . $tipeDiizinkan[$mime];
            $folder = __DIR__ . "/gambar/foto_profil/";
        
            if (move_uploaded_file($foto["tmp_name"], $folder . $fotoBaru)) {
                $pathFotoBaru = $fotoBaru;
            }
        }

        $fotoLama = __DIR__ . "/gambar/foto_profil/" . $user["foto_profil"];
        if (file_exists($fotoLama) && $user["foto_profil"] != "default.png") {
            unlink($fotoLama);
        }
    }

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
            foto_profil = '$pathFotoBaru',
            password = '$password'
            WHERE id = '$penggunaId'"
        ) or die(mysqli_error($connect));
    
        header("Location: profil.php?pesan=profil di perbarui");
        die();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include("tambahan/header.php"); ?>

    <div class="kartu kartu-edit">
        <h2 class="judul-kartu">Edit Profil</h2>

        <?php if (isset($error)): ?>
            <p class="error"><?= $error; ?></p>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data" class="form-edit">
            <div class="kolom-foto">
                <label for="foto">Foto Profil</label>
                <img src="<?= $fotoPreview ?>" id="preview" alt="Foto profil">
                <input class="isian" type="file" name="foto" id="foto" accept="image/*">

                <div class="tombol-baris">
                    <button type="button" id="batal" class="tombol tombol-abu" style="display: none;">Batal</button>
                    <button type="button" id="hapusFoto" class="tombol tombol-merah" value="">Hapus Foto</button>
                </div>
                <input type="hidden" name="hapusFoto" id="inputHapus">
            </div>

            <div class="kolom-isian">
                <div class="kolom">
                    <label for="nama">Nama</label>
                    <input class="isian" id="nama" type="text" name="nama" value="<?= $user['nama'] ?? ''; ?>" required>
                </div>
                <div class="kolom">
                    <label for="email_baru">Email</label>
                    <input class="isian" id="email_baru" type="email" name="email_baru" value="<?= $user['email'] ?? ''; ?>" required>
                </div>
                <div class="kolom">
                    <label for="no_hp">No. HP</label>
                    <input class="isian" id="no_hp" type="text" name="no_hp" value="<?= $user['no_hp'] ?? ''; ?>" required>
                </div>
                <div class="kolom">
                    <label for="password">Password</label>
                    <input class="isian" id="password" type="password" name="password" value="<?= $user['password'] ?? ''; ?>" required>
                </div>
            </div>

            <input type="hidden" value="<?= $user['email'] ?? ''; ?>" name="email_lama">
            <div class="aksi-simpan">
                <button type="submit" name="simpanProfil" class="tombol tombol-penuh">Simpan Perubahan</button>
                <p class="teks-bawah"><a href="profil.php" class="beranda">Kembali</a></p>
            </div>
        </form>
    </div>

<script>
    const fotoPreview = <?= json_encode($fotoPreview) ?>;
    const inputFoto = document.getElementById("foto");
    const preview = document.getElementById("preview");
    const batal = document.getElementById("batal");
    const hapusFoto = document.getElementById("hapusFoto");
    const inputHapus = document.getElementById("inputHapus");

    inputFoto.addEventListener("change", function() {
        const file = this.files[0];

        if (file) {
            preview.src = URL.createObjectURL(file);
            batal.style.display = "block"
        }
    });

    batal.addEventListener("click", function() {
        inputFoto.value = "";
        inputHapus.value = "";
        preview.src = fotoPreview;
        batal.style.display = "none";
    });

    hapusFoto.addEventListener("click", function() {
        inputFoto.value = "";
        inputHapus.value = "hapus";
        preview.src = "gambar/foto_profil/default.png";
        batal.style.display = "none";
    });
    </script>
</body>
</html>
