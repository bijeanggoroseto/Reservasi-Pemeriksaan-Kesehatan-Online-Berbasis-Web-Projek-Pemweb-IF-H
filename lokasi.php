<?php
include("tambahan/auth.php");
include("tambahan/connect.php");
if(!isset($_GET['lokasiId'])){
    header("location: index.php");
    die();
}
$lokasiId = $_GET['lokasiId'];

$dataLokasi = $connect->query("SELECT * FROM lokasi WHERE id = $lokasiId")->fetch_object();

$query = $connect->query("SELECT layanan_lokasi.*, layanan.nama FROM layanan_lokasi JOIN layanan ON layanan_lokasi.layanan_id = layanan.id WHERE layanan_lokasi.lokasi_id = $lokasiId;");
$dataLayananLokasi = [];
$dataJadwalRutin = [];
$dataReservasi = [];

while ($data = $query->fetch_object()) {
    $dataLayananLokasi[] = $data;
}

$query = $connect->query("SELECT layanan_lokasi_id, hari, jam_mulai, jam_selesai FROM jadwal_rutin WHERE layanan_lokasi_id IN (SELECT id FROM layanan_lokasi WHERE lokasi_id = $lokasiId)");
while ($data = $query->fetch_object()) { 
$dataJadwalRutin[] = $data;
}
        
