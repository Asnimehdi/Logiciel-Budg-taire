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
        <div class="container">
            <h1>Logiciel Budgétaire</h1>
            <div class="logo">
            <a href="https://www.cotedor.fr/">  <img src="logo.png" alt="Logo" ></a>
            </div>
            <ul>
                <li><a href="acceuil.php">Accueil</a></li>
                <li><a href="form.php">Recherche d'Opération</a></li>
                <li><a href="#">Mes demandes</a></li>
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

    <!-- Contenu principal de la page d'accueil -->
    <section class="hero">
        <div class="container">
            <h1>Logiciel Budgétaire du Conseil Départemental de la Côte d'Or</h1>
            <p>Gérez efficacement le budget de votre département avec notre solution logicielle avancée.</p>
            <a href="#" class="cta-button">Commencer</a>
        </div>
    </section>

    <section class="features">
        <div class="container">
            <h2>Fonctionnalités Clés</h2>
            <div class="feature">
                <!-- Contenu de votre première fonctionnalité -->
            </div>
            <div class="feature">
                <!-- Contenu de votre deuxième fonctionnalité -->
            </div>
            <div class="feature">
                <!-- Contenu de votre troisième fonctionnalité -->
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="container">
            <p>&copy; 2023 Mon Application. Tous droits réservés.</p>
        </div>
    </footer>

</body>

</html>
