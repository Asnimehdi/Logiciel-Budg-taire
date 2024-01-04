<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    header("Location: login.php"); // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    exit();
}

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "operation";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("La connexion a échoué: " . $conn->connect_error);
}

// Récupération de l'ID de l'utilisateur connecté
$utilisateur_id = $_SESSION['id'];
$utilisateur_nom = $_SESSION['nom'];

// Récupération des demandes de l'utilisateur à partir de la table `demandes_utilisateur`
$sql = "SELECT * FROM demandes_utilisateur ";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

// Fermeture de la connexion après avoir récupéré les données
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style2.css">
    <link rel="stylesheet" href="style3.css">
    <title>Tableau des Demandes</title>
</head>

<body>
    <nav class="navbar">
        <div class="container1">
            <h1>Logiciel Budgétaire</h1>
            <div class="logo">
                <a href="https://www.cotedor.fr/"><img src="logo.png" alt="Logo"></a>
            </div>
            <ul>
            <li><a href="acceuil_admin.php">Accueil </a></li>
                <li><a href="demandes_admin.php">Demandes Agents</a></li>
                <li><a href="statistiques.php">Statistiques</a></li>
                <li><a href="actions_administratives.php">Actions Administratives</a></li>
                <li><a href="logout.php">Déconnexion</a></li>
            </ul></ul><div class="bienvenue-message">
            <?php
      
        if (isset($_SESSION['nom']) && isset($_SESSION['prenom'])) {
            echo "<h2>" . $_SESSION['nom'] . " " . $_SESSION['prenom'] . "</h2>";
        } else {
            // Rediriger l'utilisateur vers la page de connexion s'il n'est pas connecté
            header("Location: login.php");
        }
        ?>
        </div>
        </div>
    </nav>

    <div class="container">
        <h3>Tableau des Demandes</h3>

        <table>
            <thead>
                <tr>

                    <th>Nom Agent</th>
                    <th>Direction</th>
                    <th>Numéro</th>
                    <th>Libellé</th>
                    <th>Chapitre</th>
                    <th>Article</th>
                    <th>Fonction</th>
                    <th>Nature</th>
                    <th>Montant</th>
                    <th>Date/Heure dernière modification</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['utilisateur_nom'] . "</td>";
                    echo "<td>" . $row['direction'] . "</td>";
                    echo "<td>" . $row['numero'] . "</td>";
                    echo "<td>" . $row['libelle'] . "</td>";
                    echo "<td>" . $row['chapitre'] . "</td>";
                    echo "<td>" . $row['article'] . "</td>";
                    echo "<td>" . $row['fonction'] . "</td>";
                    echo "<td>" . $row['nature'] . "</td>";
                    echo "<td>" . $row['montant']. ' €' . "</td>";
                    echo "<td>" . $row['date_demande'] . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <footer class="footer">
      
            <p>&copy; 2023 Conseil Départemental de la cote d'or. Tous droits réservés.</p>
       
    </footer>
</body>

</html>
<?php
// Fermeture de la requête préparée
$stmt->close();
?>
