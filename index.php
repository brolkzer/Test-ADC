<?php
session_start();
// Connect to Database
$db = new PDO('mysql:host=localhost;dbname=chat', "root", "root");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Chat</title>
  <link rel="stylesheet" href="./styles/index.css" />
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
          $('#messages-list').load("./Messages/loadMessages.php");
        </script>
      </ul>
    </div>
    <script>
      $(document).ready(function () {
        const author = document.querySelector('.header_right_greetings').innerText.split(" ")[1];
        $('#chat-form').on('submit', function (e) {
          e.preventDefault();
          const msg = $("#chat-input").val();

          if ($('.header_right_greetings') && $("#chat-input").val()) {
            $.ajax({
              type: "POST",
              url: "./Messages/postMessage.php",
              data: { author: author, msg: msg },
              success: function (response) {
                // Handle successful message send and clear the form
                console.log("Success" + response);
                $("#chat-form")[0].reset();

              },
              error: function (xhr, status, error) {
                // Handle error
                console.log(status + " : " + error);
              },
            });
          }
        });
      });
    </script>
    <form id="chat-form" method="POST" action="">
      <input type="text" id="chat-input" placeholder="Enter your message..." name="message" />
      <button type="submit" name="send">Send</button>
    </form>
  </div>
</body>

</html>