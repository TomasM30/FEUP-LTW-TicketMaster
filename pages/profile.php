<?php
declare(strict_types = 1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../templates/ticketPrev.tpl.php');
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../utils/misc.php');


$session = new Session();

$db = getDatabaseConnection();
$tickets = Misc::getTickets($db, $session->getUsername());
$username = $session->getUsername();

drawHeader($session->getUsername());?>
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
                            echo User::getName($db, $username);
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
                            echo User::getUserEmail($db, $username);
                            ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="previewTickets">
            <?php drawTicketPreview($db,$tickets) ?>
        </div>
    </div>
    <div class="changeInfoB" id="popupEmail">
        <form action="../actions/action_change_email.php" method="post">
            <div class="email-box">
                <label for="email">New e-mail</label>
                <input type="email" placeholder="Enter Email" name="email" id="email" required>
            </div>
            <span id="email-error">
                <?php
                if (isset($_GET['error']) && $_GET['error'] == 1) {
                    echo "Email already in use";
                }elseif(isset($_GET['error']) && $_GET['error'] == 8){
                    echo "Invalid Email!";
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
        <form action="../actions/action_change_name.php" method="post">
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
        <form action="../actions/action_change_username.php" method="post">
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
                } elseif (isset($_GET['error']) && $_GET['error'] == 7) {
                    echo "Invalid Username!";
                }
                ?>
            </span>
            <button type="submit" class="btn submit">Submit</button>
            <button type="button" class="btn cancel" onclick="closeForm()">Close</button>
        </form>
    </div>
<?php
    drawFooter();
?>