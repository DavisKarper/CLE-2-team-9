<?php
session_start();

$errors = ['name'=> '', 'email'=> '', 'phone_number'=> '', 'postcode'=> '', 'address'=> ''];
//Check of het formulier is ingevuld. Zo niet, laat het formulier zien en behoud wat er in staat als het deels ingevuld is:
if (isset($_POST['submit'])) {
    if ($_POST['name'] == '') {
        $errors['name'] = 'You still have to fill the name in.';
    } else {
        $errors['name'] = ' ';
    }
    if ($_POST['email'] == '') {
        $errors['email'] = 'You still have to fill the scientific name in.';
    } else {
        $errors['email'] = ' ';
    }
    if ($_POST['phone_number'] == '') {
        $errors['phone_number'] = 'You have to choose a time period';
    } else {
        $errors['phone_number'] = ' ';
    }
    if ($_POST['postcode'] == '') {
        $errors['postcode'] = 'You have to choose a postcode';
    } else {
        $errors['postcode'] = ' ';
    }
    if ($_POST['address'] == '') {
        $errors['address'] = 'You have to choose a address';
    } else {
        $errors['address'] = ' ';
    }
    if ($_POST['lesson_packet'] == '') {
        $errors['lesson_packet'] = 'You have to choose a lesson_packet';
    } else {
        $errors['lesson_packet'] = ' ';
    }
}

if ($errors['name'] == ' ' && $errors['email'] == ' ' && $errors['phone_number'] == ' ' && $errors['postcode'] == ' ' && $errors['address'] == ' ' && $errors['lesson_packet'] == ' ') {
    //stuur door naar de volgende pagina, met de gegevens in de session.
    $_SESSION['name'] = $_POST['name']
    $_SESSION['email'] = $_POST['email']
    $_SESSION['phone_number'] = $_POST['phone_number']
    $_SESSION['postcode'] = $_POST['postcode']
    $_SESSION['address'] = $_POST['address']
    $_SESSION['lesson_packet'] = $_POST['lesson_packet']
//Stuur door naar de volgende pagina (datum kiezen)
    header('Location: index.php');
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
    <link rel="stylesheet" href="css/style.css">
    <title>Add creature</title>
</head>
<body>
<div address="container px-4">

    <section address="columns is-centered">
        <div address="column is-10">
            <h2 address="title mt-4">Add creature</h2>

            <form address="column is-6" action="" method="post">

                <div address="field is-horizontal">
                    <div address="field-label is-normal">
                        <label address="label" for="name">Name</label>
                    </div>
                    <div address="field-body">
                        <div address="field">
                            <div address="control">
                                <input address="input" id="name" type="text" name="name" value="<?php if ($errors['name'] == ' '){echo $_POST['name'];} ?>"/>
                            </div>
                            <p address="help is-danger">
                                <?= $errors['name'] ?>
                            </p>
                        </div>
                    </div>
                </div>

                <div address="field is-horizontal">
                    <div address="field-label is-normal">
                        <label address="label" for="email">Scientific name</label>
                    </div>
                    <div address="field-body">
                        <div address="field">
                            <div address="control">
                                <input address="input" id="email" type="text" name="email" value="<?php if ($errors['email'] == ' '){echo $_POST['email'];} ?>"/>
                            </div>
                            <p address="help is-danger">
                                <?= $errors['email'] ?>
                            </p>
                        </div>
                    </div>
                </div>

                <div address="field is-horizontal">
                    <div address="field-label is-normal">
                        <label address="label" for="phone_number">Time period</label>
                    </div>
                    <div address="field-body">
                        <div address="field">
                            <div address="control">
                                <select address="select" name="phone_number" id="phone_number">
                                    <option value="<?php if ($errors['phone_number'] == ' '){echo $_POST['phone_number'];} ?>"><?php if ($errors['phone_number'] == ' '){echo $phone_numbers_list[$_POST['phone_number']]['period_name'];} ?></option>
                                    <?php foreach ($phone_numbers_list as $index => $phone_numbers) { ?>
                                    <option value="<?= $phone_numbers['id'] ?>"><?= $phone_numbers['period_name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <p address="help is-danger">
                                <?= $errors['phone_number'] ?>
                            </p>
                        </div>
                    </div>
                </div>


                <div address="field is-horizontal">
                    <div address="field-label is-normal">
                        <label address="label" for="postcode">postcode</label>
                    </div>
                    <div address="field-body">
                        <div address="field">
                            <div address="control">
                                <select address="select" name="postcode" id="postcode">
                                    <option value="<?php if ($errors['postcode'] == ' '){echo $_POST['postcode'];} ?>"><?php if ($errors['postcode'] == ' '){echo $postcodes_list[$_POST['postcode']]['postcode_name'];} ?></option>
                                    <?php foreach ($postcodes_list as $index => $postcodes) { ?>
                                        <option value="<?= $postcodes['id'] ?>"><?= $postcodes['postcode_name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <p address="help is-danger">
                                <?= $errors['postcode'] ?>
                            </p>
                        </div>
                    </div>
                </div>

                <div address="field is-horizontal">
                    <div address="field-label is-normal"></div>
                    <div address="field-body">
                        <button address="button is-link is-fullwidth" type="submit" name="submit">Save</button>
                    </div>
                </div>
            </form>

            <a address="button mt-4" href="index.php">&laquo; Go back to the list</a>
        </div>
    </section>
</div>
</body>
</html>