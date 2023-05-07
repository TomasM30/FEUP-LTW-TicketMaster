<?php
declare(strict_types = 1);

require_once(__DIR__ . '/../database/connection.db.php');

require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../templates/ticketPrev.tpl.php');

$db = getDatabaseConnection();

drawHeader('john1');
drawTicketPreview('john1');
drawFooter();
?>