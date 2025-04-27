<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Ville d'Angoulême</title>
    <link rel="icon" href="../images/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/header.css"> <!-- lien vers ton CSS -->

</head>
<body>
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
        <ol>
            <li><a href="../index.php">Accueil</a></li>
            <li><a href="loisirs.php">Tourisme et loisirs</a></li>
            <li><a href="histoire.php">Histoire</a></li>
            <li><a href="contact.php">Contact</a></li>
        </ol>
    </nav>
</body>
<div class="container">
        <h2>Liste des Utilisateurs</h2>

        <?php if (count($utilisateurs) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Genre</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Date de naissance</th>
                        <th>Email</th>
                        <th>Identifiant</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($utilisateurs as $utilisateur): ?>
                        <tr>
                            <td><?= htmlspecialchars($utilisateur['id']) ?></td>
                            <td><?= htmlspecialchars($utilisateur['genre']) ?></td>
                            <td><?= htmlspecialchars($utilisateur['nom']) ?></td>
                            <td><?= htmlspecialchars($utilisateur['prenom']) ?></td>
                            <td><?= htmlspecialchars($utilisateur['date_naissance']) ?></td>
                            <td><?= htmlspecialchars($utilisateur['mail']) ?></td>
                            <td><?= htmlspecialchars($utilisateur['identifiant']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Aucun utilisateur trouvé.</p>
        <?php endif; ?>
    </div>

<?php
include 'footer.php';
?>