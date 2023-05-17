<?php

    declare(strict_types=1);

    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../utils/session.php');
    require_once(__DIR__ . '/../templates/common.tpl.php');

    $db = getDatabaseConnection();
    $session = new Session();
    if ($session->getUsername() == null) die(header('Location: /../pages/login.php'));

    drawHeader($session->getUsername());

    $stmt = $db->prepare('SELECT * FROM department');
    $stmt->execute();
    $departments = $stmt->fetchAll();
    $stmt = $db->prepare('SELECT * FROM link_departments');
    $stmt->execute();
    $link_departments = $stmt->fetchAll();

?>
    <link rel="stylesheet" href="../css/departments.css">

    <h1>Departments</h1>
    <table>
        <tr>
            <th>Name</th>
            <th>ID</th>
            <th>Number of agents assigned</th>
        </tr>
        <?php foreach ($departments as $department) { 
                $num_agents = 0;
            ?>
            <tr>
                <td><?= $department['name'] ?></td>
                <td><?= $department['id'] ?></td>
                <?php foreach ($link_departments as $link_department) { 
                     if ($link_department['department_id'] == $department['id']) { $num_agents++; } }?>
                <td><?= $num_agents ?></td>
            </tr>
        <?php } ?>
    </table>

    <button type="button" id="showDepForm" name="showDepForm">Add/Remove Departments</button>
        <form id="modifyDeps" method="POST" action="../actions/action_add_remove_department.php">
            <input type="text" name="department" placeholder="Enter Department Name">
            <label for="add-rm" id="add-rmLabel">Add</label>
            <button name="add-rm" id="add-rm" type="button">Change action</button> 
            <input type="hidden" id="action_input" name="action" value="add">  
            <input type="submit" value="Submit">
        </form>

<?php
    drawFooter();
?>