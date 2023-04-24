<?php function draw_header($username, $uid, $pfp) { ?>

    <link href="../css/header.css" rel="stylesheet">
    <header>
    <div class="logo">
        <p>Home Page</p>
    </div>
    <div class="statistics">
        <p>Statistics</p>
    </div>
    <div class="user panel">
        <p><?$username?></p>
        <p><?$uid?></p>
        <img src="<? $pfp ?>" alt="../images/default_user.png">
        <a>Log Out</a>
    </div>
</header>

<?php } ?>