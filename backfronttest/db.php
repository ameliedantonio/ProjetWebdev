<?php
$host = '127.0.0.1';  // Adresse du serveur MySQL
$username = 'root';    // Utilisateur MySQL (modifie si nécessaire)
$password = '';        // Mot de passe MySQL (modifie si nécessaire)
$dbname = 'zoo';       // Nom de la base de données

// Création de la connexion
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    // Configuration des options de PDO
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>
