<?php
declare(strict_types=1);
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/ticket.php');
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../templates/drawTicketSequence.php');
require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../database/faq.php');

$session = new Session();

if ($session->getUsername() == null) die(header('Location: /../pages/login.php'));

$db = getDatabaseConnection();

$username = $session->getUsername();
$ticketId = $_GET['id'] ?? null;
$ticket = ticket::getTicketById($db, $ticketId);
$isAgent = user::isAgent($db, $username);
$statuses = ticket::getAllStatuses($db);
$agents = user::getAgentsByTicketDepartment($db, $ticketId);
$departments = ticket::getAllDepartments($db);
$hashtags = ticket::getAllHashtags($db);
$priorities = ticket::getAllPriorities($db);
$files = ticket::getDocument($db, $ticketId);
$pfp = User::getPfp($db, $username);
?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Ticket Details</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="module" src="../javascript/ticket.js" defer></script>
    <link rel="stylesheet" href="../css/ticket.css">
</head>
<?php drawHeader($session->getUsername()); ?>
<div class="ticketDetails">
    <?php drawNavBarTicket(); ?>
    <input type="hidden" id="ticketId" value="<?php echo $ticket['id'] ?>">
    <div class="ticketContainerBox">
        <!-- todo background on ticketcontainerBox -->
        <h2><?php echo strlen($ticket['subject']) > 33 ? substr($ticket['subject'], 0, 33) . "..." : $ticket['subject'] ?></h2>
        <div class="status-priority">
            <div class="editable">
                <?php
                $statusColor = '';
                if ($ticket['status'] == 0) {
                    $statusColor = 'green';
                } else if ($ticket['status'] == 1) {
                    $statusColor = '#be9801';
                } else {
                    $statusColor = 'red';
                }
                ?>
                <p id="ticketStatus" style="color: <?php echo $statusColor; ?>">
                    <?php echo ticket::getStatusName($db, intval($ticket['status'])); ?>
                </p>
                <?php
                if ($isAgent) { ?>
                    <button class="edit"> &#9998;</button>
                    <!-- todo fix the double click not supposed -->
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
            <?php
            if ($isAgent) { ?>
                <div class="editable">
                    <form class="editForm" id="priorityChangeForm" action="../actions/action_change_priority.php">
                        <input type="hidden" name="ticket_id" value="<?php echo $ticket['id'] ?>">
                        <label for="priority"></label>
                        <select id="priority" name="priority">
                            <?php foreach ($priorities as $priority) {
                                //todo ajax to update agents list
                                $selected = ($priority['id'] === $ticket['priority']) ? 'selected' : ''; ?>
                                <option value="<?php echo $priority['name']; ?>" <?php echo $selected; ?>><?php echo $priority['name']; ?></option>
                            <?php } ?>
                        </select>
                        <input type="submit" value="Submit">
                    </form>
                    <p id='ticketPriority'>
                        Priority: <?php echo ticket::getPriorityName($db, intval($ticket['priority'])); ?></p>
                    <button class="edit"> &#9998;</button>

                </div>
                <?php
            }
            ?>
        </div>
        <div class="infoHeading">
            <div class="authorInfo">
                <img src="<?= $pfp ?>" alt="User" width="50" height="50">
                <h3><?php echo $ticket['author_username'] ?></h3>
            </div>
            <p><?php echo $ticket['date']; ?></p>
        </div>
        <div class="contentBox">
            <fieldset>
                <legend>Content</legend>
                <p><?php echo $ticket['content']; ?></p>
            </fieldset>
        </div>
        <div class="otherInfos">
            <div class="editable" id="agentDivChange">
                <p id="ticketAgent"><?php echo "Agent: " . $ticket['agent_username']; ?></p>
                <?php
                if ($isAgent) {
                    ?>
                    <button class="edit" id='agentEdit'> &#9998;</button>
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
            <div class="editable" id="departmentDivChange">
                <p id='ticketDepartment'><?php
                    $ticketDep = ticket::getDepartmentName($db, intval($ticket['department_id']));
                    echo $ticketDep; ?></p>
                <?php
                if ($isAgent) {
                    ?>
                    <button class="edit"> &#9998;</button>
                    <form class="editForm" action="../actions/action_change_department.php"
                          id="departmentChangeForm">
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
        </div>
        <?php
        $hashtags = ticket::getTicketHashtagNames($db, intval($ticket['id']));
        if (!empty($hashtags)) {
            ?>
            <div class="hashtags">
                <?php
                foreach ($hashtags as $hashtag) {
                    ?>
                    <p>
                        <?php echo $hashtag; ?>
                    </p>
                    <?php
                }
                ?>
            </div>
            <?php
        }
        ?>
        <div class="fileDownload">
            <p>
                <?php
                foreach ($files as $file) {
                    ?>
                    <a href="<?php echo $file ?>" target="_blank" rel="noopener noreferrer">
                        <img src="../images/download.png" alt="Download" width="50" height="50">
                    </a>
                    <?php
                }
                ?>
            </p>
        </div>
    </div>
    <div class="ticketContainerBox">
        <form action="../actions/action_add_response.php" id='responseForm'>
            <input type="hidden" name="ticket_id" value="<?php echo $ticket['id']; ?>">
            <input type="hidden" name="imgPath" value="<?php echo $pfp; ?>">
            <input type="hidden" name="author_username" value="<?php echo $session->getUsername(); ?>">
            <div class="contentBox">
                <fieldset>
                    <legend>Response</legend>
                    <label for="comment"></label>
                    <input list="faq" name="comment" id="comment" placeholder="Write your response here...">
                    <datalist id="faq"></datalist>
                </fieldset>
            </div>
            <input type="submit" value="Submit">
        </form>
    </div>
    <!--todo button toogle between log and comments-->
    <div class="ticketContainerBox" id="responseDiv">
        <?php
        $responses = array_reverse(ticket::getTicketResponses($db, intval($ticket['id'])));
        if ($responses == null) {
            ?>
            <script>document.getElementById('responseDiv').style.display = 'none';</script>
            <?php
        }
        if (!empty($responses)) {
            foreach ($responses as $response) {
                ?>
                <div class="infoHeading">
                    <div class="authorInfo">
                        <img src="<?= $pfp ?>" alt="User" width="50" height="50">
                        <h3><?php echo $response['username'] ?></h3>
                    </div>
                    <p><?php echo $response['date']; ?></p>
                </div>
                <div class="contentBox">
                    <fieldset>
                        <legend>Answer</legend>
                        <p><?php
                            if (strpos($response['content'], '#') !== false) {
                                $response['content'] = preg_replace('/#(\w+)/', '<a href="../pages/faq.php?faq=$1">#$1</a>', $response['content']);
                            }
                            echo $response['content']; ?></p>
                    </fieldset>
                </div>
                <?php
            }
        }
        ?>
    </div>
    <div class="ticketContainerBox">
        <h2>Logs</h2>
        <ul class="log-list">
            <?php
            $logs = ticket::getLogs($db, intval($ticket['id']));
            if (!empty($logs)) {
                foreach ($logs as $log) {
                    ?>
                    <li class="log-item">
                        <p class="log-content"><?php echo $log['content']; ?></p>
                        <p class="log-date"><?php echo $log['date']; ?></p>
                    </li>
                    <?php
                }
            }
            ?>
        </ul>
    </div>
</div>


<?php drawFooter(); ?>
