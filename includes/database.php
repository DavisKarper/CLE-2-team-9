<?php
$host       = "localhost";
$database   = "ancient_creatures2";
$user       = "root";
$password   = "";

$db = mysqli_connect($host, $user, $password, $database)
    or die("Error: " . mysqli_connect_error());;
