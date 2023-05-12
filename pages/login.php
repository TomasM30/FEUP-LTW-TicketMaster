<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Ticket Master | Login</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="">
    </head>
    <header>
        <img src="../images/logo.svg" alt="" width="400" height="400">
        <h1>Ticket Master</h1>
        <h3>World's number one ticketing solution for your company</h3>
    </header>
    <body>
        <form action="../actions/action_login.php" method="post">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" placeholder="Enter your username">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" placeholder="Enter your password">
            <input type="submit" value="Login">
        </form>
        <p>
            <?php
            if (isset($_GET['error']) && $_GET['error'] == 1){
                echo "Invalid username or password";
            }
            elseif (isset($_GET['success']) && $_GET['success'] == 1) {
                echo "Account successfully created! Please login";
            }
            elseif (isset($_GET['success']) && $_GET['success'] == 2) {
                echo "Email changed successfully! Please login";
            }
            ?>
        </p>

        <a href="../pages/register.php">Register</a>
    </body>
</html>