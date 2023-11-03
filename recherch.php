<?php
// Connexion à la base de données (remplacez ces valeurs par vos propres informations de connexion)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "operation";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("La connexion a échoué: " . $conn->connect_error);
}

if (isset($_GET['libelle'])) {
    $libelle = $_GET['libelle'];

    $sql = "SELECT Libelle FROM test2_csv_zip WHERE Libelle LIKE '$libelle%'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<label for='libelleDropdown'>Sélectionnez un Libellé :</label>";
        echo "<select id='libelleDropdown' name='libelleDropdown'>";
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['Libelle'] . "'>" . $row['Libelle'] . "</option>";
        }
        echo "</select>";
    } else {
        echo "Aucun résultat trouvé.";
    }}
    

$conn->close();
?>
