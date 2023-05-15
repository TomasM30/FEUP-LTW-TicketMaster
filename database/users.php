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

        static public function getUserEmail($db, $username){
            $stmt = $db->prepare('SELECT email FROM user WHERE username = :username');
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            return $stmt->fetch()['email'];
        }

        static public function changeEmail($db, $username, $new_email){
            $stmt = $db->prepare('UPDATE user SET email = :new_email WHERE username = :username');
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':new_email', $new_email);
            $stmt->execute();
        }

        static public function changePassword($db, $username, $new_psw){
            $hashed_pw = password_hash($new_psw, PASSWORD_DEFAULT, ['cost' => 10]);
            $stmt = $db->prepare('UPDATE user SET password = :new_psw WHERE username = :username');
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':new_psw', $hashed_pw);
            $stmt->execute();
        }

        static public function insertUser(PDO $db, User $user){
            
            $hashed_pw = password_hash($user->password, PASSWORD_DEFAULT, ['cost' => 10]);

            $searched_user = User::getUser($db, $user->username);
            if ($searched_user != null){return "The username provided is already in use, please use another";}

            $stmt = $db->prepare('INSERT INTO User (username, name, password, email) VALUES (?, ?, ?, ?)');
            $stmt->execute(array($user->username, $user->name, $hashed_pw, strtolower($user->email)));
            $stmt = $db->prepare('INSERT INTO Client (client_username) VALUES (?)');
            $stmt->execute(array($user->username));

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

        static public function checkPassword($pwd, &$errors): bool{
            $errors_init = $errors;

            if (strlen($pwd) < 8) {
                $errors[] = "Password too short!";
            }

            if (!preg_match("#[0-9]+#", $pwd)) {
                $errors[] = "Password must include at least one number!";
            }

            if (!preg_match("#[a-zA-Z]+#", $pwd)) {
                $errors[] = "Password must include at least one letter!";
            }

            return ($errors == $errors_init);
        }

        static public function checkUsername($username, &$errors): bool {
            $errors_init = $errors;

            if (strlen($username) > 11) {
                $errors[] = "Username must not exceed 11 characters!";
            }

            if (!preg_match("/^[a-zA-Z0-9]+$/", $username)) {
                $errors[] = "Username must only contain letters and numbers!";
            }

            return ($errors == $errors_init);
        }

        static public function checkEmail($email, &$errors): bool {
            $errors_init = $errors;

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Invalid email format!";
            }

            return ($errors == $errors_init);
        }


        static public function samePassword($db, $username, $new_psw): bool{
            $hashed_pw = password_hash($new_psw, PASSWORD_DEFAULT, ['cost' => 10]);
            $stmt = $db->prepare('SELECT password FROM user WHERE username = :username');
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            $result = $stmt->fetch()['password'];
            return password_verify($hashed_pw, $result);
        }

        static public function sameName($db, $username, $newName): bool{
            $stmt = $db->prepare('SELECT name FROM user WHERE username = :username');
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            $result = $stmt->fetch()['name'];
            return $result == $newName;
        }
        static public function sameUName($db, $username, $newUName): bool{
            $stmt = $db->prepare('SELECT username FROM user WHERE username = :username');
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            $result = $stmt->fetch()['username'];
            return $result == $newUName;
        }

        static public function changeName($db, $username, $newName){
            $stmt = $db->prepare('UPDATE user SET name = :newName WHERE username = :username');
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':newName', $newName);
            $stmt->execute();
        }


        static public function changeUName($db, $username, $newUName){
            $stmt = $db->prepare('UPDATE user SET username = :newUName WHERE username = :username');
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':newUName', $newUName);
            $stmt->execute();
            $stmt = $db->prepare('UPDATE client SET client_username = :newUName WHERE client_username = :username');
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':newUName', $newUName);
            $stmt->execute();
            $stmt = $db->prepare('UPDATE agent SET agent_username = :newUName WHERE agent_username = :username');
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':newUName', $newUName);
            $stmt->execute();
            $stmt = $db->prepare('UPDATE admin SET admin_username = :newUName WHERE admin_username = :username');
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':newUName', $newUName);
            $stmt->execute();
            $stmt = $db->prepare('UPDATE Link_departments SET username = :newUName WHERE username = :username');
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':newUName', $newUName);
            $stmt->execute();
            $stmt = $db->prepare('UPDATE Ticket SET author_username = :newUName WHERE author_username = :username');
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':newUName', $newUName);
            $stmt->execute();
            $stmt = $db->prepare('UPDATE Ticket SET agent_username = :newUName WHERE agent_username = :username');
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':newUName', $newUName);
            $stmt->execute();
            $stmt = $db->prepare('UPDATE Comment SET username = :newUName WHERE username = :username');
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':newUName', $newUName);
            $stmt->execute();
        }

        static public function isAgent($db, $username): bool{
            $stmt = $db->prepare('SELECT * FROM agent WHERE agent_username = :username');
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            return $stmt->fetch() != null;
        }

        static public function getAllAgents($db): array{
            $stmt = $db->prepare('SELECT * FROM agent');
            $stmt->execute();
            return $stmt->fetchAll();
        }
    }
?>
