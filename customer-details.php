<?php
session_start();

$lesson_type_id = $_GET['opleiding'];
$errors = ['name'=> '', 'email'=> '', 'phone_number'=> '', 'postcode'=> '', 'address'=> '', 'lesson_packet'=> ''];
//Check of het formulier is ingevuld. Zo niet, laat het formulier zien en behoud wat er in staat als het deels ingevuld is:
if (isset($_POST['submit'])) {
    if ($_POST['name'] == '') {
        $errors['name'] = 'Je bent vergeten je naam in te vullen.';
    } else {
        $errors['name'] = ' ';
    }
    if ($_POST['email'] == '') {
        $errors['email'] = 'Vul je email in.';
    } else {
        $errors['email'] = ' ';
    }
    if ($_POST['phone_number'] == '') {
        $errors['phone_number'] = 'Vul jouw telefoonnummer in.';
    } else {
        $errors['phone_number'] = ' ';
    }
    if ($_POST['postcode'] == '') {
        $errors['postcode'] = 'Je moet een postcode opgeven.';
    } else {
        $errors['postcode'] = ' ';
    }
    if ($_POST['address'] == '') {
        $errors['address'] = 'Je moet je straatnaam en huisnummer nog invullen.';
    } else {
        $errors['address'] = ' ';
    }
    if ($_POST['lesson_packet'] == '') {
        $errors['lesson_packet'] = 'je moet een lespakket kiezen.';
    } else {
        $errors['lesson_packet'] = ' ';
    }
}

if ($errors['name'] == ' ' && $errors['email'] == ' ' && $errors['phone_number'] == ' ' && $errors['postcode'] == ' ' && $errors['address'] == ' ' && $errors['lesson_packet'] == ' ') {
    //stuur door naar de volgende pagina, met de gegevens in de session.
    $_SESSION['name'] = $_POST['name'];
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['phone_number'] = $_POST['phone_number'];
    $_SESSION['postcode'] = $_POST['postcode'];
    $_SESSION['address'] = $_POST['address'];
    $_SESSION['lesson_packet'] = $_POST['lesson_packet'];
    $_SESSION['lesson_type_id'] = $lesson_type_id;
//Stuur door naar de volgende pagina (datum kiezen)
    header('Location: datum.php');
    exit;
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mado - Contact info</title>
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
            background-image: url(img/house.png);
            background-size: 25px;
            background-position: center center;
            background-repeat: no-repeat;
        }

        .bottom-auto {
            background-image: url(img/car.png);
            background-size: 25px;
            background-position: center center;
            background-repeat: no-repeat;
        }

        .bottom-motor {
            background-image: url(img/motorcycle.png);
            background-size: 25px;
            background-position: center center;
            background-repeat: no-repeat;
        }

        .bottom-aanhanger {
            background-image: url(img/vracht.png);
            background-size: 25px;
            background-position: center center;
            background-repeat: no-repeat;
        }

        .bottom-brommer {
            background-image: url(img/brom.png);
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
            background-image: url(img/house-green.png);
            background-size: 29px;
            background-position: center center;
            background-repeat: no-repeat;
        }

        .bottom-auto:hover {
            background-image: url(img/car-green.png);
            background-size: 28px;
            background-position: center center;
            background-repeat: no-repeat;
        }

        .bottom-motor:hover {
            background-image: url(img/motor-green.png);
            background-size: 28px;
            background-position: center center;
            background-repeat: no-repeat;
        }

        .bottom-aanhanger:hover {
            background-image: url(img/vracht-green.png);
            background-size: 27px;
            background-position: center center;
            background-repeat: no-repeat;
        }

        .bottom-brommer:hover {
            background-image: url(img/brom-green.png);
            background-size: 29px;
            background-position: center center;
            background-repeat: no-repeat;
        }

        .bottom button {
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

        /*select#lesson_packet {*/
        /*    width: 108%;*/
        /*}*/

        form {
            margin: 0 auto;
            width: 650px;
            padding: 0 20px 20px 20px;
        }

        form label {
            font-weight: bold;
        }
        .error{
            color: #f14b59;
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
            /* font-weight: bold; */
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
        <a class="bottom-home" href="index.html">
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
    <h2>Direct aanmelden <?= $_GET['opleiding'] ?> opleiding</h2>
    <img src="img/step 1.png" alt="step indicator">
    <h2>Je gegevens</h2>

    <form action="" method="post">

        <label for="lesson_packet">
            <br>Kies je <?= $_GET['opleiding'] ?> pakket </br>
        </label>
        <select name="lesson_packet" id="lesson_packet">
            <option value="" selected="selected" disabled="">--- MAAK EEN KEUZE ---</option>
            <option value="1">Pakket Pro</option>
            <option value="2">Pakket Gevorderd</option>
            <option value="3">Pakket Starter</option>
            <option value="4">Pakket Beginner</option>
        </select>
        <div class="error">
            <?= $errors['lesson_packet'] ?>
        </div>

        <label for="name">
            <br>Naam</br>
        </label>
        <input type="text" name="name" placeholder="Femke Hart" value="<?php if ($errors['name'] == ' '){echo $_POST['name'];} ?>"/>
        <div class="error">
            <?= $errors['name'] ?>
        </div>
        <label for="phone_number">
            <br>Telefoonnummer</br>
        </label>
        <input type="text" name="phone_number" placeholder="0612345678" value="<?php if ($errors['phone_number'] == ' '){echo $_POST['phone_number'];} ?>"/>
        <div class="error">
            <?= $errors['phone_number'] ?>
        </div>
        <label for="address">
            <br>Straatnaam en huisnummer</br>
        </label>
        <input type="text" name="address" placeholder="Kanaalweg 6A" value="<?php if ($errors['address'] == ' '){echo $_POST['address'];} ?>"/>
        <div class="error">
            <?= $errors['address'] ?>
        </div>
        <label for="postcode">
            <br>Postcode</br>
        </label>
        <input type="text" name="postcode" placeholder="2903LS" value="<?php if ($errors['postcode'] == ' '){echo $_POST['postcode'];} ?>"/>
        <div class="error">
            <?= $errors['postcode'] ?>
        </div>
        <label for="email">
            <br>E-mail</br>
        </label>
        <input type="text" name="email" placeholder="femkehart@hotmail.com" value="<?php if ($errors['email'] == ' '){echo $_POST['email'];} ?>"/>
        <div class="error">
            <?= $errors['email'] ?>
        </div>

<div>
    <button type="submit" name="submit">Kies uw Datum en tijdstip &#10095</button>
</div>
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