<?php
include("tambahan/auth.php");
include("tambahan/connect.php");
$penggunaId = $_SESSION["pengguna_id"];

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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>reservasi</title>
    <link rel="stylesheet" href="style.css">
</head>
<style>
    #semuaReservasi {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }
</style>

<body>
    <?php include("tambahan/header.php") ?>
    <h2>Reservasi Saya</h2>

    <?php if (mysqli_num_rows($queryReservasi) > 0): ?>
        <div id="semuaReservasi">
            <?php while ($data = mysqli_fetch_array($queryReservasi)): ?>
            <div class="detailReservasi">
                <p>Nama: <?= $data["nama_pasien"]; ?></p>
                <p>Lokasi: <?= $data["nama_lokasi"]; ?></p>
                <p>Layanan: <?= $data["nama_layanan"]; ?></p>
                <p>Jadwal: <?= $data["jadwal"]; ?></p>
                <p>Harga: Rp <?= number_format($data["harga"], 0, ",", "."); ?></p>
                <p>Status pembayaran: <?= $data["status_pembayaran"] == 1 ? "Lunas" : "Belum Dibayar"; ?></p>
                <?php if(!$data["status_pembayaran"]){ ?>
                <form action="pembayaran.php" method="GET">
                    <input type="hidden" value="<?=  $data["id"] ?>" name="reservasiId">
                    <input type="submit" name="bayarReservasi" value="Bayar">
                </form>
                <?php } else { ?>
                <p>Metode: <?= $data["metode"]; ?></p>
                <p>Waktu di bayar: <?= $data["dibayar_pada"]; ?></p>
                <?php }?>
            </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <p>Belum ada reservasi yang dibuat!</p>
    <?php endif; ?>
    <p><a href="profil.php" class="beranda">Kembali</a></p>
</body>

</html>