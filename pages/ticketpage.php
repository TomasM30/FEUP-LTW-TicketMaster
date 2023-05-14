<?php
declare(strict_types=1);
error_reporting(E_ALL);
ini_set('display_errors', "1");

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/ticket.php');
require_once(__DIR__ . '/../utils/session.php');
require_once (__DIR__ . '/../templates/drawTicketSequence.php');
require_once (__DIR__ . '/../templates/common.tpl.php');

$session = new Session();
$db = getDatabaseConnection();

drawHeader($session->getUsername());
$username = $session->getUsername();
$tickets = ticket::getClientTickets(getDatabaseConnection(), $username);
$statuses = ticket::getAllStatuses($db);
$departments = ticket::getAllDepartments($db);
$hashtags = ticket::getAllHashtags($db);

?>
<div class="ticketPage">
    <nav id="navBarTicket">
        <ul>
            <li><a href="../pages/create_ticket.php">Create Ticket</a></li>
        </ul>
    </nav>
    <div class = "filtering-box">
        <?php
        drawFilter($statuses, $departments, $hashtags);
        ?>
    </div>
    <div class="ticketContentBox">
        <?php
        drawTicketSequence($tickets, $db);
        ?>
    </div>
</div>



<?php drawFooter(); ?>
