<?php
$host = 'localhost';  // Serveur de base de données (en local)
$dataname = 'angouleme'; // Nom de votre base
$username = 'root';    // Nom d'utilisateur MySQL (souvent 'root' en local)
$password = '';        // Mot de passe MySQL (souvent vide en local)

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    // On définit le mode d'erreur de PDO sur Exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Erreur de connexion : ' . $e->getMessage());
}
?>
