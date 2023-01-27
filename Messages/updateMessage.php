<?php
session_start();
// Connect to Database
$db = new PDO('mysql:host=localhost;dbname=chat', "root", "root");

// Clear inputs and defines variables
$msg = htmlspecialchars($_POST['msg']);
$id = htmlspecialchars($_POST['id']);

// Check if inputs are empty, return an error if so
if (!empty($msg)) {
    $editMessage = $db->prepare('UPDATE messages SET messages.msg = ? WHERE messages.id = ?');
    $editMessage->execute(array($msg, $id));
} else if (empty($msg)) {
    throw new Exception('You must enter a message');
}
// }
?>