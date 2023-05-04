<?php
declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
?>

<?php function drawHeader(Session $session)
{ ?>
    <!DOCTYPE html>
    <html lang="en-US">
    <head>
        <title>Ticket Master</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
              integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
              crossorigin="anonymous" referrerpolicy="no-referrer"/>
        <script src="../javascript/script.js" defer></script>
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
            <a href="/">
                <img src="../images/default_user.png" alt="User" width="50" height="50">
            </a>
        </div>
    </header>

    <section id="messages">
        <?php foreach ($session->getMessages() as $messsage) { ?>
            <article class="<?= $messsage['type'] ?>">
                <?= $messsage['text'] ?>
            </article>
        <?php } ?>
    </section>

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

<?php function drawLoginForm()
{ ?>
    <form action="../actions/action_login.php" method="post" class="login">
        <input type="email" name="email" placeholder="email">
        <input type="password" name="password" placeholder="password">
        <a href="../pages/register.php">Register</a>
        <button type="submit">Login</button>
    </form>
<?php } ?>

<?php function drawLogoutForm(Session $session)
{ ?>
    <form action="../actions/action_logout.php" method="post" class="logout">
        <a href="../pages/profile.php"><?= $session->getName() ?></a>
        <button type="submit">Logout</button>
    </form>
<?php } ?>