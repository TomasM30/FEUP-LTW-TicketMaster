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

    static function getTicketHashtagNames(PDO $pdo, int $ticketId): array {
        $stmt = $pdo->prepare("SELECT h.name FROM Link_hashtags lh JOIN Hashtags h ON lh.hashtag_id = h.id WHERE lh.ticket_id = :ticket_id");
        $stmt->bindValue(":ticket_id", $ticketId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    static function getStatusName(PDO $pdo, int $statusId): string {
        $stmt = $pdo->prepare("SELECT name FROM Statuses WHERE id = :status_id");
        $stmt->bindValue(":status_id", $statusId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    static function getAllStatuses(PDO $pdo): array {
        $stmt = $pdo->prepare("SELECT * FROM Statuses");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    static function getAllDepartments(PDO $pdo): array {
        $stmt = $pdo->prepare("SELECT * FROM Department");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    static function getAllHashtags(PDO $pdo): array {
        $stmt = $pdo->prepare("SELECT * FROM Hashtags");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    static function ticketHasHashtag(PDO $pdo, int $ticketId, string $hashtagName): bool {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM Link_hashtags lh JOIN Hashtags h ON lh.hashtag_id = h.id WHERE lh.ticket_id = :ticket_id AND h.name = :hashtag_name");
        $stmt->bindValue(":ticket_id", $ticketId, PDO::PARAM_INT);
        $stmt->bindValue(":hashtag_name", $hashtagName, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }
}
