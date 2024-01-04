<?php
session_start();

// Vérifier si l'administrateur est connecté
if (!isset($_SESSION['email']) || !isset($_SESSION['nom']) || $_SESSION['role'] !== 'admin') {
    // Rediriger l'utilisateur vers la page de connexion s'il n'est pas connecté en tant qu'administrateur
    header("Location: login.php");
    exit(); // Assurez-vous de terminer le script après la redirection
}

// Ici, vous pouvez ajouter du code pour récupérer et afficher les informations spécifiques à l'administrateur
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style2.css">
    <title>Page d'Accueil Administrateur</title>
</head>

<body>
    <nav class="navbar">
        <div class="container1">
            <h1>Logiciel Budgétaire - Administrateur</h1>
            <div class="logo">
                <a href="https://www.cotedor.fr/"><img src="logo.png" alt="Logo"></a>
            </div>
            <ul>
                <li><a href="acceuil_admin.php">Accueil </a></li>
                <li><a href="demandes_admin.php">Demandes Agents</a></li>
                <li><a href="statistiques.php">Statistiques</a></li>
                <li><a href="actions_administratives.php">Actions Administratives</a></li>
                <li><a href="logout.php">Déconnexion</a></li>
            </ul><div class="bienvenue-message">
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
    <h3>Saisie de l'étape</h3>
    <form id="etapeForm">
        <label for="etape">Étape De Budget :</label>
        <select name="etapeB" id="etapeB">
           <option value="Budget primitif">Budget Primitif</option>
           <option value="Budget supplémentaire">Budget supplémentaire</option>
           <option value="DM1">DM1</option>
           <option value="DM2">DM2</option>
        </select>

        <label for="date_debut_etape">Date de début de l'étape :</label>
        <input type="date" name="date_debut_etape" required>

        <label for="date_fin_etape">Date de fin de l'étape :</label>
        <input type="date" name="date_fin_etape" required>
        <br>
        <button type="button" onclick="envoiFormEtape()" class="cta-button">Valider</button>
    </form>
</div>
    <footer class="footer">
       
            <p>&copy; 2023 Conseil Départemental de la côte d'or. Tous droits réservés.</p>
        
    </footer>
    <script>
function envoiFormEtape() {
    var form = document.getElementById('etapeForm');
    var formData = new FormData(form);

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'traitement_etape.php', true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Traitement de la réponse du serveur si nécessaire
            console.log(xhr.responseText);
        }
    };

    xhr.send(formData);
    window.location.reload();
}
</script>

</body>

</html>
