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

        #nominal {
            margin-left: 20px;
            font-size: 20px;
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
        <div style="display: flex;">
            <p id="nominal">Nominal pembayaran: <br>100.0000</p>
        </div>
        <form action="index.php">
            <input type="submit">
        </form>
    </div>
</body>
</html>