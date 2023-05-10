<?php
declare(strict_types=1);
require_once(__DIR__ . '/../database/ticket.php');

?>

<?php
function drawTicketPreview(string $username)
{ ?>
    <div class="container">

        <?php
        $tickets = ticket::getClientTickets(getDatabaseConnection(), $username);
        foreach ($tickets as $ticket) {
            ?>
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
        ?>


    </div>

    <?php
} ?>

<?php
function drawUserTicketStats(string $username)
{ ?>
    <div class="container">
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
    <?php
} ?>
