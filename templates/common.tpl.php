<?php
declare(strict_types=1);
require_once(__DIR__ . '/../database/user.class.php');

?>

<?php function drawHeader(int $id)
{ ?>
    <!DOCTYPE html>
    <html lang="en-US">
    <head>
        <title>Ticket Master</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>
    <input type="checkbox" id="hamburger">
    <label for="hamburger" class="hamburger">
        <div class="bars" id="bar1"></div>
        <div class="bars" id="bar2"></div>
        <div class="bars" id="bar3"></div>
    </label>
    <header>
        <div class='logo'>
            <a href="/">
                <img src="../images/logo.svg" alt="Logo" width="50">
                <h1>Ticket Master</h1>
            </a>
        </div>
        <div class="options">
            <nav>
                <div class="links">
                    <ul>
                        <li><a href="/">Tickets</a></li>
                        <li><a href="/">Departments</a></li>
                        <li><a href="/">Team</a></li>
                        <li><a href="/">FAQ</a></li>
                        <li class="userProfile"><a href="/">Account</a></li>
                    </ul>
                </div>
            </nav>
        </div>
        <div class="user">
            <a class="username" href="/">
                <p><?= User::getUserName(getDatabaseConnection(), $id) ?></p>

            </a>
            <a class="userImage" href="/">
                <img src="../images/default_user.png" alt="User" width="50" height="50">
            </a>
        </div>
    </header>
    <main>
<?php } ?>

<?php function drawFooter()
{ ?>
    </main>

    <footer>
        <p>
            <a href="/">
                &copy; 2023 Ticket Master
            </a>
        </p>
    </footer>
    </body>
    </html>
<?php } ?>