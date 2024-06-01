<?php require "start.php";

if (isset($_SESSION["chat_user"])) {
    //if user is logged in    
    //redirect to friends.php
    header("Location: friends.php");
    exit();
}
$wrongsignin = false;
if (isset($_POST["action"])) {
    if ($_POST["action"] == "login") {
        $username = $_POST["username"];
        $password = $_POST["password"];
        if ($service->login($username, $password)) {
            $_SESSION["chat_user"] = $username;
            header("Location: friends.php");
            exit();
        } else {
            $wrongsignin = true;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
                    <a class="btn btn-outline-success" href="register.php">Register</a>
                </div>
        </nav>
    </header>
    <main class="container">
        <div class="container text-center pt-5">
            <img src="files/chat.png" alt="chat" class="img-fluid mb-3 rounded-circle" width=200 height=200>
            <div class="row justify-content-center align-items-center">
                <div class="col-6 p-3 rounded">
                    <div class="card text-center">
                        <div class="card-header">
                            Please Sign in
                        </div>
                        <div class="card-body">
                            <form method="post" action="login.php">
                                <div class="input-group flex-nowrap pb-3">
                                    <span class="input-group-text w-25" id="addon-wrapping">Username</span>
                                    <input type="text" class="form-control" placeholder="Username" aria-label="Username"
                                        aria-describedby="addon-wrapping" name="username" id="username">
                                </div>
                                <div class="input-group flex-nowrap pb-4">
                                    <label for="password" class="input-group-text w-25"
                                        id="addon-wrapping">Password</label>
                                    <input type="password" class="form-control" placeholder="Password"
                                        aria-label="Username" aria-describedby="addon-wrapping" name="password"
                                        id="password">
                                </div>
                                <div class="formheader">
                                    <?php
                                    if ($wrongsignin) { ?>
                                        <p style="color:red">Wrong username or password!</p>
                                    <?php }
                                    ?>
                                </div>
                                <a class="btn btn-secondary" href="register.php">
                                    Register
                                </a>
                                <button class="btn btn-primary" type="submit" name="action" value="login">Login</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>