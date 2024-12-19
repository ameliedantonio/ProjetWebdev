<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services</title>
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
        <h2><br>Services du Parc</h2>
        <ul>
            <li>Toilettes</li>
            <li>Points d'eau</li>
            <li>Boutique</li>
            <li>Gare</li>
            <li>Trajet train</li>
            <li>Lodge</li>
            <li>Tente pédagogique</li>
            <li>Paillote</li>
            <li>Café Nomade</li>
            <li>Petit Café</li>
            <li>Plateau de jeux</li>
            <li>Espace Pique-Nique</li>
            <li>Point de vue</li><br>
        </ul>
        <h3>Horaires d'ouverture du Parc</h3>
        <ul>
            <li>9h - 17h du mardi au vendredi</li>
            <li>8h - 20h du samedi au dimanche, vacances et jours fériés</li><br>
        </ul>
        
        <h3>Plan du Parc</h3>
        
        <img src="./photos/map.png" alt="map" class="map-services" style="width: 1200px; height: auto;">

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