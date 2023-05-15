<?php

    declare(strict_types=1);

    require_once(__DIR__ . '/../database/users.php');
    require_once(__DIR__ . '/../database/connection.db.php');

    $db = getDatabaseConnection();

    $email = User::getEmail($db, $_POST['email']);

    if($email){
        ?>
        <script>
            window.alert("Email already in use");
            window.location.href = "../pages/profile.php?error=1";
        </script>
        <?php
        exit();
    }elseif (!user::checkEmail($_POST['email'], $errors)) {
        if (!empty($errors)) {
            $error_message = "";
            foreach ($errors as $error) {
                $error_message .= $error . "\\n";
            }
            ?>
            <script>
                window.alert("<?php echo $error_message ?>");
                window.location.href = "../pages/profile.php?error=8";
            </script>
            <?php
            exit;
        }
    }
    user::changeEmail($db, '123', $_POST['email']);
    header('Location: ../pages/login.php?success=2');
