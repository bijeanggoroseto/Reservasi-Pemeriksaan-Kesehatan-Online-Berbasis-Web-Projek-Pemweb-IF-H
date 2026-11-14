<?php
session_start();
include("connect.php");

if (!isset($_SESSION["pengguna_id"])) {
    header("Location: login.php");
    die();
}
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
        lokasi.alamat As alamat_lokasi,
        layanan.nama As nama_layanan,
        layanan_lokasi.harga
        FROM reservasi
        JOIN layanan_lokasi ON reservasi.layanan_lokasi_id = layanan_lokasi.id
        JOIN lokasi ON layanan_lokasi.lokasi_id = lokasi.id
        JOIN layanan ON layanan_lokasi.layanan_id = layanan.id
        WHERE reservasi.pengguna_id = '$penggunaId'
        ORDER BY reservasi.id DESC
    ") or die(mysqli_error($connect));
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservasi</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include("header.php"); ?>
    <h2>Reservasi Saya</h2>

    <?php if (mysqli_num_rows($queryReservasi) > 0): ?>
        <table border="1">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pasien</th>
                    <th>Klinik/RS</th>
                    <th>Layanan</th>
                    <th>Jadwal</th>
                    <th>Harga</th>
                    <th>Status Pembayaran</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php while ($row = mysqli_fetch_array($queryReservasi)): ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $row["nama_pasien"]; ?></td>
                        <td><?= $row["nama_lokasi"]; ?>
                            <?= $row["alamat_lokasi"]; ?>
                        </td>
                        <td>
                            <?= $row["nama_layanan"]; ?>
                        </td>
                        <td><?= $row["jadwal"]; ?></td>
                        <td>Rp <?= number_format($row["harga"], 0, ",", "."); ?></td>
                        <td><?= $row["status_pembayaran"] == 1 ? "Lunas" : "Belum Dibayar"; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Belum ada reservasi yang dibuat!</p>
    <?php endif; ?>
    <p><a href="index.php" class="beranda">Kembali ke Beranda</a></p>
</body>

</html>