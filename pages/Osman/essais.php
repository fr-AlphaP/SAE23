<?php
// Connexion à la base de données
try {
    $pdo = new PDO("mysql:host=localhost;dbname=db_CETINER;charset=utf8", "22409662", "726209");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Traitement du formulaire
$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $prenom      = trim($_POST['prenom']);
    $nom         = trim($_POST['nom']);
    $email       = trim($_POST['email']);
    $telephone   = trim($_POST['telephone']);
    $date_essai  = $_POST['date_essai'];
    $heure_essai = $_POST['heure_essai'];
    $modele      = $_POST['modele'];
    $status      = 'en attente';

    if ($prenom && $nom && $email && $telephone && $date_essai && $heure_essai && $modele) {
        try {
            $stmt = $pdo->prepare("
                INSERT INTO Essais (prenom, nom, email, telephone, date_essai, heure_essai, modele, status) 
                VALUES (:prenom, :nom, :email, :telephone, :date_essai, :heure_essai, :modele, :status)
            ");

            $stmt->execute([
                ':prenom'      => $prenom,
                ':nom'         => $nom,
                ':email'       => $email,
                ':telephone'   => $telephone,
                ':date_essai'  => $date_essai,
                ':heure_essai' => $heure_essai,
                ':modele'      => $modele,
                ':status'      => $status
            ]);

            $success = "✅ Votre demande d’essai a bien été enregistrée.";
        } catch (Exception $e) {
            $error = "❌ Erreur : " . $e->getMessage();
        }
    } else {
        $error = "❗ Tous les champs sont obligatoires.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Réservation d'essai BMW</title>
    <style>
        body {
            background-color: white;
            color: black;
            font-family: Arial, sans-serif;
        }

        form {
            max-width: 500px;
            margin: auto;
            background-color:rgb(230, 230, 230);
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 0 10px #000;
        }

        label {
            display: block;
            /* margin-top: 1rem; */
            margin-bottom: 0.3rem;
        }

        input, select {
            width: 100%;
            padding: 0.5rem;
            background-color:rgb(252, 252, 252);
            color:rgb(0, 0, 0);
            border: 1px solid #555;
            border-radius: 5px;
        }

        input::placeholder {
            color: #aaaaaa;
        }

        button {
            margin-top: 1.5rem;
            padding: 0.7rem;
            width: 100%;
            background-color: #0070ba;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #005a94;
        }

        .message, .error {
            max-width: 500px;
            margin: 1rem auto;
            padding: 1rem;
            border-radius: 5px;
            text-align: center;
        }

        .message {
            background-color: #2e7d32;
            color: #fff;
        }

        .error {
            background-color: #c62828;
            color: #fff;
        }

        h1 {
            text-align: center;
        }

        .footer {
            margin-top: -5vh;
            font-size: 2.5vh;
            justify-content: center;
            align-items: center;
            display: flex;
            flex-direction: column;
            flex-wrap: wrap;
            gap: 0;
            height: 10vw;
            width: 100%;
        }

        .footer p {
            margin: 0;
            padding: 0;
            color: black;
        }
        #hrbas {
            margin-top: 5vw;
            margin-bottom: 5vw;
            display: block;
            margin-left: auto;
            margin-right: auto;
            width: 70%;
            height: 2px;
            background-color: #2ecc71;
            border: none;
        }

        
        .footer {
            font-size: 2.5vh;
            justify-content: center;
            align-items: center;
            display: flex;
            flex-direction: column;
            flex-wrap: wrap;
            gap: 0;
            height: 10vw;
            width: 100%;
            /* background-color: red; */
        }

        .footer p {
            margin: 0;
            padding: 0;
            color: black;
        }
        #hrbas {
            /* margin-top: 5vh; */
            display: block;
            margin-left: auto;
            margin-right: auto;
            width: 80%;
            height: 2px;
            background-color: #2ecc71;
            border: none;
        }

        /* Header */
        .header {
            margin: 0;
            padding: 0;
            height: 20vh;
            border-top: 2px solid #2ecc71;
            /* border-bottom: 2px solid #2ecc71; */
            display: flex;
            /* background-color: red; */
            
        }


        .header h1 {
            font-size: 2rem;
            color: black;
            margin: 0;
            padding: 1rem;
            text-align: left;
        }

        .header h2 {
            font-size: 1.5rem;
            color: black;
            margin-top: -20px;
            padding-left: 1rem;
            text-align: left;
        }

        .logo-container {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-grow: 1;
        }

    .logo {
            margin-top: -8vh;
            /* background-color: blue; */
        }

        .backtqt {
            height: 100%;
            width: 100%;
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }

        .logoback {
            width: 80px;
            height: 80px;
            margin-top : -3vh;
            margin-right: 10px; /* Ajout d'une marge pour l'espacement */
            display: block; /* S'assure que les dimensions sont respectées */
            background-color: #2ecc71;
            border-radius: 10%; Vous pouvez décommenter pour des coins arrondis
        }


    </style>
</head>
<body>
    <div class="header">
        <div class="title"> 
            <h1>BMW Osval</h1>
            <h2>Le plaisir de conduire</h2>
        </div>
        <div class="logo-container">
            <img class="logo" src="../../styles/img/bmw_logo.webp" alt="Logo BMW" style="width: 80px; height: auto; margin-left: 1rem;">
            <div class="backtqt">
                <a href="../index.html"><img class="logoback" src="../../styles/svg/home.svg" alt="Logo Osval" style="margin-left: 1rem;"></a>
            </div>
        </div>
    </div>

<h1>Réservez un essai BMW</h1>

<?php if ($success): ?>
    <div class="message"><?= htmlspecialchars($success) ?></div>
<?php elseif ($error): ?>
    <div class="error"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form method="POST" action="essais.php">
    <label for="prenom">Prénom :</label>
    <input type="text" id="prenom" name="prenom" required>

    <label for="nom">Nom :</label>
    <input type="text" id="nom" name="nom" required>

    <label for="email">Adresse e-mail :</label>
    <input type="email" id="email" name="email" required>

    <label for="telephone">Téléphone :</label>
    <input type="text" id="telephone" name="telephone" required>

    <label for="date_essai">Date souhaitée :</label>
    <input type="date" id="date_essai" name="date_essai" required>

    <label for="heure_essai">Heure souhaitée :</label>
    <input type="time" id="heure_essai" name="heure_essai" required>

    <label for="modele">Modèle à essayer :</label>
    <select id="modele" name="modele" required>
        <option value="">-- Sélectionnez un modèle --</option>
        <option value="BMW Serie 3">BMW Série 3</option>
        <option value="BMW X5">BMW X5</option>
        <option value="BMW i4">BMW i4</option>
        <option value="BMW M4">BMW M4</option>
        <option value="BMW Série 5">BMW Série 5</option>
        <option value="BMW X3">BMW X3</option>
    </select>

    <button type="submit">Envoyer la demande</button>
</form>
    <hr id="hrbas">
    <div class="footer">
        <p>© 2025 BMW Osval. Tous droits réservés.</p>
        <p>Mentions légales | Politique de confidentialité</p>
        <p><b>Ce site n'est pas un site commercial, il a été réalisé dans le cadre d'un projet Fictif</b></p>
        <p><b>IUT de Béziers</b></p>
    </div>
</body>
</html>
