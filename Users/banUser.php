<?php
session_start();
// Connect to Database
$db = new PDO('mysql:host=localhost;dbname=chat', "root", "root");

// Defines variable
$pseudo = htmlspecialchars($_POST['pseudo']);

// Browse the database to find the user's id with his pseudo
$retrieveUser = $db->prepare('SELECT * FROM users WHERE pseudo = ?');
$retrieveUser->execute(array($pseudo));
$userId = $retrieveUser->fetch()['id'];

if ($retrieveUser->rowCount() > 0) {
    // Ban user and remove his mod privileges if user is a mod
    $banUser = $db->prepare('UPDATE users SET users.banned = 1, users.mod = 0 WHERE users.id = ?');
    $banUser->execute(array($userId));

    $deleteMessages = $db->prepare('UPDATE messages SET messages.show = 0 WHERE author = ?');
    $deleteMessages->execute(array($pseudo));
}

?>