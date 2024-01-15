<?php
//je maakt verbinding met de database.
/**@var mysqli $db */
require_once "includes/database.php";

$errors=['email'=> '', 'userName'=> '', 'password'=> ''];
$data=['email'=> '', 'userName'=> '', 'password'=> ''];

if (isset($_POST['submit'])) {

    if ($_POST['userName'] == '') {
        $errors['userName'] = 'you must fill in a user name ';
    } else {
        $errors['userName'] = ' ';
    }

    if ($_POST['email'] == '') {
    $errors['email'] = 'you must fill in your email';
    } else {
    $errors['email'] = ' ';
    }

    if ($_POST['password'] == '') {
    $errors['password'] = 'you must fill in a password';
    } else {
    $errors['password'] = ' ';
    }
}

if ($errors['email'] == ' ' && $errors['userName'] == ' ' && $errors['password'] == ' ') {

$email = mysqli_escape_string($db, $_POST['email']);
$userName = mysqli_escape_string($db, $_POST['userName']);
$password = mysqli_escape_string($db, $_POST['password']);

$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$query = "INSERT INTO users (email, user_name, password)
VALUES('$email', '$userName', '$password')";

$result = mysqli_query($db, $query)
or die('Error ' . mysqli_error($db) . ' with query ' . $query);

mysqli_close($db);

header('location: index.php');
exit;
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet">
    <title>Sign up</title>
</head>
<body>
    <section>
            <h2>if you dont have a account please make one first</h2>

            <form class="column is-6" action="" method="post">
                    </div>
                                <label class="label" for="userName">User name</label>
                                <input class="input" id="userName" type="text" name="userName" value="<?php if ($errors['userName'] == ' '){echo $_POST['userName'];}?>"/>
                                <?= $errors['userName']?>

                                <label class="label" for="email">Email</label>
                                <input class="input" id="email" type="text" name="email" value="<?php if ($errors['email'] == ' '){echo $_POST['email'];}?>"/>
                                <?= $errors['email']?>

                                <label class="label" for="password">Password</label>
                                <input class="input" id="password" type="text" name="password" value="<?php if ($errors['password'] == ' '){echo $_POST['password'];}?>"/>
                                <?= $errors['password']?>
                    </div>
                        <button type="submit" name="submit">Register</button>
            </form>
            <a href="index.php">&laquo; Go back to the homepage</a>
    </section>
</body>
</html>