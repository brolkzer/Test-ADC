<?php

// Connect to database
$db = new PDO('mysql:host=localhost;dbname=chat', "root", "root");

// Retrieve message from client
$message = $_POST["message"];

// Insert message into database
$stmt = $db->prepare("INSERT INTO messages (message) VALUES (:message)");
$stmt->execute(array(':message' => $message));
?>