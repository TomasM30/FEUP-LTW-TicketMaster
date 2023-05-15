<?php
    require_once(__DIR__ . '/../utils/misc.php');
class ticket
{

    static public function getClientTickets($db, $username){
        $stmt = $db->prepare('SELECT * FROM ticket WHERE author_username = :username');
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    static  public function getUnassignedTickets($db){
        $stmt = $db->prepare('SELECT * FROM ticket WHERE agent_username IS NULL');
        $stmt->execute();
        return $stmt->fetchAll();
    }

    static public function getTicketById($db, $id){
        $stmt = $db->prepare('SELECT * FROM ticket WHERE id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    static public function getAgentTickets($db, $username){
        $stmt = $db->prepare('SELECT * FROM ticket WHERE agent_username = :username');
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    static public function shorten($string, $maxLength) {
        return substr($string, 0, $maxLength);
    }

    static public function getStatus($db, $status){
        $stmt = $db->prepare('SELECT name FROM Statuses WHERE id = :status');
        $stmt->bindParam(':status', $status);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    static public function addResponse($db,  $ticketId, $username, $content){
        $getLastId = $db->prepare('SELECT id FROM comment ORDER BY id DESC LIMIT 1');
        $getLastId->execute();
        $lastId = $getLastId->fetch()['id'];
        $id = $lastId + 1;

        $content = trim($content);

        $stmt = $db->prepare('INSERT INTO comment (id, ticket_id, username, content) VALUES (:id,:ticketId,:username, :content)');
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':ticketId', $ticketId);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':content', $content);
        $stmt->execute();
    }


    static public function addTicket($db, $author, $department, $subject, $content, $hashtags, $documents){
        
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

    static public function getTicketHashtagNames(PDO $db, int $ticketId): array {
        $stmt = $db->prepare("SELECT h.name FROM Link_hashtags lh JOIN Hashtags h ON lh.hashtag_id = h.id WHERE lh.ticket_id = :ticket_id");
        $stmt->bindValue(":ticket_id", $ticketId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    static public function getStatusName(PDO $db, int $statusId): string {
        $stmt = $db->prepare("SELECT name FROM Statuses WHERE id = :status_id");
        $stmt->bindValue(":status_id", $statusId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    static public function getAllStatuses(PDO $db): array {
        $stmt = $db->prepare("SELECT * FROM Statuses");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    static public function getAllDepartments(PDO $db): array {
        $stmt = $db->prepare("SELECT * FROM Department");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    static public function getAllHashtags(PDO $db): array {
        $stmt = $db->prepare("SELECT * FROM Hashtags");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    static public function ticketHasHashtag(PDO $db, int $ticketId, string $hashtagName): bool {
        $stmt = $db->prepare("SELECT COUNT(*) FROM Link_hashtags lh JOIN Hashtags h ON lh.hashtag_id = h.id WHERE lh.ticket_id = :ticket_id AND h.name = :hashtag_name");
        $stmt->bindValue(":ticket_id", $ticketId);
        $stmt->bindValue(":hashtag_name", $hashtagName);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    static public function getTicketResponses(PDO $db, int $ticketId): array {
        $stmt = $db->prepare("SELECT * FROM Comment WHERE ticket_id = :ticket_id");
        $stmt->bindValue(":ticket_id", $ticketId);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    static public function changeStatus($db, $ticketId, $status){
        $stmt = $db->prepare('UPDATE Ticket SET status = :status WHERE id = :ticketId');
        $stmt->bindParam(':ticketId', $ticketId);
        $stmt->bindParam(':status', $status);
        $stmt->execute();
    }
    static public function changeAgent($db, $ticketId, $agent){
        $stmt = $db->prepare('UPDATE Ticket SET agent_username = :agent WHERE id = :ticketId');
        $stmt->bindParam(':ticketId', $ticketId);
        $stmt->bindParam(':agent', $agent);
        $stmt->execute();
    }
}
