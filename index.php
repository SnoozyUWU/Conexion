<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sae203";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification des erreurs de connexion
if ($conn->connect_error) {
    die("Erreur de connexion à la base de données : " . $conn->connect_error);
}

// Initialisation de la variable pour contrôler la visibilité de la section d'inscription
$showInscription = false;

// Message de confirmation
$confirmationMessage = '';

// Vérification des données soumises pour la connexion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["inscription"]) && $_POST["inscription"] == "false") {
    // ... Code de vérification de la connexion ...

    // Connexion réussie, affichage du message de confirmation
    $confirmationMessage = "Connexion réussie !";
}

// Vérification des données soumises pour l'inscription
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["inscription"]) && $_POST["inscription"] == "true") {
    // ... Code de vérification et d'insertion de l'inscription ...

    // Inscription réussie, affichage du message de confirmation
    $confirmationMessage = "Compte créé avec succès !";
}

// Fermeture de la connexion à la base de données
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Formulaire de connexion et d'inscription</title>
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <main>
        <h2 class="subtitle">Connectez vous à votre compte</h2>

        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="container">
                <div class="imgcontainer">
                    <img src="img/avatar.png" alt="Avatar" class="avatar">
                </div>
                <label for="uname"><b>Identifiant</b></label>
                <input type="text" placeholder="Entrez votre identifiant" name="uname" required>

                <label for="psw"><b>Mot de passe</b></label>
                <input type="password" placeholder="Entrez votre mot de passe" name="psw" required>

                <h3 class="text">Vous n'avez pas de compte ? Créez le <a href="#" onclick="toggleInscription()">ici</a></h3>

                <input type="hidden" value="false" name="inscription"></input>
                <button type="submit">Connexion</button>
            </div>

            <div class="container" style="background-color:#f1f1f1">
                <button type="button" class="cancelbtn">Cancel</button>
            </div>
        </form>

        <h2 class="subtitle" id="inscriptionTitle" style="display: none;">Création de votre compte</h2>

        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="inscriptionForm" style="display: none;">
            <div class="container">
                <div class="imgcontainer">
                    <img src="img/creation.png" alt="Creation" class="creation">
                </div>
                <label for="uname"><b>Identifiant</b></label>
                <input type="text" placeholder="Identifiant" name="uname" required>

                <label for="psw"><b>Mot de passe</b></label>
                <input type="password" placeholder="Mot de passe" name="psw" required>

                <label for="cpsw"><b>Confirmez votre mot de passe</b></label>
                <input type="password" placeholder="Confirmez votre mot de passe" name="cpsw" required>

                <input type="hidden" value="true" name="inscription"></input>
                <button type="submit">Création</button>
            </div>

            <div class="container" style="background-color:#f1f1f1">
                <button type="button" class="cancelbtn" onclick="toggleInscription()">Cancel</button>
            </div>
        </form>

        <div id="confirmationMessage" style="display: <?php echo $confirmationMessage ? 'block' : 'none'; ?>;">
            <?php echo $confirmationMessage; ?>
        </div>

        <script>
            function toggleInscription() {
                var title = document.getElementById("inscriptionTitle");
                var form = document.getElementById("inscriptionForm");
                var confirmation = document.getElementById("confirmationMessage");

                if (title.style.display === "none") {
                    title.style.display = "block";
                    form.style.display = "block";
                    confirmation.style.display = "none";
                } else {
                    title.style.display = "none";
                    form.style.display = "none";
                    confirmation.style.display = "none";
                }
            }
        </script>
    </main>
</body>
</html>
