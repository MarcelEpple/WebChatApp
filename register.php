<?php
require "start.php";
if (isset($_SESSION["chat_user"])) {
    //if user is logged in    
    //redirect to friends.php
    header("Location: friends.php");
    exit();
}


// wird true falls sich ein nicht leerer String oder Array in der Variable befindet
// oder falls sie auf true gesetzt wird
$errorNameEmptyMsg = false;
$errorNameExistsMsg = false;
$errorNameLengthMsg = false;
$errorPasswordEmptyMsg = false;
$errorPasswordLengthMsg = false;
$errorPasswordConfirmMsg = false;


$username = "";
$password = "";
$confirm_password = "";

// 1. Maßnahme: Prüfen ob das Formular abgesendet wurde
if (isset($_POST["register"])) {
    // Formular wurde abgesendet

    // 2. Maßnahme: Welche Daten wurden abgesendet?
    $username = $_POST["username"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];


    // 3. Maßnahme: Validierung der Daten    
    if (empty($username)) {
        $errorNameEmptyMsg = "Username is empty";

    } elseif (strlen($username) < 3) {
        $errorNameLengthMsg = "Username is too short";
    }

    if (empty($password)) {
        $errorPasswordEmptyMsg = "Password is empty";
    } elseif (strlen($password) < 8) {
        $errorPasswordLengthMsg = "Password is too short";
    }

    if ($password != $confirm_password) {
        $errorPasswordConfirmMsg = "Passwords do not match";
    }

    if ($service->userExists($username)) {
        $errorNameExistsMsg = "Username already exists";
    }

    // Überprüfe, ob keine Validierungsfehler vorliegen, bevor du weiterleitest
    if (
        !$errorNameEmptyMsg && !$errorNameLengthMsg && !$errorPasswordEmptyMsg &&
        !$errorPasswordLengthMsg && !$errorPasswordConfirmMsg && !$errorNameExistsMsg
    ) {
        if ($service->register($username, $password)) {
            $_SESSION["chat_user"] = $username;
            header("Location: friends.php");
            exit();
        } else {
            echo "Registration failed";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register</title>
    <link rel="preconnect" href="https://rsms.me/">
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body class="bg-light">
    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">Chat-App</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="d-flex">
                    <a class="btn btn-outline-success ml-auto me-2" href="logout.php">Login</a>
                </div>
        </nav>
    </header>

    <main class="container">
        <div class="container text-center pt-5">
            <div class="formheader">
                <img src="files/profile.png" alt="chat" class="img-fluid mb-3 rounded-circle" width=200 height=200>
                <div class="row justify-content-center align-items-center">
                    <div class="col-6 p-3 rounded">
                        <div class="card text-center">
                            <div class="card-header">
                                Register yourself
                            </div>

                            <!--action="friends.php"-->
                            <form action="" id="register-form" method="post">
                                <fieldset>
                                    <div class="card-body">
                                        <div class="formular">
                                            <div class="input-group flex-nowrap pb-4">
                                                <label for="username" class="input-group-text w-25 ps-1"
                                                    id="addon-wrapping">Username</label>

                                                <input class="form-control" placeholder="Username" aria-label="Username"
                                                    aria-describedby="addon-wrapping" name="username" id="username"><br>
                                            </div>
                                        </div>

                                        <div class="formular">
                                            <div class="input-group flex-nowrap pb-4">
                                                <label for="password" class="input-group-text w-25 ps-1"
                                                    id="addon-wrapping">Password</label>

                                                <input class="form-control" placeholder="Password" aria-label="Password"
                                                    aria-describedby="addon-wrapping" name="password" type="password"
                                                    id="password"><br>
                                            </div>
                                        </div>

                                        <div class="formular">
                                            <div class="input-group flex-nowrap pb-4">
                                                <label for="confirm_password" class="input-group-text w-25 ps-1"
                                                    id="addon-wrapping">Confirm Password</label>

                                                <input class="form-control" placeholder="Confirm Password"
                                                    aria-label="Confirm Password" aria-describedby="addon-wrapping"
                                                    name="confirm_password" type="password" id="confirm_password"><br>
                                            </div>
                                        </div>

                                        <div class="text-danger">
                                            <?php if ($errorPasswordEmptyMsg) { ?>
                                                <p class="error-msg">
                                                    <?= $errorPasswordEmptyMsg; ?>
                                                </p>
                                            <?php } ?>

                                            <?php if ($errorPasswordLengthMsg) { ?>
                                                <p class="error-msg">
                                                    <?= $errorPasswordLengthMsg; ?>
                                                </p>
                                            <?php } ?>

                                            <?php if ($errorNameLengthMsg) { ?>
                                                <p class="error-msg">
                                                    <?= $errorNameLengthMsg; ?>
                                                </p>
                                            <?php } ?>

                                            <?php if ($errorNameEmptyMsg) { ?>
                                                <p class="error-msg">
                                                    <?= $errorNameEmptyMsg; ?>
                                                </p>
                                            <?php } ?>

                                            <?php if ($errorPasswordConfirmMsg) { ?>
                                                <p class="error-msg">
                                                    <?= $errorPasswordConfirmMsg; ?>
                                                </p>
                                            <?php } ?>

                                        </div>

                                        <div class="formbutton">
                                            <a href="login.php" class="btn btn-secondary">Cancel</a>
                                            <button id="register_button" name="register" class="btn btn-primary"
                                                type="submit">Create Account</button>
                                        </div>
                                    </div>


                                </fieldset>

                        </div>

                    </div>
                </div>

            </div>

            </form>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
        </script>

</body>

</html>