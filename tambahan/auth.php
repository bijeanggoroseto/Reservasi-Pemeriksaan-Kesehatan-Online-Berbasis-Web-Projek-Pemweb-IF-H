<?php
    session_start();
    if(!isset($_SESSION["pengguna_id"])){
        header("location: login.php");
        die();
    }
?>