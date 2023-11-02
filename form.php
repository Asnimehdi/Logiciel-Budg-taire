<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style2.css">
    <title>Recherche d'Opération</title>
</head>

<body>
    <nav class="navbar">
        <div class="container">
            <h1>Logiciel Budgétaire</h1>
            <div class="logo">
            <a href="https://www.cotedor.fr/">  <img src="logo.png" alt="Logo" ></a>
            </div>
            <ul>
                <li><a href="acceuil.php">Accueil</a></li>
                <li><a href="form.php">Recherche d'Opération</a></li>
                <li><a href="profile.php">Profil</a></li>
                <li><a href="logout.php">Déconnexion</a></li>
            </ul>
            <?php
        session_start();
        if (isset($_SESSION['nom']) && isset($_SESSION['prenom'])) {
            echo "<h2>Bonjour, " . $_SESSION['nom'] . " " . $_SESSION['prenom'] . "</h2>";
        } else {
            // Rediriger l'utilisateur vers la page de connexion s'il n'est pas connecté
            header("Location: login.php");
        }
        ?>
        </div>

    </nav>

    <div class="container">
      
        <h3>Recherche d'Opération</h2>
        <form action="form.php" method="post">
            <input type="text" name="operation" required>
            <input type="submit" value="Rechercher">
        </form>
    </div>
    <?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer le numéro d'opération à partir du formulaire
    $operation = $_POST['operation'];

    // Connexion à la base de données (remplacez ces valeurs par vos propres informations de connexion)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "operation";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Vérifier la connexion
    if ($conn->connect_error) {
        die("La connexion a échoué: " . $conn->connect_error);
    }

    // Requête SQL pour récupérer les données
    $sql = "SELECT DISTINCT t.Libelle, t.Information
            FROM principlal_csv_zip p
            INNER JOIN test2_csv_zip t ON p.Article = t.Article 
            WHERE p.Operation = '$operation'";

    $result = $conn->query($sql);

    // Afficher les résultats
    if ($result->num_rows > 0) {
        echo "<div class='result-container'>";
        echo "<h3>Résultats pour l'opération numéro: $operation</h3>";
        echo "<ul class='result-list'>";
        while ($row = $result->fetch_assoc()) {
            echo "<li><strong>Libelle:</strong> " . $row["Libelle"] . "<br><strong>Information:</strong> " . $row["Information"] . "</li>";
        }
        echo "</ul>";
        echo "</div>";
    } else {
        echo "<h2 class='no-result'>Aucun résultat trouvé pour l'opération numéro: $operation</h2>";
    }

    // Fermer la connexion
    $conn->close();
}
?>

    <footer class="footer">
        <div class="container">
            <p>&copy; 2023 Mon Application. Tous droits réservés.</p>
        </div>
    </footer>
</body>

</html>
