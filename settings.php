<?php require "start.php";

if (!isset($_SESSION["chat_user"])) {
    header("Location: login.php");
    exit();
}
//load user
$username = $_SESSION["chat_user"];
$user = $service->loadUser($username);
$saveSettings = "";

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        error_log("Formular wurde abgeschickt.");

        //$user->setFirstName($_POST["firstname"]);
        $user->setFirstName($_POST["firstname"]);
        $user->setLastName($_POST["lastname"]);
        $user->setFavoriteDrink($_POST["favoriteDrink"]);
        $user->setAboutMe($_POST["aboutMe"]);
        $user->setChatLayout($_POST["chatLayout"]);

        // Save user
        if ($service->saveUser($user)) {
            $saveSettings = "Erfolgreich gespeichert!";
        }
    }

} catch (Throwable $e) {
    echo "Fehler in Absendung: " . $e;
}

?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nutzerprofil</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>


<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">Chat-App</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mt-1 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="friends.php">Friends</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="settings.php">Settings</a>
                        </li>
                    </ul>
                    <p class="btn navbar-nav">Logged in as:
                        <?php echo $_SESSION["chat_user"]; ?>
                    </p>
                    <a class="btn btn-outline-danger" href="logout.php">Logout</a>
                </div>
            </div>
        </nav>
    </header>
    <main class="bg-light p-3">
        <div class="container ">
            <h1> Profile Settings</h1>
            <hr>

            <form method="post" id="settingsForm" class="was-validated" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <?php $username = $_SESSION["chat_user"];
                $user = $service->loadUser($username); ?>

                <fieldset>
                    <legend>Base Data</legend>

                    <!-- Label and input type text for username -->
                    <div class="form-floating mb-3" id="firstnamediv">
                        <input id="firstname" class="form-control" type="text" placeholder="First Name "
                            name="firstname" value="<?php
                            if ($user->getFirstName() != null):
                                echo $user->getFirstName();
                            else:
                                echo $_SESSION["chat_user"];
                            endif; ?>">

                        <label for="firstname"> First Name </label>

                    </div>



                    <!-- Label and input type text for lastname -->
                    <div class="form-floating mb-3">
                        <input id="lastname" class="form-control" type="text" placeholder="Your surname" name="lastname"
                            required value="<?php
                            if ($user->getLastName() != null):
                                echo $user->getLastName();
                            else:
                                echo "";
                            endif; ?>">

                        <label for="lastname"> Last Name </label>

                    </div>

                    <!-- Label and select for favorite drink -->
                    <div class="form-floating mb-4">

                        <select class="form-select" aria-label="Coffee or Tea" id=coffee name="favoriteDrink" required>
                            <?php $favoriteDrink = $user->getFavoriteDrink(); ?>

                            <option selected disabled value="">Select</option>
                            <option <?php echo ($favoriteDrink == 'Neither nor') ? 'selected' : ''; ?>>Neither nor
                            </option>
                            <option <?php echo ($favoriteDrink == 'Coffee') ? 'selected' : ''; ?>> Coffee </option>
                            <option <?php echo ($favoriteDrink == 'Tea') ? 'selected' : ''; ?>> Tea </option>
                            <option <?php echo ($favoriteDrink == 'Both') ? 'selected' : ''; ?>> Both </option>
                        </select>

                        <label for="coffee"> Select your favorite Drink </label>
                    </div>
                    <hr>
                </fieldset>


                <!-- Label and textarea for about me -->
                <fieldset>
                    <legend> Tell Something About You </legend>

                    <div class="form-floating mb-4">
                        <textarea class="form-control" name="aboutMe" id="aboutMe" placeholder="Leave a comment here"
                            style="height: 100px" required><?php
                            if ($user->getAboutMe() != null):
                                echo $user->getAboutMe();
                            else:
                                echo "";
                            endif; ?></textarea>

                        <label for="floatingTextarea">About me</label>
                    </div>
                    <hr>
                </fieldset>



                <!-- Label and radio buttons for chat layout -->
                <fieldset>
                    <legend> Prefered Chat Layout </legend>

                    <?php $chatLayout = $user->getChatLayout(); ?>
                    <div class="form-check mb-2">
                        <input class="form-check-input" id="oneline" type="radio" name="chatLayout" value="oneLine"
                            required <?php echo ($chatLayout === 'oneLine') ? 'checked' : ''; ?> />
                        <label class="form-check-label" for="oneline"> Username and message in one line </label>
                    </div>

                    <div class="form-check mb-4">
                        <input class="form-check-input" id="separateline" type="radio" name="chatLayout"
                            value="separateLine" required <?php echo ($chatLayout === 'separateLine') ? 'checked' : ''; ?> />
                        <label class="form-check-label" for="separateline"> Username and message in separated lines
                        </label>
                    </div>
                    <hr>
                </fieldset>



                <?php if ($saveSettings !== ""): ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $saveSettings; ?>
                    </div>
                <?php endif; ?>



                <div class="btn-group d-flex mt-1">
                    <a href="friends.php" class="btn btn-secondary w-50" aria-current="page">Cancel</a>
                    <button type="submit" class="btn btn-primary w-50">Save</button>
                </div>
            </form>
        </div>
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>