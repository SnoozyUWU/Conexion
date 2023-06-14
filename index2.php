<?php
// Informations de connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";

// Connexion au serveur MySQL
$conn = new mysqli($servername, $username, $password);

// Vérification des erreurs de connexion
if ($conn->connect_error) {
    die("Erreur de connexion à la base de données : " . $conn->connect_error);
}

// Nom de la base de données
$databaseName = "sae203";

// Vérifier si la base de données existe
if ($conn->query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$databaseName'")->num_rows == 0) {
    // Création de la base de données
    $createDatabaseQuery = "CREATE DATABASE $databaseName";

    if ($conn->query($createDatabaseQuery) === FALSE) {
        die("Erreur lors de la création de la base de données : " . $conn->error);
    }
}

// Sélection de la base de données
$conn->select_db($databaseName);

// Nom de la table
$tableName = "utilisateur";

// Vérifier si la table n'existe pas
if ($conn->query("SHOW TABLES LIKE '$tableName'")->num_rows == 0) {
    // Création de la table utilisateur
    $createTableQuery = "CREATE TABLE $tableName (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        nom_utilisateur VARCHAR(50) NOT NULL UNIQUE,
        mot_de_passe VARCHAR(50) NOT NULL
    )";

    if ($conn->query($createTableQuery) === FALSE) {
        die("Erreur lors de la création de la table utilisateur : " . $conn->error);
    }
}

// Vérification si le formulaire d'inscription est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["inscription"])) {
    // Récupération des valeurs du formulaire
    $uname = $_POST["uname"];
    $psw = $_POST["psw"];
    $cpsw = $_POST["cpsw"];

    // Vérification si le nom d'utilisateur existe déjà dans la base de données
    $checkUsernameQuery = "SELECT * FROM $tableName WHERE nom_utilisateur = '$uname'";
    $result = $conn->query($checkUsernameQuery);

    if ($result->num_rows > 0) {
        echo "<script>alert('Le nom d\\'utilisateur est déjà pris. Veuillez en choisir un autre.');</script>";
    } elseif ($psw !== $cpsw) {
        echo "<script>alert('Les mots de passe ne correspondent pas. Veuillez réessayer.');</script>";
    } else {
        // Insertion du nouvel utilisateur dans la base de données
        $insertUserQuery = "INSERT INTO $tableName (nom_utilisateur, mot_de_passe) VALUES ('$uname', '$psw')";

        if ($conn->query($insertUserQuery) === TRUE) {
            echo "<script>alert('Le compte a été créé avec succès. Vous pouvez vous connecter.');</script>";
        } else {
            echo "<script>alert('Erreur lors de la création du compte. Veuillez réessayer.');</script>";
        }
    }
}

// Fermeture de la connexion à la base de données
$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Mon Site</title>
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <link rel="stylesheet" href="css/style.css">
    <script>
        function showError(message) {
            alert(message);
        }
    </script>
</head>
<body>
    <header>
        <h1>Mon Site</h1>
    </header>
    <main>
        <h2 class="subtitle">Connectez-vous à votre compte</h2>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="container">
                <div class="imgcontainer">
                    <img src="img/avatar.png" alt="Avatar" class="avatar">
                </div>
                <label for="uname"><b>Identifiant</b></label>
                <input type="text" placeholder="Entrez votre identifiant" name="uname" required>
                <label for="psw"><b>Mot de passe</b></label>
                <input type="password" placeholder="Entrez votre mot de passe" name="psw" required>
                <h3 class="text">Vous n'avez pas de compte ? Créez-le <a href="#">ici</a></h3>
                <input type="hidden" value="false" name="inscription"></input>
                <button type="submit">Connexion</button>
            </div>
            <div class="container" style="background-color:#f1f1f1">
                <button type="button" class="cancelbtn">Cancel</button>
            </div>
        </form>

        <h2 class="subtitle">Création de votre compte</h2>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="container">
                <div class="imgcontainer">
                    <img src="img/creation.png" alt="Creation" class="creation">
                </div>
                <label for="uname"><b>Identifiant</b></label>
                <input type="text" placeholder="Identifiant" name="uname" required>
                <label for="psw"><b>Mot de passe</b></label>
                <input type="password" placeholder="Mot de passe" name="psw" required>
                <label for="psw"><b>Confirmez votre mot de passe</b></label>
                <input type="password" placeholder="Mot de passe" name="cpsw" required>
                <input type="hidden" value="true" name="inscription"></input>
                <button type="submit">Création</button>
            </div>
            <div class="container" style="background-color:#f1f1f1">
                <button type="button" class="cancelbtn">Cancel</button>
            </div>
        </form>
    </main>
</body>
</html>
