<?php

class ticket
{
    public int $id;
    public string $author;
    public int $depId;
    public string $assignedTo;
    public string $subject;
    public string $description;
    public int $statusId;
    public string $dateCreated;
    public int $priorityId;

    public function __construct(int $id, string $author, int $depId, string $assignedTo, string  $subject, string $description, int $statusId, string $dateCreated, int $priorityId){
        $this->id = $id;
        $this->author = $author;
        $this->depId = $depId;
        $this->assignedTo = $assignedTo;
        $this->subject = $subject;
        $this->description = $description;
        $this->statusId = $statusId;
        $this->dateCreated = $dateCreated;
        $this->priorityId = $priorityId;
    }

    static function getUserTickets($db, $username){
        $stmt = $db->prepare('SELECT * FROM ticket WHERE author_username = :username');
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

}
