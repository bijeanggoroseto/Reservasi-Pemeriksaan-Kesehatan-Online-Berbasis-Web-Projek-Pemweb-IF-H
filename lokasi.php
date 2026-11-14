<?php
    include("header.php");

    if(!isset($_GET['lokasiId'])){
        header("location: index.php");
        die();
    }

    $lokasiId = $_GET['id'];
    
    $dataLokasi = $connect->query("SELECT * FROM lokasi WHERE id = $lokasiId")->fetch_object();

    $query = $connect->query("SELECT layanan_lokasi.*, layanan.nama FROM layanan_lokasi JOIN layanan ON layanan_lokasi.layanan_id = layanan.id WHERE layanan_lokasi.lokasi_id = $lokasiId;");
    $dataLayananLokasi = [];
    $dataJadwalRutin = [];
    $dataReservasi = [];

    $i = 0;
    while ($data = $query->fetch_object()) {
        $dataLayananLokasi[$i++] = $data;
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
    <title>Dummy Data</title>
    <link rel="stylesheet" href="style.css">
    <style>
        #gambarLokasi {
            width: 300px;
            height: 300px;
        }

        #namaLokasi {
            font-size: 40px;
            margin: 0px;
            align-self: center;
        }

        #inputJadwal {
            margin: 20px 0px;
            padding: 10px;
            width: 200px;
            border-radius: 5px;
            border: 1px solid gray;
        }
        
        #submit {
            width: 100px;
        }

        p {
            font-size: 20px;
        }

        label {
            font-size: 20px;
        }

        select {
            margin: 20px 0px;
            margin: 20px 0px;
            padding: 10px;
            width: 200px;
            border-radius: 5px;
            border: 1px solid gray;
            cursor: pointer;
        }

        .availableDay {
            width: 50px;
            height: 50px;
            border: 1px solid black;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            background-color: rgb(1, 170, 43);
        }

        .unavailableDay {
            width: 50px;
            height: 50px;
            border: 1px solid black;
            display: flex;
            justify-content: center;
            align-items: center;
            color: black;
            background-color: gray;
        }

        .offDay{
            width: 50px;
            height: 50px;
            border: 1px solid black;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            background-color: rgb(148, 0, 0);
        }

        .penuh {
            width: 50px;
            height: 50px;
            border: 1px solid black;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            background-color: rgb(1, 75, 20);
        }

        jadwal {
            padding: 20px;
        }
        
        #daftarSlot {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 8px;
        }
        
        .slot {
            padding: 10px;
            border: 1px solid white;
            border-radius: 6px;
            background-color: white;
            color: rgb(1, 120, 30);
            font: inherit;
            cursor: pointer;
        }
        
        .slotPenuh {
            background-color: rgb(1, 75, 20);
            border-color: rgb(1, 75, 20);
            color: rgb(150, 190, 160);
            cursor: not-allowed;
        }
        
        .slotDipilih {
            background-color: #ffd54a;
            border-color: #ffd54a;
            color: black;
        }
        

        #kalenderDialog {
            border: none;
            border-radius: 12px;
            padding: 0;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
        }

        #kalenderDialog::backdrop {
            background: rgba(0, 0, 0, 0.5);
        }

        .jadwal {
            flex: 1 1 200px;
            min-width: 350px;
            min-height: 80px;
            background-color: rgb(1, 170, 43);
            border-color: rgb(1, 170, 43);
            color: white;
        }

        .kalenderKonten {
            padding: 20px;
            gap: 20px;
            flex-wrap: wrap
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
            font-size: 1.3rem;
        }

        .kalenderNav {
            display: flex;
            gap: 6px;
            margin-bottom: 12px;
        }
    </style>
