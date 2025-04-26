<?php
// On permet la connexion à la base de données
require_once 'login_bdd.php';

// On vérifiee que la requête vient bien du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Ceci est une fonction pour éviter les failles XSS et ainsi améliorer grandement la sécurité du site 
    function nettoyer($donnee) {
        return htmlspecialchars(trim($donnee));
    }

    // On récupère et on nettoie les données du formulaire
    $identifiant = nettoyer($_POST['identifiant'] ?? '');
    $mdp = nettoyer($_POST['mdp'] ?? '');

    $erreurs = [];

    // On vérifie que tous les champs sont valides/remplis
    if (empty($identifiant)) {
        $erreurs[] = "Veuillez entrer votre identifiant ou e-mail.";
    }

    if (empty($mdp)) {
        $erreurs[] = "Veuillez entrer votre mot de passe.";
    }

    // S'il n'a pas d'erreurs, on vérifie les identifiants en base
    if (empty($erreurs)) {
        try {
            // On prépare la requête : on cherche par identifiant OU par email
            $stmt = $conn->prepare("SELECT * FROM utilisateurs WHERE email = :email OR identifiant = :identifiant");
            $stmt->execute([
                'email' => $identifiant,
                'identifiant' => $identifiant
            ]);

            $utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);

            // On vérifier que l'utilisateur existe et que le mot de passe correspond
            if ($utilisateur && password_verify($mdp, $utilisateur['mot_de_passe'])) {
                echo "<h2>Connexion réussie ! Bienvenue " . htmlspecialchars($utilisateur['identifiant']) . ".</h2>";
                echo "<a href='../index.html'>Aller à l'accueil</a>";
            } else {
                echo "<h2>Identifiant ou mot de passe incorrect.</h2>";
                echo "<a href='../php/connexion.php'>Réessayer</a>";
            }
        } catch (Exception $e) {
            echo "<h2>Erreur lors de la connexion : " . htmlspecialchars($e->getMessage()) . "</h2>";
        }
    } else {
        // Affichage des erreurs
        echo "<h2>Erreurs :</h2><ul>";
        foreach ($erreurs as $e) {
            echo "<li>" . htmlspecialchars($e) . "</li>";
        }
        echo "</ul>";
        echo "<a href='../php/connexion.php'>Retour à la page de connexion</a>";
    }
} else {
    // Si quelqu'un essaie d'ouvrir directement la page login.php sans envoyer le formulaire
    header("Location: ../php/connexion.php");
    exit();
}
?>
