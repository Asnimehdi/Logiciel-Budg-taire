<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "operation";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("La connexion a échoué: " . $conn->connect_error);
}

$operation = $_GET['operation'];
$libelle = $_GET['libelle'];
session_start();
$utilisateur_direction = $_SESSION['direction'];
// Récupération de l'étape à partir de la base de données
$stmtEtape = $conn->prepare("SELECT nom_etape FROM etape WHERE CURDATE() BETWEEN date_debut AND date_fin");
$stmtEtape->execute();
$stmtEtape->bind_result($etape);
$stmtEtape->fetch();
$stmtEtape->close();
// Effectuez la recherche dans la base de données et générez le tableau des résultats
$sql = "SELECT o.numéro, o.Libellé, o.Politique, d.Chapitre, d.Article, d.Fonction, d.Nature, d.Montant, d.Année, d.Direction, d.Statut, d.Section, d.EtapeVote, d.codeEnveloppe, d.PhasageAP ,d.Etape
FROM operationslib_csv_zip o
INNER JOIN database_csv_zip d ON o.numéro= d.Operation AND d.Année = YEAR(CURDATE())+1 AND d.Etape = '$etape' AND d.Direction = '$utilisateur_direction'
WHERE o.numéro LIKE '%$operation%' AND o.Libellé LIKE '%$libelle%'";


$result = $conn->query($sql);

// Vérifier si la requête a échoué
if ($result === false) {
    die("Erreur SQL: " . $conn->error);
}

// Vérifier si des résultats ont été trouvés
if ($result->num_rows > 0) {
    echo "<tr><th>Numéro</th><th>Libellé</th><th>Chapitre</th><th>Article</th><th>Fonction</th><th>Nature</th><th>Direction</th><th>Montant</th></tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['numéro'] . "</td>";
        echo "<td>" . $row['Libellé'] . "</td>";
        echo "<td>" . $row['Chapitre'] . "</td>";
        echo "<td>" . $row['Article'] . "</td>";
        echo "<td>" . $row['Fonction'] . "</td>";
        echo "<td>" . $row['Nature'] . "</td>";
        echo "<td>" . $row['Direction'] . "</td>";
        if (empty($row['Montant']) || $row['Montant'] === '0.00') {
            // Si vide, afficher un champ de saisie
            echo "<td><input type='text' name='montant_" . $row['numéro']. $row['Chapitre']. $row['Article'] . $row['Fonction'] .  "'></td>"; 
            echo "<td><button class='validerButton' style='background-color: #333; color: white; padding: 15px 30px;' onclick='validerMontantManuel2(" . $row['numéro'] . ", \"" . urlencode($row['Libellé']) . "\", \"" . $row['Chapitre'] . "\", \"" . $row['Article'] . "\", \"" . $row['Fonction'] . "\", \"" . $row['Nature']. "\", \"" . $row['Direction'] . "\", \"" . $row['Statut'] . "\", \"" . $row['Section'] . "\", \"" . $row['EtapeVote'] . "\", \"" . $row['codeEnveloppe'] . "\", \"" . $row['PhasageAP'] . "\", \"" . urlencode($row['Politique'])  . "\")'>Valider</button></td>";
        } else {
            // Sinon, afficher le montant dans un td
            echo "<td>" . $row['Montant'] . ' €'."</td>";
        }
        
        echo "</tr>";
    }
} else {

    $sql2 ="SELECT o.numéro, o.Libellé, o.Politique, d.Chapitre, d.Article, d.Fonction, d.Nature, d.Montant, d.Année, d.Direction, d.Statut, d.Section,d.EtapeVote, d.codeEnveloppe, d.PhasageAP, d.NumBUDG, d.Etape
    FROM operationslib_csv_zip o
    INNER JOIN database_csv_zip d ON o.numéro= d.Operation AND d.Année = YEAR(CURDATE())+0 AND d.Etape = '$etape'AND d.Direction = '$utilisateur_direction'
    WHERE o.numéro LIKE '%$operation%' AND o.Libellé LIKE '%$libelle%'"; 

$result2 = $conn->query($sql2);

// Vérifier si la requête a échoué
if ($result2 === false) {
    die("Erreur SQL: " . $conn->error);
}

// Vérifier si des résultats ont été trouvés
if ($result2->num_rows > 0) {
    echo "<tr><th>Numéro</th><th>Libellé</th><th>Chapitre</th><th>Article</th><th>Fonction</th><th>Nature</th><th>Direction</th><th>Montant</th></tr>";

    while ($row = $result2->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['numéro'] . "</td>";
        echo "<td>" . $row['Libellé'] . "</td>";
        echo "<td>" . $row['Chapitre'] . "</td>";
        echo "<td>" . $row['Article'] . "</td>";
        echo "<td>" . $row['Fonction'] . "</td>";
        echo "<td>" . $row['Nature'] . "</td>";
        echo "<td>" . $row['Direction'] . "</td>";
        echo "<td><input type='text' name='montant_" . $row['numéro']. $row['Chapitre']. $row['Article'] . $row['Fonction'] .  "'></td>"; 
        echo "<td><button class='validerButton' style='background-color: #333; color: white; padding: 15px 30px;' onclick='validerMontantManuel(" . $row['numéro'] . ", \"" . urlencode($row['Libellé']) . "\", \"" . $row['Chapitre'] . "\", \"" . $row['Article'] . "\", \"" . $row['Fonction'] . "\", \"" . $row['Nature']. "\", \"" . $row['Direction']. "\", \"" . $row['NumBUDG'] . "\", \"" . $row['Statut'] . "\", \"" . $row['Section'] . "\", \"" . $row['EtapeVote'] . "\", \"" . $row['codeEnveloppe'] . "\", \"" . $row['PhasageAP'] . "\", \"" . urlencode($row['Politique'])  . "\")'>Valider</button></td>";

        echo "</tr>";
    }
    


}



else {
    echo "<tr><td colspan='5'>Aucun résultat trouvé.</td></tr>";
}
}
$conn->close();
?>