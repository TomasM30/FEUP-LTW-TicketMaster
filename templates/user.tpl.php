<?php declare(strict_types=1);
require_once(__DIR__ . '/../database/ticket.php');
?>


<?php function drawProfileForm(string $username)
{ ?>
    <div class="profileContainer" id="profilePage">
        <div class="settingsColumn">
            <div class="profileCard">
                <div class="cardBody">
                    <img src="../images/default_user.png" alt="userImg"
                         class="userImg">
                    <h5 class="usernameP">
                        <?php
                        echo $username;
                        ?>
                    </h5>
                </div>
            </div>
            <div class="profileCard" id="settingsCard">
                <div class="optionsBody">
                    <ul class="userSettings">
                        <li class="button">
                            <button class="openButton" onclick="openEmailForm()">Change email</button>
                        </li>
                        <li class="button">
                            <button class="openButton" onclick="openPswForm()">Change password</button>
                        <li class="button">
                            <button class="openButton" onclick="openInfoForm()">Change information</button>
                        <li class="button">
                            <button class="openButton" onclick="window.location.href = '../actions/action_logout.php'">Logout</button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="userInfoColumn">
            <div class="profileCard" id="profileInfoCard">
                <div class="cardBody">
                    <div class="row">
                        <div class="titleColumn">
                            <p class="title">Name</p>
                        </div>
                        <div class="infoColumn">
                            <p class="info">
                                <?php
                                echo User::getName(getDatabaseConnection(), $username);
                                ?>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="titleColumn">
                            <p class="title">Email</p>
                        </div>
                        <div class="infoColumn">
                            <p class="info">
                                <?php
                                echo User::getUserEmail(getDatabaseConnection(), $username);
                                ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="previewTickets">
                <div class="container" id = 'profileTickets'>
                    <?php
                    $tickets = Ticket::getClientTickets(getDatabaseConnection(), $username);
                    if(!empty($tickets)){
                        foreach ($tickets as $ticket) {?>
                        <a href="/">
                            <div class="card">
                                <div class="content">
                                    <header>
                                        <h2 class="status"><?= ticket::getStatus(getDatabaseConnection(), $ticket['status']) ?></h2>
                                        <h1><?= $ticket['subject'] ?></h1>
                                    </header>
                                    <article>
                                        <?= $ticket['content'] ?>
                                    </article>
                                </div>
                            </div>
                        </a>
                        <?php
                        }
                    } else{
                        ?>
                    <a href="/">
                    <div class="card">
                            <div class="content">
                                <header>
                                    <h2 class="status"></h2>
                                    <h1>No tickets</h1>
                                </header>
                                <article>
                                    You still don't have any tickets
                                </article>
                            </div>
                        </div>
                    </a>
                        <?php
                    }
                    ?>
                </div>
                <div class="container" id = 'profileTickets'>
                    <a href="/">
                        <div class="card" id="stat_card">
                            <div class="content" id="statistics">
                                <header>
                                    <h1>Number of tickets</h1>
                                </header>
                                <article>
                                    <?php
                                    $tickets = ticket::getClientTickets(getDatabaseConnection(), $username);
                                    echo count($tickets);
                                    ?>
                                </article>
                            </div>
                        </div>
                    </a>
                    <a href="/">
                        <div class="card" id="stat_card">
                            <div class="content" id="statistics">
                                <header>
                                    <h1>Tickets Open</h1>
                                </header>
                                <article>
                                    <?php
                                    $tickets = ticket::getClientTickets(getDatabaseConnection(), $username);
                                    $open = 0;
                                    foreach ($tickets as $ticket) {
                                        if ($ticket['status'] == 1) {
                                            $open++;
                                        }
                                    }
                                    echo $open;
                                    ?>
                                </article>
                            </div>
                        </div>
                    </a>
                    <a href="/">
                        <div class="card" id="stat_card">
                            <div class="content" id="statistics">
                                <header>
                                    <h1>Tickets in progress</h1>
                                </header>
                                <article>
                                    <?php
                                    $tickets = ticket::getClientTickets(getDatabaseConnection(), $username);
                                    $inProgress = 0;
                                    foreach ($tickets as $ticket) {
                                        if ($ticket['status'] == 3) {
                                            $inProgress++;
                                        }
                                    }
                                    echo $inProgress;
                                    ?>
                                </article>
                            </div>
                        </div>
                    </a>
                    <a href="/">
                        <div class="card" id="stat_card">
                            <div class="content" id="statistics">
                                <header>
                                    <h1>Tickets Closed</h1>
                                </header>
                                <article>
                                    <?php
                                    $tickets = ticket::getClientTickets(getDatabaseConnection(), $username);
                                    $closed = 0;
                                    foreach ($tickets as $ticket) {
                                        if ($ticket['status'] == 2) {
                                            $closed++;
                                        }
                                    }
                                    echo $closed;
                                    ?>
                                </article>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="changeInfoB" id="popupEmail">
        <form action="../actions/change_email.php" method="post">
            <div class="email-box">
                <label for="email">New e-mail</label>
                <input type="email" placeholder="Enter Email" name="email" id="email" required>
            </div>
            <span id="email-error">
                <?php
                if (isset($_GET['error']) && $_GET['error'] == 1) {
                    echo "Email already in use";
                }
                ?>
            </span>
            <button type="submit" class="btn submit">Submit</button>
            <button type="button" class="btn cancel" onclick="closeForm()">Close</button>
        </form>
    </div>

    <div class="changeInfoB" id="popupPsw">
        <form action="../actions/change_password.php" method="post">
            <div class="psw-box">
                <label for="psw">New password</label>
                <input type="password" placeholder="Enter Password" name="psw" id="psw" required>
            </div>
            <span id="password_error">
                <?php
                if (isset($_GET['error']) && $_GET['error'] == 2) {
                    echo "Must contain at least 8 Char, 1 up/lowercase letter and 1 number";
                } elseif(isset($_GET['error']) && $_GET['error'] == 3){
                    echo "Insert a different password!";
                }
                ?>
            </span>
            <button type="submit" class="btn submit">Submit</button>
            <button type="button" class="btn cancel" onclick="closeForm()">Close</button>
        </form>
    </div>

    <div class="changeInfoB" id="popupInfo">
        <form action="../actions/change_info.php" method="post">
            <div class="info-box">
                <label for="info">New name</label>
                <input type="text" placeholder="Enter Name" name="info" id="info" required>
            </div>
            <span id="info_error">
                <?php
                if (isset($_GET['error']) && $_GET['error'] == 4) {
                    echo "Insert a different name!";
                }
                ?>
            </span>
            <button type="submit" class="btn submit">Submit</button>
            <button type="button" class="btn cancel" onclick="closeForm()">Close</button>
        </form>
    </div>

<?php } ?>