<?php declare(strict_types=1);
require_once(__DIR__ . '/../database/ticket.php');
?>


<?php function drawProfileForm(string $username, string $pfp_url)
{ ?>
    <div class="profileContainer" id="profilePage">
        <div class="settingsColumn">
            <div class="profileCard">
                <div class="cardBody">
                    <form action="/../actions/action_upload_pfp.php" method="post" enctype="multipart/form-data">
                        <label for="pfp"><img src="<?= $pfp_url ?>" alt="userImg" class="userImg"></label>
                        <input type="file" id="pfp" name="pfp" required="required" accept="image/*">
                        <input type="submit" id="submit" value="Submit changes!" class="openButton">
                    </form>
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
                            <button class="openButton" onclick="openInfoForm()">Change Name</button>
                        <li class="button">
                            <button class="openButton" onclick="openUserNameForm()">Change Username</button>
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
                            <button class="slideB" id="slideBL"  onclick="scrollHContainer(200,'left',this.parentNode)"></button>
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
                            <button class="slideB" id="slideBR" onclick="scrollHContainer(200,'right',this.parentNode)"></button>
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
                    <button class="slideB" id="slideBL"  onclick="scrollHContainer(200,'left',this.parentNode)"></button>
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
                    <button class="slideB" id="slideBR" onclick="scrollHContainer(200,'right',this.parentNode)"></button>
                    <button class="slideB" id="slideBL"  onclick="scrollHContainer(200,'left',this.parentNode)"></button>
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
                    <button class="slideB" id="slideBR" onclick="scrollHContainer(200,'right',this.parentNode)"></button>
                    <button class="slideB" id="slideBL"  onclick="scrollHContainer(200,'left',this.parentNode)"></button>
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
                    <button class="slideB" id="slideBR" onclick="scrollHContainer(200,'right',this.parentNode)"></button>
                    <button class="slideB" id="slideBL"  onclick="scrollHContainer(200,'left',this.parentNode)"></button>
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
                    <button class="slideB" id="slideBR" onclick="scrollHContainer(200,'right',this.parentNode)"></button>
                    <button class="slideB" id="slideBL"  onclick="scrollHContainer(200,'left',this.parentNode)"></button>
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

    <div class="changeInfoB" id="popupName">
        <form action="../actions/change_name.php" method="post">
            <div class="name-box">
                <label for="name">New name</label>
                <input type="text" placeholder="Enter Name" name="name" id="name" required>
            </div>
            <span id="name_error">
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

    <div class="changeInfoB" id="popupUserName">
        <form action="../actions/change_username.php" method="post">
            <div class="username-box">
                <label for="username">New username</label>
                <input type="text" placeholder="Enter Username" name="username" id="username" required>
            </div>
            <span id="username_error">
                <?php
                if (isset($_GET['error']) && $_GET['error'] == 5) {
                    echo "Insert a different name!";
                } elseif (isset($_GET['error']) && $_GET['error'] == 6) {
                    echo "Username already in use!";
                }
                ?>
            </span>
            <button type="submit" class="btn submit">Submit</button>
            <button type="button" class="btn cancel" onclick="closeForm()">Close</button>
        </form>
    </div>

<?php } ?>