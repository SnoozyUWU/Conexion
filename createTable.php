<?php
// Connexion au serveur de base de données
$servername = "localhost";
$username = "root";
$password = "";

$conn = new mysqli($servername, $username, $password);

// Vérification des erreurs de connexion
if ($conn->connect_error) {
    die("Erreur de connexion au serveur de base de données : " . $conn->connect_error);
}

// Création de la base de données
$databaseName = "sae203";
$sqlCreateDatabase = "CREATE DATABASE IF NOT EXISTS $databaseName";

if ($conn->query($sqlCreateDatabase) === TRUE) {
    echo "La base de données '$databaseName' a été créée avec succès.";

    // Connexion à la base de données
    $conn->select_db($databaseName);

    // Création de la table "utilisateurs"
    $sqlCreateTable = "CREATE TABLE IF NOT EXISTS utilisateurs (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL,
        password VARCHAR(255) NOT NULL
    )";

    if ($conn->query($sqlCreateTable) === TRUE) {
        echo "La table 'utilisateurs' a été créée avec succès.";
    } else {
        echo "Erreur lors de la création de la table : " . $conn->error;
    }
} else {
    echo "Erreur lors de la création de la base de données : " . $conn->error;
}

// Fermeture de la connexion au serveur de base de données
$conn->close();
?>
