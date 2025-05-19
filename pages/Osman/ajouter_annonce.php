<?php
try {
    $pdo = new PDO('mysql:host=localhost;charset=utf8;dbname=db_CETINER', '22409662', '726209');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Récupération des données du formulaire
$marque = $_POST['marque'];
$modele = $_POST['modele'];
$annee = $_POST['annee'];
$prix = $_POST['prix'];
$description = $_POST['description'];
$image = $_POST['image']; // Lien direct

$sql = "INSERT INTO Stock (marque, modele, annee, prix, description, image)
        VALUES (:marque, :modele, :annee, :prix, :description, :image)";
$stmt = $pdo->prepare($sql);

$stmt->execute([
    ':marque' => $marque,
    ':modele' => $modele,
    ':annee' => $annee,
    ':prix' => $prix,
    ':description' => $description,
    ':image' => $image
]);

echo "Annonce ajoutée avec succès avec image en lien.";
?>

<?php
/*
try {
    $pdo = new PDO('mysql:host=localhost;charset=utf8;dbname=db_CETINER', '22409662', '726209');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

$sql = "SELECT * FROM Stock ORDER BY date_ajout DESC";
$stmt = $pdo->query($sql);

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "<div class='annonce'>";
    echo "<h3>" . htmlspecialchars($row['marque']) . " " . htmlspecialchars($row['modele']) . "</h3>";

    if (!empty($row['image'])) {
        $image = htmlspecialchars($row['image']);
        
        // Vérifie si c’est une URL complète
        if (filter_var($image, FILTER_VALIDATE_URL)) {
            echo "<img src='$image' alt='Image voiturezzz' width='300'><br>";
        } else {
            // Sinon, traite comme un chemin local
            echo "<img src='/uploads/$image' alt='Image voiture' width='300'><br>";
        }
    } else {
        echo "<p><em>Aucune image fournie</em></p>";
    }

    echo "<strong>Année :</strong> " . htmlspecialchars($row['annee']) . "<br>";
    echo "<strong>Prix :</strong> " . htmlspecialchars($row['prix']) . " €<br>";
    echo "<p>" . nl2br(htmlspecialchars($row['description'])) . "</p>";
    echo "</div><hr>";
}
*/
?>

