<?php
session_start();
include("connect.php");

if (isset($_POST["login"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $query = mysqli_query($connect, "SELECT * FROM pengguna WHERE email = '$email' AND password = '$password' ") or die (mysqli_error($connect));
    
    if (mysqli_num_rows($query) > 0) {
        $data= mysqli_fetch_array($query);

        $_SESSION["pengguna_id"] = $data["id"];
        $_SESSION["nama"] = $data["nama"];

        header("Location: index.php");
        die();
    } else {
        $error = "Email atau Password Salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dummy Data</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php if (isset($error)): {
        echo $error;
    } ?>
    <?php endif; ?>
    <form method="POST">
        email :
        <input type="email" name="email" placeholder="input email">
        <br>
        password :
        <input type="password" name="password" placeholder="input password">
        <br>
        <input type="submit" name="login" value="login">
    </form>
    <p>
        Haven't An Account Yet? <a href="register.php" class="register">Register Here</a>
    </p>
</body>

</html>