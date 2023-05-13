<?php
declare(strict_types = 1);

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../templates/ticketPrev.tpl.php');
require_once(__DIR__ . '/../utils/session.php');

$session = new Session();

$db = getDatabaseConnection();


drawHeader($session->getUsername());
drawTicketPreview($session->getUsername());
drawFooter();
?>