<?php require "start.php";
if (!isset($_SESSION["chat_user"])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION["chat_user"];
$chat_partner = $_GET["friend"];

//check if user has someone to chat with that is not himself
if (!isset($chat_partner)) {
    header("Location: friends.php");
    exit;
}

if ($chat_partner == $username) {
    header("Location: friends.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
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
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mt-1 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="friends.php">Friends</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="settings.php">Settings</a>
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
    <main class="p-3">
        <div class="container">

            <header>
                <div class="text-start">
                    <h1 id="chat_with"> Chat with <span id="chat_partner">
                            <?php echo $chat_partner; ?>
                        </span>
                        <div class="btn-group float-end">
                            <a href="friends.php" class="btn btn-outline-secondary" aria-current="page">&#60; Back</a>
                            <a href="profile.php?friend=<?php echo $chat_partner ?>"
                                class="btn btn-outline-secondary">Profile</a>
                            <button type="button" class="btn btn-outline-danger" onclick="openModal()"> Remove Friend
                            </button>
                        </div>

                    </h1>
                </div>
                <hr>
            </header>




            <!-- Chat Container -->
            <div class=card style="height: 50%;">
                <div class="card-body overflow-auto " id="chat_container">
                    <!-- Messages will be displayed here -->
                </div>
            </div>

            <hr>

            <!-- Message Input & Button-->
            <div class="input-group mb-3">
                <input type="text" id="text" class="form-control" placeholder="New Message" aria-label="New Message"
                    aria-describedby="button-addon2">
                <button class="btn btn-primary" type="button" id="sendMessage">Send</button>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="chatModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">

                            <h1 class="modal-title fs-5" id="chatModalHeader">
                                Remove
                                <?php echo $chat_partner; ?> as friend?
                            </h1>

                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body" id="chatModalBody">
                            Do you really want to remove
                            <?php echo $chat_partner; ?> as friend?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <a href="friends.php?remove_friend=<?php echo $chat_partner ?>"
                                class="btn btn-primary">Yes</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <script defer type="text/javascript" src="js/chat.js"></script>

    </div>

</body>

</html>