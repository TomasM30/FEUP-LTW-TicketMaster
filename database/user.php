<?php
class User{
    public string $username;
    public string $password;
    public string $email;
    public string $name;

    public function __construct($username, $password, $email, $name){
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->name = $name;
    }

    static function getUser($db, $username){
        $stmt = $db->prepare('SELECT * FROM user WHERE username = :username');
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->fetch();
    }

    static function getEmail($db, $email){
        $stmt = $db->prepare('SELECT * FROM user WHERE email = :email');
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch();
    }
    static function insertUser(PDO $db, User $user){

        $hashed_pw = password_hash($user->password, PASSWORD_DEFAULT, ['cost' => 10]);

        $searched_user = User::getUser($db, $user->username);
        if ($searched_user != null){return "The username provided is already in use, please use another";}
        print($user->username);

        $stmt = $db->prepare('INSERT INTO user (username, name, password, email) VALUES (?, ?, ?, ?)');

        $stmt->execute(array($user->username, $user->name, $hashed_pw, strtolower($user->email)));
    }

    static function getName(PDO $db, $username){
        $stmt = $db->prepare('SELECT name FROM user WHERE username = :username');
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->fetch()['name'];
    }

    function deleteUser($username){
        global $db;
        $stmt = $db->prepare('DELETE FROM user WHERE username = :username');
        $stmt->bindParam(':username', $username);
        $stmt->execute();
    }

    function editUserProfile($username, $name, $email){
        global $db;
        $stmt = $db->prepare('UPDATE user SET name = :name, email = :email WHERE username = :username');
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
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

    function getUserUsernamePassword($username, $password) : ?User{
        global $db;
        $stmt = $db->prepare('
            SELECT * FROM user WHERE lower(username) = ?
            ');

        $stmt->execute(array(strtolower($username)));
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])){
            return new User(
                $user['username'],
                $user['password'],
                $user['email'],
                $user['name']
            );
        }
        else {
            return null;
        }
    }
}
?>
