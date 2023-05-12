<?php
    declare(strict_types=1);

    require_once(__DIR__ . '/../database/users.php');
    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../utils/session.php');

    $session = new Session();

    $db = getDatabaseConnection();
    $user = User::getUserUsernamePassword($_POST['username'], $_POST['password']);

    if ($user){
        $session->setUsername($user->username);
        header('Location: ../pages/index.php');
        die();
    }
    header('Location: ../pages/login.php?error=1');
?>