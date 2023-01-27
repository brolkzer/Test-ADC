<?php
session_start();
// Connect to Database
$db = new PDO('mysql:host=localhost;dbname=chat', "root", "root");

// Defines variable
$id = htmlspecialchars($_POST['id']);

// Check if the message we want to delete actually exists

$retrieveMessage = $db->prepare('SELECT * FROM messages where id = ?');
$retrieveMessage->execute(array($id));

if ($retrieveMessage->rowCount() > 0) {
    $deleteMessage = $db->prepare('UPDATE messages SET messages.show = 0 WHERE messages.id = ?');
    $deleteMessage->execute(array($id));
} else {
    throw new Exception('Could not find the message you want to delete');
}
// }
?>