<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billetterie</title>
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
        <h2>Billetterie en Ligne</h2>
        <form action="#" method="post">
            <button type="submit" name="buy_ticket">Acheter un billet</button>
        </form>
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['buy_ticket'])) {
            if (isset($_SESSION['user_id'])) {
                echo "<p style='color:green;'>Billet acheté</p>";
            } else {
                echo "<p style='color:red;'>Veuillez vous connecter pour acheter un billet.</p>";
            }
        }
        ?>
    </section>

     <!-- Footer -->
    <footer>
        <p>&copy; 2024 Parc Animalier</p>

        <?php
    if (!empty($_SESSION['nickname'])) {
        echo " - Bienvenue, " . htmlspecialchars($_SESSION['nickname']) . "!";
        }
        ?>

        </p>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="logout.php">Se déconnecter</a>
        <?php endif; ?>

    </footer>
</body>
</html>
