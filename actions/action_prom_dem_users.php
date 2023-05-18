<?php
    declare(strict_types=1);

    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../utils/session.php');
    require_once(__DIR__ . '/../database/users.php');

    $db = getDatabaseConnection();
    $session = new Session();

    if (isset($_POST['action']) && $_POST['action'] == 'promote'){
        User::promoteUser($db, $_POST['username']);
    } elseif (isset($_POST['action']) && $_POST['action'] == 'demote'){
        User::demoteUser($db, $_POST['username']);
    }

    die(header('Location: /../pages/agents.php'));
?>