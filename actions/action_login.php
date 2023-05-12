<?php
    declare(strict_types=1);

    require_once(__DIR__ . '/../database/users.php');
    require_once(__DIR__ . '/../database/connection.db.php');

    $db = getDatabaseConnection();
    $user = User::getUserUsernamePassword($_POST['username'], $_POST['password']);

    if ($user){
        header('Location: ../pages/index.php');
        die();
    }
    header('Location: ../pages/login.php?error=1');

?>