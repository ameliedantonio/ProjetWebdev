<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Zoo</title>
  <link rel="stylesheet" href="style.css">
  <script src="script.js" defer></script>
</head>
<body>
  <header>
        <h1>Le ZOO</h1>
  </header>
  <nav>
        <a href="index.php" class="active">Accueil</a>
        <a href="biomes.php">Biomes</a>
        <a href="services.php">Services</a>
        <a href="login.php">Connexion</a>
    </nav>

  <main>
  <section>
            <h2>Découvrez nos animaux et biomes</h2>
            <p>Explorez les différents environnements et services que nous proposons.</p>
        </section>

  <div class="carousel">
    <img src="enclos1.avif" alt="Slide 1" class="active">
    <img src="enclos2.jpg" alt="Slide 2">
    <img src="enclos3.jpg" alt="Slide 3">
  </div>
  <h3> Amelie et Haron ZOO </h3> 
  </main>

  <footer>
    <p>Zoo - Tous droits réservés</p>
  </footer>
</body>
</html>
