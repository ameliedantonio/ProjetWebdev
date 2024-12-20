<?php
session_start();
include 'db.php'; //connexion à la bdd

$search_result = [];
if (isset($_POST['search'])) {
    $search_term = htmlspecialchars($_POST['search_term']);
    // Requête corrigée avec jointures pour récupérer le biome
    $stmt = $pdo->prepare("
        SELECT animals.name, biomes.name AS biome 
        FROM animals
        JOIN relation_enclos_animals ON animals.id = relation_enclos_animals.id_animal
        JOIN enclosures ON relation_enclos_animals.id_enclos = enclosures.id
        JOIN biomes ON enclosures.id_biomes = biomes.id
        WHERE animals.name LIKE :search_term
    ");
    $stmt->execute(['search_term' => '%' . $search_term . '%']);
    $search_result = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
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
        <h2><br>Nos Biomes et Enclos</h2>
        <h4><br>Repérez où se situent vos animaux préférés au sein de notre parc !</h4>

        <!-- Section ajoutée pour la recherche d'animaux -->
        <section>
            <h2><br>Recherchez d'un animal</h2>
            <form method="POST" action="">
                <input type="text" name="search_term" placeholder="Entrez le nom d'un animal" required>
                <button type="submit" name="search">Rechercher</button>
            </form>
            <?php if (!empty($search_result)): ?>
                <h3>Résultats de la recherche :</h3>
                <ul>
                    <?php foreach ($search_result as $animal): ?>
                        <li><?= htmlspecialchars($animal['name']) ?> (<?= htmlspecialchars($animal['biome']) ?>)</li>
                    <?php endforeach; ?>
                </ul>
            <?php elseif (isset($_POST['search'])): ?>
                <p>Aucun animal trouvé.</p>
            <?php endif; ?>
        </section>

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

        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="logout.php">Se déconnecter</a>
        <?php endif; ?>

        <p>&copy; 2024 Parc Animalier</p>
    </footer>

</body>
</html>
