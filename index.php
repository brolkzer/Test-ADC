<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>
  <link rel="stylesheet" href="app.css" />
  <script src="app.js" defer></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
  <?php
  include "environment.php";

  // Connect to database
  $sql_username = getenv("username");
  $sql_password = getenv("password");
  $db = new PDO('mysql:host=localhost;dbname=chat', $sql_username, $sql_password);
  ?>
  <div id="chat-container">
    <div id="chat-messages">
      <ul id="messages-list">
        <?php
        // Retrieve latest messages from database
        $stmt = $db->prepare("SELECT message FROM messages ORDER BY id ASC LIMIT 10");
        $stmt->execute();
        $messages = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

        // Return latest messages as JSON
        for ($i = 0; $i < count($messages); $i++) {
          echo ("<li>$messages[$i]");
        }
        ?>
      </ul>
    </div>
    <form id="chat-form">
      <input type="text" id="chat-input" placeholder="Enter your message..." />
      <button type="submit">Send</button>
    </form>
  </div>
</body>

</html>