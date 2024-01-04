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
$utilisateur_nom = $_SESSION['nom'];
$utilisateur_direction = $_SESSION['direction'];

// Récupération des données du formulaire
$numero = $_POST['numero'];
$libelle = $_POST['libelle'];
$chapitre = $_POST['chapitre'];
$article = $_POST['article'];
$fonction = $_POST['fonction'];
$nature = $_POST['nature'];
$montant = $_POST['montant'];
$direction = $_POST['direction'];
$statut = $_POST['statut'];
$section = $_POST['section'];
$etapeVote = $_POST['etapeVote'];
$codeEnveloppe = $_POST['codeEnveloppe'];
$numBudg = $_POST['numBudg'];
$phasageAp = $_POST['phasageAp'];
$politique = urldecode($_POST['politique']);

// Préparation de la requête préparée pour la table `database_csv_zip`
$sql1 = "UPDATE database_csv_zip
         SET Montant = ?
         WHERE Année = YEAR(CURDATE())+1
         AND Etape = 'budget primitif'
         AND Operation = ?
         AND Chapitre = ?
         AND Article = ?
         AND Fonction = ?
         AND Direction = ?
         AND Nature = ?
       ";

// Utilisation d'une requête préparée pour éviter les injections SQL
$stmt1 = $conn->prepare($sql1);
$stmt1->bind_param("dssssss", $montant, $numero, $chapitre, $article, $fonction, $direction, $nature);
// Exécution de la requête préparée pour la table `database_csv_zip`
if ($stmt1->execute()) {
    echo "Données mises à jour dans database_csv_zip avec succès!";
} else {
    echo "Erreur lors de la mise à jour des données dans database_csv_zip: " . $stmt1->error;
}

// requete cherche op complet dans les demandes if trouve update else create 


// Récupération de l'ID de l'utilisateur
$utilisateur_nom = $_SESSION['nom']; // Assurez-vous que cette variable contient l'ID de l'utilisateur
$utilisateur_direction = $_SESSION['direction'];

// Préparation de la requête préparée pour la table `demandes_utilisateur`
$sql2 = "UPDATE demandes_utilisateur 
         SET utilisateur_nom = ?,
            montant = ?,             -- Premier paramètre (montant) de type double
             date_demande = NOW()     -- Met à jour la colonne date_demande avec la date et l'heure actuelles
         WHERE numero = ?             -- Deuxième paramètre (numero) de type string
           AND Chapitre = ?           -- Troisième paramètre (chapitre) de type string
           AND Article = ?            -- Quatrième paramètre (article) de type string
           AND Fonction = ?           -- Cinquième paramètre (fonction) de type string
           AND Nature = ?";          

// Utilisation d'une requête préparée pour éviter les injections SQL
$stmt2 = $conn->prepare($sql2);
$stmt2->bind_param("sdsssss", $utilisateur_nom,$montant, $numero, $chapitre, $article, $fonction, $nature);



// Exécution de la requête préparée pour la table `demandes_utilisateur`
if ($stmt2->execute()) {
    echo "Données mises à jour dans demandes_utilisateur avec succès!";
} else {
    echo "Erreur lors de la mise à jour des données dans demandes_utilisateur: " . $stmt2->error;
}

// Fermeture de la connexion et des requêtes préparées
$stmt1->close();
$stmt2->close();
$conn->close();
?>
