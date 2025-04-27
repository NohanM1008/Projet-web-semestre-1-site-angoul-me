<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr"> <!-- Je commence pas page html en définissant le langage (ici français)-->
    <head>  <!-- La balise head anglobe tout ce qui n'apparaîtra pas dans notre page Web-->
        <title><?php echo htmlspecialchars($pageTitle); ?></title>
        <link rel="icon" href="../images/logo.png" type="image/x-icon">
        <meta charset="utf-8"> <!-- On utilisera la chaîne de caractère utf-8-->
        <link rel="stylesheet" href="../css/boutique.css"> <!-- On link la page html avec la page css afin d'ajouter de l'esthétique à notre page WEB -->
        <link rel="stylesheet" href="../css/footer.css">
        <link rel="stylesheet" href="../css/header.css">
    </head>
    <body> <!-- La balise body anglobe tout ce qui apparaîtra dans notre page Web-->
    <header>
        <a href="../index.php"><img src="../images/logo.png" alt="Angoulême Logo"></a>

        <?php if (isset($_SESSION['id'])): ?>
            <a href="infoperso.php" class="btn-connexion">Mon profil</a>
        <?php else: ?>
            <a href="connexion.php" class="btn-connexion">Se connecter</a>
        <?php endif; ?>

        <h1>Ville d'Angoulême</h1>
    </header>
        <nav>
            <ol><!--Liste non ordonnée pour la navigation entre les pages-->
                <li><a href="../index.php">Accueil</a></li>
                <li><a href="loisirs.php">Tourisme et loisirs</a></li>
                <li><a href="histoire.php">Histoire</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ol>
        </nav>