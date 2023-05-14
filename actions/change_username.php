<?php

declare(strict_types=1);


require_once(__DIR__ . '/../database/users.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../utils/session.php');

$db = getDatabaseConnection();
$session = new Session();
$user = User::getUser($db, $_POST['username']);

if(user::sameUName($db,$session->getUsername(),$_POST['username'])){
    ?>
    <script>
        window.alert("Insert a different username from the previous one!");
        window.location.href = "../pages/profile.php?error=5";
    </script>
    <?php
    exit;
} elseif ($user){
    ?>
    <script>
        window.alert("Username already in use!");
        window.location.href = "../pages/profile.php?error=6";
    </script>
    <?php
    exit;
}

user::changeUName($db,$session->getUsername(), $_POST['username']);
header('Location: ../pages/login.php?success=4');
