<?php
// On démarre la session
session_start();

// On permet la connexion à la base de données
require_once 'connexion_bdd.php';

// Ceci est une fonction pour éviter les failles XSS et ainsi améliorer grandement la sécurité du site 
function nettoyer($donnee) {
    return htmlspecialchars(trim($donnee));
}

// On vérifie que le formulaire a été envoyé
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // On récupère les données du formulaire
    $genre = isset($_POST['genre']) ? nettoyer($_POST['genre']) : "";
    $nom = nettoyer($_POST['nom']);
    $prenom = nettoyer($_POST['prenom']);
    $email = nettoyer($_POST['mail']);
    $identifiant = nettoyer($_POST['identifiant']);
    $mdp = nettoyer($_POST['mdp']);
    $mdp2 = nettoyer($_POST['mdp2']);
    $date_naissance = isset($_POST['date_naissance']) ? nettoyer($_POST['date_naissance']) : null;

    $erreurs = [];

    // On vérifie que tous les champs ont bien été remplis
    if (empty($nom) || empty($prenom) || empty($email) || empty($identifiant) || empty($mdp) || empty($mdp2)) {
        $erreurs[] = "Tous les champs sont obligatoires.";
    }

    // On vérifie que l'adresse email est bien valide
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreurs[] = "Adresse email invalide.";
    }

    // On vérifie que les mots de passe correspondent
    if ($mdp !== $mdp2) {
        $erreurs[] = "Les mots de passe ne correspondent pas.";
    }

    // On vérifie si l'email ou l'identifiant existent déjà (pour éviter les incohérences/erreurs dans la BDD)
    $stmt = $conn->prepare("SELECT * FROM utilisateurs WHERE email = :email OR identifiant = :identifiant");
    $stmt->execute(['email' => $email, 'identifiant' => $identifiant]);
    if ($stmt->fetch()) {
        $erreurs[] = "Un compte avec cet e-mail ou identifiant existe déjà.";
    }

    // S'il n'y a pas d'erreurs, on enregistre
    if (empty($erreurs)) {
        $mdp_hash = password_hash($mdp, PASSWORD_DEFAULT); // Hachage du mot de passe

        $stmt = $conn->prepare("INSERT INTO utilisateurs (genre, nom, prenom, email, identifiant, mot_de_passe, date_naissance) 
                                VALUES (:genre, :nom, :prenom, :email, :identifiant, :mot_de_passe, :date_naissance)");

        $stmt->execute([
            'genre' => $genre,
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $email,
            'identifiant' => $identifiant,
            'mot_de_passe' => $mdp_hash,
            'date_naissance' => $date_naissance
        ]);

        echo "<h2>Compte créé avec succès !</h2>";
        echo "<p>Bienvenue, " . htmlspecialchars($prenom) . " " . htmlspecialchars($nom) . " (" . htmlspecialchars($identifiant) . ")</p>";
        echo "<a href='connexion.php'>Se connecter</a>";

    } else {
        // Sinon on affiche des erreurs
        echo "<h2>Erreurs :</h2><ul>";
        foreach ($erreurs as $e) {
            echo "<li>" . htmlspecialchars($e) . "</li>";
        }
        echo "</ul>";
        echo "<a href='../php/compte.php'>Retour</a>";
    }
} else {
    header("Location: ../php/compte.php");
    exit();
}
?>