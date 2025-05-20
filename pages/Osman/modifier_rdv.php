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
            background-color:rgb(255, 255, 255);
            color:rgb(0, 0, 0);
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 600px;
            margin: 2rem auto;
            background-color:rgb(224, 224, 224);
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
            background-color:white;
            color: black;
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
    <hr id="hrbas">
    <div class="footer">
        <p>© 2025 BMW Osval. Tous droits réservés.</p>
        <p>Mentions légales | Politique de confidentialité</p>
        <p><b>Ce site n'est pas un site commercial, il a été réalisé dans le cadre d'un projet Fictif</b></p>
        <p><b>IUT de Béziers</b></p>
    </div>
</body>
</html>
