<script src="https://kit.fontawesome.com/d241de481a.js" crossorigin="anonymous"></script>
<script>
    $(document).ready(function () {
        $('li span i').on('click', function (e) {
            const closestLi = e.currentTarget.closest('li');
            const closestLiMsg = closestLi.lastChild.textContent.trim();
            const closestLiId = closestLi.attributes.id.nodeValue;

            if (e.currentTarget.textContent.trim() == "Editer le message") {
                closestLi.innerHTML =
                    `<form action="" method="POST" class="editPostForm" id="editForm" data-id="${closestLiId}}">
                        <input type='text' class="editPostText" value="${closestLiMsg}" id="editText"/>
                        <input type="submit" id="${closestLiId}" class="editPostSubmit"/>
                    </form>`
            } else if (e.currentTarget.textContent.trim() == "Supprimer le message") {
                console.log('message delete');
                const id = closestLiId;
                const confirmDelete = confirm('Voulez vous vraiment supprimer ce message?');
                if (confirmDelete) {
                    $.ajax({
                        type: "POST",
                        url: "../Messages/deleteMessage.php",
                        data: { id: id },
                        success: function (response) {
                            // Handle successful message send
                            console.log("Success" + response);
                            $('#messages-list').load("./Messages/loadMessages.php");

                        },
                        error: function (xhr, status, error) {
                            // Handle error
                            console.log(status + " : " + error, { msg, id });
                        },
                    });
                }
            } else if (e.currentTarget.textContent.trim() == "Bannir l'utilisateur") {
                const pseudo = e.currentTarget.closest('li').querySelector('span').innerText.split(" ")[1]
                const confirmDelete = confirm('Voulez vous vraiment bannir cet utilisateur?');
                if (confirmDelete) {
                    $.ajax({
                        type: "POST",
                        url: "../Users/banUser.php",
                        data: { pseudo: pseudo },
                        success: function (response) {
                            // Handle successful message send
                            console.log("Success" + response);
                            $('#messages-list').load("./Messages/loadMessages.php");

                        },
                        error: function (xhr, status, error) {
                            // Handle error
                            console.log(status + " : " + error, { msg, id });
                        },
                    });
                }
            }
            $('#editForm').on('submit', function (e) {
                e.preventDefault();
                const id = closestLiId;
                const msg = $("#editText").val();

                if ($("#editText").val()) {
                    $.ajax({
                        type: "POST",
                        url: "../Messages/updateMessage.php",
                        data: { msg: msg, id: id },
                        success: function (response) {
                            // Handle successful message send
                            console.log("Success" + response);
                            $('#messages-list').load("./Messages/loadMessages.php");

                        },
                        error: function (xhr, status, error) {
                            // Handle error
                            console.log(status + " : " + error, { msg, id });
                        },
                    });
                }
            });
        })

    })


</script>
<?php
session_start();
//Connection to database
$db = new PDO('mysql:host=localhost;dbname=chat', "root", "root");

// Retrieve latest messages from database
$getMessages = $db->query("SELECT * FROM messages ORDER BY id ASC LIMIT 10");

// Return latest messages as JSON 
while ($message = $getMessages->fetch()) {
    // Check if user is the author of the post and a class in consequenses,
    // if no user logged, add the same class as if other people typed it.
    if (array_key_exists('pseudo', $_SESSION) and $message['author'] == $_SESSION['pseudo']) {
        if ($message["show"] == 1) {
            ?>
            <li class="userPost" id="<?= $message['id']; ?>">
                <span>
                    <?="From " . $message["author"] . " at " . $message['createdAt'] ?>
                </span>
                <span class="postIcons">
                    <?php
                    if ($message['author'] == $_SESSION['pseudo']) {
                        echo "<i class=\"fa-regular fa-pen-to-square edit\">
                        <span class=\'icons_tooltips\'> Editer le message </span></i>
                        <i class=\"fa-sharp fa-solid fa-trash delete\">
                        <span class=\'icons_tooltips\'> Supprimer le message </span></i>";
                    }
                    ?>
                </span>
                <br>
                <?php

                // for ($i = 0; $i < count($findLink); $i++) {
    
                //     if (str_contains($findLink[$i], "https://www.youtube.com/watch?v=")) {
                //         $embed = str_replace("watch?v=", "embed/", $findLink[$i]);
    
                //         echo str_replace($findLink[$i], "", $message['msg']);
                //         echo "<iframe width=\"560\" height=\"315\" src=\"$embed\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" allowfullscreen></iframe>";
                //     } else {
    
                //         // $i = count($findLink) - 1;
                //     }
                // }
                if (str_contains($message['msg'], "https://www.youtube.com/watch?v=")) {
                    $findLink = explode(" ", $message['msg']);
                    $regex = "@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?).*$)@";
                    for ($i = 0; $i < count($findLink); $i++) {
                        $embed = str_replace("watch?v=", "embed/", $findLink[$i]);
                    }
                    echo preg_replace($regex, ' ', $message["msg"]);
                    echo "<iframe width=\"460\" height=\"315\" src=\"$embed\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" allowfullscreen></iframe>";
                } else {
                    echo $message['msg'];
                }

                // echo $message['msg'];
                ?>

            </li>
            <?php
        }
    } else if (array_key_exists('pseudo', $_SESSION) and $message['author'] != $_SESSION['pseudo']) {
        if ($message["show"] == 1) {
            ?>
                <li class="othersPost" id="<?= $message['id']; ?>">
                    <span>
                    <?="From " . $message["author"] . " at " . $message['createdAt'] ?>
                    </span>
                    <span class="postIcons">
                        <?php
                        $retrieveUser = $db->prepare("SELECT * FROM users WHERE pseudo = ?");
                        $retrieveUser->execute(array($_SESSION['pseudo']));

                        if ($retrieveUser->fetch()['mod'] == 1)
                            echo "<i class=\"fa-regular fa-pen-to-square edit\">
                            <span class=\'icons_tooltips\'> Editer le message </span></i>
                            <i class=\"fa-sharp fa-solid fa-trash delete\">
                            <span class=\'icons_tooltips\'> Supprimer le message </span></i>
                            <i class=\"fa-solid fa-user-slash ban\">
                            <span class=\'icons_tooltips\'> Bannir l'utilisateur </span></i>";
                        ?>
                    </span>
                    <br>
                <?= $message['msg']; ?>
                </li>
            <?php
        }
    } else if (!array_key_exists('pseudo', $_SESSION)) {
        if ($message["show"] == 1) {
            ?>
                    <li class="othersPost" id="<?= $message['id']; ?>">
                        <span>
                    <?="From " . $message["author"] . " at " . $message['createdAt'] ?>
                        </span>
                        <br>
                <?= $message['msg']; ?>
                    </li>
            <?php
        }
    }
}
?>