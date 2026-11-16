# Reservasi-Pemeriksaan-Kesehatan-Online-Berbasis-Web-Projek-Pemweb-IF-H
 
Proyek mata kuliah Pemrograman Web, kelas IF-H.
 
Aplikasi web untuk memesan jadwal pemeriksaan kesehatan secara online. Pengguna memilih lokasi dan jenis pemeriksaan, memilih tanggal dan jam yang masih kosong lewat kalender, mengisi data pasien, lalu membayar. Semua reservasi dapat dilihat dan dikelola dari halaman profil.
 
## Fitur
 
**Akun**
- Daftar, masuk, dan keluar.
- Profil pengguna dengan foto.
- Edit profil (nama, email, no. HP, password, foto profil) dengan pratinjau foto dan tombol hapus foto.
- Hapus akun beserta data reservasi dan pembayarannya.
**Reservasi**
- Daftar lokasi pelayanan, dengan filter berdasarkan kategori layanan.
- Halaman detail lokasi: gambar, alamat, deskripsi, dan pilihan jenis pemeriksaan lengkap dengan durasi dan harga.
- Kalender jadwal. Tanggal ditandai tersedia, penuh, atau tidak ada jadwal. Daftar jam muncul setelah tanggal dipilih, dan slot yang sudah terisi tidak bisa dipilih.
- Jadwal dibuat otomatis dari jadwal rutin tiap layanan (hari dan jam buka) dibagi sesuai durasi layanan.
- Form data pasien (nama, tanggal lahir, jenis kelamin).
**Pembayaran dan riwayat**
- Konfirmasi pembayaran dengan metode QRIS atau tunai.
- Halaman "Reservasi Saya" menampilkan reservasi yang akan datang beserta status Lunas atau Belum Dibayar.
- Reservasi yang belum dibayar bisa dibatalkan.
## Teknologi
 
- PHP native dengan ekstensi `mysqli`
- MySQL / MariaDB
- HTML, CSS, dan JavaScript (tanpa framework)
## Alur penggunaan
 
```
register / login
      ↓
index.php        pilih lokasi (bisa difilter per layanan)
      ↓
lokasi.php       pilih jenis pemeriksaan → pilih tanggal dan jam di kalender
      ↓
dataPribadi.php  isi data pasien
      ↓
buatReservasi.php  simpan reservasi
      ↓
pembayaran.php   pilih metode dan bayar
      ↓
reservasi.php    lihat status reservasi
```
 
## Struktur folder
 
```
.
├── index.php            Daftar lokasi + filter layanan
├── lokasi.php           Detail lokasi, pilih layanan dan jadwal (kalender)
├── dataPribadi.php      Form data pasien
├── buatReservasi.php    Menyimpan reservasi ke database
├── pembayaran.php       Konfirmasi dan pencatatan pembayaran
├── reservasi.php        Daftar reservasi pengguna
├── profil.php           Profil, logout, hapus akun
├── editProfil.php       Edit profil dan foto
├── login.php
├── register.php
├── logout.php
├── style.css            Gaya bersama seluruh halaman
├── tambahan/            auth.php, connect.php, header.php
└── gambar/
    └── foto_profil/     Foto profil pengguna (termasuk default.png)
```
