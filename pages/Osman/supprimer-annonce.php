<!-- supprimer-annonce.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Supprimer une annonce</title>
    <style>
        /* Vos styles CSS ici */
    </style>
</head>
<body>
    <h1>Supprimer une annonce</h1>
    <div class="container">
        <?php
        // Vérifier si l'ID de l'annonce est bien passé dans l'URL
        if (!isset($_GET['id_mat'])) {
            die("ID manquant !");
        }

        $id_mat = intval($_GET['id_mat']);  // Récupération de l'ID de l'annonce à supprimer

        // Connexion à la base de données
        try {
            $pdo = new PDO('mysql:host=localhost;charset=utf8;dbname=db_CETINER', '22409662', '726209');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }

        try {
            // Préparer et exécuter la requête pour supprimer l'annonce
            $stmt = $pdo->prepare("DELETE FROM Stock WHERE id_mat = :id_mat");
            $stmt->execute(['id_mat' => $id_mat]);

            // Redirection vers la page 'modeles.php' avec un message de succès
            header("Location: modeles.php?message=supprimé");
            exit();
        } catch (PDOException $e) {
            die("Erreur lors de la suppression : " . $e->getMessage());
        }
        ?>
    </div>
</body>
</html>
