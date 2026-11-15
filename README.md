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
 
> Folder `tambahan/` berisi file yang di-include oleh hampir semua halaman: `auth.php` (memulai sesi dan memeriksa login), `connect.php` (koneksi database), dan `header.php` (header halaman).
 
## Tabel database
 
Kode memakai tabel dan kolom berikut. Tipe data dan skema lengkap belum disertakan di repositori ini.
 
| Tabel | Kolom yang dipakai |
|---|---|
| `pengguna` | `id`, `nama`, `email`, `no_hp`, `password`, `foto_profil` |
| `lokasi` | `id`, `nama`, `alamat`, `deskripsi`, `gambar` |
| `layanan` | `id`, `nama` |
| `layanan_lokasi` | `id`, `lokasi_id`, `layanan_id`, `harga`, `durasi_menit` |
| `jadwal_rutin` | `layanan_lokasi_id`, `hari`, `jam_mulai`, `jam_selesai` |
| `reservasi` | `id`, `pengguna_id`, `nama`, `tanggal_lahir`, `jenis_kelamin`, `layanan_lokasi_id`, `jadwal`, `jam_mulai`, `jam_selesai`, `status_pembayaran` |
| `pembayaran` | `reservasi_id`, `jumlah`, `metode`, `dibayar_pada` |
 
Keterangan:
- `jadwal_rutin.hari` memakai angka hari seperti `Date.getDay()` di JavaScript (0 = Minggu, 1 = Senin, dan seterusnya).
- `reservasi.status_pembayaran` bernilai `0` (belum dibayar) atau `1` (lunas).
- `layanan_lokasi` menghubungkan satu layanan dengan satu lokasi, lengkap dengan harga dan durasinya.
## Cara menjalankan
 
1. Pasang XAMPP, Laragon, atau paket lain yang menyediakan Apache, PHP, dan MySQL.
2. Salin proyek ke folder web server, misalnya `htdocs/`.
3. Buat database di MySQL, lalu buat tabel sesuai bagian **Tabel database** dan isi data awal untuk `lokasi`, `layanan`, `layanan_lokasi`, dan `jadwal_rutin`.
4. Sesuaikan koneksi database di `tambahan/connect.php`.
5. Pastikan folder `gambar/foto_profil/` ada, berisi `default.png`, dan bisa ditulis oleh web server.
6. Jalankan Apache dan MySQL, lalu buka `http://localhost/<nama-folder>/register.php`.
## Catatan pengembangan
 
Proyek ini dibuat untuk keperluan perkuliahan. Sebelum dipakai di lingkungan nyata, beberapa hal perlu dibenahi:
 
- Password disimpan dan dibandingkan sebagai teks biasa. Gunakan `password_hash()` dan `password_verify()`.
- Query SQL masih menyisipkan input langsung ke dalam string. Gunakan prepared statement (`mysqli_prepare`) untuk mencegah SQL injection.
- Pembatalan reservasi sebaiknya memeriksa pemilik reservasi dan status pembayarannya.
- Pembayaran saat ini hanya mencatat pilihan metode (QRIS atau tunai) dan belum terhubung ke payment gateway.
## Tim
 
Isi dengan nama dan NIM anggota kelompok.
 
| Nama | NIM | Peran |
|---|---|---|
| | | |
 
