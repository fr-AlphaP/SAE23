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
            background-color:rgb(255, 255, 255);
            color:rgb(0, 0, 0);
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
            background-color:rgb(224, 224, 224);
        }
        tr:nth-child(even) {
            background-color:rgb(224, 224, 224);
        }
        .actions #mod {
            color:rgb(0, 152, 212);
            text-decoration: none;
            margin-right: 0.5rem;
        }
        .actions #sup {
            color:rgb(212, 0, 0);
            text-decoration: none;
            margin-right: 0.5rem;
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
                <a href="../Valentin/espace_employe.php"><img class="logoback" src="../../styles/svg/home.svg" alt="Logo Osval" style="margin-left: 1rem;"></a>
            </div>
        </div>
    </div>
    <div class="container">
        <h1>Administration - Liste des plaques</h1>
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
                        <a id="mod" href="modifier_lire_plaque.php?id_plaque=<?= $plaque['id_plaque'] ?>">Modifier</a>
                        <a id="sup" href="afficher_plaques.php?action=delete&id_plaque=<?= $plaque['id_plaque'] ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette entrée ?')">Supprimer</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
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
