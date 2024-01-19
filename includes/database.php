<?php
$host       = "localhost";
$database   = "prj_2023_2024_ressys_t9";
$user       = "prj_2023_2024_ressys_t9";
$password   = "niroofoo";

$db = mysqli_connect($host, $user, $password, $database)
    or die("Error: " . mysqli_connect_error());;
