<?php
declare(strict_types=1);
error_reporting(E_ALL);
ini_set('display_errors', "1");

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/ticket.php');
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../templates/drawTicketSequence.php');
require_once(__DIR__ . '/../templates/common.tpl.php');

$session = new Session();

if ($session->getUsername() == null) die(header('Location: /../pages/login.php'));

$db = getDatabaseConnection();

drawHeader($session->getUsername());
$username = $session->getUsername();
$ticketId = $_GET['id'] ?? null;
$ticket = ticket::getTicketById($db, $ticketId);
$isAgent = user::isAgent($db, $username);
$statuses = ticket::getAllStatuses($db);
$agents = user::getAllAgents($db);
$departments = ticket::getAllDepartments($db);
$hashtags = ticket::getAllHashtags($db);
$priorities = ticket::getAllPriorities($db);

?>
<div class="ticketDetails">
    <?php drawNavBarTicket(); ?>
    <div class="ticket">

        <h2><?php echo $ticket['subject']; ?></h2>
        <div class="editable">
            <p><?php echo ticket::getStatusName($db, $ticket['status']); ?></p>
            <?php
            if ($isAgent) { ?>
                <button class="edit" onclick="openStatusMenu()"><i class="pencil"></i></button>
                <form class="editForm" method="get" action="../actions/action_change_status.php" id="statusChangeForm">
                    <input type="hidden" name="ticket_id" value="<?php echo $ticket['id'] ?>">
                    <label for="status"></label>
                    <select id="status" name="status">
                        <?php
                        foreach ($statuses as $status) {
                            $selected = ($status['id'] === $ticket['status']) ? 'selected' : ''; ?>
                            <option value="<?php echo $status['id']; ?>"<?php echo $selected; ?>><?php echo $status['name']; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                    <input type="submit" value="">
                </form>
                <?php
            }
            ?>
        </div>
        <div class="editable">
            <p>Assigned agent: <?php echo $ticket['agent_username']; ?></p>
            <?php
            if ($isAgent) {
                if ($ticket['status'] != 0){
                ?>
                    <button class="edit" onclick="openAgentsMenu()"><i class="pencil"></i></button>
                    <form class="editForm" method="get" action="../actions/action_change_agent.php" id="agentChangeForm">
                        <input type="hidden" name="ticket_id" value="<?php echo $ticket['id'] ?>">
                        <label for="agent"></label>
                        <select id="agent" name="agent">
                            <?php foreach ($agents as $agent) {
                                $selected = ($agent['agent_username'] === $ticket['agent_username']) ? 'selected' : ''; ?>
                                <option value="<?php echo $agent['agent_username']; ?>" <?php echo $selected; ?>><?php echo $agent['agent_username']; ?></option>
                            <?php } ?>
                        </select>
                        <input type="submit" value="">
                    </form>
                <?php
                } elseif ($ticket['agent_username'] != Null){
                    ticket::changeAgent($db, $ticket['id'], Null);
                    header("Location: ../pages/ticket_details.php?id=" . $ticket['id']);
                }
            }
            ?>
        </div>
        <p>Date created: <?php echo $ticket['date']; ?></p>
        <div class="editable">
            <p>Department: <?php echo $ticket['department_id']; ?></p>
            <?php
            if ($isAgent) { ?>
                <button class="edit" onclick="openDepartmentMenu()"><i class="pencil"></i></button>
                <form class="editForm" method="get" action="../actions/action_change_department.php"
                      id="departmentChangeForm">
                    <input type="hidden" name="ticket_id" value="<?php echo $ticket['id'] ?>">
                    <label for="department"></label>
                    <select id="department" name="department">
                        <?php foreach ($departments as $department) {
                            $selected = ($department['id'] === $ticket['department_id']) ? 'selected' : ''; ?>
                            <option value="<?php echo $department['id']; ?>" <?php echo $selected; ?>><?php echo $department['name']; ?></option>
                        <?php } ?>
                    </select>
                    <input type="submit" value="">
                </form>
                <?php
            }
            ?>
        </div>
        <?php
        if ($isAgent) { ?>
            <div class="editable">
                <p>Priority: <?php echo $ticket['priority']; ?></p>
                <button class="edit" onclick="openPriorityMenu()"><i class="pencil"></i></button>
                <form class="editForm" method="get" action="../actions/action_change_priority.php"
                      id="priorityChangeForm">
                    <input type="hidden" name="ticket_id" value="<?php echo $ticket['id'] ?>">
                    <label for="priority"></label>
                    <select id="priority" name="priority">
                        <?php foreach ($priorities as $priority) {
                            $selected = ($priority['id'] === $ticket['priority']) ? 'selected' : ''; ?>
                            <option value="<?php echo $priority['id']; ?>" <?php echo $selected; ?>><?php echo $priority['name']; ?></option>
                        <?php } ?>
                    </select>
                    <input type="submit" value="">
                </form>
            </div>
            <?php
        }
        ?>
        <article><?php echo $ticket['content']; ?></article>
        <?php
        $hashtags = ticket::getTicketHashtagNames($db, $ticket['id']);
        if (!empty($hashtags)) {
            ?>
            <div class="hashtags">
                <p>Hashtags:
                    <?php
                    foreach ($hashtags as $hashtag) {
                        ?>
                        <?php echo $hashtag; ?>
                        <?php
                    }
                    ?>
                </p>
            </div>
            <?php
        }
        ?>
    </div>
    <div class="ticketResponses">
        <?php
        $responses = ticket::getTicketResponses($db, $ticket['id']);
        if (!empty($responses)) {
            foreach ($responses as $response) {
                ?>
                <div class="response">
                    <p><?php echo $response['username']; ?></p>
                    <p><?php echo $response['date']; ?></p>
                    <article><?php echo $response['content']; ?></article>
                </div>
                <?php
            }
        }
        ?>
    </div>
    <div class="addResponse">
        <form action="../actions/action_add_response.php" method="post">
            <input type="hidden" name="ticket_id" value="<?php echo $ticket['id']; ?>">
            <label for="comment">Comment:</label><br>
            <textarea name="comment" id="comment" placeholder="Write your response here..." required></textarea>
            <input type="submit" value="Submit">
        </form>
    </div>


    <?php drawFooter(); ?>
