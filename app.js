$(document).ready(function () {
  $("#chat-form").submit(function (e) {
    e.preventDefault();
    var message = $("#chat-input").val();
    sendMessage(message);
    $("#chat-input").val("");
  });

  function sendMessage(message) {
    // Use AJAX to send message to server
    console.log("Sent" + " " + message);
    sendMessageToServer(message);
    addPostedMessage(message);
  }
});

function sendMessageToServer(message) {
  $.ajax({
    type: "POST",
    url: "chat.php",
    data: { message: message },
    success: function (response) {
      // Handle successful message send
      console.log("Success" + response);
    },
    error: function (xhr, status, error) {
      // Handle error
      console.log(status + " : " + error);
    },
  });
}

function addPostedMessage(message) {
  const messagesList = document.querySelector("#messages-list");
  const postedMessage = document.createElement("li");
  postedMessage.innerText = message;
  messagesList.append(postedMessage);
}
