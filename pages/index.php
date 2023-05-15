<?php
declare(strict_types = 1);

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../templates/ticketPrev.tpl.php');
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../utils/misc.php');

$session = new Session();

$db = getDatabaseConnection();
$tickets = misc::getTickets($db, $session->getUsername());

drawHeader($session->getUsername());
drawTicketPreview($db,$tickets);
drawFooter();

if (isset($_GET['success']) && $_GET['success'] == 1){
    echo "<script>alert('Succesfully created the ticket!');</script>";
}
?>