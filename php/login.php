<?php
session_start();
// On permet la connexion à la base de données
require_once 'login_bdd.php';

// On vérifie que la requête vient bien du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Fonction pour éviter les failles XSS
    function nettoyer($donnee) {
        return htmlspecialchars(trim($donnee));
    }

    // On récupère et on nettoie les données du formulaire
    $identifiant = nettoyer($_POST['identifiant'] ?? '');
    $mdp = nettoyer($_POST['mdp'] ?? '');

    $erreurs = [];

    // Vérification des champs
    if (empty($identifiant)) {
        $erreurs[] = "Veuillez entrer votre identifiant ou e-mail.";
    }

    if (empty($mdp)) {
        $erreurs[] = "Veuillez entrer votre mot de passe.";
    }

    // S'il n'y a pas d'erreurs
    if (empty($erreurs)) {
        try {
            // Recherche dans la base de données par identifiant OU mail
            $stmt = $conn->prepare("SELECT * FROM utilisateurs WHERE mail = :identifiant OR identifiant = :identifiant");
            $stmt->execute([
                'identifiant' => $identifiant
            ]);

            $utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);

            // Vérification du mot de passe
            if ($utilisateur && $mdp == $utilisateur['mdp']) { // Comparaison directe sans hash
                // Connexion réussie, gestion de la session
                $_SESSION['user_id'] = $utilisateur['id']; // Enregistrer l'ID de l'utilisateur dans la session
                $_SESSION['username'] = $utilisateur['identifiant']; // Enregistrer l'identifiant
                header("Location: ../index.php"); // Redirige vers le tableau de bord ou la page protégée
                exit();
            } else {
                $erreurs[] = "Identifiant ou mot de passe incorrect.";
            }
        } catch (Exception $e) {
            $erreurs[] = "Erreur lors de la connexion : " . htmlspecialchars($e->getMessage());
        }
    }

    // Affichage des erreurs
    if (!empty($erreurs)) {
        echo "<h2>Erreurs :</h2><ul>";
        foreach ($erreurs as $e) {
            echo "<li>" . htmlspecialchars($e) . "</li>";
        }
        echo "</ul>";
        echo "<a href='../php/connexion.php'>Retour à la page de connexion</a>";
    }
} else {
    // Redirige si la méthode n'est pas POST
    header("Location: ../php/connexion.php");
    exit();
}
?>