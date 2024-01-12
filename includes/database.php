<?php
$host       = "https://sql.hosted.hro.nl/";
$database   = "prj_2023_2024_ressys_t9";
$user       = "1075509";
$password   = "zaedoodi";

$db = mysqli_connect($host, $user, $password, $database)
    or die("Error: " . mysqli_connect_error());;
