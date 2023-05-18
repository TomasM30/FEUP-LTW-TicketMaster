<?php
declare(strict_types=1);

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../templates/common.tpl.php');

$db = getDatabaseConnection();
$session = new Session();

if ($session->getUsername() == null) die(header('Location: /../pages/login.php'));


drawHeader($session->getUsername());

$stmt = $db->prepare('SELECT * FROM Agent JOIN User on username = agent_username');
$stmt->execute();
$agents = $stmt->fetchAll();
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
        </tr>
        <?php foreach ($agents as $agent) { ?>
            <tr>
                <td><img src="<?= $agent['image_url'] ?>" alt="Agent image" width=50 height=50></td>
                <td><?= $agent['username'] ?></td>
                <td><?= $agent['name'] ?></td>
            </tr>
        <?php } ?>
    </table>
    <button type="button" id="showAgForm" name="showAgForm">Promote/Demote Users</button>
    <form id="modifyUsers" method="POST" action="../actions/action_prom_dem_users.php">
        <input type="text" name="username" placeholder="Enter Username">
        <button name="add-rm" id="promote-demote" type="button">Promote</button>
        <input type="hidden" id="action_input" name="action" value="promote">
        <input type="submit" value="Submit">
    </form>


<?php drawFooter(); ?>