<?php
    class Session{ 
        public function __construct(){
            session_start();
        }
        public function setUsername(string $username){
            $_SESSION['username'] = $username;
        }
        public function getUsername() : ?string{
            return isset($_SESSION['username']) ? $_SESSION['username'] : null;
        }

        public function isLoggedIn() : bool {
            return isset($_SESSION['username']);
        }
    }
?>