<?php

declare(strict_types=1);

require_once(__DIR__ . '/../database/users.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../utils/session.php');

$db = getDatabaseConnection();
$session = new Session();
$errors = array();

if(user::sameName($db,$session->getUsername(),$_POST['info'])){
    ?>
    <script>
    window.alert("Insert a different name from the previous one!");
    window.location.href = "../pages/profile.php?error=4";
    </script>
        <?php
    exit;
}

user::changeInfo($db,$session->getUsername(), $_POST['info']);
header('Location: ../pages/profile.php?');
