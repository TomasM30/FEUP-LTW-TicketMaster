<?php
declare(strict_types = 1);

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../templates/ticketPrev.tpl.php');
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../utils/misc.php');

$session = new Session();

$db = getDatabaseConnection();
if ($session->getUsername() == null) die(header('Location: /../pages/login.php'));

$tickets = ticket::getTickets($db, $session->getUsername());
?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Ticket Master</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="../javascript/scripts.js" defer></script>
    <link rel="stylesheet" href="../css/cards.css">
</head>
<?php
drawHeader($session->getUsername());
drawTicketPreview($db,$tickets);
drawFooter();
?>