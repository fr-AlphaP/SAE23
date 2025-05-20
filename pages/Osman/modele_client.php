<!-- modeles.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modèles - BMW</title>
    <style>
        body {
            background-color: white;
            color: #ffffff;
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            padding: 2rem;
            font-size: 2.5rem;
            color:black;
        }

        .container2 {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            padding: 2rem;
        }

        .annonce {
            background-color:rgba(37, 37, 37, 0.1);
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.71);
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
            color:black;
        }

        .annonce p {
            color:rgb(38, 38, 38);
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

        .footer {
            font-size: 2.5vh;
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
            color: black;
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
        <h1>Nos modèles disponibles</h1>
        <hr id="hrbas">
        <div class="container2">
        <?php
        try {
            $pdo = new PDO('mysql:host=localhost;charset=utf8;dbname=db_CETINER', '22409662', '726209');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }

        // Requête pour récupérer toutes les annonces où supprimer = 0
        $sql = "SELECT * FROM Stock WHERE supprimer = 0 ORDER BY date_ajout DESC";
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

            // Formatage du prix avec un espace comme séparateur des milliers
            $formatted_price = number_format($row['prix'], 0, '', ' ');
            echo "<p><strong>Prix :</strong> " . htmlspecialchars($formatted_price) . " €</p>";

            echo "<p>" . nl2br(htmlspecialchars($row['description'])) . "</p>";

            echo "</div>";
        }
        ?>
        </div>
        <hr id="hrbas">
        <div class="footer">
            <p>© 2025 BMW Osval. Tous droits réservés.</p>
            <p>Mentions légales | Politique de confidentialité</p>
            <p><b>Ce site n'est pas un site commercial, il a été réalisé dans le cadre d'un projet Fictif</b></p>
            <p><b>IUT de Béziers</b></p>
        </div>
    </div>
    </div>
</body>
</html>
