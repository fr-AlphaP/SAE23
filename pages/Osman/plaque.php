<?php
// Connexion à la base de données
try {
    $pdo = new PDO('mysql:host=localhost;charset=utf8;dbname=db_CETINER', '22409662', '726209');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

// Fonction pour générer une plaque aléatoire (exemple : AB-123-CD)
function genererPlaque() {
    $lettres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $chiffres = rand(100, 999);
    $plaque = 
        $lettres[rand(0, 25)] . $lettres[rand(0, 25)] . '-' .
        $chiffres . '-' .
        $lettres[rand(0, 25)] . $lettres[rand(0, 25)];
    return $plaque;
}

// Traitement du formulaire
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'] ?? '';
    $prenom = $_POST['prenom'] ?? '';
    $serie = $_POST['serie'] ?? '';
    $plaque = genererPlaque();

    if (!empty($nom) && !empty($prenom) && !empty($serie)) {
        $sql = "INSERT INTO Plaque (nom, prenom, serie_vehicule, plaque) 
                VALUES (:nom, :prenom, :serie, :plaque)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':nom' => htmlspecialchars($nom),
            ':prenom' => htmlspecialchars($prenom),
            ':serie' => htmlspecialchars($serie),
            ':plaque' => $plaque
        ]);
        $message = "✅ Plaque générée avec succès : <strong>$plaque</strong>";
    } else {
        $message = "⚠️ Tous les champs sont obligatoires.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Générer ma plaque - BMW</title>
    <style>
        body {
            background-color:rgb(255, 255, 255);
            color: black;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 2rem;
        }

        .header {
            background-color: #1f1f1f;
            padding: 1rem;
            border-bottom: 2px solid #333;
        }

        #title {
            color: #ffffff;
            margin: 0;
        }

        .navo ul {
            list-style-type: none;
            padding: 0;
            display: flex;
            gap: 1rem;
        }

        .navo ul li a {
            color: #f5f5f5;
            text-decoration: none;
        }

        .form-section {
            margin: auto;
            width: 500px;
            background-color:rgb(201, 201, 201);
            padding: 2rem;
            border-radius: 8px;
            margin-top: 2rem;
        }

        .form-section label {
            display: block;
            margin-top: 1rem;
        }

        .form-section input {
            width: 100%;
            padding: 0.5rem;
            margin-top: 0.3rem;
            background-color: white;
            color: black;
            border: none;
            border-radius: 4px;
        }

        .form-section button {
            margin-top: 1.5rem;
            padding: 0.7rem 1.5rem;
            background-color: #00bcd4;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .message {
            margin-top: 1rem;
            padding: 1rem;
            border-radius: 5px;
            background-color: #2ecc71;
        }

        #hrbas {
            margin-top: 5vh;
            display: block;
            margin-left: auto;
            margin-right: auto;
            width: 80%;
            height: 2px;
            background-color: #2ecc71;
            border: none;
        }

        /* Header */
        .header2 {
            margin: 0;
            padding: 0;
            height: 20vh;
            border-top: 2px solid #2ecc71;
            /* border-bottom: 2px solid #2ecc71; */
            display: flex;
            /* background-color: red; */
            
        }


        .header2 h1 {
            font-size: 2rem;
            color: black;
            margin: 0;
            padding: 1rem;
            text-align: left;
        }

        .header2 h2 {
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

        .footer {
            font-size: 20px;
            justify-content: center;
            align-items: center;
            display: flex;
            flex-direction: column;
            flex-wrap: wrap;
            gap: 0;
            height: 20vw;
            width: 100%;
        }

        .footer p {

            margin: 0;
            padding: 0;
            margin-top: -10vh;
            color: black;
        }

    </style>
</head>
<body>
        <div class="header2">
            <div class="title"> 
                <h1>BMW Osval</h1>
                <h2>Le plaisir de conduire</h2>
            </div>
            <div class="logo-container">
                <img class="logo" src="../../styles/img/bmw_logo.webp" alt="Logo BMW" style="width: 80px; height: auto; margin-left: 1rem;">
                <div class="backtqt">
                    <a href="../Valentin/espace_employe.php"><img class="logoback" src="../../styles/svg/home.svg" alt="Logo Osval" style="margin-left: 1rem;"></a>
                </div>
            </div>
        </div>
        <div class="form-section">
            <h2>Formulaire de demande de plaque</h2>

            <?php if (!empty($message)): ?>
                <div class="message"><?= $message ?></div>
            <?php endif; ?>

            <form method="POST" action="plaque.php">
                <label for="nom">Nom :</label>
                <input type="text" id="nom" name="nom" required>

                <label for="prenom">Prénom :</label>
                <input type="text" id="prenom" name="prenom" required>

                <label for="serie">Numéro de série du véhicule :</label>
                <input type="text" id="serie" name="serie" required>

                <button type="submit">Générer une plaque</button>
            </form>
        </div>
    </div>
    <hr id="hrbas">
    <div class="footer">
        <p>© 2025 BMW Osval. Tous droits réservés.</p>
        <p>Mentions légales | Politique de confidentialité</p>
        <p><b>Ce site n'est pas un site commercial, il a été réalisé dans le cadre d'un projet Fictif</b></p>
        <p><b>IUT de Béziers</b></p>
    </div>
</body>
</html>
