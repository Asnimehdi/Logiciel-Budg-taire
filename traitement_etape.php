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

// Récupération des données du formulaire
$etape = $_POST['etapeB'];
$dateDebut = $_POST['date_debut_etape'];
$dateFin = $_POST['date_fin_etape'];

// Préparation de la requête SQL de mise à jour
$sql = "UPDATE etape
        SET date_debut = ?,
            date_fin = ?
        WHERE nom_etape = ?";

// Utilisation d'une requête préparée pour éviter les injections SQL
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $dateDebut, $dateFin, $etape);

// Exécution de la requête préparée
if ($stmt->execute()) {
    echo "Étape mise à jour avec succès!";
} else {
    echo "Erreur lors de la mise à jour de l'étape: " . $stmt->error;
}

// Fermeture de la connexion et de la requête préparée
$stmt->close();
$conn->close();
?>
