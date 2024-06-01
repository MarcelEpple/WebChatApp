<?php require "start.php"; ?>
<!DOCTYPE html>
<html lang="de">

<?php
session_unset();
session_destroy();
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body class="bg-light">
    <main>
        <div class="container text-center pt-5">
            <img src="files/logout.png" alt="chat" class="img-fluid mb-3 rounded-circle" width=200 height=200>
            <div class="row justify-content-center align-items-center">
                <div class="col-6 bg-white p-3 rounded">
                    <div class="card text-center">
                        <div class="card-header">
                            Logged out...
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">See u!</h5>
                            <div class="d-grid gap-2">
                                <a class="btn btn-secondary" href="login.php">Login again</a>
                            </div>
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