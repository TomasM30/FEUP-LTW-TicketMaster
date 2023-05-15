<?php
declare(strict_types=1);
require_once(__DIR__ . '/../database/ticket.php');

?>

<?php
function drawTicketPreview(PDO $db, array $tickets)
{ ?>
    <div class="ticketPrev">
        <div class="container">

            <?php
            if (!empty($tickets)) {
                foreach ($tickets as $ticket) { ?>
                    <button class="slideB" id="slideBL" onclick="scrollHContainer(200,'left',this.parentNode)"></button>
                    <a href="../pages/ticket_details.php?id=<?php echo $ticket['id']?>">
                        <div class="card">
                            <div class="content">
                                <header>
                                    <h2 class="status"><?= ticket::getStatus($db, $ticket['status']) ?></h2>
                                    <h1><?= $ticket['subject'] ?></h1>
                                </header>
                                <article>
                                    <?= $ticket['content'] ?>
                                </article>
                            </div>
                        </div>
                    </a>
                    <button class="slideB" id="slideBR"
                            onclick="scrollHContainer(200,'right',this.parentNode)"></button>
                    <?php
                }
            } else {
                ?>
                <a href="../pages/ticketPage.php">
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
        <div class="container">
            <button class="slideB" id="slideBL" onclick="scrollHContainer(200,'left',this.parentNode)"></button>
            <a href="../pages/ticketPage.php">
                <div class="card" id="stat_card">
                    <div class="content" id="statistics">
                        <header>
                            <h1>Number of tickets</h1>
                        </header>
                        <article>
                            <?php
                            echo count($tickets);
                            ?>
                        </article>
                    </div>
                </div>
            </a>
            <button class="slideB" id="slideBR" onclick="scrollHContainer(200,'right',this.parentNode)"></button>
            <button class="slideB" id="slideBL" onclick="scrollHContainer(200,'left',this.parentNode)"></button>
            <a href="../pages/ticketPage.php">
                <div class="card" id="stat_card">
                    <div class="content" id="statistics">
                        <header>
                            <h1>Tickets Open</h1>
                        </header>
                        <article>
                            <?php

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
            <button class="slideB" id="slideBL" onclick="scrollHContainer(200,'left',this.parentNode)"></button>
            <a href="../pages/ticketPage.php">
                <div class="card" id="stat_card">
                    <div class="content" id="statistics">
                        <header>
                            <h1>Tickets in progress</h1>
                        </header>
                        <article>
                            <?php

                            $inProgress = 0;
                            foreach ($tickets as $ticket) {
                                if ($ticket['status'] == 2) {
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
            <button class="slideB" id="slideBL" onclick="scrollHContainer(200,'left',this.parentNode)"></button>
            <a href="../pages/ticketPage.php">
                <div class="card" id="stat_card">
                    <div class="content" id="statistics">
                        <header>
                            <h1>Tickets Closed</h1>
                        </header>
                        <article>
                            <?php

                            $closed = 0;
                            foreach ($tickets as $ticket) {
                                if ($ticket['status'] == 3) {
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
        </div>
    </div>

    <?php
} ?>
