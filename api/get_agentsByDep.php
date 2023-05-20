<?php
require_once '../utils/session.php';
require_once '../database/ticket.php';
require_once '../database/connection.db.php';

$session = new Session();
$session->generateToken();

if ($session->getUsername() == null) die(header('Location: /../pages/login.php'));

$db = getDatabaseConnection();

if (isset($_GET['department'])) {
    $departmentId = ticket::getDepartmentId($db,htmlspecialchars($_GET['department']));
    $agents = user::getAgentsByDepartment($db, $departmentId);
    if(count($agents) == 0){
        ticket::changeAgent($db, htmlspecialchars($_GET['ticket_id']), null);
    } else{
        ticket::changeAgent($db, htmlspecialchars($_GET['ticket_id']), $agents[0]['agent_username']);
    }
    echo json_encode($agents);
}
