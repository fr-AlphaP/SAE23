<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['psw'];
    $code = $_POST['code'];

    // Code d'inscription fixe
    $secret_code = "mercedes";

    // Vérifiez si le code d'inscription est valide
    if ($code !== $secret_code) {
        $error_message = "Code d'inscription invalide. Veuillez contacter l'administrateur.";
    } else {
        try {
            // Connexion à la base de données
            $pdo = new PDO('mysql:host=localhost;charset=utf8;dbname=db_MALOT', '22404768', '728596');

            // Hachez le mot de passe
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            // Insérez l'utilisateur dans la base de données
            $stmt = $pdo->prepare("INSERT INTO Logins (username, email, password, code) VALUES (:username, :email, :password, :code)");
            $stmt->execute([
                ':username' => $username,
                ':email' => $email,
                ':password' => $hashed_password,
                ':code' => $code
            ]);

            $success_message = "Inscription réussie ! Vous pouvez maintenant vous connecter.";
        } catch (Exception $e) {
            $error_message = "Erreur : " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>M'inscrire</title>
    <link rel="stylesheet" href="../../styles/register.css">
</head>
<body>
    <?php if (!empty($error_message)): ?>
        <p style="color: red; text-align: center;"><?= htmlspecialchars($error_message) ?></p>
    <?php elseif (!empty($success_message)): ?>
        <p style="color: green; text-align: center;"><?= htmlspecialchars($success_message) ?></p>
    <?php endif; ?>

    <form action="" method="post">
        <a href="https://r207.borelly.net/~u22404768/SAE23/pages/">
            <h1>BMW Osval</h1>
        </a>
        <a href="https://r207.borelly.net/~u22404768/SAE23/pages/">
            <img src="../../styles/svg/home.svg" alt="Home" class="home">
        </a>
        <div class="container">
            <div class="notif">
                <p id="title">Formulaire d'inscription</p>
                <div class="champs">
                    <hr>
                    <label for="username"><b>Nom & prénom :</b></label>
                    <input type="text" placeholder="Entrez votre nom et prénom" name="username" id="username" required>
                    <br>
                    <label for="email"><b>Adresse Email :</b></label>
                    <input type="email" placeholder="Entrez votre adresse email" name="email" id="email" required>
                    <br>
                    <label for="psw"><b>Mot de passe :</b></label>
                    <input type="password" placeholder="Entrez votre mot de passe" name="psw" id="psw" required>
                    <br>
                    <label for="code"><b>Code d'inscription :</b></label>
                    <input type="text" placeholder="Entrez le code d'inscription" name="code" id="code" required>
                    <hr>
                    <p>En vous inscrivant, vous acceptez nos <a href="ok.html">Conditions générales d'utilisation</a></p>
                    <button class="registerbtn" id="btn" type="submit">S'inscrire</button>
                    <div id="bas">
                        <p>Vous avez déjà un compte ? <a href="login.php">Connectez-vous ici</a></p>
                    </div>
                </div>
            </div>
        </div>
    </form>
</body>
</html>