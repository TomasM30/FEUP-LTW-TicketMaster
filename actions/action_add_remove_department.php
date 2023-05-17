<?php
    declare(strict_types=1);
    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../utils/session.php');
    require_once(__DIR__ . '/../utils/misc.php');

    $db = getDatabaseConnection();
    $session = new Session();

    if (isset($_POST['action']) && $_POST['action'] == 'add'){
        Misc::addDepartment($db, $_POST['department']);
    } elseif (isset($_POST['action']) && $_POST['action'] == 'remove'){
        Misc::removeDepartment($db, $_POST['department']);
    }

    die(header('Location: /../pages/departments.php'));
?>