<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logiciel Budgétaire - Conseil Départemental de la Côte d'Or</title>
    <link rel="stylesheet" href="style2.css">
</head>

<body>

<nav class="navbar">
        <div class="container1">
            <h1>Logiciel Budgétaire</h1>
            <div class="logo">
            <a href="https://www.cotedor.fr/">  <img src="logo.png" alt="Logo" ></a>
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
        session_start();
        if (isset($_SESSION['nom']) && isset($_SESSION['prenom'])) {
            echo "<h2>Bonjour, " . $_SESSION['nom'] . " " . $_SESSION['prenom'] . "</h2>";
        } else {
            // Rediriger l'utilisateur vers la page de connexion s'il n'est pas connecté
            header("Location: login.php");
        }
        ?>
        </div>
        </div>

    </nav>

    <!-- Contenu principal de la page d'accueil -->
    <section class="hero">
        
            <h1>Logiciel Budgétaire du Conseil Départemental de la Côte d'Or</h1>
            <p>Gérez efficacement le budget de votre département avec notre solution logicielle avancée.</p>
            <a href="#" class="cta-button">Commencer</a>
       
    </section>

<div class="message-container">
<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "operation"; // Remplacez par le nom de votre base de données

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("La connexion a échoué: " . $conn->connect_error);
}

// Récupération de l'étape actuelle et de la date de fin depuis la base de données
$sql = "SELECT nom_etape, date_debut, date_fin FROM etape WHERE CURDATE() BETWEEN date_debut AND date_fin";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $nomEtape = $row['nom_etape'];
    $dateDebut = $row['date_debut'];
    $dateFin = $row['date_fin'];

    echo "<p>Nous sommes actuellement dans l'étape : $nomEtape.</p>";
    echo "<p>Cette étape a commencé le : $dateDebut.</p>";
    echo "<p>Vous avez jusqu'au : $dateFin pour soumettre vos demandes et les modifier. Au-delà de cette date, vous n'aurez plus le droit de faire des modifications.</p>";
} else {
    echo "<p>Aucune étape en cours pour le moment.</p>";
}

// Fermeture de la connexion
$conn->close();
?>
    </div>

    <section class="features">
   
    <div class="container">
        <h3>Fonctionnalités Clés</h3>
        <div class="feature">
            <h4>Gestion des Opérations Budgétaires</h4>
            <p>Effectuez des recherches avancées, suivez et gérez toutes les opérations budgétaires de manière efficace.</p>
        </div>
        <div class="feature">
            <h4>Tableaux de Bord Intuitifs</h4>
            <p>Accédez à des tableaux de bord visuels pour obtenir rapidement des insights sur les tendances budgétaires et les dépenses.</p>
        </div>
        <div class="feature">
             <h4>Gestion Simplifiée des Demandes de Financement</h4>
             <p>Effectuez vos demandes de financement en toute simplicité avec notre interface conviviale. Remplissez un formulaire intuitif, spécifiez les détails de votre demande, et suivez son statut en temps réel. Même la modification de votre demande est simplifiée, et vous serez notifié instantanément sur le site et par e-mail. Une approche simple pour simplifier vos démarches financières.</p>
        </div>


    </div>
</section>


    <footer class="footer">
       
            <p>&copy; 2023 Conseil Départemental de la cote d'or. Tous droits réservés.</p>
        
    </footer>

</body>

</html>
