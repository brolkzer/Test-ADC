<?php
session_start();
//Connection to database
$db = new PDO('mysql:host=localhost;dbname=chat', "root", "root");

// Retrieve latest messages from database
$getMessages = $db->query("SELECT * FROM messages ORDER BY id ASC LIMIT 10");

// Return latest messages as JSON 
while ($message = $getMessages->fetch()) {
    if (array_key_exists('pseudo', $_SESSION) and $message['author'] == $_SESSION['pseudo']) {
        if ($message["show"] == 1) {
            ?>
            <li class="userPost">
                <span>
                    <?="From " . $message["author"] . " at " . $message['createdAt'] ?>
                </span>
                <span>BOUTON EDIT // BOUTON DELETE // BOUTON BAN USER</span>
                <br>
                <?= $message['msg']; ?>
            </li>
            <?php
        }
    } else if (array_key_exists('pseudo', $_SESSION) and $message['author'] != $_SESSION['pseudo']) {
        if ($message["show"] == 1) {
            ?>
                <li class="othersPost">
                    <span>
                    <?="From " . $message["author"] . " at " . $message['createdAt'] ?>
                    </span>
                    <span>BOUTON EDIT // BOUTON DELETE // BOUTON BAN USER</span>
                    <br>
                <?= $message['msg']; ?>
                </li>
            <?php
        }
    } else if (!array_key_exists('pseudo', $_SESSION)) {
        if ($message["show"] == 1) {
            ?>
                    <li class="othersPost">
                        <span>
                    <?="From " . $message["author"] . " at " . $message['createdAt'] ?>
                        </span>
                        <span>BOUTON EDIT // BOUTON DELETE // BOUTON BAN USER</span>
                        <br>
                <?= $message['msg']; ?>
                    </li>
            <?php
        }
    }
}
?>