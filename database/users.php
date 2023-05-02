<?php
    $db = new PDO('sqlite:ticketingdb.db');

    function insertUser($username, $name, $password, $email){
        global $db;
        $stmt = $db->prepare('INSERT INTO users (username, name, password, email) VALUES (:username, :name, :password, :email)');
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
    }

    function deleteUser($username){
        global $db;
        $stmt = $db->prepare('DELETE FROM users WHERE username = :username');
        $stmt->bindParam(':username', $username);
        $stmt->execute();
    }

    function editUserProfile($username, $name, $email){
        global $db;
        $stmt = $db->prepare('UPDATE users SET name = :name, email = :email WHERE username = :username');
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
    }

    function getUser($username){
        global $db;
        $stmt = $db->prepare('SELECT * FROM users WHERE username = :username');
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->fetch();
    }

    function getClient($username){
        global $db;
        $stmt = $db->prepare('SELECT * FROM client WHERE client_username = :username');
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->fetch();
    }

    function getAgent($username){
        global $db;
        $stmt = $db->prepare('SELECT * FROM agent WHERE agent_username = :username');
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->fetch();
    }

    function getAdmin($username){
        global $db;
        $stmt = $db->prepare('SELECT * FROM admin WHERE admin_username = :username');
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->fetch();
    }
?>