</head>
<body>
    <div style="display: flex; margin: 20px 0px 20px 20px;">
        <img id="gambarLokasi" src="<?php echo $dataLokasi->gambar ?>">
        <div style="margin-left: 20px;">
            <h2 id="namaLokasi"><?php echo $dataLokasi->nama ?></h2>
            <div class="teksDeskripsi">
                <p><?php echo $dataLokasi->deskripsi ?></p>
            </div>
            <div style="display: flex;">
                <p>Alamat: <?php echo $dataLokasi->alamat ?></p>
            </div>
        </div>
    </div>

    <form id="inputLokasiDanJadwal" action="dataPribadi.php" method="POST" style="display: grid; margin: 20px 20px;">
        <div style="display: flex;">
            <div style="display: grid;">
                <label for="jenisLayanan">Pilih Jenis Pemeriksaan</label>
                <select id="jenisLayanan" name="jenisLayanan" required>
                    <option value="" disabled selected>Pilih</option>
                    <?php $j = 0; while($j < $i){ ?>
                    <option value="<?= $j ?>"><?= $dataLayananLokasi[$j]->nama ?></option>
                    <?php $j++; } ?>
                </select>
            </div>
            <p id="durasi" style="margin-left: 30px;">Durasi: </p>
            <p id="harga" style="margin-left: 30px;">Harga: </p>
        </div>

        <label for="inputJadwal">Pilih Jadwal</label>

        <button type="button" id="openKalender">Pilih tanggal</button>

        <p id="errorTanggal" style="color: red; display: none;">
            Silakan pilih tanggal terlebih dahulu!
        </p>

        <dialog id="kalenderDialog">
            <div style="display: flex;">
                <div class="kalenderKonten">
                    <div class="kalenderHeader">
                        <h2><span id="month"></span> <span id="year"></span></h2>
                        <button type="button" id="closeKalender">✕</button>
                    </div>
        
                    <div class="kalenderNav">
                        <button type="button" id="prev">‹</button>
                        <button type="button" id="today">Hari ini</button>
                        <button type="button" id="next">›</button>
                    </div>
                    <div id="dayColl" style="display: grid;"></div>
                    <button type="button" id="pilihTanggal">Pilih tanggal</button>
                </div>
                <div class="jadwal">
                    <h1 id="greenBoxTanggal"></h1>
                    <div id="daftarSlot"></div>
                </div>
            </div>
        </dialog>

        <input type="hidden" name="jamMulai" id="inputJamMulai">
        <input type="hidden" name="jamSelesai" id="inputJamSelesai">
        
        <input id="inputJadwal" type="hidden" name="jadwal">
        <p id="displayTanggalTerpilih">Jadwal</p>

        <input type="hidden" name="layananLokasiId" id="layananLokasiId">

        <input id="submit" type="submit" name="lokasiLayanan" value="Kirim">
    </form>
    
    <script>
        const BULAN=["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
        const HARI=["Senin","Selasa","Rabu","Kamis","Jumat","Sabtu","Minggu"];

        const today = new Date();
        const kalenderDialog = document.getElementById("kalenderDialog");
        const prev = document.getElementById("prev");
        const next = document.getElementById("next");
        const greenBoxTanggal = document.getElementById("greenBoxTanggal");
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
        const displayTanggalTerpilih = document.getElementById("displayTanggalTerpilih");
        
        const daftarSlot = document.getElementById("daftarSlot");
        const inputJamMulai = document.getElementById("inputJamMulai");
        const inputJamSelesai = document.getElementById("inputJamSelesai");

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
                            dayBox.className = "offDay";
                        }
                        else{
                            if(cekPenuh(renderingDate)){
                                dayBox.className = "penuh";
                            }
                            else{
                                dayBox.className = "availableDay";
                            }
                            dayBox.dataset.year = renderingDate.getFullYear();
                            dayBox.dataset.month = renderingDate.getMonth();
                            dayBox.dataset.date = renderingDate.getDate();
                            dayBox.addEventListener("click", function(){pilihTanggal(dayBox.dataset.year, dayBox.dataset.month, dayBox.dataset.date)})
                        }
                    }
                    else{
                        dayBox.className = "unavailableDay";
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

        document.getElementById("openKalender").onclick = () => {
            if(!jenisLayanan.value){ alert("Pilih jenis pemeriksaan dulu"); return; }
            currentYear = today.getFullYear();
            currentMonth = today.getMonth();
            renderKalender(currentYear, currentMonth);
            kalenderDialog.showModal();
        };

        document.getElementById("closeKalender").onclick = () => {
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
            displayTanggalTerpilih.textContent = tanggalTerpilih + ", " + jamMulaiTerpilih + " - " + jamSelesaiTerpilih;
            kalenderDialog.close();
        };


        document.querySelector("#inputLokasiDanJadwal").addEventListener("submit", function(e) {
            if (!inputJadwal.value) {
                e.preventDefault();
                document.getElementById("errorTanggal").style.display = "block";
            }
        });

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
            let layananId = parseInt(jenisLayanan.value);
            durasi.textContent = "Durasi: " + dataLayananLokasi[layananId].durasi_menit + "menit";
            harga.textContent = "Harga: " + dataLayananLokasi[layananId].harga;
            layananLokasiId.value = dataLayananLokasi[layananId].id;
        });
    </script>
</body>
</html>