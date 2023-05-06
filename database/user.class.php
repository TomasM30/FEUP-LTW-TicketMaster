<?php
declare(strict_types=1);

class User
{
    public int $id;
    public string $username;
    public string $email;
    public string $name;
    public string $image_url;

    public function __construct(int $id,string $username, string $email, string $name, string $image_url)
    {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->name = $name;
        $this->image_url = $image_url;
    }

    function name(){
        return $this->name;
    }

    function save($db){
        $stmt = $db->prepare(
            'UPDATE User set name = ?, image_url = ?, username = ? where UserId= ?'
        );
        $stmt->execute(array($this->name, $this->image_url, $this->username, $this->id));
    }

    static function getUserWithPass(PDO $db, string $email, string $password): ?User
    {
        $stmt = $db->prepare('SELECT UserId, username, name, image_url FROM User WHERE lower(email) = ? and password = ?');
        $stmt->execute(array(strtolower($email), sha1($password)));
        if ($user = $stmt->fetch()) {
            return new User($user['UserId'], $user['username'], $user['name'], $user['image_url'], $user['email']);
        } else {
            return null;
        }
    }

    static function getUser(PDO $db, int $id) : User{
        $stmt = $db->prepare('SELECT UserId, username, email, name, image_url FROM User WHERE UserId = ?');
        $stmt->execute(array($id));
        $user = $stmt->fetch();
        return new User($user['UserId'],$user['username'], $user['email'], $user['name'], $user['image_url']);
    }

    static function getUserName(PDO $db, int $id) : string{
        $stmt = $db->prepare('SELECT username FROM User WHERE UserId = ?');
        $stmt->execute(array($id));
        $user = $stmt->fetch();
        return $user['username'];
    }
}

?>


