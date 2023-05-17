<?php
declare(strict_types=1);

require_once(__DIR__ . '/../database/ticket.php');
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');

$db = getDatabaseConnection();
$session = new Session();
$content = $_GET['content'];
$ticketId = $_GET['ticket_id'];
if (trim($content) == '') {
    echo json_encode('Content cannot be empty');
} else {
    ticket::addResponse($db, $ticketId, $session->getUsername(), $content);
    echo json_encode('');
    exit();
}