
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Page de Connexion</title>
</head>

<body>
    <h1>Bienvenue au Logiciel Budgétaire du Département</h1>

    <div class="content">
        <div class="container">
            <div class="menu">
                <a href="#connexion" class="btn-connexion">
                    <h2>SE CONNECTER</h2>
                </a>
            </div>
            <div class="connexion">
                <div class="logo">
                    <img src="logo.png" alt="Logo">
                </div>
                <div class="contact-form">
                    <form action="connexion.php" method="post">
                        <label>Nom d'utilisateur</label>
                        <input name="email" placeholder="Entrez votre nom d'utilisateur" type="text" required>

                        <label>Mot de passe</label>
                        <input name="mot_de_passe" placeholder="Entrez votre mot de passe" type="password" required>
                        <div id="erreur-message" style="color: #FE2E2E; margin-top: 20px;">
                            <?php 
                            if (isset($_GET['erreur']) && $_GET['erreur'] === "motdepasse") {
                                echo "Mot de passe incorrect. Veuillez réessayer.";
                            } elseif (isset($_GET['erreur']) && $_GET['erreur'] === "email") {
                                echo "Adresse email incorrecte. Veuillez réessayer.";
                            }
                            ?>
                        </div>
                        
                        <input class="submit" value="CONNEXION" type="submit">
                    </form>
                </div>
                <hr>
            </div>
        </div>
    </div>
</body>

</html>

