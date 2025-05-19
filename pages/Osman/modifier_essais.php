<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=db_MALOT;charset=utf8", "22404768", "728596");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die("Erreur : " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && isset($_POST['status'])) {
    // Traitement rapide pour confirmer/annuler
    $stmt = $pdo->prepare("UPDATE Essais SET status = ? WHERE id_essai = ?");
    $stmt->execute([$_POST['status'], $_POST['id']]);
    header("Location: lire_essais.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM Essais WHERE id_essai = ?");
    $stmt->execute([$id]);
    $essai = $stmt->fetch();
    if (!$essai) die("Demande introuvable");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $stmt = $pdo->prepare("UPDATE Essais SET prenom=?, nom=?, email=?, telephone=?, date_essai=?, heure_essai=?, modele=? WHERE id_essai=?");
    $stmt->execute([
        $_POST['prenom'], $_POST['nom'], $_POST['email'], $_POST['telephone'],
        $_POST['date_essai'], $_POST['heure_essai'], $_POST['modele'], $_POST['id']
    ]);
    header("Location: lire_essais.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier essai</title>
    <style>
        body {
            background-color:rgb(255, 255, 255);
            color:rgb(0, 0, 0);
            font-family: Arial, sans-serif;
            padding: 2rem;
        }

        form {
            max-width: 600px;
            margin: auto;
            background-color:rgb(201, 201, 201);
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 0 10px #000;
        }

        label {
            display: block;
            margin-top: 1rem;
        }

        input, select {
            width: 100%;
            padding: 0.5rem;
            background-color: white;
            color: black;
            border: 1px solid #555;
            border-radius: 5px;
        }

        button {
            margin-top: 1.5rem;
            width: 100%;
            background-color: #2ecc71;
            color: white;
            padding: 0.8rem;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
        }

        h2 {
            text-align: center;
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
        .header2 {
            margin: 0;
            padding: 0;
            height: 20vh;
            border-top: 2px solid #2ecc71;
            /* border-bottom: 2px solid #2ecc71; */
            display: flex;
            /* background-color: red; */
            
        }


        .header2 h1 {
            font-size: 2rem;
            color: black;
            margin: 0;
            padding: 1rem;
            text-align: left;
        }

        .header2 h2 {
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
<div class="header2">
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

<h2>Modifier la demande d’essai</h2>

<?php if (isset($essai)): ?>
<form method="POST">
    <input type="hidden" name="id" value="<?= $essai['id_essai'] ?>">
    <label>Prénom :</label>
    <input type="text" name="prenom" value="<?= htmlspecialchars($essai['prenom']) ?>" required>

    <label>Nom :</label>
    <input type="text" name="nom" value="<?= htmlspecialchars($essai['nom']) ?>" required>

    <label>Email :</label>
    <input type="email" name="email" value="<?= htmlspecialchars($essai['email']) ?>" required>

    <label>Téléphone :</label>
    <input type="text" name="telephone" value="<?= htmlspecialchars($essai['telephone']) ?>" required>

    <label>Date :</label>
    <input type="date" name="date_essai" value="<?= $essai['date_essai'] ?>" required>

    <label>Heure :</label>
    <input type="time" name="heure_essai" value="<?= $essai['heure_essai'] ?>" required>

    <label>Modèle :</label>
    <select name="modele" required>
        <?php
        $modeles = ['BMW Serie 3', 'BMW x5', 'BMW i4', 'BMW M4', 'BMW Série 5', 'BMW X3'];
        foreach ($modeles as $modele) {
            $selected = ($essai['modele'] === $modele) ? "selected" : "";
            echo "<option value=\"$modele\" $selected>$modele</option>";
        }
        ?>
    </select>

    <button type="submit" name="update">💾 Enregistrer les modifications</button>
</form>
<?php endif; ?>

    <hr id="hrbas">
    <div class="footer">
        <p>© 2025 BMW Osval. Tous droits réservés.</p>
        <p>Mentions légales | Politique de confidentialité</p>
        <p><b>Ce site n'est pas un site commercial, il a été réalisé dans le cadre d'un projet Fictif</b></p>
        <p><b>IUT de Béziers</b></p>
    </div>
</body>
</html>
