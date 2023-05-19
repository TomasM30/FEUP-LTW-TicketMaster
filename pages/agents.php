<?php
declare(strict_types=1);

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../database/users.php');

$db = getDatabaseConnection();
$session = new Session();
$username = $session->getUsername();

if ($username == null) die(header('Location: /../pages/login.php'));


drawHeader($username);

$agents = user::getAgentsInfo($db);
?>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="../javascript/showHideForm.js" defer></script>
        <link rel="stylesheet" href="../css/agents.css">
        <title>Team</title></head>
    <h1>Our Team</h1>
    <table>
        <tr>
            <th></th>
            <th>Username</th>
            <th>Name</th>
            <th>Role</th>
        </tr>
        <?php foreach ($agents as $agent) { ?>
            <tr>
                <td><img src="<?= $agent['image_url'] ?>" alt="Agent image" width=50 height=50></td>
                <td><?= $agent['username'] ?></td>
                <td><?= $agent['name'];
                    ?></td>
                <td><?php if (user::isAdmin($db, $agent['username'])) {
                        echo "Admin";
                    } else {
                        echo "Agent";
                    } ?></td>
            </tr>
        <?php } ?>
    </table>

<?php
if (user::isAdmin($db, $username)) {
    //todo add a button to make a agent be on a department
    //todo style the button better
    ?>
    <button type="button" id="showAgForm" name="showAgForm">Promote/Demote Users</button>
    <form id="modifyUsers" method="POST" action="../actions/action_prom_dem_users.php">
        <input type="text" name="username" placeholder="Enter Username">
        <button name="add-rm" id="promote-demote" type="button">Promote</button>
        <input type="hidden" id="action_input" name="action" value="promote">
        <input type="submit" value="Submit">
    </form>
    <?php
}
?>


<?php drawFooter(); ?>