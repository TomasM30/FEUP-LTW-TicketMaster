<?php
declare(strict_types=1);


require_once(__DIR__ . '/../database/ticket.php');
require_once(__DIR__ . '/../database/connection.db.php');

$db = getDatabaseConnection();
$ticketId = $_GET['ticket_id'];
$department = $_GET['department'];
ticket::changeDepartment($db, $ticketId, $department);
header('Location: ../pages/ticket_details.php?id=' . $ticketId);

