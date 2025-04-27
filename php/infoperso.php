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

    <footer>
        <div class="footer-gauche">
            <img src="../images/footer/angouleme.png" alt="Logo d'Angoulême" />
            <img src="../images/footer/unesco.png" alt="Membre des villes de l'Unesco" />
        </div>
        <div class="footer-centre">
            <div class="carte">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d44627.94880314658!2d0.10382750595865571!3d45.64586530034062!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47fe2d85032bc499%3A0x405d39260eec0f0!2sAngoulême!5e0!3m2!1sfr!2sfr!4v1733300128398!5m2!1sfr!2sfr" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
            <div class="infos">
                <dl class="infos2">
                    <dd>Angoulême 16000</dd>
                </dl>
            </div>
            <div class="logos">
                <a href="https://www.facebook.com/villeangouleme" target="_blank"><img src="../images/footer/facebook.png" alt="Facebook d'Angoulême" /></a>
                <a href="https://www.instagram.com/villeangouleme/" target="_blank"><img src="../images/footer/instagram.png" alt="Instagram d'Angoulême" /></a>
                <a href="https://www.youtube.com/@VilleAngoulemeTV" target="_blank"><img src="../images/footer/youtube.png" alt="Youtube d'Angoulême" /></a>
                <a href="https://twitter.com/villeangouleme" target="_blank"><img src="../images/footer/twitter.png" alt="Twitter d'Angoulême" /></a>
                <a href="https://fr.linkedin.com/company/villeangouleme" target="_blank"><img src="../images/footer/linkedin.png" alt="Linkedin d'Angoulême" /></a>
            </div>
        </div>
        <div class="footer-droite">
            <ul class="infos1">
                <li><p>Téléphone :</p><p>05 45 38 92 89</p></li>
                <li><a href="contact.php" class="contact1">Nous contacter</a></li>
                <li><a href="politiquedeconfidentialite.php" class="lien">Politique de confidentialité</a></li>
            </ul>
        </div>
    </footer>
</html>
