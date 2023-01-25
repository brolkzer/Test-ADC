<?php
session_start();
// Connect to Database
$db = new PDO('mysql:host=localhost;dbname=chat', "root", "root");

if (isset($_POST['envoi'])) {
    $errors = array();

    $pseudo = strtolower(htmlspecialchars($_POST['pseudo']));
    $pwd = strtolower(sha1(htmlspecialchars($_POST['pwd'])));

    $isPseudoUnique = $db->prepare("SELECT pseudo FROM users WHERE pseudo = ? ");
    $isPseudoUnique->execute(array($pseudo));

    if ($isPseudoUnique->rowCount() > 0) {
        $errors['pseudoUnique'] = "Ce pseudo existe déjà";

    } else {

        if (empty($_POST['pseudo']) and empty(($_POST['pwd']))) {
            $errors['pseudoEmpty'] = "Vous devez renseigner un pseudo";
            $errors['pwdEmpty'] = "Vous devez renseigner un mot de passe";
        } else if (!empty($_POST['pseudo']) and empty($_POST['pwd'])) {
            $errors['pwdEmpty'] = "Vous devez renseigner un mot de passe";
        } else if (empty($_POST['pseudo']) and !empty($_POST['pwd'])) {
            $errors['pseudoEmpty'] = "Vous devez renseigner un pseudo";
        } else if (!empty($_POST['pseudo']) and !empty($_POST['pwd'])) {

            $createUser = $db->prepare('INSERT INTO users (pseudo, pwd) VALUES (?, ?)');
            $createUser->execute(array($pseudo, $pwd));

            $createdUserId = $db->prepare("SELECT * FROM users WHERE pseudo = ? and pwd = ?");
            $createdUserId->execute(array($pseudo, $pwd));

            if ($createdUserId->rowCount() > 0) {
                $_SESSION['pseudo'] = $pseudo;
                $_SESSION['pwd'] = $pwd;
                $_SESSION['id'] = $createdUserId->fetch()['id'];
                header('Location: ../index.php');
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/signUp.css" />
    <script src="signUp.js" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>S'inscire</title>
</head>

<body>
    <h1>S'inscrire </h1>
    <form action="" method="POST">
        <input type="text" name="pseudo" autocomplete="off" placeholder="Pseudonyme">
        <p>
            <?php if (isset($errors['pseudoUnique']))
                echo $errors['pseudoUnique'];
            else if (isset($errors['pseudoEmpty']))
                echo $errors['pseudoEmpty'] ?>
                </p>
                <input type="password" name="pwd" autocomplete="off" placeholder="Mot de passe">
                <p>
            <?php if (isset($errors['pwdEmpty']))
                echo $errors['pwdEmpty']; ?>
        </p>
        <input id="signUpForm" type="submit" name="envoi" value="S'inscrire">
    </form>
</body>

</html>