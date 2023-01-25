<?php
session_start();
// Connect to Database
$db = new PDO('mysql:host=localhost;dbname=chat', "root", "root");

// Clear inputs and defines variables
$pseudo = htmlspecialchars($_POST['author']);
$message = nl2br(htmlspecialchars($_POST['msg']));


// Checks if user is authorized to post
$checkUserBanned = $db->prepare('SELECT * FROM users WHERE pseudo = ? AND banned = 1');
$checkUserBanned->execute(array($pseudo));

if ($checkUserBanned->rowCount() == 1) {
    throw new Exception('Vous n\'êtes pas autorisé à poster sur ce site');
} else if ($checkUserBanned->rowCount() == 0) {
    // Check if inputs are empty, return an error if so
    if (!empty($pseudo) and !empty($message)) {
        $postMessage = $db->prepare('INSERT INTO messages (author, msg) VALUES (?, ?)');
        $postMessage->execute(array($pseudo, $message));
    } else if (empty($pseudo)) {
        throw new Exception('You must be logged in to send messages');
    } else if (empty($message)) {
        throw new Exception('You must enter a message');
    }
}
?>