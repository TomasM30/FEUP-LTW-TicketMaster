<?php
declare(strict_types=1);


require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/ticket.php');
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../templates/drawTicketSequence.php');
require_once(__DIR__ . '/../templates/common.tpl.php');

$session = new Session();

if ($session->getUsername() == null) die(header('Location: /../pages/login.php'));

$db = getDatabaseConnection();

$username = $session->getUsername();
$ticketId = $_GET['id'] ?? null;
$ticket = ticket::getTicketById($db, $ticketId);
$isAgent = user::isAgent($db, $username);
$statuses = ticket::getAllStatuses($db);
$agents = user::getAllAgents($db);
$departments = ticket::getAllDepartments($db);
$hashtags = ticket::getAllHashtags($db);
$priorities = ticket::getAllPriorities($db);
$files = ticket::getDocument($db, $ticketId);

?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Ticket Details</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="../javascript/ticket.js" defer></script>
</head>
<?php drawHeader($session->getUsername()); ?>
<div class="ticketDetails">
    <?php drawNavBarTicket(); ?>
    <div class="ticket">
        <h2><?php echo $ticket['subject']; ?></h2>
        <h3><?php echo $ticket['author_username'] ?></h3>
        <div class="editable">
            <p id='ticketStatus'><?php echo ticket::getStatusName($db, intval($ticket['status'])); ?></p>
            <?php
            if ($isAgent) { ?>
                <button class="edit" onclick="openStatusMenu()"></button>
                <form class="editForm" id="statusChangeForm">
                    <input type="hidden" name="ticket_id" value="<?php echo $ticket['id'] ?>">
                    <label for="status"></label>
                    <select id="status" name="status">
                        <?php
                        foreach ($statuses as $status) {
                            $selected = ($status['id'] === $ticket['status']) ? 'selected' : ''; ?>
                            <option value="<?php echo $status['name']; ?>" <?php echo $selected; ?>><?php echo $status['name']; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                    <input type="submit" value="Submit">
                </form>
                <?php
            }
            ?>
        </div>
        <div class="editable">
            <p id="ticketAgent">Assigned agent: <?php echo $ticket['agent_username']; ?></p>
            <?php
            if ($isAgent) {
                ?>
                <button class="edit" id='agentEdit' onclick="openAgentsMenu()"><i class="pencil"></i></button>
                <form class="editForm" action="../actions/action_change_agent.php" id="agentChangeForm">
                    <input type="hidden" name="ticket_id" value="<?php echo $ticket['id'] ?>">
                    <label for="agent"></label>
                    <select id="agent" name="agent">
                        <?php foreach ($agents as $agent) {
                            $selected = ($agent['agent_username'] === $ticket['agent_username']) ? 'selected' : ''; ?>
                            <option value="<?php echo $agent['agent_username']; ?>" <?php echo $selected; ?>><?php echo $agent['agent_username']; ?></option>
                        <?php } ?>
                    </select>
                    <input type="submit" value="Submit">
                </form>
            <?php
            if ($ticket['status'] == 0) { ?>
                <script>
                    document.getElementById('agentEdit').style.display = 'none';
                </script>
                <?php
            }
            }
            ?>
        </div>
        <p>Date created: <?php echo $ticket['date']; ?></p>
        <div class="editable">
            <p id='ticketDepartment'>
                Department: <?php echo ticket::getDepartmentName($db, intval($ticket['department_id'])); ?></p>
            <?php
            if ($isAgent) { ?>
                <button class="edit" onclick="openDepartmentMenu()"><i class="pencil"></i></button>
                <form class="editForm" action="../actions/action_change_department.php" id="departmentChangeForm">
                    <input type="hidden" name="ticket_id" value="<?php echo $ticket['id'] ?>">
                    <label for="department"></label>
                    <select id="department" name="department">
                        <?php foreach ($departments as $department) {
                            $selected = ($department['id'] === $ticket['department_id']) ? 'selected' : ''; ?>
                            <option value="<?php echo $department['name']; ?>" <?php echo $selected; ?>><?php echo $department['name']; ?></option>
                        <?php } ?>
                    </select>
                    <input type="submit" value="Submit">
                </form>
                <?php
            }
            ?>
        </div>
        <?php
        if ($isAgent) { ?>
            <div class="editable">
                <p id='ticketPriority'>Priority: <?php echo ticket::getPriorityName($db, intval($ticket['priority'])); ?></p>
                <button class="edit" onclick="openPriorityMenu()"><i class="pencil"></i></button>
                <form class="editForm" action="../actions/action_change_priority.php" id="priorityChangeForm">
                    <input type="hidden" name="ticket_id" value="<?php echo $ticket['id'] ?>">
                    <label for="priority"></label>
                    <select id="priority" name="priority">
                        <?php foreach ($priorities as $priority) {
                            $selected = ($priority['id'] === $ticket['priority']) ? 'selected' : ''; ?>
                            <option value="<?php echo $priority['name']; ?>" <?php echo $selected; ?>><?php echo $priority['name']; ?></option>
                        <?php } ?>
                    </select>
                    <input type="submit" value="Submit">
                </form>
            </div>
            <?php
        }
        ?>
        <P><?php echo $ticket['content']; ?></P>
        <?php
        $hashtags = ticket::getTicketHashtagNames($db, intval($ticket['id']));
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
        <div class='fileDownload'>
            <p>
                Documents:
                <?php
                foreach ($files as $file) {
                    ?>
                    <a href="<?php echo $file ?>" target="_blank"
                       rel="noopener noreferrer"><?php echo basename($file) ?></a>
                    <?php
                }
                ?>
            </p>
        </div>
    </div>
    <div class="ticketResponses" id="responseDiv">
        <?php
        $responses = ticket::getTicketResponses($db, intval($ticket['id']));
        if (!empty($responses)) {
            foreach ($responses as $response) {
                ?>
                <div class="response">
                    <p>User: <?php echo $response['username']; ?></p>
                    <p><?php echo $response['date']; ?></p>
                    <P>Answer: <?php echo $response['content']; ?></P>
                </div>
                <?php
            }
        }
        ?>
    </div>
</div>
<div class="addResponse">
    <form action="../actions/action_add_response.php" id='responseForm'>
        <input type="hidden" name="ticket_id" value="<?php echo $ticket['id']; ?>">
        <input type="hidden" name="author_username" value="<?php echo $session->getUsername(); ?>">
        <label for="comment">Comment:</label><br>
        <textarea name="comment" id="comment" placeholder="Write your response here..." required></textarea>
        <input type="submit" value="Submit">
    </form>
</div>

<div class="logs">
    <h2>Logs</h2>
    <?php
    $logs = Ticket::getLogs($db, intval($ticket['id']));
    if (!empty($logs)) {
        foreach ($logs as $log) {
            ?>
            <div class="log">
                <p><?php echo $log['date']; ?></p>
                <p><?php echo $log['content']; ?></p>
            </div>
            <?php
        }
    }
    ?>


<?php drawFooter(); ?>
