<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Parc Animalier</h1>
        <nav>
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="biomes.php">Biomes</a></li>
                <li><a href="services.php">Services</a></li>
                <li><a href="billet.php">Billetterie</a></li>
                <li><a href="auth.php">Connexion</a></li>
            </ul>
        </nav>
    </header>

    <section>
        <div class="auth-container">
        <div class="login">
                <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
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
                        session_write_close();
                        header('Location: index.php');
                        exit;
                    } else {
                        $error = "Email ou mot de passe incorrect.";
                    }
                }
                ?>
                <h2>Connexion</h2>
                <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
                <form action="#auth" method="post">
                    <input type="hidden" name="login" value="1">
                    <label for="email">Email :</label>
                    <input type="email" id="email" name="email" required>
                    <label for="password">Mot de passe :</label>
                    <input type="password" id="password" name="password" required>
                    <button type="submit">Se connecter</button>
                </form>
            </div>

            <div class="register">
                <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
                    $pdo = new PDO('mysql:host=localhost;dbname=zoo', 'root', '');
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    $email = trim($_POST['email']);
                    $nickname = trim($_POST['nickname']);
                    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

                    $stmt = $pdo->prepare("INSERT INTO users (mail, nickname, password) VALUES (?, ?, ?)");
                    $stmt->execute([$email, $nickname, $password]);

                    $_SESSION['user_id'] = $pdo->lastInsertId();
                    $_SESSION['nickname'] = $nickname;
                    header('Location: index.php');
                    exit;
                }
                ?>
                <h2>Inscription</h2>
                <form action="#auth" method="post">
                    <input type="hidden" name="register" value="1">
                    <label for="nickname">Nom d'utilisateur :</label>
                    <input type="text" id="nickname" name="nickname" required>
                    <label for="email">Email :</label>
                    <input type="email" id="email" name="email" required>
                    <label for="password">Mot de passe :</label>
                    <input type="password" id="password" name="password" required>
                    <button type="submit">S'inscrire</button>
                </form>
            </div>
        </div>
    </section>

     <!-- Footer -->
    <footer>
        
        <?php
    if (!empty($_SESSION['nickname'])) {
        echo " Bienvenue " . htmlspecialchars($_SESSION['nickname']) . " !";
        }
        ?>

        </p>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="logout.php">Se déconnecter</a>
        <?php endif; ?>

        <p>&copy; 2024 Parc Animalier</p>
    </footer>
</body>
</html>
