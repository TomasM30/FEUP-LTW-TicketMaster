<?php
    declare(strict_types=1);
    
    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../templates/common.tpl.php');
    require_once(__DIR__ . '/../utils/session.php');
    require_once(__DIR__ . '/../utils/misc.php');
    require_once(__DIR__ . '/../templates/drawTicketSequence.php');

    $session = new Session();

    if ($session->getUsername() == null) die(header('Location: /../pages/login.php'));

    $db = getDatabaseConnection();

    drawHeader($session->getUsername());
    drawNavBarTicket();
?>
    <div class="ticket-form">
    <form action="/../actions/action_ticket.php" method="post" enctype="multipart/form-data">
        <input type="text" name="title" id="title" placeholder="Title">
        <textarea name="content" id="content" cols="30" rows="10" placeholder="content"></textarea>
        <select name="department">
            <?php
                foreach (Misc::getDepartments($db) as $department){
                    echo "<option value=";
                    echo $department['id'];
                    echo ">";
                    echo $department['name'];
                    echo "</option>";
                }
            ?>
        </select>
        <input type="text" id="hashtags" name="hashtags" placeholder="#">
        <label for="documents"> Annex documents: </label>
        <input type="file" id="documents" name="documents[]" multiple> 
        <input type="submit" value="Create Ticket">
    </form>
</div>

<?php drawFooter(); ?>