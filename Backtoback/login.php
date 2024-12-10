<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdo = new PDO('mysql:host=localhost;dbname=zoo', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE mail = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['nickname'] = $user['nickname'];
        header('Location: index.php');
        exit;
    } else {
        $error = "Email ou mot de passe incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="style.css">
  <script src="script.js" defer></script>
</head>
<body>
    <header>
        <h1>Connexion / Inscription</h1>
    </header>
<nav>
        <a href="index.php" class="active">Accueil</a>
        <a href="biomes.php">Biomes</a>
        <a href="services.php">Services</a>
        <a href="login.php">Connexion</a>
    </nav>

    <h1>Connexion</h1>
    <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="POST">
        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required>
        <br>
        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required>
        <br>
        <button type="submit">Se connecter</button>
    </form>
    <a href="register.php">Pas encore inscrit ? Inscrivez-vous</a>

    <h1>Le Zoo</h1>
    <?php if (isset($_SESSION['user_id'])): ?>
            <p>Bienvenue, <?php echo htmlspecialchars($_SESSION['nickname']); ?> !</p>
            <a href="logout.php">Se déconnecter</a>
        <?php else: ?>
            <a href="login.php">Se connecter</a>
            <a href="register.php">S'inscrire</a>
        <?php endif; ?>

</body>
</html>
