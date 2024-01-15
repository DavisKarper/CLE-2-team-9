<?php
session_start();
//je maakt verbinding met de database.
/**@var mysqli $db */
require_once "includes/database.php";

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
mysqli_close($db);


?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet">
    <title>login page</title>
</head>
<body>
    <section>
        <div>
            <h2>Log in to your account</h2>

            <form action="" method="post">
                            <div class="control">
                                <label class="label" for="userName">User name</label>
                                <input class="input" id="email" type="text" name="email" value="<?php if ($errors['email'] == ' '){echo $_POST['email'];}?>"/>
                                <?= $errors['email']?>
                                <label class="label" for="password">Password</label>
                                <input class="input" id="password" type="text" name="password" value="<?php if ($errors['password'] == ' '){echo $_POST['password'];}?>"/>
                                <?= $errors['password']?>
                            </div>
            </form>
            <a href="index.php">&laquo; Go back to home page</a>
        </div>
    </section>
</body>
</html>

