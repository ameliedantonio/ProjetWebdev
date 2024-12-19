<?php
session_start();
include 'db.php'; //connexion a la bdd
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biomes</title>
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
        <h2>Nos Biomes et Enclos</h2>
        <div class="biomes-container">
            <?php
            $biomesStmt = $pdo->query("SELECT * FROM biomes");
            while ($biome = $biomesStmt->fetch(PDO::FETCH_ASSOC)) {
                $biomeId = $biome['id'];
                $biomeName = $biome['name'];
                $biomeColor = $biome['color'];

                echo "<div class='biome' style='background-color: $biomeColor' data-id='$biomeId'>
                        <h3>$biomeName</h3>
                        <div class='enclosures'>";

                $enclosuresStmt = $pdo->prepare("SELECT * FROM enclosures WHERE id_biomes = ?");
                $enclosuresStmt->execute([$biomeId]);
                while ($enclosure = $enclosuresStmt->fetch(PDO::FETCH_ASSOC)) {
                    $enclosureId = $enclosure['id'];

                    echo "<div class='enclosure' data-id='$enclosureId'>
                            <h4>Enclos $enclosureId</h4>
                            <div class='animals'>";

                    $animalsStmt = $pdo->prepare("SELECT animals.name FROM animals 
                                                  JOIN relation_enclos_animals ON animals.id = relation_enclos_animals.id_animal
                                                  WHERE relation_enclos_animals.id_enclos = ?");
                    $animalsStmt->execute([$enclosureId]);
                    while ($animal = $animalsStmt->fetch(PDO::FETCH_ASSOC)) {
                        $animalName = $animal['name'];
                        echo "<p>$animalName</p>";
                    }

                    echo "</div></div>";
                }

                echo "</div></div>";
            }
            ?>
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
