<?php
function drawTicketSequence(array $tickets, PDO $db)
{
    if (!empty($tickets)) {
        $statusFilter = $_GET['status'] ?? null;
        $departmentFilter = $_GET['department'] ?? null;
        $hashtagFilter = $_GET['hashtag'] ?? null;
        foreach ($tickets as $ticket) {
            if (($statusFilter != null && $ticket['status'] != $statusFilter) || ($departmentFilter != null && $ticket['department_id'] != $departmentFilter) || ($hashtagFilter != null && !ticket::ticketHasHashtag($db, $ticket['id'], $hashtagFilter))) {
                continue;
            }
            ?>
            <a href="/">
            <div class="ticket">
                <h2><?php echo $ticket['subject']; ?></h2>
                <p><?php echo ticket::getStatusName($db, $ticket['status']); ?></p>
                <p>Assigned agent: <?php echo $ticket['agent_username']; ?></p>
                <p>Date created: <?php echo $ticket['date']; ?></p>
                <p>Department: <?php echo $ticket['department_id']; ?></p>
                <a><?php echo $ticket['content']; ?></a>
                <?php
                $hashtags = ticket::getTicketHashtagNames($db, $ticket['id']);
                if (!empty($hashtags)) {
                    ?>
                    <div class="hashtags">
                        <p>Hashtags:</p>
                        <?php
                        foreach ($hashtags as $hashtag) {
                            ?>
                            <span><?php echo $hashtag; ?></span>
                            <?php
                        }
                        ?>
                    </div>
                    <?php
                }
                ?>
            </div>
            </a>
            <?php
        }
    } else {
        ?>
        <button class=createATicketButton><a href="../pages/create_ticket.php">Create a ticket</a></button>
        <?php
    }

} ?>

<?php
function drawFilter(array $statuses, array $departments, array $hashtags){?>
<form method="get" action="">
    <label for="status">Filter by status:</label>
    <select id="status" name="status">
        <option value="">All</option>
        <?php
        foreach ($statuses as $status) {
            ?>
            <option value="<?php echo $status['id']; ?>" <?php if (isset($_GET['status']) && $_GET['status'] == $status['id']) echo 'selected'; ?>><?php echo $status['name']; ?></option>
            <?php
        }
        ?>
    </select>
    <label for="department">Filter by department:</label>
    <select id="department" name="department">
        <option value="">All</option>
        <?php
        foreach ($departments as $department) {
            ?>
            <option value="<?php echo $department['id']; ?>" <?php if (isset($_GET['department']) && $_GET['department'] == $department['id']) echo 'selected'; ?>><?php echo $department['name']; ?></option>
            <?php
        }
        ?>
    </select>
    <label for="hashtag">Filter by hashtags:</label>
    <select id="hashtag" name="hashtag">
        <option value="">All</option>
        <?php
        foreach ($hashtags as $hashtag) {
            ?>
            <option value="<?php echo $hashtag['name']; ?>" <?php if (isset($_GET['hashtag']) && $_GET['hashtag'] == $hashtag['id']) echo 'selected'; ?>><?php echo $hashtag['name']; ?></option>
            <?php
        }
        ?>
    </select>
    <input type="submit" value="Apply Filter">
    <?php
}
?>
