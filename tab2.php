<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="style2.css">
    <link rel="stylesheet" href="style3.css">
    <title>Recherche d'Opération</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="tab.js"></script>
    <script src="ajouter.js"></script>
    <script src="ajouter2.js"></script>
</head>

<body>
    <nav class="navbar">
        <div class="container1">
            <h1>Logiciel Budgétaire</h1>
            <div class="logo">
                <a href="https://www.cotedor.fr/">
                    <img src="logo.png" alt="Logo">
                </a>
            </div>
            <ul>
                <li><a href="acceuil.php">Accueil</a></li>
                <li><a href="tab2.php">Recherche d'Opération</a></li>
                <li><a href="demandes.php">Mes demandes</a></li>
                <li><a href="profile.php">Profil</a></li>
                <li><a href="logout.php">Déconnexion</a></li>
            </ul><div class="bienvenue-message">
            <?php
        session_start();
        if (isset($_SESSION['nom']) && isset($_SESSION['prenom'])) {
            echo "<h2> " . $_SESSION['nom'] . " " . $_SESSION['prenom'] . "</h2>";
        } else {
            // Rediriger l'utilisateur vers la page de connexion s'il n'est pas connecté
            header("Location: login.php");
        }
        ?>
        </div>
            
        </div>
    </nav>
    <div class="container">
        <h3>Recherche d'Opération</h3>
        <form id="searchForm">
            <label for="operation">Numéro d'Opération :</label>
            <input type="text" id="operation" name="operation">

            <label for="libelle">Libellé :</label>
            <input type="text" id="libelle" name="libelle">

            <table id="resultTable">
                <!-- Tableau pour afficher les résultats -->
            </table>
        </form>
    </div>
    <footer class="footer">
       
            <p>&copy; 2023 Conseil Départemental de la Côte-d'Or. Tous droits réservés.</p>
      
    </footer>
</body>

</html>
