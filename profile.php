<?php require "start.php";
if (!isset($_SESSION["chat_user"])) {
    header("Location: login.php");
    exit();
} ?>

<?php require "start.php";

//username from url
$username = $_GET["friend"];

//check if friends
$friends = $service->loadFriends();

if ($username !== $_SESSION["chat_user"]) {
    //no friends
    if ($friends == null) {
        header("Location: friends.php");
        exit();
    }

    $true_friends = false;
    foreach ($friends as $friend) {
        if ($friend->getUsername() == $username) {
            $true_friends = true;
        }
    }

    if (!$true_friends) {
        header("Location: friends.php");
        exit();
    }
}

$user = $service->loadUser($username);
?>


<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>profile</title>
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
        <div class="container">
            <div class="text-start">
                <h1>Profile of
                    <?php echo $username; ?>
                    <div class="btn-group float-end">
                        <a href="chat.php?friend=<?php echo $username; ?>" class="btn btn-outline-secondary" aria-current="page">&#60; Back to Chat</a>
                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                            data-bs-target="#exampleModal">
                            Remove Friend </button>
                    </div>
                </h1>
            </div>
    </header>

    <main class="container text-center p-3">
        <div class="row text-start">
            <div class="col-md-3">
                <div class="text-end">
                    <img src="files/profile.png" class="img-fluid" alt="chat">
                </div>
            </div>

            <div class="col-md-5">
                <div class="border border-3" style="overflow-y: auto;">
                    <div class="border border-3 p-2" style="min-height: 100px; max-height: 450px; overflow-y: auto;">
                        <dt><b>Name</b></dt>
                        <?php if ($user->getFirstName() != null): ?>
                            <dd>
                                <?php echo $user->getFirstName();
                                echo " ";
                                echo $user->getLastName(); ?>
                            </dd>
                        <?php else: ?>
                            <dd>No information available.</dd>
                        <?php endif; ?>

                        <dt><b>About</b></dt>
                        <?php if ($user->getAboutMe() != null): ?>
                            <dd>
                                <?php echo wordwrap($user->getAboutMe(), 30, "<br>\n", true); ?>
                            </dd>
                        <?php else: ?>
                            <dd>No information available.</dd>
                        <?php endif; ?>

                        <dt><b>Coffee or Tea?</b></dt>
                        <?php if ($user->getFavoriteDrink() != null): ?>
                            <dd>
                                <?php echo $user->getFavoriteDrink(); ?>
                            </dd>
                        <?php else: ?>
                            <dd>No information available.</dd>
                        <?php endif; ?>

                        <dt><b>Chat layout</b></dt>
                        <?php if ($user->getChatLayout() != null): ?>
                            <dd>
                                <?php echo $user->getChatLayout(); ?>
                            </dd>
                        <?php else: ?>
                            <dd>No information available.</dd>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        </div>

        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">

                        <h1 class="modal-title fs-5" id="exampleModalLabel"> Remove
                            <?php echo $username ?> from Friendlist?
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Do you really want to end your Freindship with
                        <?php echo $username ?> ?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <a href="friends.php?remove_friend=<?php echo $username ?>" class="btn btn-primary">Remove</a>
                    </div>
                </div>
            </div>
        </div>



    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <script defer type="text/javascript" src="js/chat.js"></script>

</body>

</html>