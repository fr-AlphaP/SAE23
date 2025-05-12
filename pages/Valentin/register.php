<?php
session_start(); // Bonne pratique, utile pour des messages flash ou la gestion de session future
$alert_message = null;
$alert_type = 'error'; // 'error' or 'success'

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']); // "Nom & prénom" sera stocké comme username
    $email = trim($_POST['email']);
    $password = $_POST['psw'];
    $password_repeat = $_POST['psw-repeat'];

    $errors = [];
    if (empty($username)) {
        $errors[] = "Le nom et prénom sont requis.";
    }
    if (empty($email)) {
        $errors[] = "L'adresse email est requise.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "L'adresse email n'est pas valide.";
    }
    if (empty($password)) {
        $errors[] = "Le mot de passe est requis.";
    } elseif (strlen($password) < 8) { // Exemple de longueur minimale
        $errors[] = "Le mot de passe doit contenir au moins 8 caractères.";
    }
    if ($password !== $password_repeat) {
        $errors[] = "Les mots de passe ne correspondent pas.";
    }

    if (empty($errors)) {
        try {
            // Connexion à la base de données
            $pdo = new PDO('mysql:host=localhost;charset=utf8;dbname=db_MALOT', '22404768', '728596');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Vérifier si l'email existe déjà (PK)
            $stmt = $pdo->prepare("SELECT email FROM Logins WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            if ($stmt->fetch()) {
                $errors[] = "Cette adresse email est déjà utilisée.";
            }

            // Vérifier si le nom d'utilisateur existe déjà
            if (empty($errors)) { // Seulement si l'email n'est pas déjà pris
                $stmt = $pdo->prepare("SELECT username FROM Logins WHERE username = :username");
                $stmt->bindParam(':username', $username);
                $stmt->execute();
                if ($stmt->fetch()) {
                    $errors[] = "Ce nom d'utilisateur (Nom & prénom) est déjà utilisé.";
                }
            }

            if (empty($errors)) {
                // Hasher le mot de passe
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // Insérer l'utilisateur
                $insert_stmt = $pdo->prepare("INSERT INTO Logins (username, email, password) VALUES (:username, :email, :password)");
                $insert_stmt->bindParam(':username', $username);
                $insert_stmt->bindParam(':email', $email);
                $insert_stmt->bindParam(':password', $hashed_password);
                
                if ($insert_stmt->execute()) {
                    $safe_username = htmlspecialchars($username, ENT_QUOTES, 'UTF-8');
                    $safe_email = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
                    $alert_message = "Compte créé! Identifiants: {$safe_username}, Email: {$safe_email}";
                    $alert_type = 'success';
                    // Pour éviter la resoumission du formulaire, on pourrait rediriger ici après l'alerte
                    // ou vider les variables POST. Pour l'instant, l'alerte s'affichera et le formulaire restera.
                    $_POST = array(); // Vider les données POST pour ne pas re-remplir le formulaire après succès
                } else {
                    $errors[] = "Une erreur est survenue lors de la création du compte.";
                }
            }
        } catch (PDOException $e) {
            // En mode développement, vous pourriez vouloir voir $e->getMessage()
            // error_log("Erreur PDO: " . $e->getMessage()); 
            $errors[] = "Erreur de connexion à la base de données. Veuillez réessayer plus tard.";
        }
    }

    if (!empty($errors) && $alert_type === 'error') {
        // Formatte les erreurs pour l'alerte JavaScript
        $alert_message = implode("\\n", array_map('addslashes', $errors));
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../styles/register.css">
    <title>M'inscrire</title>
</head>
<body>
    <form action="register.php" method="post">
    <a href="https://r207.borelly.net/~u22404768/SAE23/pages/">
        <h1>BMW Group</h1>
    </a>
    <a href="https://r207.borelly.net/~u22404768/SAE23/pages/">
        <img src="../../styles/svg/home.svg" alt="Home" class="home">
    </a>
    <div class="container">
        <div class="notif">
            <p id="title">Formulaire d'inscription</p>
            <div class="champs">
            <hr>
                <label for="username"><b>Nom & prénom</b></label>
                <input type="text" placeholder="Entrez votre nom et prénom" name="username" id="username" required value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username'], ENT_QUOTES) : ''; ?>">

                <label for="email"><b>Adresse Email</b></label>
                <input type="email" placeholder="Entrez votre adresse email" name="email" id="email" required value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email'], ENT_QUOTES) : ''; ?>">

                <label for="psw"><b>Mot de passe</b></label>
                <input type="password" placeholder="Entrez votre mot de passe" name="psw" id="psw" required>

                <label for="psw-repeat"><b>Mot de passe (Confirmation) </b></label>
                <input type="password" placeholder="Répétez votre mot de passe" name="psw-repeat" id="psw-repeat" required>
                <hr>

                <p>En vous inscrivant, vous acceptez nos<a href="ok.html"> Conditions générales d'utilisation</a></p>
                <button type="submit" class="registerbtn">S'inscrire</button>
                <p id="bas">Avez vous déjà un compte ? -> <a href="login.php">Connectez-vous ici</a></p>
            </div>
        </div>
    </div>
    </form> 

    <script>
    <?php
    if ($alert_message !== null) {
        echo "alert('{$alert_message}');";
        // Si l'inscription a réussi et que vous souhaitez rediriger l'utilisateur:
        if ($alert_type === 'success') {
            // Décommentez la ligne suivante pour rediriger vers login.php après l'alerte
            // echo "window.location.href = 'login.php';"; 
        }
    }
    ?>
    </script>
</body>
</html>