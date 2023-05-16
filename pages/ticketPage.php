<?php
declare(strict_types=1);

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/ticket.php');
require_once(__DIR__ . '/../database/users.php');
require_once(__DIR__ . '/../utils/session.php');
require_once (__DIR__ . '/../templates/drawTicketSequence.php');
require_once (__DIR__ . '/../templates/common.tpl.php');
require_once (__DIR__ . '/../utils/misc.php');

$session = new Session();
if ($session->getUsername() == null) die(header('Location: /../pages/login.php'));

$db = getDatabaseConnection();

drawHeader($session->getUsername());
$username = $session->getUsername();

$tickets = misc::getTickets($db, $username);
$statuses = ticket::getAllStatuses($db);
$departments = ticket::getAllDepartments($db);
$hashtags = ticket::getAllHashtags($db);
$agents = user::getAllAgents($db);
$priorities = ticket::getAllPriorities($db);

?>
<div class="ticketPage">
    <?php drawNavBarTicket();
    if(user::isAgent($db, $username)){
        ?>
        <div class = "filtering-box">
            <?php
            drawFilter($statuses, $departments, $hashtags, $agents, $priorities);
            ?>
        </div>
        <?php
    }
    ?>
    <div class="ticketContentBox">
        <?php
        drawTicketSequence($tickets, $db);
        ?>
    </div>
</div>



<?php drawFooter(); ?>
