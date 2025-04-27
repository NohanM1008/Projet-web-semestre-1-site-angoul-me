<?php
// Démarrer la session
session_start();

// Si ce n'est pas une requête POST, redirige vers le formulaire
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: contact.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération sécurisée des données du formulaire
    $genre = htmlspecialchars($_POST["genre"] ?? '');
    $nom = htmlspecialchars($_POST["nom"] ?? '');
    $prenom = htmlspecialchars($_POST["prenom"] ?? '');
    $mail = htmlspecialchars($_POST["mail"] ?? '');
    $telephone = htmlspecialchars($_POST["telephone"] ?? '');
    $objet = htmlspecialchars($_POST["objet"] ?? '');
    $precision = htmlspecialchars($_POST["precision_demande"] ?? '');
    $description = htmlspecialchars($_POST["description"] ?? '');

    // Vérification que les champs obligatoires sont remplis
    if (empty($nom) || empty($prenom) || empty($mail) || empty($description)) {
        echo "<h1>Erreur : Veuillez remplir tous les champs obligatoires (Nom, Prénom, Mail, Message).</h1>";
        echo '<a href="contact.php">Retourner au formulaire</a>';
        exit;
    }
}
$servername = 'localhost'; // Serveur de base de données
$username = 'root'; // Nom d'utilisateur
$password = 'root'; // Mot de passe
$dataname = 'projet'; // Nom de la base de donnée
// On essaie de se connecter

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dataname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Préparation de la requête SQL pour insérer les données dans la table "contacts"
    $stmt = $pdo->prepare("INSERT INTO contacts (genre, nom, prenom, email, telephone, objet, precision, description) 
                           VALUES (:genre, :nom, :prenom, :email, :telephone, :objet, :precision, :description)");

    // Lier les paramètres à la requête préparée
    $stmt->bindParam(':genre', $genre);
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':prenom', $prenom);
    $stmt->bindParam(':email', $mail);
    $stmt->bindParam(':telephone', $telephone);
    $stmt->bindParam(':objet', $objet);
    $stmt->bindParam(':precision', $precision);
    $stmt->bindParam(':description', $description);

    // Exécution de la requête
    $stmt->execute();

    // Affichage d'un message de confirmation
    echo "<h1>Merci pour votre message !</h1>";
    echo "<p>Voici un récapitulatif de votre demande :</p>";
    echo "<ul>";
    echo "<li><strong>Genre :</strong> " . ($genre ? $genre : "Non précisé") . "</li>";
    echo "<li><strong>Nom :</strong> $nom</li>";
    echo "<li><strong>Prénom :</strong> $prenom</li>";
    echo "<li><strong>Email :</strong> $mail</li>";
    echo "<li><strong>Téléphone :</strong> " . ($telephone ? $telephone : "Non précisé") . "</li>";
    echo "<li><strong>Objet :</strong> " . ($objet !== "0" ? $objet : "Non précisé") . "</li>";
    echo "<li><strong>Précision :</strong> " . ($precision ? $precision : "Aucune précision") . "</li>";
    echo "<li><strong>Message :</strong> $description</li>";
    echo "</ul>";

    echo '<a href="contact.php">Retourner au formulaire</a>';
} catch (Exception $e) {
    echo "<h1>Erreur : Impossible d'enregistrer les données.</h1>";
    echo "Erreur : " . $e->getMessage();
    echo '<a href="contact.php">Retourner au formulaire</a>';
}
?>
?>