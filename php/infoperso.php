<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: connexion.php");
    exit;
}
$host = 'localhost';
$dbname = 'projet';
$username = 'root';
$password = 'root';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
$sql = "SELECT id, genre, nom, prenom, date_naissance, mail, identifiant 
        FROM utilisateurs 
        WHERE id = :id";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $_SESSION['id'], PDO::PARAM_INT);
$stmt->execute();
$utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);

$pageTitle = "Ville d'Angoulême";
$css = "infoperso"; 
include 'header.php';
?>

<body>
<main class="encadre">
    <h2>Mon profil</h2>

    <?php if ($utilisateur): ?>
        <div class="profil">
            <div class="profil"><strong>ID :</strong> <?= htmlspecialchars($utilisateur['id']) ?></div>
            <div class="profil"><strong>Genre :</strong> <?= htmlspecialchars($utilisateur['genre']) ?></div>
            <div class="profil"><strong>Nom :</strong> <?= htmlspecialchars($utilisateur['nom']) ?></div>
            <div class="profil"><strong>Prénom :</strong> <?= htmlspecialchars($utilisateur['prenom']) ?></div>
            <div class="profil"><strong>Date de naissance :</strong> <?= htmlspecialchars($utilisateur['date_naissance']) ?></div>
            <div class="profil"><strong>Email :</strong> <?= htmlspecialchars($utilisateur['mail']) ?></div>
            <div class="profil"><strong>Identifiant :</strong> <?= htmlspecialchars($utilisateur['identifiant']) ?></div>
        </div>
    <?php else: ?>
        <p>Utilisateur introuvable.</p>
    <?php endif; ?>
</main>


<?php include 'footer.php'; ?>
</body>
</html>
