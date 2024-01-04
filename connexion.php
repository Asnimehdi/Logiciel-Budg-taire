<?php
session_start();

$serveur = "localhost";
$utilisateur = "root";
$mot_de_passe = "";
$base_de_donnees = "operation";

$connexion = new mysqli($serveur, $utilisateur, $mot_de_passe, $base_de_donnees);

if ($connexion->connect_error) {
    die("La connexion à la base de données a échoué : " . $connexion->connect_error);
}

$email = $_POST['email'];
$mot_de_passe_saisi = $_POST['mot_de_passe'];

// Vérifier l'utilisateur dans la base de données
$requete = "SELECT * FROM utilisateurs WHERE email='$email'";
$resultat = $connexion->query($requete);

if ($resultat->num_rows > 0) {
    // Utilisateur trouvé dans la base de données
    $utilisateur = $resultat->fetch_assoc();
    if ($mot_de_passe_saisi === $utilisateur['mot_de_passe']) {
        // Stocker les informations de l'utilisateur dans les variables de session
        $_SESSION['email'] = $email;
        $_SESSION['nom'] = $utilisateur['nom'];
        $_SESSION['prenom'] = $utilisateur['prenom'];
        $_SESSION['direction'] = $utilisateur['numero_direction'];
        $_SESSION['role'] = $utilisateur['role'];
        $_SESSION['id'] = $utilisateur['id'];
        if ($utilisateur['role'] === 'admin') {
            // Rediriger l'administrateur vers la page d'administration
            header("Location: acceuil_admin.php");
        } else {
            // Rediriger les agents vers leur page normale
            header("Location: acceuil.php");
        }
    } else {
        // Mot de passe incorrect, rediriger vers la page de connexion avec un message d'erreur
        header("Location: login.php?erreur=motdepasse");
    }
} else {
    // Utilisateur non trouvé, rediriger vers la page de connexion avec un message d'erreur
    header("Location: login.php?erreur=email");
}

$connexion->close();
?>
