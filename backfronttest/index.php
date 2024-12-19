<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parc Animalier</title>
    <link rel="stylesheet" href="style.css">

</head>
<body>
    <!-- Header avec navigation -->
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

    <!-- Page d'Accueil avec Carrousel d'Images -->
    <section id="index" class="page active">
        <div class="home-content">
            <h2>Découvrez les Merveilles de la Faune</h2>
            <p>Explorez les différents biomes et observez des animaux fascinants dans notre parc animalier.</p>
            <button onclick="window.location.href='biomes.php'">Explorer les Biomes</button>
        </div>
        
        <!-- Carrousel d'Images -->
        <div class="carousel">
            <div class="carousel-images">
                <img src="./enclos1.avif" alt="Animal 1" class="carousel-item active">
                <img src="./enclos2.jpg" alt="Animal 2" class="carousel-item">
                <img src="./enclos3.jpg" alt="Animal 3" class="carousel-item">
            </div>
            <button class="carousel-control prev" onclick="prevImage()">&#10094;</button>
            <button class="carousel-control next" onclick="nextImage()">&#10095;</button>
        </div>
        <div class="welcome-message">
            Bienvenue au Zoo de Amelie et Haron
        </div>
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
<script src="script.js"></script>
</html>
