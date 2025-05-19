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

    $sql = "INSERT INTO RDV (prenom, nom, type, date, heure, mail, numero, nom_conseiller)
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
    <div class="header">
        <div class="title"> 
            <h1>BMW Osval</h1>
            <h2>Le plaisir de conduire</h2>
        </div>
        <div class="logo-container">
            <img class="logo" src="../../styles/img/bmw_logo.webp" alt="Logo BMW" style="width: 80px; height: auto; margin-left: 1rem;">
            <div class="backtqt">
                <a href="../index.html"><img class="logoback" src="../../styles/svg/home.svg" alt="Logo Osval" style="margin-left: 1rem;"></a>
            </div>
        </div>
    </div>
    <title>Demande de Rendez-vous</title>
    <style>
        body {
            background-color: white;
            color:rgb(0, 0, 0);
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background-color:rgb(201, 201, 201);
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 10px 32px rgba(0, 0, 0, 0.25);
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
            background-color: white;
            border: none;
            border-radius: 4px;
            color: black;
            margin-top: 0.3rem;
        }
        button {
            margin-top: 1.5rem;
            width: 100%;
            padding: 0.7rem;
            background-color: #4caf50;
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

        .footer {
            margin-top: -5vh;
            font-size: 2.5vh;
            justify-content: center;
            align-items: center;
            display: flex;
            flex-direction: column;
            flex-wrap: wrap;
            gap: 0;
            height: 10vw;
            width: 100%;
        }

        .footer p {
            margin: 0;
            padding: 0;
            color: black;
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
    <hr id="hrbas">
    <div class="footer">
        <p>© 2025 BMW Osval. Tous droits réservés.</p>
        <p>Mentions légales | Politique de confidentialité</p>
        <p><b>Ce site n'est pas un site commercial, il a été réalisé dans le cadre d'un projet Fictif</b></p>
        <p><b>IUT de Béziers</b></p>
    </div>
</body>
</html>
