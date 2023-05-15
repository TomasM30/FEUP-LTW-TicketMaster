<?php
declare(strict_types=1);

require_once(__DIR__ . '/../database/ticket.php');
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');

$db = getDatabaseConnection();
$session = new Session();
$content = $_POST['comment'];
$ticketId = $_POST['ticket_id'];
if (trim($content) == '') {
    ?>
    <script>
        window.location.href = "../pages/ticket_details.php?id=<?php echo $ticketId; ?>";
        window.alert("Please write something!");
    </script>
    <?php
    exit();
} else {
    ticket::addResponse($db, $ticketId, $session->getUsername(), $content);
    header('Location: ../pages/ticket_details.php?id=' . $ticketId);
}