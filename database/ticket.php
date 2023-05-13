<?php
    require_once(__DIR__ . '/../utils/misc.php');
class ticket
{
    static function getClientTickets($db, $username){
        $stmt = $db->prepare('SELECT * FROM ticket WHERE author_username = :username');
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    static function getAgentTickets($db, $username){
        $stmt = $db->prepare('SELECT * FROM ticket WHERE agent_username = :username');
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    static function shorten($string, $maxLength) {
        return substr($string, 0, $maxLength);
    }

    static function getStatus($db, $status){
        $stmt = $db->prepare('SELECT name FROM Statuses WHERE id = :status');
        $stmt->bindParam(':status', $status);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    static function addTicket($db, $author, $department, $subject, $content, $hashtags, $documents){
        
        $getLastId = $db->prepare('SELECT id FROM Ticket ORDER BY id DESC LIMIT 1');
        $getLastId->execute();
        $lastId = $getLastId->fetch()['id'];
        $id = $lastId + 1;
        

        $stmt = $db->prepare('INSERT INTO Ticket (id, author_username, department_id, subject, content, status) VALUES (:id, :author, :department, :subject, :content, 1)');
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':author', $author);
        $stmt->bindParam(':department', $department);
        $stmt->bindParam(':subject', $subject);
        $stmt->bindParam(':content', $content);
        $stmt->execute();

        $seperatedHashtags = explode(' ', $hashtags);
        foreach($seperatedHashtags as $ht){
            Misc::addHashtagToTicket($db, $ht, $id);
        }

        foreach($documents as $doc){
            Misc::addDocumentToTicket($db, $doc, $id);
        }
    }
}
