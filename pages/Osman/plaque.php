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
            background-color: #121212;
            color: #f5f5f5;
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
            background-color: #1e1e1e;
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
            background-color: #333;
            color: #fff;
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
            background-color: #2e2e2e;
        }
    </style>
</head>
<body>
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
</body>
</html>
