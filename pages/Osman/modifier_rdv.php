<?php
// Connexion à la base de données
try {
    $pdo = new PDO('mysql:host=localhost;charset=utf8;dbname=db_CETINER', '22409662', '726209');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Vérifier que l'ID est bien passé
if (!isset($_GET['id_rdv'])) {
    die("ID du rendez-vous manquant !");
}

$id_rdv = intval($_GET['id_rdv']);

// Traitement du formulaire de modification
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $prenom = $_POST['prenom'];
    $nom = $_POST['nom'];
    $type = $_POST['type'];
    $date = $_POST['date'];
    $heure = $_POST['heure'];
    $mail = $_POST['mail'];
    $numero = $_POST['numero'];
    $nom_conseiller = $_POST['nom_conseiller'];

    $sql = "UPDATE RDV SET prenom = :prenom, nom = :nom, type = :type, date = :date, heure = :heure, mail = :mail, numero = :numero, nom_conseiller = :nom_conseiller WHERE id_rdv = :id_rdv";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':prenom' => $prenom,
        ':nom' => $nom,
        ':type' => $type,
        ':date' => $date,
        ':heure' => $heure,
        ':mail' => $mail,
        ':numero' => $numero,
        ':nom_conseiller' => $nom_conseiller,
        ':id_rdv' => $id_rdv
    ]);

    header('Location: lire_rdv.php?message=modifie');
    exit();
}

// Récupération des données du rendez-vous
$stmt = $pdo->prepare("SELECT * FROM RDV WHERE id_rdv = :id_rdv");
$stmt->execute([':id_rdv' => $id_rdv]);
$rdv = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$rdv) {
    die("Rendez-vous introuvable.");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier le rendez-vous</title>
    <style>
        body {
            background-color: #121212;
            color: #f5f5f5;
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 600px;
            margin: 2rem auto;
            background-color: #1e1e1e;
            padding: 2rem;
            border-radius: 10px;
        }
        label {
            display: block;
            margin-top: 1rem;
        }
        input, select {
            width: 100%;
            padding: 0.5rem;
            background-color: #2c2c2c;
            color: white;
            border: 1px solid #444;
            border-radius: 4px;
        }
        button {
            margin-top: 2rem;
            padding: 0.7rem 1.5rem;
            background-color: #00bcd4;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        a {
            display: inline-block;
            margin-top: 1rem;
            color: #00bcd4;
            text-decoration: none;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Modifier un rendez-vous</h1>
    <form method="POST">
        <label for="prenom">Prénom :</label>
        <input type="text" name="prenom" id="prenom" value="<?= htmlspecialchars($rdv['prenom']) ?>" required>

        <label for="nom">Nom :</label>
        <input type="text" name="nom" id="nom" value="<?= htmlspecialchars($rdv['nom']) ?>" required>

        <label for="type">Type :</label>
        <select name="type" id="type" required>
            <?php
            $types = ['RV', 'EV', 'C', 'G', 'A'];
            foreach ($types as $t) {
                $selected = ($rdv['type'] === $t) ? 'selected' : '';
                echo "<option value=\"$t\" $selected>$t</option>";
            }
            ?>
        </select>

        <label for="date">Date :</label>
        <input type="date" name="date" id="date" value="<?= htmlspecialchars($rdv['date']) ?>" required>

        <label for="heure">Heure :</label>
        <input type="time" name="heure" id="heure" value="<?= htmlspecialchars(substr($rdv['heure'], 0, 5)) ?>" required>

        <label for="mail">E-mail :</label>
        <input type="email" name="mail" id="mail" value="<?= htmlspecialchars($rdv['mail']) ?>" required>

        <label for="numero">Téléphone :</label>
        <input type="text" name="numero" id="numero" value="<?= htmlspecialchars($rdv['numero']) ?>" required>

        <label for="nom_conseiller">Conseiller :</label>
        <input type="text" name="nom_conseiller" id="nom_conseiller" value="<?= htmlspecialchars($rdv['nom_conseiller']) ?>" required>

        <button type="submit">Enregistrer les modifications</button>
    </form>

    <a href="lire_rdv.php">← Retour à la liste des rendez-vous</a>
</div>
</body>
</html>