$query = $connect->query("SELECT layanan_lokasi_id, jadwal, jam_mulai FROM reservasi WHERE layanan_lokasi_id IN (SELECT id FROM layanan_lokasi WHERE lokasi_id = $lokasiId)");
while ($data = $query->fetch_object()) {
    $dataReservasi[] = $data;
}
        
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Lokasi</title>
        <link rel="stylesheet" href="style.css">
    <style>
        main {
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
        }

        #container {
            display: flex;
            gap: 24px;
            margin: 0px 0px 20px 0px;
            padding: 20px;
            background-color: var(--surface);
            border: 2px solid var(--border);
            border-radius: 20px;
        }

        #gambarLokasi {
            flex-shrink: 0;
            width: 260px;
            height: 260px;
            object-fit: cover;
            border: 3px solid var(--border);
            border-radius: 16px;
        }

        #container-2 {
            display: block;
            margin: 0px;
        }

        #nama-lokasi {
            margin: 0px 0px 6px 0px;
            font-size: 32px;
            font-family: 'Poppins', sans-serif;
            color: var(--primary-dark);
        }

        #alamat {
            margin: 0px 0px 10px 0px;
            font-size: 17px;
            font-family: 'Poppins', sans-serif;
            color: var(--secondary-dark);
            font-weight: bold;
        }

        #teks-detail {
            margin: 0px;
            font-size: 15px;
            font-family: 'Inter', sans-serif;
            color: var(--text);
        }

        #input-layanan-dan-jadwal {
            display: grid;
            gap: 6px;
            padding: 20px 25px;
            background-color: white;
            border: 2px solid var(--border);
            border-radius: 20px;
        }

        label {
            font-size: 18px;
            font-family: 'Poppins', sans-serif;
            color: var(--primary-dark);
            font-weight: bold;
        }

        select,
        #open-kalender {
            width: 100%;
            max-width: 340px;
            box-sizing: border-box;
            margin: 4px 0px 10px 0px;
            padding: 10px;
            border: 1px solid var(--border);
            border-radius: 8px;
            background-color: white;
            color: var(--text);
            font: inherit;
            text-align: left;
            cursor: pointer;
        }

        #open-kalender:hover,
        select:hover {
            background-color: var(--primary-light);
        }

        #durasi-harga p {
            display: inline-block;
            margin: 0px 8px 10px 0px;
            padding: 4px 12px;
            background-color: var(--primary-light);
            border: 1px solid var(--primary);
            border-radius: 20px;
            color: var(--primary-dark);
        }

        #displayTanggalTerpilih {
            margin: 4px 0px 10px 0px;
            padding: 10px 14px;
            background-color: var(--primary-light);
            border-left: 4px solid var(--primary);
            border-radius: 8px;
            color: var(--primary-dark);
            font-weight: bold;
        }

        #submit {
            width: 100%;
            max-width: 340px;
            padding: 10px 16px;
            border: none;
            border-radius: 8px;
            background-color: var(--primary);
            color: white;
            font: inherit;
            cursor: pointer;
        }

        #submit:hover {
            background-color: var(--primary-dark);
        }

        #kalenderDialog {
            width: fit-content;
            max-width: 94vw;
            padding: 0;
            border: none;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }

        #kalenderDialog::backdrop {
            background: rgba(0, 0, 0, 0.5);
        }

        .dlg-isi {
            display: flex;
        }

        .kalenderKonten {
            flex: none;
            width: 380px;
            padding: 20px;
            box-sizing: border-box;
        }

        .kalenderHeader {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 12px;
        }

        .kalenderHeader h2 {
            margin: 0;
            font-size: 22px;
            font-family: 'Poppins', sans-serif;
            color: var(--primary-dark);
        }

        .kalenderHeader button,
        .kalenderNav button {
            padding: 6px 12px;
            border: 1px solid var(--border);
            border-radius: 8px;
            background-color: var(--primary-light);
            color: var(--primary-dark);
            font: inherit;
            cursor: pointer;
        }

        .kalenderHeader button:hover,
        .kalenderNav button:hover {
            background-color: var(--primary);
            color: white;
        }

        .kalenderNav {
            display: flex;
            gap: 6px;
            margin-bottom: 14px;
        }

        .nama-hari,
        #dayColl > div {
            display: flex;
            gap: 4px;
            margin-bottom: 4px;
        }

        .nama-hari span {
            flex: 1;
            text-align: center;
            font-size: 13px;
            font-weight: bold;
            color: var(--secondary-dark);
        }

        .available-day,
        .unavailable-day,
        .off-day,
        .penuh {
            flex: 1;
            min-width: 0;
            aspect-ratio: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            border: 1px solid transparent;
            border-radius: 10px;
            font: inherit;
        }

        .available-day {
            background-color: var(--primary-light);
            border-color: var(--primary);
            color: var(--primary-dark);
            font-weight: bold;
            cursor: pointer;
        }

        .available-day:hover {
            background-color: var(--secondary-light);
        }

        .penuh {
            background-color: #dcdcdc;
            color: #666666;
            text-decoration: line-through;
            cursor: pointer;
        }

        .off-day {
            background-color: #fdecea;
            color: #b3261e;
        }

        .unavailable-day {
            background-color: transparent;
            color: #b5b5b5;
        }

        #dayColl button.dipilih {
            background-color: var(--primary);
            border-color: var(--primary-dark);
            color: white;
        }

        .legenda {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
            margin: 12px 0px 16px 0px;
            font-size: 13px;
        }

        .legenda span::before {
            content: "";
            display: inline-block;
            width: 12px;
            height: 12px;
            margin-right: 6px;
            border-radius: 4px;
            vertical-align: -1px;
        }

        .legenda .l-tersedia::before { background-color: var(--primary-light); border: 1px solid var(--primary); }
        .legenda .l-penuh::before { background-color: #dcdcdc; }
        .legenda .l-libur::before { background-color: #fdecea; border: 1px solid #b3261e; }

        #pilihTanggal {
            padding: 10px 16px;
            border: none;
            border-radius: 8px;
            background-color: var(--primary);
            color: white;
            font: inherit;
            cursor: pointer;
        }

        #pilihTanggal:hover {
            background-color: var(--primary-dark);
        }

        .jadwal {
            flex: none;
            width: 300px;
            padding: 20px;
            box-sizing: border-box;
            background-color: var(--primary-dark);
            color: white;
        }

        #greenBoxTanggal {
            min-height: 28px;
            margin: 0px 0px 14px 0px;
            font-size: 20px;
            font-family: 'Poppins', sans-serif;
        }

        #daftarSlot {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            grid-auto-rows: 44px;
            align-content: start;
            gap: 8px;
            max-height: 320px;
            overflow-y: auto;
        }

        .slot {
            box-sizing: border-box;
            width: 100%;
            height: 100%;
            padding: 0px 6px;
            white-space: nowrap;
            border: 1px solid white;
            border-radius: 8px;
            background-color: white;
            color: var(--primary-dark);
            font: inherit;
            cursor: pointer;
        }

        .slot:hover {
            background-color: var(--secondary-light);
        }

        .slotPenuh,
        .slotPenuh:hover {
            background-color: transparent;
            border-color: var(--secondary-dark);
            color: #7fb08a;
            text-decoration: line-through;
            cursor: not-allowed;
        }

        .slotDipilih,
        .slotDipilih:hover {
            background-color: #ffd54a;
            border-color: #ffd54a;
            color: black;
        }

        @media (max-width: 700px) {
            #container,
            .dlg-isi {
                flex-direction: column;
            }

            #gambarLokasi {
                width: 100%;
                height: 220px;
            }

            #kalenderDialog {
                width: 94vw;
            }

            .kalenderKonten,
            .jadwal {
                width: auto;
            }
        }
    </style>
