<?php
// Connexion à la base de données
try {
    $pdo = new PDO('mysql:host=localhost;charset=utf8;dbname=db_CETINER', '22409662', '726209');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

// Traitement de suppression
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id_plaque'])) {
    $id_plaque = intval($_GET['id_plaque']);
    $stmt = $pdo->prepare("DELETE FROM Plaque WHERE id_plaque = :id");
    $stmt->execute([':id' => $id_plaque]);
    header('Location: modifier_lire_plaque.php');
    exit();
}

// Traitement de mise à jour
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_plaque'])) {
    $id = intval($_POST['id_plaque']);
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $serie = $_POST['serie'];

    $sql = "UPDATE Plaque SET nom = :nom, prenom = :prenom, serie_vehicule = :serie WHERE id_plaque = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nom' => $nom,
        ':prenom' => $prenom,
        ':serie' => $serie,
        ':id' => $id
    ]);
    header("Location: modifier_lire_plaque.php");
    exit();
}

// Liste des plaques
$stmt = $pdo->query("SELECT * FROM Plaque");
$plaques = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Chargement des infos pour édition
$plaque_to_edit = null;
if (isset($_GET['id_plaque'])) {
    $stmt = $pdo->prepare("SELECT * FROM Plaque WHERE id_plaque = :id");
    $stmt->execute([':id' => intval($_GET['id_plaque'])]);
    $plaque_to_edit = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier et lire les plaques</title>
    <style>
        body {
            background-color: #121212;
            color: #f5f5f5;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 2rem;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 2rem;
        }
        th, td {
            border: 1px solid #333;
            padding: 0.5rem;
        }
        th {
            background-color: #1f1f1f;
        }
        tr:nth-child(even) {
            background-color: #1e1e1e;
        }
        .actions a {
            color: #00bcd4;
            text-decoration: none;
            margin-right: 0.5rem;
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
    </style>
</head>
<body>
<div class="container">
    <h1>Liste des plaques</h1>
    <table>
        <thead>
        <tr>
            <th>ID Plaque</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Numéro de série</th>
            <th>Plaque</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($plaques as $plaque): ?>
            <tr>
                <td><?= htmlspecialchars($plaque['id_plaque']) ?></td>
                <td><?= htmlspecialchars($plaque['nom']) ?></td>
                <td><?= htmlspecialchars($plaque['prenom']) ?></td>
                <td><?= htmlspecialchars($plaque['serie_vehicule']) ?></td>
                <td><?= htmlspecialchars($plaque['plaque']) ?></td>
                <td class="actions">
                    <a href="modifier_lire_plaque.php?id_plaque=<?= $plaque['id_plaque'] ?>">Modifier</a>
                    <a href="modifier_lire_plaque.php?action=delete&id_plaque=<?= $plaque['id_plaque'] ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette entrée ?')">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <?php if ($plaque_to_edit): ?>
        <div class="form-section">
            <h2>Modifier une plaque</h2>
            <form method="POST" action="modifier_lire_plaque.php">
                <input type="hidden" name="id_plaque" value="<?= htmlspecialchars($plaque_to_edit['id_plaque']) ?>">
                <label for="nom">Nom :</label>
                <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($plaque_to_edit['nom']) ?>" required>
                <label for="prenom">Prénom :</label>
                <input type="text" id="prenom" name="prenom" value="<?= htmlspecialchars($plaque_to_edit['prenom']) ?>" required>
                <label for="serie">Numéro de série du véhicule :</label>
                <input type="text" id="serie" name="serie" value="<?= htmlspecialchars($plaque_to_edit['serie_vehicule']) ?>" required>
                <button type="submit">Mettre à jour</button>
            </form>
        </div>
    <?php endif; ?>
</div>
</body>
</html>
