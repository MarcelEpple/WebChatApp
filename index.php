<?php require "start.php"; ?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
    <link rel="preconnect" href="https://rsms.me/">
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <script defer type="text/javascript" src="js/index.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body class="container py-5">
    <h2 class="mb-4">Landing Page</h2>
    <hr>
    <h3 class="mb-4">All Pages:</h3>
    <ul class="list-group mb-4">
        <a class="list-group-item list-group-item-action" href="login.php">Login</a>
        <a class="list-group-item list-group-item-action"href="register.php">Register</a>
        <a class="list-group-item list-group-item-action" href="friends.php">Friends</a>
        <a class="list-group-item list-group-item-action" href="logout.php">Logout</a></li>
        <a class="list-group-item list-group-item-action" href="settings.php">Settings</a>
        <a class="list-group-item list-group-item-action" href="chat.php">Chat</a>
        <a class="list-group-item list-group-item-action" href="profile.php">Profile</a>
    </ul>

    <hr>
    <h3 class="mb-4"> <a href="https://online-lectures-cs.thi.de/chat/helper/c546cc42-1c6a-4fcb-8800-b9bb74e72452#Tom"
            target="_blank" class="btn btn-info">Helper</a></h1>
    </h3>
    <hr>

    <h3 class="mb-4">
        <?php
        if (isset($_SESSION["chat_user"])) {
            echo "Current user: " . $_SESSION["chat_user"];
        } else {
            echo "No user logged in";
        }
        ?>
    </h3>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>