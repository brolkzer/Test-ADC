<?php
session_start();
//Connection to database
$db = new PDO('mysql:host=localhost;dbname=chat', "root", "root");

// Retrieve latest messages from database
$getMessages = $db->query("SELECT * FROM messages ");

// Return latest messages as JSON
while ($message = $getMessages->fetch()) {
    if (array_key_exists('pseudo', $_SESSION) and $message['author'] == $_SESSION['pseudo']) {
        if ($message["show"] == 1) {
            ?>
            <li class="userPost">
                <?= $message['msg']; ?>
            </li>
            <?php
        }
    } else if (array_key_exists('pseudo', $_SESSION) and $message['author'] != $_SESSION['pseudo']) {
        if ($message["show"] == 1) {
            ?>
                <li class="othersPost">
                <?= $message['msg']; ?>
                </li>
            <?php
        }
    } else if (!array_key_exists('pseudo', $_SESSION)) {
        if ($message["show"] == 1) {
            ?>
                    <li class="othersPost">
                <?= $message['msg']; ?>
                    </li>
            <?php
        }
    }
}
?>