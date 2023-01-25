// $(document).ready(function () {
//   $("#chat-form").submit(function (e) {
//     e.preventDefault();
//     var msg = $("#chat-input").val();
//     sendMessage(author, msg);
//     $("#chat-input").val("");
//   });

//   function sendMessage(author, msg) {
//     // Use AJAX to send message to server
//     console.log("Sent" + " " + msg);
//     sendMessageToServer(author, msg);
//   }
// });

// function sendMessageToServer(author, msg) {
//   $.ajax({
//     type: "POST",
//     url: "index.php",
//     data: { author: author, msg: msg },
//     success: function (response) {
//       // Handle successful message send
//       console.log("Success" + response);
//     },
//     error: function (xhr, status, error) {
//       // Handle error
//       console.log(status + " : " + error);
//     },
//   });
// }
