<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
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

// Récupération des informations de l'utilisateur connecté
$utilisateur_id = $_SESSION['id'];
$utilisateur_nom = $_SESSION['nom'];
$utilisateur_role = $_SESSION['role'];
$utilisateur_direction = $_SESSION['direction'];

// Préparation de la requête SQL en fonction du rôle de l'utilisateur
$sql = "";
if ($utilisateur_role === 'super') {
    $sql = "SELECT * FROM demandes_utilisateur WHERE direction_agent = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $utilisateur_direction);
} elseif ($utilisateur_role === 'agent') {
    $sql = "SELECT * FROM demandes_utilisateur WHERE utilisateur_nom = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $utilisateur_nom);
}

// Exécution de la requête préparée
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style2.css">
    <link rel="stylesheet" href="style3.css">
    <script src="ajouter3.js"></script>
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
                <li><a href="acceuil.php">Accueil</a></li>
                <li><a href="tab2.php">Recherche d'Opération</a></li>
                <li><a href="demandes.php">Mes demandes</a></li>
                <li><a href="profile.php">Profil</a></li>
                <li><a href="logout.php">Déconnexion</a></li>
            </ul>
            <div class="bienvenue-message">
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
<br>
    <div class="container">
        <h3>Tableau de mes Demandes</h3>

        <table>
            <thead>
                <tr>

                    <th>Numéro</th>
                    <th>Libellé</th>
                    <th>Chapitre</th>
                    <th>Article</th>
                    <th>Fonction</th>
                    <th>Nature</th>
                    <th>Direction</th>
                    <th>Montant</th>
                </tr>
            </thead>
        <tbody>
    <?php
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['numero'] . "</td>";
        echo "<td>" . $row['libelle'] . "</td>";
        echo "<td>" . $row['chapitre'] . "</td>";
        echo "<td>" . $row['article'] . "</td>";
        echo "<td>" . $row['fonction'] . "</td>";
        echo "<td>" . $row['nature'] . "</td>";
        echo "<td>" . $row['direction'] . "</td>";
        echo "<td>";
        echo "<input type='text' id='montant_" . $row['numero'] . "' value='" . $row['montant'] ."  €". "' disabled>";
        echo "</td>";
        echo "<td>";
        echo "<button class='validerButton' style='background-color: #333; color: white; padding: 15px 30px;' onclick='validerMontantManuel3(" . $row['numero'] . ", \"" . urlencode($row['libelle']) . "\", \"" . $row['chapitre'] . "\", \"" . $row['article'] . "\", \"" . $row['fonction'] . "\", \"" . $row['nature'] . "\", \"" . $row['direction'] . "\")'>Modifier</button>";
        echo "</td>";
        echo "</tr>";
    }
    ?>
</tbody>

        </table>
    </div>
<br>
    <footer class="footer">
        
            <p>&copy; 2023 Conseil Départemental de la cote d'or. Tous droits réservés.</p>
       
    </footer>
</body>

</html>
<?php
// Fermeture de la requête préparée
$stmt->close();
?>
