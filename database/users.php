<?php
    class User{
        public string $username;
        public string $password;
        public string $email;
        public string $name;
        public string $pfp;
        
        public function __construct($username, $password, $email, $name){
            $this->username = $username;
            $this->password = $password;
            $this->email = $email;
            $this->name = $name;
        }

        static public function getUser($db, $username){
            $stmt = $db->prepare('SELECT * FROM User WHERE username = :username');
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            return $stmt->fetch();
        }

        static public function getEmail($db, $email){
            $stmt = $db->prepare('SELECT * FROM User WHERE email = :email');
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            return $stmt->fetch();
        }
        static public function insertUser(PDO $db, User $user){
            
            $hashed_pw = password_hash($user->password, PASSWORD_DEFAULT, ['cost' => 10]);

            $searched_user = User::getUser($db, $user->username);
            if ($searched_user != null){return "The username provided is already in use, please use another";}

            $stmt = $db->prepare('INSERT INTO User (username, name, password, email) VALUES (?, ?, ?, ?)');

            $stmt->execute(array($user->username, $user->name, $hashed_pw, strtolower($user->email)));
        }
        static function getName(PDO $db, $username){
            $stmt = $db->prepare('SELECT name FROM User WHERE username = :username');
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            return $stmt->fetch()['name'];
        }
        
        public function deleteUser($username){
            global $db;
            $stmt = $db->prepare('DELETE FROM User WHERE username = :username');
            $stmt->bindParam(':username', $username);
            $stmt->execute();
        }
        
        public function editUserProfile($username, $name, $email){
            global $db;
            $stmt = $db->prepare('UPDATE User SET name = :name, email = :email WHERE username = :username');
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
        }
        
    
        public function getClient($username){
            global $db;
            $stmt = $db->prepare('SELECT * FROM Client WHERE client_username = :username');
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            return $stmt->fetch();
        }
        
        public function getAgent($username){
            global $db;
            $stmt = $db->prepare('SELECT * FROM Agent WHERE agent_username = :username');
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            return $stmt->fetch();
        }
        
        public function getAdmin($username){
            global $db;
            $stmt = $db->prepare('SELECT * FROM Admin WHERE admin_username = :username');
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            return $stmt->fetch();
        }

        static public function getUserUsernamePassword($username, $password) : ?User{
            global $db;
            $stmt = $db->prepare('
            SELECT * FROM User WHERE lower(username) = ?
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
