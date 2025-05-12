<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../../styles/login.css">
</head>
<body>
<body>
    <form action="login.php" method="post">
    <a href="https://r207.borelly.net/~u22404768/SAE23/pages/">
        <h1>BMW Group</h1>
    </a>
    <a href="https://r207.borelly.net/~u22404768/SAE23/pages/">
        <img src="../../styles/svg/home.svg" alt="Home" class="home">
    </a>
    <div class="container">
        <div class="notif">
            <p id="title">Formulaire de Connexion</p>
            <div class="champs">
            <hr>
                <label for="username"><b>Nom d'utilisateur :</b></label>
                <input id ="user" type="text" id="username" name="username" placeholder="Entrez votre nom d'utilisateur" required>
                <br>
                <label id="pass"for="password"><b>Mot de passe :</b></label>
                <input type="password" id="password" name="password" placeholder="Entrez votre mot de passe" required>
                <br>
                <button class="loginbtn" id="btn" type="submit">Me connecter</button>
                <!-- <button class="registerbtn"id="btn2" onclick="window.location.href='register.php'" type="button">S'inscrire</button> -->
                <!-- <button class="autre" id="btn3" onclick="window.location.href='index.html'" type="button">Retour</button> -->
                <div id="bas">
                    <p>Vous n'avez pas de compte : <a href="register.php">Inscrivez vous ici</a></p>
                </div>
            </div>
        </form>
    </div>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];

        try {
            $pdo = new PDO('mysql:host=localhost;charset=utf8;dbname=db_MALOT', '22404768', '728596');
            
            $statement = $pdo->prepare("SELECT * FROM Logins WHERE username = :username");
            $statement->execute([':username' => $username]);
            $user = $statement->fetch(PDO::FETCH_ASSOC);
            
            if ($user && ($password === $user['password'] || password_verify($password, $user['password']))) {
                // Si la connexion réussit
                echo "Login successful!";
                // Vous pourriez aussi démarrer une session
                // session_start();
                // $_SESSION['user_id'] = $user['id'];
                // $_SESSION['username'] = $user['username'];
                // header('Location: dashboard.php');
            } else {
                echo "Invalid username or password.";
            }
        }
        catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    ?>

</body>
</html>