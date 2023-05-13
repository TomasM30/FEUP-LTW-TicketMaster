<?php
    declare(strict_types=1);
    error_reporting(E_ALL);
    ini_set('display_errors', '1');

    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/ticket.php');
    require_once(__DIR__ . '/../utils/session.php');

    $session = new Session();
    $db = getDatabaseConnection();

    $title = $_POST['title'];
    $content = $_POST['content'];
    $hashtags = $_POST['hashtags'];
    $department = $_POST['department'];
    if (isset($_POST['documents'])) {
        $documents = $_POST['documents'];
        ticket::addTicket($db, $session->getUsername(), $department, $title, $content, $hashtags, $documents);

    } else {
        ticket::addTicketWDoc($db, $session->getUsername(), $department, $title, $content, $hashtags);
    }
    header('Location: ../pages/index.php');
    exit();

