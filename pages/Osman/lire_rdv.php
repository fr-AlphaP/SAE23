<?php
// Connexion à la base de données
try {
    $pdo = new PDO('mysql:host=localhost;charset=utf8;dbname=db_CETINER', '22409662', '726209');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Masquer un rendez-vous (mettre supprimer = 1)
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id_rdv'])) {
    $stmt = $pdo->prepare("UPDATE RDV SET supprimer = 1 WHERE id_rdv = :id_rdv");
    $stmt->execute([':id_rdv' => intval($_GET['id_rdv'])]);
    header("Location: lire_rdv.php?message=supprimé");
    exit();
}

// Récupération des rendez-vous (afficher uniquement ceux où supprimer = 0)
$stmt = $pdo->query("SELECT * FROM RDV WHERE supprimer = 0 ORDER BY date, heure");
$rdvs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des rendez-vous</title>
    <style>
        body {
            background-color:rgb(255, 255, 255);
            color:rgb(0, 0, 0);
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 2rem;
            background-color:rgb(224, 224, 224);
            border-radius: 8px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 2rem;
        }
        th, td {
            padding: 0.75rem;
            border: 1px solid #333;
            text-align: left;
        }
        th {
            background-color:rgb(255, 255, 255);
        }
        tr:nth-child(even) {
            background-color:rgb(201, 201, 201);
        }
        .actions a {
            color: #00bcd4;
            text-decoration: none;
            margin-right: 1rem;
        }
        .add-button {
            display: inline-block;
            margin-bottom: 1rem;
            background-color: #00bcd4;
            color: white;
            padding: 0.7rem 1.2rem;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
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
    <h1>Administration - Liste des rendez-vous</h1>

    <a href="demande_rdv.php" class="add-button">+ Ajouter un rendez-vous</a>

    <?php if (isset($_GET['message']) && $_GET['message'] == 'supprimé'): ?>
        <p style="color: lightgreen;">Rendez-vous masqué avec succès.</p>
    <?php elseif (isset($_GET['message']) && $_GET['message'] == 'modifie'): ?>
        <p style="color: lightgreen;">Rendez-vous modifié avec succès.</p>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Prénom</th>
                <th>Nom</th>
                <th>Type</th>
                <th>Date</th>
                <th>Heure</th>
                <th>Email</th>
                <th>Téléphone</th>
                <th>Conseiller</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rdvs as $rdv): ?>
            <tr>
                <td><?= htmlspecialchars($rdv['id_rdv']) ?></td>
                <td><?= htmlspecialchars($rdv['prenom']) ?></td>
                <td><?= htmlspecialchars($rdv['nom']) ?></td>
                <td><?= htmlspecialchars($rdv['type']) ?></td>
                <td><?= htmlspecialchars($rdv['date']) ?></td>
                <td><?= htmlspecialchars(substr($rdv['heure'], 0, 5)) ?></td>
                <td><?= htmlspecialchars($rdv['mail']) ?></td>
                <td><?= htmlspecialchars($rdv['numero']) ?></td>
                <td><?= htmlspecialchars($rdv['nom_conseiller']) ?></td>
                <td class="actions">
                    <a href="modifier_rdv.php?id_rdv=<?= $rdv['id_rdv'] ?>">Modifier</a>
                    <a href="lire_rdv.php?action=delete&id_rdv=<?= $rdv['id_rdv'] ?>" onclick="return confirm('Supprimer ce rendez-vous ?')">Suppprimer</a>
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
