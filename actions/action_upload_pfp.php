<?php
    declare(strict_types=1);

    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../utils/session.php');
    require_once(__DIR__ . '/../database/uploads.php');

    $db = getDatabaseConnection();
    $session = new Session();
    $username = $session->getUsername();

    $path = Upload::uploadFile($username, true);
    var_dump($path);
    
    $stmt = $db->prepare ('UPDATE User SET image_url = :url WHERE username = :username');
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':url', $path[0]);
    $stmt->execute();

    header('Location: /../pages/profile.php')

?>