
    <!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <title>Ticket Master | Register</title>
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
            <form action="../actions/action_register.php" method="post">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" placeholder="Enter your username">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" placeholder="Enter your name">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Enter your email">
                <br>
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Enter your password">
                <label for="password2">Confirm Password</label>
                <input type="password" name="password2" id="password2" placeholder="Confirm your password">
                <input type="submit" value="Register">
            </form>
            <br>
            <p><?php
                if (isset($_GET['error'])) {
                    if ($_GET['error'] == 1){
                        echo "Username is already in use, please use another one";
                    } elseif ($_GET['error'] == 2) {
                        echo "Email is already in use, please use another one";
                    } elseif ($_GET['error'] == 3) {
                        echo "Passwords do not match, please try again";
                    }
                }
                ?></p>

            <a href="../pages/login.php">Login</a>
        </body>
    </html>
