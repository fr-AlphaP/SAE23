<?php
// Connexion à la base de données
try {
    $pdo = new PDO('mysql:host=localhost;charset=utf8;dbname=db_CETINER', '22409662', '726209');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

// Suppression d'une entrée
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id_plaque'])) {
    $id_plaque = $_GET['id_plaque'];
    $sql = "DELETE FROM Plaque WHERE id_plaque = :id_plaque";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id_plaque' => $id_plaque]);
    header('Location: afficher_plaques.php');
    exit();
}

// Récupération des données
$sql = "SELECT * FROM Plaque";
$stmt = $pdo->query($sql);
$plaques = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Afficher les plaques</title>
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 2rem;
        }
        th, td {
            border: 1px solid #333;
            padding: 0.5rem;
            text-align: left;
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
                        <a href="afficher_plaques.php?action=delete&id_plaque=<?= $plaque['id_plaque'] ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette entrée ?')">Supprimer</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
