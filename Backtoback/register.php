<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdo = new PDO('mysql:host=localhost;dbname=zoo', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $email = trim($_POST['email']);
    $nickname = trim($_POST['nickname']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO users (mail, nickname, password) VALUES (?, ?, ?)");
    $stmt->execute([$email, $nickname, $password]);

    echo "Inscription réussie ! Vous pouvez maintenant <a href='login.php'>vous connecter</a>.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
</head>
<body>
    <h1>Inscription</h1>
    <form method="POST">
        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required>
        <br>
        <label for="nickname">Pseudo :</label>
        <input type="text" id="nickname" name="nickname" required>
        <br>
        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required>
        <br>
        <button type="submit">S'inscrire</button>
    </form>
    <a href="login.php">Déjà inscrit ? Connectez-vous</a>
</body>
</html>
