<?php
session_start();

// Vérifier si l'administrateur est connecté
if (!isset($_SESSION['email']) || !isset($_SESSION['nom']) || $_SESSION['role'] !== 'admin') {
    // Rediriger l'utilisateur vers la page de connexion s'il n'est pas connecté en tant qu'administrateur
    header("Location: login.php");
    exit(); // Assurez-vous de terminer le script après la redirection
}

// Ici, vous pouvez ajouter du code pour récupérer et afficher les informations spécifiques à l'administrateur


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "operation";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("La connexion a échoué: " . $conn->connect_error);
}

// Supposons que vous ayez une table `budget` avec des colonnes pour chaque catégorie
$sql = "SELECT DISTINCT Chapitre FROM database_csv_zip";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style2.css">
    <title>Synthèse Budgétaire</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
        }

        h2 {
            font-family: 'Poppins', sans-serif; /* Une police moderne et épurée */
            font-size: 25px; /* Augmente la taille pour plus d'impact */
            color: #34495e; /* Couleur de texte plus moderne et douce */
            text-align: center;
            margin-top: 20px;
            margin-bottom: 30px;
            text-transform: uppercase;
            letter-spacing: 3px; /* Espacement légèrement augmenté pour un style épuré */
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1); /* Ombre subtile pour de la profondeur */
        }
       
        .header-section {
            margin-bottom: 20px;
        }
        .header-section select {
            padding: 5px;
            font-size: 16px;
        }
        .header-section h1 {
            margin: 0;
        }
        .flex-container {
            display: flex;
            justify-content: space-between;
        }
        .flex-container > div {
            width: 49%;
        }
        
        /* Style global pour le formulaire */

        .form-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 10px;
            padding: 10px;
            background: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            flex-basis: calc(33.333% - 10px);
        }

        .form-group label {
            font-weight: bold;
            margin-bottom: 5px;
            color: #333;
        }

        .form-group select {
            padding: 8px 12px;
            border-radius: 4px;
            border: 1px solid #ddd;
            font-size: 14px;
            color: #333;
            background-color: #f8f8f8;
            cursor: pointer;
            outline: none;
        }

        .form-group select:hover {
            background-color: #e7e7e7;
        }

        .form-group select:focus {
            border-color: #aaa;
            box-shadow: 0 0 3px #aad;
        }

        /* Réponses pour les écrans plus petits */
        @media (max-width: 768px) {
            .form-group {
                flex-basis: calc(50% - 10px);
            }
        }

        @media (max-width: 480px) {
            .form-group {
                flex-basis: 100%;
            }
        }
      

    .depenses th{
       * Une couleur de fond différente pour les lignes de sous-totaux et de total */
        font-weight: bold;
    }
    .total th{
        
        background-color: #868686; /* Une couleur de fond différente pour les lignes de sous-totaux et de total */
        font-weight: bold;
        color : white;
    }
    .fonction th {      
     /* Une couleur de fond différente pour les lignes de sous-totaux et de total */
        font-weight: bold;
    }
    </style>
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
    <h2>Visualisation des Résultats Détaillés</h1>
        <div class="form-container">
            <div class="form-group">
                <label for="codeBudget">Code Budget</label>
                <select name="codeBudget" id="codeBudget">
                    <option>0</option>
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                    <option>6</option>
                    <option>7</option>
                    <!-- Options chargées depuis la base de données -->
                </select>
            </div>
            <div class="form-group">
                <label for="annee">Année</label>
                <select name="annee" id="annee">
                    <option>2024</option>
                    <option>2023</option>
                    <option>2022</option>
                    <option>2021</option>
                    <option>2020</option>
                    <option>2019</option>
                    <!-- Options chargées depuis la base de données -->
                </select>
            </div>
            <div class="form-group">
                <label for="etapeBudgetaire">Étape Budgétaire Souhaitée</label>
                <select name="etapeBudgetaire" id="etapeBudgetaire">
                    <option>Budget primitif</option>
                    <option>DM1</option>
                    <option>DM2</option>
                    <option>DM3</option>
                    <option>CA</option>
                    <!-- Options chargées depuis la base de données -->
                </select>
            </div>
            <div class="form-group">
                <label for="etapePrecedente">Étape Budgétaire Précédente</label>
                <select name="etapePrecedente" id="etapePrecedente">
                    <!-- Options chargées depuis la base de données -->
                    <option>Budget primitif</option>
                    <option>DM1</option>
                    <option>DM2</option>
                    <option>DM3</option>
                    <option>CA</option>
                </select>
            </div>
            <div class="form-group">
                <label for="mouvementsReports">Mouvements de Reports au Niveau de l'Étape</label>
                <select name="mouvementsReports" id="mouvementsReports">
                    <option>REP</option>
                    <option> </option>
                   
                    <!-- Options chargées depuis la base de données -->
                </select>
            </div>
            <div class="form-group">
                <label for="statut">Statut</label>
                <select name="statut" id="statut">
                    <option>Arbitré</option>
                   
                   
                    <!-- Options chargées depuis la base de données -->
                </select>
            </div>
        </div>
        <div class="flex-container">
            <div>
                <h2>Dépenses et fonctionnement</h2>
                <!-- Tableau des dépenses -->
                <table>
                    <thead class="depenses">
                        <tr>
                            <th>Chapitre</th>
                            <th>Libellé</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td> 011 </td>
                            <td> Charges à caractère général </td>
                            <td> </td>
                        </tr>
                        <tr>
                            <td> 012 </td>
                            <td> Charges de personnel et frais assimilés </td>
                            <td> </td>
                        </tr>
                        <tr>
                            <td> 014 </td>
                            <td> Atténuations de produits </td>
                            <td> </td>
                        </tr>
                        <tr>
                            <td> 016 </td>
                            <td> APA </td>
                            <td> </td>
                        </tr>
                        <tr>
                            <td> 017 </td>
                            <td> RSA </td>
                            <td> </td>
                        </tr>
                        <tr>
                            <td> 65 </td>
                            <td> Autres charges de gestion courante </td>
                            <td> </td>
                        </tr>
                        <tr>
                            <td> 6586</td>
                            <td>Frais fonctionnement groupes d'élus</td>
                            <td> </td>
                        </tr>
                    </tbody>
                    <thead>
                        <tr class="total">
                            <th colspan="2"> Total des dépenses de gestion courante</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td> 66 </td>
                            <td> Charges financières </td>
                            <td> </td>
                        </tr>
                        <tr>
                            <td> 67 </td>
                            <td> Charges spécifiques </td>
                            <td> </td>
                        </tr>
                        <tr>
                            <td> 68 </td>
                            <td> Dotations aux provisions </td>
                            <td> </td>
                        </tr>
                        </tbody>
                        <thead class="depenses">
                        <tr>
                            <th colspan="2">Total des dépenses réelles de fonctionnement</th>
                            <th></th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div>
                <h2>Comparaison avec total vote de l'exercice</h2>
                <!-- Tableau de comparaison -->
                <table>
                    <thead>
                        <tr class="fonction">
                            <th>Chapitre</th>
                            <th>Libellé</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td> 011 </td>
                            <td> Charges à caractère général </td>
                            <td> </td>
                        </tr>
                        <tr>
                            <td> 012 </td>
                            <td> Charges de personnel et frais assimilés </td>
                            <td> </td>
                        </tr>
                        <tr>
                            <td> 014 </td>
                            <td> Atténuations de produits </td>
                            <td> </td>
                        </tr>
                        <tr>
                            <td> 016 </td>
                            <td> APA </td>
                            <td> </td>
                        </tr>
                        <tr>
                            <td> 017 </td>
                            <td> RSA </td>
                            <td> </td>
                        </tr>
                        <tr>
                            <td> 65 </td>
                            <td> Autres charges de gestion courante </td>
                            <td> </td>
                        </tr>
                        <tr>
                            <td> 6586</td>
                            <td>Frais fonctionnement groupes d'élus</td>
                            <td> </td>
                        </tr>
                    </tbody>
                    <thead>
                        <tr class="total">
                            <th colspan="2"> Total des dépenses de gestion courante</th>
                            <th></th>
                        </tr>
                    <tbody>
                        <tr>
                            <td> 66 </td>
                            <td> Charges financières </td>
                            <td> </td>
                        </tr>
                        <tr>
                            <td> 67 </td>
                            <td> Charges spécifiques </td>
                            <td> </td>
                        </tr>
                        <tr>
                            <td> 68 </td>
                            <td> Dotations aux provisions </td>
                            <td> </td>
                        </tr>
                        </tbody>
                        <thead class="fonction">
                        <tr>
                            <th colspan="2">Total des dépenses réelles de fonctionnement</th>
                            <th></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>

    
</div>
    <footer class="footer">
       
            <p>&copy; 2023 Conseil Départemental de la côte d'or. Tous droits réservés.</p>
        
    </footer>


</body>

</html>
