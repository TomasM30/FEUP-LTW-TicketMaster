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
    <head><script src="../javascript/showhideform.js" defer></script></head>
    <h1>Our Team</h1>
    <button type="button" id="showAgForm" name="showAgForm">Promote/Demote Users</button>
        <form id="modifyUsers" method="POST" action="../actions/action_prom_dem_users.php">
            <input type="text" name="username" placeholder="Enter Username">
            <label for="add-rm" id="promote-demoteLabel">Promote</label>
            <button name="add-rm" id="promote-demote" type="button">Change action</button> 
            <input type="hidden" id="action_input" name="action" value="promote">  
            <input type="submit" value="Submit">
        </form>
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


<?php drawFooter(); ?>