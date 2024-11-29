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
    <h1>Le Zoo</h1>
  </header>

  <main>
    <div class="biomes-container">
      <?php
        // Connexion à la base de données
        $pdo = new PDO('mysql:host=localhost;dbname=zoo', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Récupérer tous les biomes
        $biomesStmt = $pdo->query("SELECT * FROM biomes");
        while ($biome = $biomesStmt->fetch(PDO::FETCH_ASSOC)) {
          $biomeId = $biome['id'];
          $biomeName = $biome['name'];
          $biomeColor = $biome['color'];

          // Affichage des biomes
          echo "<div class='biome' style='background-color: $biomeColor' data-id='$biomeId'>
                  <h3>$biomeName</h3>
                  <div class='enclosures'>";

          // Récupérer les enclos de chaque biome
          $enclosuresStmt = $pdo->prepare("SELECT * FROM enclosures WHERE id_biomes = ?");
          $enclosuresStmt->execute([$biomeId]);
          while ($enclosure = $enclosuresStmt->fetch(PDO::FETCH_ASSOC)) {
            $enclosureId = $enclosure['id'];

            echo "<div class='enclosure' data-id='$enclosureId'>
                    <h4>Enclos $enclosureId</h4>
                    <div class='animals'>";

            // Récupérer les animaux associés à cet enclos
            $animalsStmt = $pdo->prepare("SELECT animals.name FROM animals 
                                          JOIN relation_enclos_animals ON animals.id = relation_enclos_animals.id_animal
                                          WHERE relation_enclos_animals.id_enclos = ?");
            $animalsStmt->execute([$enclosureId]);
            while ($animal = $animalsStmt->fetch(PDO::FETCH_ASSOC)) {
              $animalName = $animal['name'];
              echo "<p>$animalName</p>";
            }

            echo "</div></div>"; // Fermeture de div animals et enclosure
          }

          echo "</div></div>"; // Fermeture de div enclosures et biome
        }
      ?>
    </div>
  </main>

  <footer>
    <p>Zoo - Tous droits réservés</p>
  </footer>
</body>
</html>
