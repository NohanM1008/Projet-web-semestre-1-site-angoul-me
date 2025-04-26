<?php
// Ceci est une fonction pour éviter les failles XSS et ainsi améliorer grandement la sécurité du site
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    function nettoyer($donnee) {
        return htmlspecialchars(trim($donnee));
    }
    // On nettoie les données (pour améliorer la sécurité)
    $identifiant = nettoyer($_POST['identifiant'] ?? '');
    $mdp = nettoyer($_POST['mdp'] ?? '');

    $erreurs = [];

    // On vérifie qu'il n'y a pas d'erreur
    if (empty($identifiant)) {
        $erreurs[] = "Veuillez entrer votre identifiant.";
    }

    if (empty($mdp)) {
        $erreurs[] = "Veuillez entrer votre mot de passe.";
    }

    if (empty($erreurs)) {
        // !! À ce stade normalement on vérifie dans la base de données.
        // Mais comme on n'a pas encore de BDD, on va simuler un identifiant/mot de passe

        $identifiantCorrect = "TheodortleBison"; // Exemple d'identifiant correct
        $motDePasseCorrect = "password123";       // Exemple de mot de passe correct

        if ($identifiant === $identifiantCorrect && $mdp === $motDePasseCorrect) {
            echo "<h2>Connexion réussie ! Bienvenue $identifiant.</h2>";
            echo "<a href='index.html'>Aller à l'accueil</a>";
        } else {
            echo "<h2>Identifiant ou mot de passe incorrect.</h2>";
            echo "<a href='connexion.html'>Réessayer</a>";
        }
    } else {
        // S'il y a des erreurs, on les affiche
        echo "<h2>Erreurs :</h2><ul>";
        foreach ($erreurs as $e) {
            echo "<li>" . $e . "</li>";
        }
        echo "</ul>";
        echo "<a href='connexion.html'>Retour à la page de connexion</a>";
    }
} else {
    // Si la page est ouverte directement, on redirige
    header("Location: connexion.php");
    exit();
}
?>