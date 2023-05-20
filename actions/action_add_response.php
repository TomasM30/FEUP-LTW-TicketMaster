<?php
declare(strict_types=1);

require_once(__DIR__ . '/../database/ticket.php');
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');

$db = getDatabaseConnection();
$session = new Session();

if ($_SESSION['csrf'] !== $_POST['csrf']) {
    echo "<script>alert('Invalid token')</script>";
    die(header('Location: /../pages/departments.php'));
}

$content = htmlspecialchars($_POST['comment']);
$ticketId = $_POST['ticket_id'];
if (trim($content) == '') {
    echo json_encode('Content cannot be empty');
} else {
    ticket::addResponse($db, $ticketId, $session->getUsername(), htmlspecialchars($content));
    echo json_encode('');
    exit();
}