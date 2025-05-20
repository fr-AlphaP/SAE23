<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=db_CETINER;charset=utf8", "22409662", "726209");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Masquer une annonce (mettre supprimer = 1)
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id_essai'])) {
    $stmt = $pdo->prepare("UPDATE Essais SET supprimer = 1 WHERE id_essai = :id_essai");
    $stmt->execute([':id_essai' => intval($_GET['id_essai'])]);
    header("Location: lire_essais.php?message=supprimé");
    exit();
}

// Récupération des essais (afficher uniquement ceux où supprimer = 0)
$essais = $pdo->query("SELECT * FROM Essais WHERE supprimer = 0 ORDER BY date_essai DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des essais</title>
    <style>
        body {
            background-color:rgb(255, 255, 255);
            color:rgb(0, 0, 0);
            font-family: Arial, sans-serif;
            padding: 2rem;
        }

        h2 {
            text-align: center;
            margin-bottom: 2rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 2rem;
        }

        th, td {
            border: 1px solid #444;
            padding: 0.8rem;
            text-align: left;
        }

        th {
            background-color:rgb(255, 255, 255);
            color:rgb(0, 0, 0);
        }

        tr:nth-child(even) {
            background-color:rgb(224, 224, 224);
        }

        .buttons {
            display: flex;
            gap: 0.5rem;
        }

        a, button {
            padding: 0.5rem 1rem;
            text-decoration: none;
            font-weight: bold;
            border: none;
            cursor: pointer;
        }

        .modifier {
            background-color: #1976d2;
            color: white;
        }

        .confirmer {
            background-color: #2e7d32;
            color: white;
        }

        .annuler {
            background-color: #c62828;
            color: white;
        }

        .supprimer {
            background-color: #d32f2f;
            color: white;
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

<h2>Demandes d'essai</h2>

<?php if (isset($_GET['message']) && $_GET['message'] == 'supprimé'): ?>
    <p style="color: lightgreen;">Annonce supprimée avec succès.</p>
<?php endif; ?>

<table>
    <thead>
        <tr>
            <th>Nom</th>
            <th>Email</th>
            <th>Téléphone</th>
            <th>Date</th>
            <th>Heure</th>
            <th>Modèle</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($essais as $essai): ?>
        <tr>
            <td><?= htmlspecialchars($essai['prenom'] . ' ' . $essai['nom']) ?></td>
            <td><?= htmlspecialchars($essai['email']) ?></td>
            <td><?= htmlspecialchars($essai['telephone']) ?></td>
            <td><?= htmlspecialchars($essai['date_essai']) ?></td>
            <td><?= htmlspecialchars($essai['heure_essai']) ?></td>
            <td><?= htmlspecialchars($essai['modele']) ?></td>
            <td><?= htmlspecialchars($essai['status']) ?></td>
            <td class="buttons">
                <a class="modifier" href="modifier_essais.php?id=<?= $essai['id_essai'] ?>">✏️ Modifier</a>
                <form method="POST" action="modifier_essais.php" style="display:inline;">
                    <input type="hidden" name="id" value="<?= $essai['id_essai'] ?>">
                    <input type="hidden" name="status" value="confirmé">
                    <button type="submit" class="confirmer">✅ Confirmer</button>
                </form>
                <form method="POST" action="modifier_essais.php" style="display:inline;">
                    <input type="hidden" name="id" value="<?= $essai['id_essai'] ?>">
                    <input type="hidden" name="status" value="annulé">
                    <button type="submit" class="annuler">❌ Annuler</button>
                </form>
                <a class="supprimer" href="lire_essais.php?action=delete&id_essai=<?= $essai['id_essai'] ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette annonce ?')">❌ Supprimer</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
        <hr id="hrbas">
        <div class="footer">
            <p>© 2025 BMW Osval. Tous droits réservés.</p>
            <p>Mentions légales | Politique de confidentialité</p>
            <p><b>Ce site n'est pas un site commercial, il a été réalisé dans le cadre d'un projet Fictif</b></p>
            <p><b>IUT de Béziers</b></p>
        </div>

</body>
</html>
