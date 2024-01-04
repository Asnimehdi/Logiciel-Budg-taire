<?php
session_start();
if (!isset($_SESSION['email']) || !isset($_SESSION['nom']) || !isset($_SESSION['prenom'])) {
    // Rediriger l'utilisateur vers la page de connexion s'il n'est pas connecté
    header("Location: login.php");
    exit(); // Assurez-vous de terminer le script après la redirection
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

// Récupération des données du formulaire
$numero = $_POST['numero'];
$libelle = urldecode($_POST['libelle']);
$chapitre = $_POST['chapitre'];
$article = $_POST['article'];
$fonction = $_POST['fonction'];
$nature = $_POST['nature'];
$montant = $_POST['montant'];
$direction = $_POST['direction'];
$numBudg = $_POST['numBudg'];
$statut = $_POST['statut'];
$section = $_POST['section'];
$etapeVote = $_POST['etapeVote'];
$codeEnveloppe = $_POST['codeEnveloppe'];
$phasageAp = $_POST['phasageAp'];
$politique = urldecode($_POST['politique']);

// Récupération de l'étape à partir de la base de données
$stmtEtape = $conn->prepare("SELECT nom_etape FROM etape WHERE CURDATE() BETWEEN date_debut AND date_fin");
$stmtEtape->execute();
$stmtEtape->bind_result($etape);
$stmtEtape->fetch();
$stmtEtape->close();

// Préparation de la requête préparée pour la table `database_csv_zip`
$sql1 = "INSERT INTO database_csv_zip 
        (`Année`, `Etape`, `Section`, `Nature`, `NumBUDG`, `Operation`, `Chapitre`, `Article`, `Fonction`, `Direction`, `Statut`, `Montant`, `CodeEnveloppe`, `MillesimesaisieAP`, `EtapeVote`, `PhasageAP`, `Politique`)
        VALUES 
        (YEAR(CURDATE())+1, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, '', ?, ?, ?)";

// Utilisation d'une requête préparée pour éviter les injections SQL
$stmt1 = $conn->prepare($sql1);
$stmt1->bind_param("sssssssssssssss", $etape, $section, $nature, $numBudg, $numero, $chapitre, $article, $fonction, $direction, $statut, $montant, $codeEnveloppe, $etapeVote, $phasageAp, $politique);

// Exécution de la requête préparée pour la table `database_csv_zip`
if ($stmt1->execute()) {
    echo "Données ajoutées dans database_csv_zip avec succès!";
} else {
    echo "Erreur lors de l'ajout des données dans database_csv_zip: " . $stmt1->error;
}

// Récupération de l'ID de l'utilisateur
$utilisateur_nom = $_SESSION['nom']; // Assurez-vous que cette variable contient l'ID de l'utilisateur
$utilisateur_direction = $_SESSION['direction'];

// Préparation de la requête préparée pour la table `demandes_utilisateur`
$sql2 = "INSERT INTO demandes_utilisateur 
        (utilisateur_nom, direction_agent, numero, libelle, chapitre, article, fonction, nature, direction, montant)
        VALUES 
        (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

// Utilisation d'une requête préparée pour éviter les injections SQL
$stmt2 = $conn->prepare($sql2);
$stmt2->bind_param("sssssssssd", $utilisateur_nom, $utilisateur_direction, $numero, $libelle, $chapitre, $article, $fonction, $nature, $direction, $montant);

// Exécution de la requête préparée pour la table `demandes_utilisateur`
if ($stmt2->execute()) {
    echo "Données ajoutées dans demandes_utilisateur avec succès!";
} else {
    echo "Erreur lors de l'ajout des données dans demandes_utilisateur: " . $stmt2->error;
}

// Fermeture de la connexion et des requêtes préparées
$stmt1->close();
$stmt2->close();
$conn->close();
?>
