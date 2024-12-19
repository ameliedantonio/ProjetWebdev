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
                <img src="./photos/bergerie/iguane.jpg" alt="Animal 1" class="carousel-item active">
                <img src="./photos/bergerie/python.jpg" alt="Animal 2" class="carousel-item">
                <img src="./photos/belvedere/coati.jpg" alt="Animal 3" class="carousel-item">
                <img src="./photos/belvedere/saimiri.jpg" alt="Animal 4" class="carousel-item">
                <img src="./photos/bois/daim.jpg" alt="Animal 5" class="carousel-item">
                <img src="./photos/clairieres/tamanoir.jpg" alt="Animal 6" class="carousel-item">
                <img src="./photos/clairieres/tigre.jpg" alt="Animal 7" class="carousel-item">
                <img src="./photos/clairieres/porc_epic.jpg" alt="Animal 8" class="carousel-item">
                <img src="./photos/clairieres/mouton_noir.jpg" alt="Animal 9" class="carousel-item">
                <img src="./photos/plateau/cercopitheque.jpg" alt="Animal 10" class="carousel-item">
                <img src="./photos/plateau/grivet.jpg" alt="Animal 11" class="carousel-item">
                <img src="./photos/plateau/lion.jpg" alt="Animal 12" class="carousel-item">
                <img src="./photos/plateau/ouistiti.jpg" alt="Animal 13" class="carousel-item">
                <img src="./photos/vallon/oiseau.jpg" alt="Animal 14" class="carousel-item">
                <img src="./photos/vallon/loutre.jpg" alt="Animal 15" class="carousel-item">
                <img src="./photos/vallon/panda_roux.jpg" alt="Animal 16" class="carousel-item">
                <img src="./photos/vallon/grand_hocco.jpg" alt="Animal 17" class="carousel-item">
                <img src="./photos/vallon/chevre_naine.jpg" alt="Animal 18" class="carousel-item">
                <img src="./photos/vallon/binturong.jpg" alt="Animal 19" class="carousel-item">

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
<script src="script.js"></script>
</html>
