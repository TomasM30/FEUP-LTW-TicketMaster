<?php
declare(strict_types=1);


require_once(__DIR__ . '/../database/ticket.php');
require_once(__DIR__ . '/../database/connection.db.php');

$db = getDatabaseConnection();
$ticketId = $_GET['ticket_id'];
$status = $_GET['status'];
ticket::changeStatus($db, $ticketId, $status);
header('Location: ../pages/ticket_details.php?id=' . $ticketId);

