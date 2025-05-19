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
        body {
            background-color: #121212;
            color: white;
            font-family: 'Segoe UI', sans-serif;
            padding: 2rem;
        }

        form {
            background-color: #1f1f1f;
            padding: 2rem;
            border-radius: 10px;
            max-width: 600px;
            margin: auto;
        }

        input, textarea {
            width: 100%;
            margin-bottom: 1rem;
            padding: 10px;
            background-color: #2a2a2a;
            border: none;
            color: white;
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
    </style>
</head>
<body>
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
</body>
</html>
