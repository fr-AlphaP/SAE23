<?php
// Connexion à la base de données
try {
    $pdo = new PDO('mysql:host=localhost;charset=utf8;dbname=db_CETINER', '22409662', '726209');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

// Traitement du formulaire
$success = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $prenom = $_POST['prenom'];
    $nom = $_POST['nom'];
    $type = $_POST['type'];
    $date = $_POST['date'];
    $heure = $_POST['heure'];
    $mail = $_POST['mail'];
    $numero = $_POST['numero'];
    $nom_conseiller = $_POST['nom_conseiller'];

    $sql = "INSERT INTO rdv (prenom, nom, type, date, heure, mail, numero, nom_conseiller)
            VALUES (:prenom, :nom, :type, :date, :heure, :mail, :numero, :nom_conseiller)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':prenom' => $prenom,
        ':nom' => $nom,
        ':type' => $type,
        ':date' => $date,
        ':heure' => $heure,
        ':mail' => $mail,
        ':numero' => $numero,
        ':nom_conseiller' => $nom_conseiller
    ]);

    $success = true;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Demande de Rendez-vous</title>
    <style>
        body {
            background-color: #121212;
            color: #f5f5f5;
            font-family: Arial, sans-serif;
            padding: 2rem;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background-color: #1e1e1e;
            padding: 2rem;
            border-radius: 10px;
        }
        h1 {
            text-align: center;
        }
        label {
            display: block;
            margin-top: 1rem;
        }
        input, select {
            width: 100%;
            padding: 0.5rem;
            background-color: #333;
            border: none;
            border-radius: 4px;
            color: #fff;
            margin-top: 0.3rem;
        }
        button {
            margin-top: 1.5rem;
            width: 100%;
            padding: 0.7rem;
            background-color: #00bcd4;
            border: none;
            border-radius: 4px;
            color: #fff;
            font-weight: bold;
            cursor: pointer;
        }
        .success {
            margin-top: 1rem;
            color: #4caf50;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Prendre un rendez-vous</h1>
    <?php if ($success): ?>
        <p class="success">Votre demande de rendez-vous a été enregistrée avec succès !</p>
    <?php endif; ?>
    <form method="POST" action="demande_rdv.php">
        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom" required>

        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" required>

        <label for="type">Type de rendez-vous :</label>
        <select id="type" name="type" required>
            <option value="RV">RV - Rendez-vous</option>
            <option value="EV">EV - Entretien</option>
            <option value="C">C - Conseil</option>
            <option value="G">G - Gestion</option>
            <option value="A">A - Autre</option>
        </select>

        <label for="date">Date :</label>
        <input type="date" id="date" name="date" required>

        <label for="heure">Heure :</label>
        <input type="time" id="heure" name="heure" step="1" required>

        <label for="mail">Adresse e-mail :</label>
        <input type="email" id="mail" name="mail" required>

        <label for="numero">Numéro de téléphone :</label>
        <input type="text" id="numero" name="numero" required>

        <label for="nom_conseiller">Nom du conseiller :</label>
        <input type="text" id="nom_conseiller" name="nom_conseiller" required>

        <button type="submit">Envoyer la demande</button>
    </form>
</div>
</body>
</html>
