<?php
    declare(strict_types=1);
    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../utils/session.php');
    require_once(__DIR__ . '/../database/users.php');

    $db = getDatabaseConnection();
    $session = new Session();

    if (isset($_POST['action']) && $_POST['action'] == 'assign'){
        User::assignAgentToDepartment($db, $_POST['username'], $_POST['department']);
    } elseif (isset($_POST['action']) && $_POST['action'] == 'unassign'){
        User::removeAgentFromDepartment($db, $_POST['username'], $_POST['department']);
    }

    die(header('Location: /../pages/agents.php'));
?>