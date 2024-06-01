<?php require "start.php";
if (!isset($_SESSION["chat_user"])) {
    header("Location: login.php");
    exit();
}
//load friends
$friends = $service->loadFriends();
//load users
$users = $service->loadUsers();
//load unread messages
$unread = $service->getUnread();
$username = $_SESSION["chat_user"];

//Post Request handling
if (!empty($_POST)) {
    if (isset($_POST["remove_friend"])) {
        $friend_name = $_POST["remove_friend"];
        echo $service->removeFriend($friend_name);
        header("Location: friends.php");
        exit();
    }
    if (isset($_POST["request_friend"])) {
        $friend_name = $_POST["request_name"];
        echo $service->friendRequest($friend_name);
        header("Location: friends.php");
        exit();
    }
    if (isset($_POST["accept_friend"])) {
        $friend_name = $_POST["accept_friend"];
        $service->friendAccept($friend_name);
        header("Location: friends.php");
        exit();
    }
    if (isset($_POST["reject_friend"])) {
        $friend_name = $_POST["reject_friend"];
        $service->friendDismiss($friend_name);
        header("Location: friends.php");
        exit();
    }
}

/*
Das Entfernen von Freundschaften: Diese Funktion wird später in der Chat-Ansicht 
genutzt und muss in der Freundesliste verarbeitet werden. Reagieren Sie geeignet auf
einen Aktionsidentifizierer und rufen Sie die entsprechende Methode am
BackendService auf.
*/
if (!empty($_GET)) {
    if (isset($_GET["remove_friend"])) {
        $friend_name = $_GET["remove_friend"];
        $service->removeFriend($friend_name);
        header("Location: friends.php");
    }
}


?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Friends</title>
    <link rel="preconnect" href="https://rsms.me/">
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <script defer type="text/javascript" src="js/friends_minimal.js"></script>
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
                            <a class="nav-link active" href="friends.php">Friends</a>
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

    <main class="container pt-3 pb-5">
        <div class="box card" id="friendlist">
            <h5 class="card-header">Friends</h5>
            <form action="" method="post" class="card-body">
                <?php
                //check if user has friends
                if (count($friends) == 0) {
                    ?>
                    <p class="textleft">You have no friends ):</p>
                    <?php
                } else {
                    ?>
                    <ul class="list-group">
                        <?php
                        foreach ($friends as $friend) {
                            if ($friend->getStatus() == "accepted") {
                                $friend_name = $friend->getUsername();
                                //check if unread contains the friend_name
                                $unread_count = "";
                                if (isset($unread->$friend_name)) {
                                    $unread_count = $unread->$friend_name;
                                    //if unread count is null or 0, set to empty string
                                    if ($unread_count == null || $unread_count == 0) {
                                        $unread_count = "";
                                    }
                                }

                                ?>
                                <a class="text-decoration-none list-group-item list-group-item-action"
                                    href="chat.php?friend=<?php echo $friend_name ?>">
                                    <?php echo $friend_name ?>
                                    <?php
                                    if ($unread_count != "") { ?>
                                        <span class="float-end bg-primary badge rounded-pill">
                                            <?php echo $unread_count ?>
                                        <?php } ?>
                                    </span>
                                </a>
                                <?php
                            }
                        }
                        ?>
                    </ul>
                    <?php
                }
                ?>
            </form>
        </div>
        <hr class="dottedStripe">
        <?php
        // check if user has friend requests
        $hasFriendRequests = false;
        foreach ($friends as $friend) {
            if ($friend->getStatus() == "requested") {
                $hasFriendRequests = true;
                break;
            }
        }

        if ($hasFriendRequests): ?>
            <div class="box card">
                <h5 class="card-header">New Request</h5>
                <div class="card-body">
                    <div class="list-group">
                        <?php
                        foreach ($friends as $friend) {
                            if ($friend->getStatus() == "requested") {
                                ?>
                                <button type="button" class="list-group-item list-group-item-action" data-bs-toggle="modal"
                                    data-bs-target="#friendModal" data-bs-username="<?php echo $friend->getUsername() ?>">
                                    <?php echo $friend->getUsername() ?>
                                </button>
                                <?php
                            }
                        }

                        ?>
                    </div>
                </div>
            </div>
            <hr class=" dottedStripe">
        <?php endif; ?>

        <div id="flist_container" class="box card">
            <h5 class="card-header">Add friends</h5>
            <form action="" method="post">
                <div class="input-group p-3">
                    <input class="form-control" id="add_friends_text" autocomplete="off"
                        placeholder="Add Friend to List" name="request_name" required />
                    <button type="submit" id="addfriend" class="btn btn-outline-secondary" name="request_friend"
                        value="test">Add</button>
                </div>
            </form>
            <ul class="list-group mx-3" id="flist_group" data-toggle="false" style="display:none">
                <?php
                //compare friends and users to find users that are not friends yet
                try {
                    foreach ($users as $user) {
                        $isFriend = false;
                        foreach ($friends as $friend) {
                            if ($friend->getUsername() == $user || $user == $username) {
                                $isFriend = true;
                            }
                        }
                        if (!$isFriend) {
                            ?>
                            <li class="list-group-item list-group-item-action" data-username="<?php echo $user ?>">
                                <?php echo $user ?>
                            </li>
                            <?php
                        }
                    }
                } catch (Throwable $e) {
                    echo $e;
                }
                ?>
            </ul>
        </div>
        <div class="p-5"></div>
        <div class="p-5"></div>
        <div class="p-5"></div>
    </main>
    <!-- Modal -->
    <div class="modal fade" id="friendModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Request from <span id="modal_name"></span></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Accept Request?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <form action="" method="post">
                        <button id="modal_reject" type=" submit" name="reject_friend" value=""
                            class="btn btn-outline-danger">Reject</button>
                        <button id="modal_accept" type="submit" name="accept_friend" value=""
                            class="btn btn-outline-primary">Accept</button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>

</html>