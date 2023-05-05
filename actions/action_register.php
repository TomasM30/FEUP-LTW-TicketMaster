<?php
    declare(strict_types=1);

    require_once(__DIR__ . '/../database/users.php');
    require_once(__DIR__ . '/../database/connection.db.php');

    $db = getDatabaseConnection();

    $user = User::getUser($db, $_POST['username']);
    $email = User::getEmail($db, $_POST['email']);

    if ($user){
        header('Location: ../pages/register.php?error=1');
        die();
    }
    elseif($email){
        header('Location: ../pages/register.php?error=2');
        die();
    }
    elseif($_POST['password'] != $_POST['password2']){
        header('Location: ../pages/register.php?error=3');
        die();
    }

    $newUser = new User($_POST['username'], $_POST['password'], $_POST['email'], $_POST['name']);
    User::insertUser($db, $newUser);
    header('Location: ../pages/login.php?success=1');

?>