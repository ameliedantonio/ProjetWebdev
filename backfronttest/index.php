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
                <li><a href="#home"> Accueil</a></li>
                <li><a href="#biomes">Biomes</a></li>
                <li><a href="#services">Services</a></li>
                <li><a href="#tickets">Billetterie</a></li>
                <li><a href="#auth">Connexion</a></li>
            </ul>
        </nav>
    </header>

    <!-- Page d'Accueil avec Carrousel d'Images -->
    <section id="home" class="page active">
        <div class="home-content">
            <h2>Découvrez les Merveilles de la Faune</h2>
            <p>Explorez les différents biomes et observez des animaux fascinants dans notre parc animalier.</p>
            <button onclick="showSection('biomes')">Explorer les Biomes</button>   
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

    <!-- Section Biomes -->
<section id="biomes" class="page">
    <h2>Nos Biomes et Enclos</h2>
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
</section>

    

    <!-- Section Services -->
    <section id="services" class="page">
        <h2>Services du Parc</h2>
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
            <li>Point de vue</li>
        </ul>
    </section>

    <!-- Section Billetterie -->
    <section id="tickets" class="page">
    <h2>Billetterie en Ligne</h2>
    <p>Achetez vos billets pour le parc.</p>
    <form action="#tickets" method="post">
        <button type="submit" name="buy_ticket">Acheter un billet</button>
    </form>
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['buy_ticket'])) {
        if (isset($_SESSION['user_id'])) {
            echo "<p style='color:green;'>Billet acheté</p>";
        } else {
            // Redirige vers la section #auth sans recharger la page
            header('Location: index.php#auth');
        }
    }
    ?>
    </section>

    <!-- Section Connexion / Inscription -->
    <section id="auth" class="page">
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