<?php
session_start();
$lesson_type_id = $_SESSION['lesson_type_id']; $name = $_SESSION['name']; $email = $_SESSION['email']; $phone_number = $_SESSION['phone_number']; $postcode = $_SESSION['postcode']; $address = $_SESSION['address']; $lesson_packet = $_SESSION['lesson_packet']; $planned_in = $_SESSION['planned_in'];

if($planned_in == 0){
    //niet ingepland tekst tonen met telefoonnummer
    $shown_datetime = 'Je hebt geen datum gekozen';
    $datetime = '0000-00-00 00:00';
}else{
    //datum ophalen uit sessie
    $date = $_SESSION['date'];
    //datum opsplitsen
    $date = str_replace(" ","",$date);
    $date3 = str_split($date,3); $day = $date3[0];
    $month = $date3[1];
    $date2 = str_split($date,2); $day_number = $date2[3];
    $date4 = str_split($date,4); $year = $date4[2];
    $date12 = str_split($date,12); $date8 = str_split($date12[1],8); $time = $date8[0];
    if ($time == '00:00:00'){
        $time = '10:00:00';
    }
    $time_short = str_split($time,5); $time_short = $time_short[0];
    //maand in getal veranderen
$months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    foreach ($months as $index=>$month_short){
        if ($month == $month_short){
            $month_number = $index+1;
        }
    }
    //dag in volledige dagnaam tonen
$days_short_array = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
$days = ['Maandag', 'Dinsdag', 'Woensdag', 'Donderdag', 'Vrijdag', 'Zaterdag', 'Zondag'];
    foreach ($days_short_array as $index=>$days_short){
        if ($day == $days_short){
            $day = $days[$index];
        }
    }
    //ingepland tekst tonen met datum
    $shown_datetime = $time_short.' '.$day_number.'-'.$month_number.'-'.$year;
    $datetime = $year.'-'.$month_number.'-'.$day_number.' '.$time_short;
}

