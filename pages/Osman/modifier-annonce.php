<?php
// Connexion à la base de données
try {
    $pdo = new PDO('mysql:host=localhost;charset=utf8;dbname=db_CETINER', '22409662', '726209');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Vérifier si l'ID est passé dans l'URL
if (!isset($_GET['id_mat']) || empty($_GET['id_mat'])) {
    die("ID manquant ou invalide !");
}

$id_mat = intval($_GET['id_mat']); // Sécuriser l'ID pour éviter les injections

// Si le formulaire est soumis, on met à jour l'annonce
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $marque = $_POST['marque'];
    $modele = $_POST['modele'];
    $annee = $_POST['annee'];
    $prix = $_POST['prix'];
    $description = $_POST['description'];
    $image = $_POST['image'];

    $sql = "UPDATE Stock SET marque = ?, modele = ?, annee = ?, prix = ?, description = ?, image = ? WHERE id_mat = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$marque, $modele, $annee, $prix, $description, $image, $id_mat]);

    header("Location: modeles.php?message=modifié");
    exit();
}

// Récupérer les informations de l'annonce à modifier
$stmt = $pdo->prepare("SELECT * FROM Stock WHERE id_mat = ?");
$stmt->execute([$id_mat]);
$annonce = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$annonce) {
    die("Annonce introuvable.");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier l'annonce</title>
    <style>
        * {
            margin: 0;
            padding: 0;
        }
        h1 {
            color: black;
            text-align: center;
            margin-top: 20px;
        }

        body {
            margin: 0;
            padding: 0;
            background-color:rgb(255, 255, 255);
            color: white;
            font-family: 'Segoe UI', sans-serif;
            padding: 2rem;
        }

        form {
            background-color:rgb(224, 224, 224);
            padding: 2rem;
            border-radius: 10px;
            max-width: 600px;
            margin: auto;
        }

        input, textarea {
            width: 100%;
            margin-bottom: 1rem;
            padding: 10px;
            background-color: white;
            border: none;
            color: black;
            border-radius: 5px;
        }

        button {
            background-color: #0066cc;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #004999;
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
                <a href="../index.html"><img class="logoback" src="../../styles/svg/home.svg" alt="Logo Osval" style="margin-left: 1rem;"></a>
            </div>
        </div>
    </div>
    <h1>Modifier l'annonce</h1>
    <form method="post">
        <input type="text" name="marque" value="<?= htmlspecialchars($annonce['marque']) ?>" required>
        <input type="text" name="modele" value="<?= htmlspecialchars($annonce['modele']) ?>" required>
        <input type="number" name="annee" value="<?= htmlspecialchars($annonce['annee']) ?>" required>
        <input type="number" name="prix" value="<?= htmlspecialchars($annonce['prix']) ?>" required>
        <input type="text" name="image" value="<?= htmlspecialchars($annonce['image']) ?>">
        <textarea name="description" rows="5" required><?= htmlspecialchars($annonce['description']) ?></textarea>
        <button type="submit">Enregistrer</button>
    </form>

        <hr id="hrbas">
        <div class="footer">
            <p>© 2025 BMW Osval. Tous droits réservés.</p>
            <p>Mentions légales | Politique de confidentialité</p>
            <p><b>Ce site n'est pas un site commercial, il a été réalisé dans le cadre d'un projet Fictif</b></p>
            <p><b>IUT de Béziers</b></p>
        </div>
</body>
</html>
