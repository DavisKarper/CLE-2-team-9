<?php
session_start();
//je maakt verbinding met de database.
/**@var mysqli $db */
//require_once "includes/database.php";

//je controleert of de form is ingevuld (validatie).
$errors = ['email' => '', 'password' => ''];

//valideer de gegevens uit de post
if (isset($_POST['submit'])) {
    if ($_POST['email'] == '') {
        $errors['email'] = 'you must fill in your email ';
    } else {
        $errors['email'] = ' ';
    }

    if ($_POST['password'] == '') {
        $errors['password'] = 'you must fill your password';
    } else {
        $errors['password'] = ' ';
    }
}

//haal de data uit de form en check of alle velden zijn ingevuld
if ($errors['email'] == ' ' && $errors['password'] == ' '){
    $email = mysqli_escape_string($db, $_POST['email']);
    $password = mysqli_escape_string($db, $_POST['password']);


    //maak de query aan
    $query = "SELECT id, password, is_verified FROM users WHERE email ='$email'";

    $result = mysqli_query($db, $query)
    or die('Error ' . mysqli_error($db) . ' with query ' . $query);

    if(mysqli_num_rows($result) == 1) {

// Get user data from result
        $user =  mysqli_fetch_assoc($result);
// Check if the provided password matches the stored password in the database
        if (password_verify($_POST['password'], $user['password'])){
// Store the user in the session
            $_SESSION['id'] = $user['id'];
            $_SESSION['email'] = $email;
            $_SESSION['password'] = password_hash($password, PASSWORD_DEFAULT);
            $_SESSION['verification'] = $user['is_verified'];
//Remember user for 24 hours
            setcookie('session_id', session_id(), time() + 86400);
// Redirect to secure page
            header('Location: index.php');
            exit;
// Credentials not valid
        } else {
//error incorrect log in
            $errors['loginFailed'] = "Couldn't log in";
        }
// User doesn't exist
    }else {
        $errors['loginFailed'] = "Couldn't log in";
    }
}

//je sluit de collectie
//mysqli_close($db);


?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet.css">
    <title>login page</title>
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
            padding: 0 400px 0 100px;
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
            /*margin-bottom: 8rem;*/
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
            margin: 9rem auto;

        }

        main img {
            width: 50%;
        }

        main h2 {
            font-weight: bold;
            font-size: 25px;
        }

        .form {
            /*margin: 0 auto;*/
            width: 650px;
            /*padding: 0 20px 20px 20px;*/
        }

        .form label {
            font-weight: bold;
            display: block;
        }

        input[type=text],
        input[type=email],
        input[type=tel],
        select {
            font-size: 18px;
            width: 82%;
            padding: 15px 25px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-top: 10px;
        }

        .login-button {
            background: #0DAD83;
            color: white;
            border-radius: 10px;
            border: none;
            /* font-weight: bold; */
            height: 44px;
            width: 350px;
            line-height: 40px;
            padding: 0;
            margin: 30px 15px 30px 0;
            cursor: pointer;
            -webkit-transition: all 0.15s ease;
            transition: all 0.15s ease;
            font-size: 22px;
            text-align: center;
        }

        .container-content{
            display: flex;
            flex-direction: column;
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
    </div>
</nav>

<header>
    <h1>Log in</h1>
</header>


<main class="form">
    <?php if (isset($_SESSION['login'])) { ?>
        <p>U bent ingelogd</p>
        <p><a href="logout.php">Log out</a>
    <?php } else { ?>
        <section class="columns">
            <form class="column is-6" action="" method="post">
                <div class="field is-horizontal">
                    <div class="field-label is-normal">
                        <label class="label" for="email">Email</label>
                    </div>
                    <div class="field-body">
                            <div class="control has-icons-left">
                                <input class="input" id="email" type="text" name="email" value="<?php if ($errors['email'] == ' '){echo $_POST['email'];}?>"/>
                                <span class="icon is-small is-left"><i class="fas fa-envelope"></i></span>
                                <?=$errors['password']?>
                            </div>
                            <p class="help is-danger">
                                <?= $errors['email'] = '' ?>
                            </p>
                    </div>
                </div>
                <div class="field is-horizontal">
                    <div class="field-label is-normal">
                        <label class="label" for="password">Password</label>
                    </div>
                    <div class="field-body">
                            <div class="control has-icons-left">
                                <input class="input" id="password" type="text" name="password" value="<?php if ($errors['password'] == ' '){echo $_POST['password'];}?>"/>
                                <span class="icon is-small is-left"><i class="fas fa-lock"></i></span>
                            </div>
                            <p class="help is-danger">
                                <?= $errors['password'] = '' ?>
                            </p>
                    </div>
                </div>
                <p>Geen account? <a href="registration.php">Druk hier</a> </p>
                <div class="field is-horizontal">
                    <div class="field-label is-normal"></div>
                    <div class="field-body">
                        <button class="login-button" type="submit" name="submit">Log in</button>
                    </div>
                </div>
            </form>
        </section>
    <?php } ?>
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