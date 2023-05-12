<?php
    declare(strict_types=1);

    require_once(__DIR__ . '/../database/users.php');
    require_once(__DIR__ . '/../database/connection.db.php');

    $db = getDatabaseConnection();

    $user = User::getUser($db, $_POST['username']);
    $email = User::getEmail($db, $_POST['email']);
    $errors = array();

    if ($user){
        header('Location: ../pages/register.php?error=1');
        die();
    }
    elseif($email){
        header('Location: ../pages/register.php?error=2');
        die();
    }
    elseif($_POST['password'] != $_POST['password2']){
        header('Location: ../pages/register.php?error=3');
        die();
    }
    elseif (!user::checkPassword($_POST['password'], $errors)) {
        if (!empty($errors)) {
            $error_message = "";
            foreach ($errors as $error) {
                $error_message .= $error . "\\n";
            }
            ?>
            <script>
                window.alert("<?php echo $error_message ?>");
                window.location.href = "../pages/register.php?error=4";
            </script>
            <?php
            exit;
        }
    }

    $newUser = new User($_POST['username'], $_POST['password'], $_POST['email'], $_POST['name']);
    User::insertUser($db, $newUser);
    header('Location: ../pages/login.php?success=1');
