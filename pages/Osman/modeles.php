<!-- modeles.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modèles - BMW</title>
    <style>
        body {
            background-color: #121212;
            color: #ffffff;
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            padding: 2rem;
            font-size: 2.5rem;
            color: #f0f0f0;
        }

        .container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            padding: 2rem;
        }

        .annonce {
            background-color: #1e1e1e;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.5);
            padding: 1.5rem;
            transition: transform 0.3s ease;
            position: relative;
        }

        .annonce:hover {
            transform: scale(1.02);
        }

        .annonce img {
            max-width: 100%;
            border-radius: 8px;
            margin-bottom: 1rem;
        }

        .annonce h3 {
            color: #00aaff;
            margin-top: 0;
        }

        .annonce strong {
            color: #cccccc;
        }

        .annonce p {
            color: #aaaaaa;
        }

        .annonce .actions {
            margin-top: 1rem;
            display: flex;
            justify-content: space-between;
            gap: 1rem;
        }

        .annonce .actions a {
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            font-weight: bold;
            text-align: center;
        }

        .modifier-btn {
            background-color: #0066cc;
            color: #fff;
        }

        .supprimer-btn {
            background-color: #cc0000;
            color: #fff;
        }
    </style>

    <script>
        function confirmerSuppression(id_mat) {
            if (confirm("⚠️ Voulez-vous vraiment supprimer cette annonce ?")) {
                window.location.href = 'supprimer-annonce.php?id_mat=' + id_mat;
                }
            }

    </script>
</head>
<body>
    <h1>Nos modèles disponibles</h1>
    <div class="container">
    <?php
    try {
        $pdo = new PDO('mysql:host=localhost;charset=utf8;dbname=db_CETINER', '22409662', '726209');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Erreur de connexion : " . $e->getMessage());
    }

    // Requête pour récupérer toutes les annonces
    $sql = "SELECT * FROM Stock ORDER BY date_ajout DESC";
    $stmt = $pdo->query($sql);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<div class='annonce'>";
        echo "<h3>" . htmlspecialchars($row['marque']) . " " . htmlspecialchars($row['modele']) . "</h3>";

        // Affichage de l'image, si disponible
        if (!empty($row['image'])) {
            $image = htmlspecialchars($row['image']);
            if (filter_var($image, FILTER_VALIDATE_URL)) {
                echo "<img src='$image' alt='Image voiture'>";
            } else {
                echo "<img src='/uploads/$image' alt='Image voiture'>";
            }
        } else {
            echo "<p><em>Aucune image fournie</em></p>";
        }

        // Affichage des autres informations
        echo "<p><strong>Année :</strong> " . htmlspecialchars($row['annee']) . "</p>";
        echo "<p><strong>Prix :</strong> " . htmlspecialchars($row['prix']) . " €</p>";
        echo "<p>" . nl2br(htmlspecialchars($row['description'])) . "</p>";

        // Boutons Modifier et Supprimer
        echo "<div class='actions'>";
        echo "<a class='modifier-btn' href='modifier-annonce.php?id_mat=" . $row['id_mat'] . "'>Modifier</a>";
        echo "<a class='supprimer-btn' href='#' onclick='confirmerSuppression(" . $row['id_mat'] . ")'>Supprimer</a>";
        echo "</div>";


        echo "</div>";
    }
    ?>
    </div>
</body>
</html>