</head>
<body>
    <?php include("tambahan/header.php"); ?>

    <main>

    <div id="container">
        <img id="gambarLokasi" src="<?php echo $dataLokasi->gambar ?>">
        <div id="container-2">
            <h2 id="nama-lokasi"><?php echo $dataLokasi->nama ?></h2>
            <p id="alamat">Alamat: <?php echo $dataLokasi->alamat ?></p>
            <p id="teks-detail"><?php echo $dataLokasi->deskripsi ?></p>
        </div>
    </div>

    <form id="input-layanan-dan-jadwal" action="dataPribadi.php" method="POST">
        <div style="display: grid;">
            <label for="jenisLayanan">Pilih Jenis Pemeriksaan</label>
            <select id="jenisLayanan" name="jenisLayanan" required>
                <option value="" disabled selected>Pilih</option>
                <?php $i = 0; while($dataLayananLokasi[$i]){ ?>
                <option value="<?= $i ?>"><?= $dataLayananLokasi[$i]->nama ?></option>
                <?php $i++; } ?>
            </select>
        </div>
        <div id="durasi-harga">
            <p id="durasi" style="display: none">Durasi: </p>
            <p id="harga" style="display: none;">Harga: </p>
        </div>

        <label for="open-kalender">Pilih Jadwal</label>
        <button type="button" id="open-kalender">Pilih</button>

        <dialog id="kalenderDialog">
            <div class="dlg-isi">
                <div class="kalenderKonten">
                    <div class="kalenderHeader">
                        <h2><span id="month"></span> <span id="year"></span></h2>
                        <button type="button" id="close-kalender">✕</button>
                    </div>

                    <div class="kalenderNav">
                        <button type="button" id="prev">‹</button>
                        <button type="button" id="today">Hari ini</button>
                        <button type="button" id="next">›</button>
                    </div>

                    <div class="nama-hari">
                        <span>Sen</span><span>Sel</span><span>Rab</span><span>Kam</span><span>Jum</span><span>Sab</span><span>Min</span>
                    </div>
                    <div id="dayColl" style="display: grid;"></div>

                    <div class="legenda">
                        <span class="l-tersedia">Tersedia</span>
                        <span class="l-penuh">Penuh</span>
                        <span class="l-libur">Tidak ada jadwal</span>
                    </div>
                    <button type="button" id="pilihTanggal">Pilih tanggal</button>
                </div>
                <div class="jadwal" id="panelJadwal" style="display: none;">
                    <h1 id="greenBoxTanggal"></h1>
                    <div id="daftarSlot"></div>
                </div>
            </div>
        </dialog>

        <input type="hidden" name="jamMulai" id="inputJamMulai">
        <input type="hidden" name="jamSelesai" id="inputJamSelesai">

        <input id="inputJadwal" type="hidden" name="jadwal">
        <p id="displayTanggalTerpilih" style="display: none;">Jadwal</p>

        <input type="hidden" name="layananLokasiId" id="layananLokasiId">

        <input id="submit" type="submit" name="lokasiLayanan" value="Kirim" style="display: none;">
    </form>

    </main>

    <script>
        const BULAN=["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
        const HARI=["Senin","Selasa","Rabu","Kamis","Jumat","Sabtu","Minggu"];

        const today = new Date();
        const kalenderDialog = document.getElementById("kalenderDialog");
        const prev = document.getElementById("prev");
        const next = document.getElementById("next");
        const keToday = document.getElementById("today")
        const greenBoxTanggal = document.getElementById("greenBoxTanggal");
        const panelJadwal = document.getElementById("panelJadwal");
        let currentYear = today.getFullYear();
        let currentMonth = today.getMonth();
        
        const dataLayananLokasi = <?= json_encode($dataLayananLokasi) ?>;
        const dataJadwalRutin = <?= json_encode($dataJadwalRutin) ?>;
        const dataReservasi = <?= json_encode($dataReservasi) ?>;
        
        const jenisLayanan = document.getElementById("jenisLayanan");
        const durasi = document.getElementById("durasi");
        const harga = document.getElementById("harga");
        const layananLokasiId = document.getElementById("layananLokasiId");
        const inputJadwal = document.getElementById("inputJadwal");
        let displayTanggalTerpilih = document.getElementById("displayTanggalTerpilih");
        
        const daftarSlot = document.getElementById("daftarSlot");
        const inputJamMulai = document.getElementById("inputJamMulai");
        const inputJamSelesai = document.getElementById("inputJamSelesai");
        let submit = document.getElementById("submit");

        let tanggalTerpilih;
        let jamMulaiTerpilih;
        let jamSelesaiTerpilih;

        function renderKalender(year, month){
            document.getElementById("year").textContent = year
            document.getElementById("month").textContent = BULAN[month];

            if(month == today.getMonth() && year == today.getFullYear()){
                prev.style.visibility = "hidden";
            }
            else{
                prev.style.visibility = "visible";
            }
            
            const renderingDate = new Date(year, month, 1);
            
            while(renderingDate.getDay() != 1){
                renderingDate.setDate(renderingDate.getDate() - 1);
            }

            const dayColl = document.getElementById("dayColl");
            dayColl.innerHTML = "";
            
            for(let i = 0; i < 6; i++){
                const dayRow = document.createElement("div")
                dayRow.style.display = "flex";
                for(let j = 0; j < 7; j++){
                    const dayBox = document.createElement("button");
                    dayBox.type = "button";
                    if(renderingDate.getMonth() == month && renderingDate >= today){
                        if(!cariJadwal(renderingDate)){
                            dayBox.className = "off-day";
                        }
                        else{
                            if(cekPenuh(renderingDate)){
                                dayBox.className = "penuh";
                            }
                            else{
                                dayBox.className = "available-day";
                            }
                            dayBox.dataset.year = renderingDate.getFullYear();
                            dayBox.dataset.month = renderingDate.getMonth();
                            dayBox.dataset.date = renderingDate.getDate();
                            if(formatTanggal(renderingDate) == tanggalTerpilih){ dayBox.classList.add("dipilih"); }
                            dayBox.addEventListener("click", function(){pilihTanggal(dayBox.dataset.year, dayBox.dataset.month, dayBox.dataset.date)})
                        }
                    }
                    else{
                        dayBox.className = "unavailable-day";
                    }
                    dayBox.textContent = renderingDate.getDate();
        
                    dayRow.appendChild(dayBox);
    
                    renderingDate.setDate(renderingDate.getDate() + 1);
                }
                dayColl.appendChild(dayRow);
            }
        }

        function formatTanggal(d) {
            const mm = String(d.getMonth() + 1).padStart(2, "0");
            const dd = String(d.getDate()).padStart(2, "0");
            return `${d.getFullYear()}-${mm}-${dd}`;
        }

        function ubahJam(menit) {
            return String(Math.floor(menit / 60)).padStart(2, "0") + ":" + String(menit % 60).padStart(2, "0");
        }

        function ubahMenit(jam) {
            const [h, m] = jam.split(":");
            return h * 60 + Number(m);
        }

        function buatSlot(date) {
            const layanan = dataLayananLokasi[parseInt(jenisLayanan.value)];
            const jadwal = cariJadwal(date);
            const durasiMenit = Number(layanan.durasi_menit);
            const slots = [];
        
            for (let t = ubahMenit(jadwal.jam_mulai); t + durasiMenit <= ubahMenit(jadwal.jam_selesai); t += durasiMenit) {
                slots.push(t);
            }
            return slots;
        }

        // membuat seperti array yang berisi semua slot jam pelayanan yang sudah terpakai.
        function slotTerpakai(date) {
            const layanan = dataLayananLokasi[parseInt(jenisLayanan.value)];
            const terpakai = new Set();
        
            dataReservasi.forEach(r => {
                if (r.layanan_lokasi_id == layanan.id && r.jadwal == formatTanggal(date)) {
                    terpakai.add(r.jam_mulai.slice(0, 5));
                }
            });
            return terpakai;
        }

        // mencari jadwal dari layanan_lokasi di tanggal tersebut untuk tahu jam buka dan tutupnya.
        function cariJadwal(date){          
            const layanan = dataLayananLokasi[parseInt(jenisLayanan.value)];
            if (!layanan) return undefined;                       
            const hari = date.getDay();
            return dataJadwalRutin.find(j => j.layanan_lokasi_id == layanan.id && j.hari == hari);
        }

        function cekPenuh(date){
            return slotTerpakai(date).size >= buatSlot(date).length;
        }

        function tampilkanSlot(date) {
            const layanan = dataLayananLokasi[parseInt(jenisLayanan.value)];
            const durasiMenit = Number(layanan.durasi_menit);
            const terpakai = slotTerpakai(date); // raangkum semua slot terpakai
        
            daftarSlot.innerHTML = "";
        
            buatSlot(date).forEach(t => {
                const jamMulai = ubahJam(t);
                const jamSelesai = ubahJam(t + durasiMenit);
        
                const slotJadwal = document.createElement("button");
                slotJadwal.type = "button";
                slotJadwal.textContent = jamMulai + " - " + jamSelesai;
        
                if (terpakai.has(jamMulai)) {
                    slotJadwal.className = "slot slotPenuh";
                    slotJadwal.disabled = true;
                } else {
                    slotJadwal.className = "slot";
                    slotJadwal.addEventListener("click", function () {
                        pilihSlot(jamMulai, jamSelesai, slotJadwal);
                    });
                }
                daftarSlot.appendChild(slotJadwal);
            });
        }

        function pilihSlot(jamMulai, jamSelesai, slotJadwal) {
            jamMulaiTerpilih = jamMulai;
            jamSelesaiTerpilih = jamSelesai;
        
            daftarSlot.querySelectorAll(".slotDipilih").forEach(el => el.classList.remove("slotDipilih"));
            slotJadwal.classList.add("slotDipilih");
        }

        function pilihTanggal(year, month, date){
            const greenBoxDate = new Date(year, month, date);
            tanggalTerpilih = formatTanggal(greenBoxDate);
            greenBoxTanggal.textContent = tanggalTerpilih;
        
            jamMulaiTerpilih = undefined;      
            jamSelesaiTerpilih = undefined;
            tampilkanSlot(greenBoxDate);
            panelJadwal.style.display = "block";
            renderKalender(currentYear, currentMonth);
        }
 
        prev.onclick = () => {
            currentMonth--;
            if(currentMonth < 0){currentMonth = 11; currentYear--;}
            renderKalender(currentYear, currentMonth);
        };
        
        next.onclick = () => {
            currentMonth++;
            if (currentMonth > 11) { currentMonth = 0; currentYear++; }
            renderKalender(currentYear, currentMonth);
        };

        keToday.onclick = () => {
            currentYear = today.getFullYear();
            currentMonth = today.getMonth();
            renderKalender(currentYear, currentMonth);
        };

        document.getElementById("open-kalender").onclick = () => {
            if(!jenisLayanan.value){ alert("Pilih jenis pemeriksaan dulu"); return; }
            currentYear = today.getFullYear();
            currentMonth = today.getMonth();
            renderKalender(currentYear, currentMonth);
            kalenderDialog.showModal();
        };

        document.getElementById("close-kalender").onclick = () => {
            kalenderDialog.close();
        }
        
        document.getElementById("pilihTanggal").onclick = () => {
            if (!tanggalTerpilih || !jamMulaiTerpilih) {
                alert("Pilih tanggal dan jam terlebih dahulu");
                return;
            }
            inputJadwal.value = tanggalTerpilih;
            inputJamMulai.value = jamMulaiTerpilih;
            inputJamSelesai.value = jamSelesaiTerpilih;
            displayTanggalTerpilih.style.display = "block";
            displayTanggalTerpilih.textContent = tanggalTerpilih + ", " + jamMulaiTerpilih + " - " + jamSelesaiTerpilih;
            submit.style.display = "block";
            kalenderDialog.close();
        };

        jenisLayanan.addEventListener("change", function() {
            inputJadwal.value = "";
            inputJamMulai.value = "";
            inputJamSelesai.value = "";
            tanggalTerpilih = undefined;
            jamMulaiTerpilih = undefined;
            jamSelesaiTerpilih = undefined;
            displayTanggalTerpilih.textContent = "Jadwal";
            daftarSlot.innerHTML = "";
            greenBoxTanggal.textContent = "";
            panelJadwal.style.display = "none";
            let layananId = parseInt(jenisLayanan.value);
            durasi.style.display = "block";
            durasi.textContent = "Durasi: " + dataLayananLokasi[layananId].durasi_menit + "menit";
            harga.style.display = "block";
            harga.textContent = "Harga: " + dataLayananLokasi[layananId].harga;
            layananLokasiId.value = dataLayananLokasi[layananId].id;
        });
    </script>
</body>
</html>