if(isset($_POST['submit'])){
    //gegevens opslaan in de database
    /**@var mysqli $db */
    require_once "includes/database.php";
    //datum opslaan
    $query = "INSERT INTO available_dates (date, lesson_type, instructor_id)
                    VALUES('$datetime', '$lesson_type_id', '0')";
    $result = mysqli_query($db, $query)
    or die('Error '.mysqli_error($db).' with query '.$query);
    //datum id ophalen
    $query = "SELECT id FROM available_dates ORDER BY id DESC";
    $result = mysqli_query($db, $query)
    or die('Error '.mysqli_error($db).' with query '.$query);
    $date_id_multiple = [];
    while($row = mysqli_fetch_assoc($result))
    {
        $date_id_multiple[] = $row;
    }
    $date_id = $date_id_multiple[0];
    $date_id = $date_id['id'];

    //gegevens opslaan en koppelen met de datum id
    $name = mysqli_escape_string($db, $name);
    $email = mysqli_escape_string($db, $email);
    $phone_number = mysqli_escape_string($db, $phone_number);
    $postcode = mysqli_escape_string($db, $postcode);
    $address = mysqli_escape_string($db, $address);
    $lesson_packet = mysqli_escape_string($db, $lesson_packet);
    $planned_in = mysqli_escape_string($db, $planned_in);

    $query = "INSERT INTO registrations (name, email, phone_number, postcode, address, lesson_packet, date_id, planned_in)
                    VALUES('$name', '$email', '$phone_number', '$postcode', '$address', '$lesson_packet', '$date_id', '$planned_in')";
    $result = mysqli_query($db, $query)
    or die('Error '.mysqli_error($db).' with query '.$query);
    //extra scherm laten zien dat het in de database staat



    //bevestigingsmail sturen

    //voor later

    //terugsturen naar de homepagina
    mysqli_close($db);
    header('Location: index.html');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mado - Bevestiging</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/png" sizes="32x32" href="https://rijschoolmado.nl/favicon-32x32.png?v=69Bpgky3MB">
    <link rel="icon" type="image/png" sizes="16x16" href="https://rijschoolmado.nl/favicon-16x16.png?v=69Bpgky3MB">
    <style>
        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #212529;
            text-align: left;
            background-color: #fff;
        }

        /* nav */
        nav {
            position: fixed;
            width: 100%;
            top: 0;
            left: 0;
            background-color: #FFF;
        }

        .top {
            width: 100%;
            color: #FFF;
            background-color: #272a3b;
            height: 40px;
            text-align: center;
        }

        .top span {
            line-height: 36px;
            font-weight: bold;
            padding-right: 20px;
            color: #39f2b9;
            font-size: 15px;
        }

        .bottom {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 100px;
        }

        .bottom .logo {
            height: 90px;
            padding-right: 50px;
        }

        .bottom a {
            color: #212529;
            font-weight: 700;
            cursor: pointer;
            margin-bottom: 3px;
            transition: all 0.3s ease;
        }

        .bottom-home {
            background-image: url(/img/house.png);
            background-size: 25px;
            background-position: center center;
            background-repeat: no-repeat;
        }

        .bottom-auto {
            background-image: url(/img/car.png);
            background-size: 25px;
            background-position: center center;
            background-repeat: no-repeat;
        }

        .bottom-motor {
            background-image: url(/img/motorcycle.png);
            background-size: 25px;
            background-position: center center;
            background-repeat: no-repeat;
        }

        .bottom-aanhanger {
            background-image: url(/img/vracht.png);
            background-size: 25px;
            background-position: center center;
            background-repeat: no-repeat;
        }

        .bottom-brommer {
            background-image: url(/img/brom.png);
            background-size: 25px;
            background-position: center center;
            background-repeat: no-repeat;
        }

        .bottom a p {
            margin: 0;
            padding-bottom: 3px;
            padding-top: 40px;
        }

        .bottom a:hover {
            color: #36ba7a;
            border-bottom: 3px solid #36ba7a;
            margin-bottom: 0;
        }

        .bottom-home:hover {
            background-image: url(/img/house-green.png);
            background-size: 29px;
            background-position: center center;
            background-repeat: no-repeat;
        }

        .bottom-auto:hover {
            background-image: url(/img/car-green.png);
            background-size: 28px;
            background-position: center center;
            background-repeat: no-repeat;
        }

        .bottom-motor:hover {
            background-image: url(/img/motor-green.png);
            background-size: 28px;
            background-position: center center;
            background-repeat: no-repeat;
        }

        .bottom-aanhanger:hover {
            background-image: url(/img/vracht-green.png);
            background-size: 27px;
            background-position: center center;
            background-repeat: no-repeat;
        }

        .bottom-brommer:hover {
            background-image: url(/img/brom-green.png);
            background-size: 29px;
            background-position: center center;
            background-repeat: no-repeat;
        }

        .bottom button {
            /* line-height: 24px; */
            /* position: relative; */
            font-size: 18px;
            color: #fff;
            padding: 14px 30px 14px;
            background-color: #0D9;
            border: 1px solid #04A473;
            font-weight: bold;
            border-radius: 4px;
        }




        /* header */
        header {
            display: flex;
            flex-direction: column;
            align-items: center;
            color: #FFF;
            margin-top: 150px;
            padding-bottom: 25px;
            background: linear-gradient(to bottom, #29BFE2 0%, #1259C7 100%);
        }

        header a {
            color: #FFF;
            text-decoration: none;

        }

        /* main */
        main {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 3rem;
        }

        main img {
            width: 50%;
        }

        main h2 {
            font-weight: bold;
            font-size: 25px;
        }


        form {
            margin: 0 auto;
            width: 650px;
            padding: 0 20px 20px 20px;
        }

        form label {
            font-weight: bold;
        }

        label {
            display: block;
        }

        input[type=text],
        input[type=email],
        input[type=tel],
        select {
            font-size: 18px;
            width: 100%;
            padding: 15px 25px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-top: 10px;
        }

        main button {
            background: #0DAD83;
            color: white;
            border-radius: 10px;
            border: none;
            height: 44px;
            width: 300px;
            line-height: 40px;
            padding: 0;
            margin: 30px 15px 30px 0;
            cursor: pointer;
            -webkit-transition: all 0.15s ease;
            transition: all 0.15s ease;
            font-size: 22px;
            text-align: center;
        }

        main a {
            text-decoration: none;
            font-size: 22px;
            color: #fff;
        }

        /* footer */
        .footerbox {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .footerbox img {
            height: 50px;
            padding-left: 20px;
        }

        .checkmarks {
            display: flex;
            justify-content: center;
            padding: 20px 0 20px 0
        }

        .checkmarks span {
            padding: 0 90px 0 90px;
            color: #29abe2;
            font-weight: bold;
            font-size: 20px;
            line-height: 36px;
        }

        .social {
            display: flex;
            align-items: center;
        }

        .social img {
            height: 14px;
        }

        .social a {
            color: black;
            padding-left: 40px;
            text-decoration: none;
        }

        .terms {
            padding-bottom: 0;
        }

        .small {
            margin-top: -25px;
            line-height: 25px;
            text-align: center;
            font-size: 10px;
        }
        form {
            display: flex;
        }
        .save-button {
            height: 44px;
            width: 300px;
            line-height: 40px;
            /*padding: auto;*/
            border-radius: 2px;
            margin: 30px 15px 30px 0;
            cursor: pointer;
            -webkit-transition: all 0.15s ease;
            transition: all 0.15s ease;
            font-size: 22px;
            text-align: center;
        }
        .save-button {
            background: #0DAD83;
            color: white;
            border-radius: 10px;
        }

    </style>
</head>

<body>
<nav>
    <div class="top">
        <span>&#10003 Direct starten</span>
        <span>&#10003 Betalen in termijnen</span>
        <span>&#10003 Razendsnel je rijbewijs</span>
        <span>&#10041 Beste Rijschool Rotterdam 2020</span>
    </div>
    <div class="bottom">
        <img class="logo" src="img/mado-logo.png" alt="logo">
        <a class="bottom-home">
            <p>HOME</p>
        </a>
        <a class="bottom-auto">
            <p>AUTO</p>
        </a>
        <a class="bottom-motor">
            <p>MOTOR</p>
        </a>
        <a class="bottom-aanhanger">
            <p>AANHANGER</p>
        </a>
        <a class="bottom-brommer">
            <p>BROMMER</p>
        </a>
        <button>START EEN PROEFLES</button>
    </div>
</nav>

<header>
    <h1>Aanmelden voor <?= ucfirst($_GET['opleiding']) ?>rijles</h1>
    <div>
        <a href="index.html">Home &#45</a>
        <a href=""><?= ucfirst($_GET['opleiding']) ?> &#45</a>
        <a href="">Aanmelden</a>
    </div>
</header>

<main>
    <h2>Kloppen uw gegevens?</h2>
    <ul>
        <li><strong>Naam: </strong>
            <?= $_SESSION['name'] ?>
        </li>
        <li><strong>E-mailadres: </strong>
            <?= $_SESSION['email'] ?>
        </li>
        <li><strong>Telefoonnummer: </strong>
            <?= $_SESSION['phone_number'] ?>
        </li>
        <li><strong>Postcode: </strong>
            <?= $_SESSION['postcode'] ?>
        </li>
        <li><strong>Straatnaam en huisnummer: </strong>
            <?= $_SESSION['address'] ?>
        </li>
        <li><strong>Datum en tijd: </strong>
            <?= $shown_datetime ?>
        </li>
    </ul>
<form method="post">
    <input class="save-button" type="submit" name="submit" value="Bevestigen &#10095" />
</form>
</main>

<footer>
    <!-- div for flexbox -->
    <div class="footerbox">
        <img src="img/mado-logo.png" alt="logo">
        <div class="checkmarks">
            <span>&#10003 Betaalbaar & in termijnen</span>
            <span>&#10003 Direct starten</span>
            <span>&#10003 Hoge slagingspercentage</span>
        </div>

        <div class="social">
            <a href="tel:06 1010 8080">
                <img src="img/calling.png" alt="">
                06 1010 8080
            </a>
            <a href="https://wa.me/31610108080">
                <img src="img/whatsapp.png" alt="">
                06 1010 8080
            </a>
            <a href="https://facebook.com/rijschoolmado">
                <img src="img/facebook.png" alt="">
                Facebook
            </a>
            <a href="https://instagram.com/rijschoolmado">
                <img src="img/instagram.png" alt="">
                Instagram
            </a>
        </div>

        <div class="terms">
            <p>
                © Rijschool Mado 2024 • Alle rechten voorbehouden • Created by Akina • Contact • Algemene
                voorwaarden
            </p>
        </div>
        <div class="small">
            <p>
                Lessen worden altijd aan het "einde" per lesblok betaald. Voor examens wordt vooruit per bank
                betaald.
                <br>
                De rijschool is niet aansprakelijk voor vooruitbetalingen die contant aan de instructeur zijn
                voldaan. De instructeur
                bepaald samen met jou het aantal benodigde lessen voor het afrijden.
            </p>
        </div>
    </div>
</footer>
</body>

</html>
