<?php
include("tambahan/auth.php");
include("tambahan/connect.php");
$penggunaId = $_SESSION["pengguna_id"];

if(isset($_GET["batalReservasi"])){
    $hapus_id = $_GET["reservasiId"];
    $queryHapus = mysqli_query($connect, "DELETE FROM reservasi WHERE reservasi.id = $hapus_id");
}

$queryReservasi = mysqli_query($connect, "SELECT
        reservasi.id,
        reservasi.nama AS nama_pasien,
        reservasi.tanggal_lahir,
        reservasi.jenis_kelamin,
        reservasi.jadwal,
        reservasi.jam_mulai,
        reservasi.jam_selesai,
        reservasi.status_pembayaran,
        lokasi.nama AS nama_lokasi,
        layanan.nama AS nama_layanan,
        layanan_lokasi.harga,
        pembayaran.metode,
        pembayaran.dibayar_pada
        FROM reservasi
        JOIN layanan_lokasi ON reservasi.layanan_lokasi_id = layanan_lokasi.id
        JOIN lokasi ON layanan_lokasi.lokasi_id = lokasi.id
        JOIN layanan ON layanan_lokasi.layanan_id = layanan.id
        LEFT JOIN pembayaran ON pembayaran.reservasi_id = reservasi.id
        WHERE reservasi.pengguna_id = $penggunaId
        AND TIMESTAMP(DATE(reservasi.jadwal), reservasi.jam_selesai) >= NOW()
        ORDER BY reservasi.id DESC
    ") or die(mysqli_error($connect));
?>


<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservasi Saya</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include("tambahan/header.php") ?>

    <h2 class="judul-halaman">Reservasi Saya</h2>

    <?php if (mysqli_num_rows($queryReservasi) > 0): ?>
        <div id="semuaReservasi">
            <?php while ($data = mysqli_fetch_array($queryReservasi)) { 
                if($data["jadwal"] >= date("Y-m-d")) { ?>
            <div class="detailReservasi">
                <p class="baris-data"><b>Nama</b> <span><?= $data["nama_pasien"]; ?></span></p>
                <p class="baris-data"><b>Lokasi</b> <span><?= $data["nama_lokasi"]; ?></span></p>
                <p class="baris-data"><b>Layanan</b> <span><?= $data["nama_layanan"]; ?></span></p>
                <p class="baris-data"><b>Jadwal</b> <span><?= date("d-m-Y", strtotime($data["jadwal"])); ?></span></p>
                <p class="baris-data"><b>Jam</b> <span><?= substr($data["jam_mulai"], 0, 5); ?> - <?= substr($data["jam_selesai"], 0, 5); ?></span></p>
                <p class="baris-data"><b>Harga</b> <span>Rp <?= number_format($data["harga"], 0, ",", "."); ?></span></p>
                <p class="baris-data">
                    <b>Status</b>
                    <span class="status <?= $data["status_pembayaran"] == 1 ? "lunas" : "belum"; ?>">
                        <?= $data["status_pembayaran"] == 1 ? "Lunas" : "Belum Dibayar"; ?>
                    </span>
                </p>

                <?php if(!$data["status_pembayaran"]){ ?>
                <div class="tombol-baris">
                    <form action="pembayaran.php" method="GET">
                        <input type="hidden" value="<?=  $data["id"] ?>" name="reservasiId">
                        <input type="submit" name="bayarReservasi" value="Bayar" class="tombol">
                    </form>
                    <form method="GET">
                        <input type="hidden" value="<?=  $data["id"] ?>" name="reservasiId">
                        <input type="submit" name="batalReservasi" value="Batal" class="tombol tombol-merah">
                    </form>
                </div>
                <?php } else { ?>
                <p class="baris-data"><b>Metode</b> <span><?= $data["metode"] ?? "-"; ?></span></p>
                <p class="baris-data"><b>Dibayar</b> <span><?= $data["dibayar_pada"] ?? "-"; ?></span></p>
                <?php }?>
            </div>
            <?php }} ?>
        </div>
    <?php else: ?>
        <p class="kosong">Belum ada reservasi yang dibuat!</p>
    <?php endif; ?>

    <div class="aksi-halaman">
        <a href="profil.php" class="beranda">Kembali</a>
    </div>
</body>

</html>
