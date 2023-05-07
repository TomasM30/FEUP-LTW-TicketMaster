<?php
declare(strict_types=1);
require_once(__DIR__ . '/../database/ticket.php');

?>

<?php
function drawTicketPreview(string $username)
{ ?>
    <a href="/">
        <div class="container">
            <?php
            $tickets = ticket::getUserTickets(getDatabaseConnection(), $username);
            foreach ($tickets as $ticket) {
                ?>
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
                <?php
            }
            ?>
        </div>
    </a>
    <?php
} ?>
