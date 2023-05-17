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

    <link rel="stylesheet" href="../css/team.css">
    <h1>Agents</h1>

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