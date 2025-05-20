<?php
// Connexion à la base de données
try {
    $pdo = new PDO('mysql:host=localhost;charset=utf8;dbname=db_CETINER', '22409662', '726209');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

// Masquer une plaque (mettre supprimer = 1)
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id_plaque'])) {
    $id_plaque = intval($_GET['id_plaque']);
    $stmt = $pdo->prepare("UPDATE Plaque SET supprimer = 1 WHERE id_plaque = :id");
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

// Liste des plaques (afficher uniquement celles non supprimées)
$stmt = $pdo->query("SELECT * FROM Plaque WHERE supprimer = 0");
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
    <div class="header">
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
    <title>Modifier et lire les plaques</title>
    <style>
        body {
            background-color:rgb(255, 255, 255);
            color:rgb(0, 0, 0);
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
            background-color:rgb(224, 224, 224);
        }
        tr:nth-child(even) {
            background-color:rgb(224, 224, 224);
        }
        .actions a {
            color: #00bcd4;
            text-decoration: none;
            margin-right: 0.5rem;
        }
        .form-section {
            background-color:rgb(224, 224, 224);
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
            border-radius: 10%; 
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
                    <a href="modifier_lire_plaque.php?action=delete&id_plaque=<?= $plaque['id_plaque'] ?>" onclick="return confirm('Êtes-vous sûr de vouloir masquer cette entrée ?')">Masquer</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <?php if ($plaque_to_edit): ?>
        <div class="form-section">
            <h2>Administration - Modifier une plaque</h2>
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
