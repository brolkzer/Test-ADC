<?php
session_start();
// Connect to Database
$db = new PDO('mysql:host=localhost;dbname=chat', "root", "root");

if (isset($_POST['send'])) {
  if (!empty($_POST['message']) and (array_key_exists('pseudo', $_SESSION))) {
    $pseudo = htmlspecialchars($_SESSION['pseudo']);
    $message = nl2br(htmlspecialchars($_POST['message']));

    $postMessage = $db->prepare('INSERT INTO messages (author, msg) VALUES (?, ?)');
    $postMessage->execute(array($pseudo, $message));

  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Chat</title>
  <link rel="stylesheet" href="./styles/index.css" />
  <script src="app.js" defer></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
  <header>
    <p class="header_left">Chat</p>
    <p class="header_center">Envoyez un message pour participer au feed</p>
    <div class="header_right">
      <p class="header_right_greetings">
        <?php
        if (array_key_exists('pseudo', $_SESSION)) {
          echo 'Bonjour' . ' ' . $_SESSION['pseudo'];
        } ?>
      </p>
      <?php if (array_key_exists('pseudo', $_SESSION)) {
        echo '<button class="header_right_btn" onClick="window.location.href = \'/Users/signOut.php\'">Se déconnecter</button>';
      } else if (!array_key_exists('pseudo', $_SESSION)) {
        echo '<button class="header_right_btn" onClick="window.location.href = \'/Users/signIn.php\'">
          Se connecter
        </button>
        <button class="header_right_btn" onClick="window.location.href = \'/Users/signUp.php\'">
          S\'inscrire
        </button>';
      } ?>
    </div>
  </header>
  <div id="chat-container">
    <div id="chat-messages">
      <ul id="messages-list">
        <script>
          $('#messages-list').load("./Messages/loadMessages.php")
        </script>
      </ul>
    </div>
    <form id="chat-form" method="POST" action="">

      <input type="text" id="chat-input" placeholder="Enter your message..." name="message" />
      <button type="submit" name="send">Send</button>
    </form>
  </div>
</body>

</html>