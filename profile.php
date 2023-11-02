<?php
session_start();
if (!isset($_SESSION['email']) || !isset($_SESSION['nom']) || !isset($_SESSION['prenom'])) {
    // Rediriger l'utilisateur vers la page de connexion s'il n'est pas connecté
    header("Location: login.php");
    exit(); // Assurez-vous de terminer le script après la redirection
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style2.css"> <!-- Lien vers votre fichier CSS -->
    <title>Profil Utilisateur</title>
   
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
           
        </div>
       

    </nav>
    <section class="hero">
        <div class="container">
        <h1>Bienvenue, <?php echo $_SESSION['nom'] . " " . $_SESSION['prenom']; ?></h1>
        </div>
    </section>
    <div class="container">
      
        <table>
            <tr>
                <th>Email</th>
                <td><?php echo $_SESSION['email']; ?></td>
            </tr>
            <tr>
                <th>Nom</th>
                <td><?php echo $_SESSION['nom']; ?></td>
            </tr>
            <tr>
                <th>Prénom</th>
                <td><?php echo $_SESSION['prenom']; ?></td>
            </tr>
            <tr>
                <th>direction</th>
                <td><?php echo $_SESSION['direction']; ?></td>
            </tr>
          

        </table>
    </div>
    <footer class="footer">
        <div class="container">
            <p>&copy; 2023 Mon Application. Tous droits réservés.</p>
        </div>
    </footer>
</body>

</html>