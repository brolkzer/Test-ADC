<?php
session_start();
// Connect to Database
$db = new PDO('mysql:host=localhost;dbname=chat', "root", "root");

if (isset($_POST['envoi'])) {
    $errors = array();

    $pseudo = strtolower(htmlspecialchars($_POST['pseudo']));
    $pwd = strtolower(sha1(htmlspecialchars($_POST['pwd'])));

    $retrieveUser = $db->prepare("SELECT pseudo FROM users WHERE pseudo = ? AND pwd = ?");
    $retrieveUser->execute(array($pseudo, $pwd));

    if ($retrieveUser->rowCount() == 0) {
        $errors['incorrectLogs'] = "Identifiants incorrects";
    } else {

        if (empty($_POST['pseudo']) and empty(($_POST['pwd']))) {
            $errors['pseudoEmpty'] = "Vous devez renseigner un pseudo";
            $errors['pwdEmpty'] = "Vous devez renseigner un mot de passe";
        } else if (!empty($_POST['pseudo']) and empty($_POST['pwd'])) {
            $errors['pwdEmpty'] = "Vous devez renseigner un mot de passe";
        } else if (empty($_POST['pseudo']) and !empty($_POST['pwd'])) {
            $errors['pseudoEmpty'] = "Vous devez renseigner un pseudo";
        } else if (!empty($_POST['pseudo']) and !empty($_POST['pwd'])) {
            $_SESSION['pseudo'] = $pseudo;
            $_SESSION['pwd'] = $pwd;
            $_SESSION['id'] = $retrieveUser->fetch()['id'];
            $_SESSION['mod'] = $retrieveUser->fetch()['mod'];
            header("Location: ../index.php");
        }
    }
}


?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/signIn.css" />
    <script src="signIn.js" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>Se connecter</title>
</head>

<body>
    <h1>Se connecter</h1>
    <h2>Pas de compte ? <a href="/Users/SignUp.php">Cliquez ici pour vous inscrire !</a></h2>
    <form action="" method="POST">
        <input type="text" name="pseudo" placeholder="Pseudonyme">
        <p>
            <?php if (isset($errors['pseudoEmpty']))
                echo $errors['pseudoEmpty'] ?>
            </p>
            <input type="password" name="pwd" placeholder="Mot de passe">
            <p>
            <?php if (isset($errors['pwdEmpty']))
                echo $errors['pwdEmpty']; ?>
        </p>
        <input id="signInForm" type="submit" name="envoi" value="Se connecter">
        <p>
            <?php if (isset($errors['incorrectLogs']))
                echo $errors['incorrectLogs']; ?>
        </p>
    </form>
</body>

</html>