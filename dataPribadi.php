<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <style>
        #kotakInput {
            margin-top: 50px;
            width: 600px;
            height: 350px;
            border-radius: 5px;
            border: 1px solid gray;
            justify-self: center;
        }

        h2 {
            height: 20px;
            justify-self: center;
            font-size: 30px;
        }

        input {
            margin: 20px 0px 20px 20px;
            width: 100px;
            height: 20px;
        }

        label {
            margin: 20px 0px 20px 20px;
            font-size: 20px;
        }
    </style>
</head>
<body>
    <?php include("header.php") ?>

    <div id="kotakInput">
        <h2>Isi Data Pribadi</h2>
        <form action="pembayaran.php">
            <div>
                <label for="nama">nama lengkap:</label>
                <input id="nama" type="text" placeholder="nama lengkap">
            </div>
            <div>
                <label for="tanggalLahir">tanggal lahir:</label>
                <input id="tanggalLahir" type="date">
            </div>
            <div>
                <label for="jenisKelamin">jenis kelamin:</label><br>
                <label>Laki-laki</label>
                <input id="jenisKelamin" name="jenisKelamin" type="radio" value="Male">
                <label>Perempuan</label>
                <input id="jenisKelamin" name="jenisKelamin" type="radio" value="Female">
            </div>
            <input type="submit">
        </form>
    </div>
</body>
</html>