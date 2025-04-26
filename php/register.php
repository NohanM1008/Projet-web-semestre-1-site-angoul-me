<?php
// Démarrage de la session (utile pour plus tard avec les connexions)
session_start();

// Ceci est une fonction pour éviter les failles XSS et ainsi améliorer grandement la sécurité du site 
function nettoyer($donnee) {
    return htmlspecialchars(trim($donnee));
}

// On vérifie que le formulaire a bien été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // On récupère et nettoie des données (pour améliorer la sécurité)
    $genre = isset($_POST['genre']) ? nettoyer($_POST['genre']) : "";
    $nom = nettoyer($_POST['nom']);
    $prenom = nettoyer($_POST['prenom']);
    $email = nettoyer($_POST['mail']);
    $identifiant = nettoyer($_POST['identifiant']);
    $mdp = nettoyer($_POST['mdp']);

    $erreurs = [];
    // On vérifie que tous les champs ont été remplis
    if (empty($nom) || empty($prenom) || empty($email) || empty($identifiant) || empty($mdp) || empty($mdp2)) {
        $erreurs[] = "Tous les champs sont obligatoires.";
    }
    // On vérifie que l'adresse email est valide
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreurs[] = "Adresse email invalide.";
    }
    // On vérifie que les 2 mots de passe correspondent
    if ($mdp !== $mdp2) {
        $erreurs[] = "Les mots de passe ne correspondent pas.";
    }
    // Si aucune erreur n'a été repéré, on mets un message de validation
    if (empty($erreurs)) {
        echo "<h2>Compte créé avec succès !</h2>";
        echo "<p>Bienvenue, " . $prenom . " " . $nom . " (" . $identifiant . ")</p>";
        echo "<a href='connexion.html'>Se connecter</a>";
    } else { // Sinon on met un message d'erreur
        echo "<h2>Erreurs :</h2>";
        echo "<ul>";
        foreach ($erreurs as $e) {
            echo "<li>" . $e . "</li>";
        }
        echo "</ul>";
        echo "<a href='compte.html'>Retour</a>";
    }
} else {
    header("Location: compte.php");
    exit();
}
?>