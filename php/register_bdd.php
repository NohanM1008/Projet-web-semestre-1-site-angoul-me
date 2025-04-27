<?php
// connexion_bdd.php

$servername = "localhost";
$username = "root";
$password = "root"; // ou le mot de passe de ta base de données
$dataname = "projet"; // le nom de ta base de données

// Créer la connexion
$conn = new mysqli($servername, $username, $password, $dataname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
