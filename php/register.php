<?php
// On démarre la session
session_start();

// Connexion à la base de données
require_once 'register_bdd.php';

// Fonction pour éviter les failles XSS
function nettoyer($donnee) {
    return htmlspecialchars(trim($donnee));
}

// Vérification que le formulaire est envoyé
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Récupération et nettoyage des données
    $genre = isset($_POST['genre']) ? nettoyer($_POST['genre']) : "";
    $nom = nettoyer($_POST['nom']);
    $prenom = nettoyer($_POST['prenom']);
    $mail = nettoyer($_POST['mail']);
    $identifiant = nettoyer($_POST['identifiant']);
    $mdp = nettoyer($_POST['mdp']);
    $mdp2 = nettoyer($_POST['mdp2']);
    $date_naissance = htmlspecialchars($_POST['date_naissance'] ?? null);


    $erreurs = [];

    // Vérification des champs
    if (empty($nom) || empty($prenom) || empty($mail) || empty($identifiant) || empty($mdp) || empty($mdp2)) {
        $erreurs[] = "Tous les champs sont obligatoires.";
    }

    // Vérification de l'email
    if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        $erreurs[] = "Adresse email invalide.";
    }

    // Vérification des mots de passe
    if ($mdp !== $mdp2) {
        $erreurs[] = "Les mots de passe ne correspondent pas.";
    }

    // Vérification si l'email ou l'identifiant existent déjà
    $stmt = $conn->prepare("SELECT * FROM utilisateurs WHERE mail = :mail OR identifiant = :identifiant");
    $stmt->execute([
        'mail' => $mail,
        'identifiant' => $identifiant
    ]);

    if ($stmt->fetch()) {
        $erreurs[] = "Un compte avec cet e-mail ou identifiant existe déjà.";
    }

    // Si pas d'erreurs, on enregistre
    if (empty($erreurs)) {
        $mdp_hash = password_hash($mdp, PASSWORD_DEFAULT); // Hachage du mot de passe

        $stmt = $conn->prepare("INSERT INTO utilisateurs (genre, nom, prenom, mail, identifiant, mdp, date_naissance) 
                                VALUES (:genre, :nom, :prenom, :mail, :identifiant, :mdp, :date_naissance)");

        $stmt->execute([
            'genre' => $genre,
            'nom' => $nom,
            'prenom' => $prenom,
            'mail' => $mail,
            'identifiant' => $identifiant,
            'mdp' => $mdp_hash,
            'date_naissance' => $date_naissance
        ]);

        echo "<h2>Compte créé avec succès !</h2>";
        echo "<p>Bienvenue, " . htmlspecialchars($prenom) . " " . htmlspecialchars($nom) . " (" . htmlspecialchars($identifiant) . ")</p>";
        echo "<a href='connexion.php'>Se connecter</a>";

    } else {
        // Affichage des erreurs
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
