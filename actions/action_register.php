<?php
    declare(strict_types=1);

    require_once(__DIR__ . '/../database/users.php');
    require_once(__DIR__ . '/../database/connection.db.php');

    $db = getDatabaseConnection();

    $user = User::getUser($db, $_POST['username']);
    $email = User::getEmail($db, $_POST['email']);
    $errors = array();

    if ($user){
        header('Location: ../pages/register.php?error=1');
        die();
    } elseif (!user::checkUsername($_POST['username'], $errors)) {
        if (!empty($errors)) {
            $error_message = "";
            foreach ($errors as $error) {
                $error_message .= $error . "\n";
            }
            die(header('Location: ../pages/register.php?error=5'));
        }
    }
    elseif($email){
        header('Location: ../pages/register.php?error=2');
        die();
    } elseif (!user::checkEmail($_POST['email'], $errors)) {
        print('1');
        if (!empty($errors)) {
            $error_message = "";
            foreach ($errors as $error) {
                $error_message .= $error . "\\n";
            }
            die(header('Location: ../pages/register.php?error=6'));
        }
    }
    elseif($_POST['password'] != $_POST['password2']){
        header('Location: ../pages/register.php?error=3');
        die();
    }
    elseif (!user::checkPassword($_POST['password'], $errors)) {
        print('2');

        if (!empty($errors)) {
            $error_message = "";
            foreach ($errors as $error) {
                print($error);
                $error_message .= $error . "\n";
            }
            die(header('Location: ../pages/register.php?error=4'));
        }
    } elseif(!user::checkName($_POST['name'], $errors)){
        print('3');

        if (!empty($errors)) {
            $error_message = "";
            foreach ($errors as $error) {
                $error_message .= $error . "\n";
            }
            die(header('Location: ../pages/register.php?error=7'));
        }
    }

    $newUser = new User($_POST['username'], $_POST['password'], $_POST['email'], $_POST['name']);
    User::insertUser($db, $newUser);
    header('Location: ../pages/login.php?success=1');
?>
