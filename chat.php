<?php
include "environment.php";

// Connect to database
$sql_username = getenv("username");
$sql_password = getenv("password");
$db = new PDO('mysql:host=localhost;dbname=chat', $sql_username, $sql_password);

// Retrieve message from client
$message = $_POST["message"];

// Insert message into database
$stmt = $db->prepare("INSERT INTO messages (message) VALUES (:message)");
$stmt->execute(array(':message' => $message));
?>