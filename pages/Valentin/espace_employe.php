<?php


session_start();
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Espace Employé</title>
    <style>
        body {
            background-color:rgb(255, 255, 255);
            color:rgb(0, 0, 0);
            font-family: Arial, sans-serif;
            padding: 2rem;
        }
        .menu {
            margin-top: 2rem;
        }
        .menu a {
            display: inline-block;
            margin: 0.5rem;
            padding: 1rem;
            background: #2ecc71;
            color: white;
            text-decoration: none;
            border-radius: 6px;
        }
    </style>
</head>
<body>

<h1>Bienvenue <?= htmlspecialchars($_SESSION['prenom']) ?> <?= htmlspecialchars($_SESSION['nom']) ?> !</h1>

<p>Voici votre espace employé. Choisissez une action :</p>

<div class="menu">
    <a href="../Osman/lire_rdv.php">📅 Voir les rendez-vous</a>
    <a href="../Osman/affiche_plaque.php">🔍 Voir les plaques</a>
    <a href="../Osman/plaque.php">🛠️ Générer les plaques</a>
    <a href="../Osman/modeles.php">🚗 Voir les modèles</a>
    <a href="../Osman/ajoute_annonce.html">📝 Ajouter une annonce</a>
    <a href="../Osman/lire_essais.php">🏁 Voir les essais</a>
    <a href="logout.php">🚪 Se déconnecter</a>
</div>

</body>
</html>
