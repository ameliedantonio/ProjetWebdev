<?php
session_start();

// Génération d'un token CSRF si absent
define('CSRF_TOKEN_LENGTH', 32);
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(CSRF_TOKEN_LENGTH));
}
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

        <?php if (isset($_SESSION['user_id'])): ?>
            <form action="#" method="post">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                <label for="ticket_type">Choisissez un billet :</label>
                <select name="ticket_type" id="ticket_type" required>
                    <option value="" disabled selected>-- Sélectionnez un type de billet --</option>
                    <option value="enfant">Billet 1 journée Enfant (0-18 ans) - 10€</option>
                    <option value="etudiant_senior">Billet 1 journée Étudiant/Senior (18-26 ans ou > 65 ans) - 15€</option>
                    <option value="adulte">Billet 1 journée Adulte - 20€</option>
                </select>
                <button type="submit" name="buy_ticket">Acheter un billet</button>
            </form>
            <p>Pour les prix de groupe, veuillez contacter l'établissement au <strong>0601020304</strong>.</p>
        <?php else: ?>
            <p>Veuillez <a href="auth.php">vous connecter</a> pour acheter un billet.</p>
        <?php endif; ?>

        <?php
        function displayMessage($message, $type = 'info') {
            $color = ($type === 'success') ? 'green' : (($type === 'error') ? 'red' : 'black');
            echo "<p style='color:{$color};'>{$message}</p>";
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['buy_ticket'])) {
            // Vérification du token CSRF
            if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
                displayMessage("Échec de validation CSRF.", 'error');
                exit;
            }

            if (isset($_SESSION['user_id'])) {
                $ticketType = htmlspecialchars($_POST['ticket_type']);
                switch ($ticketType) {
                    case 'enfant':
                        displayMessage("Billet enfant acheté pour 10€ envoyé par mail", 'success');
                        break;
                    case 'etudiant_senior':
                        displayMessage("Billet étudiant/senior acheté pour 15€ sur présentation d'un justificatif, envoyé par mail", 'success');
                        break;
                    case 'adulte':
                        displayMessage("Billet adulte acheté pour 20€, envoyé par mail", 'success');
                        break;
                    default:
                        displayMessage("Type de billet invalide.", 'error');
                        break;
                }
            } else {
                displayMessage("Veuillez vous connecter pour acheter un billet.", 'error');
            }
        }
        ?>

    <img src="./photos/singe3.png" alt="map" class="map-services" style="width: 500px; height: auto;">
    </section>

    <!-- Footer -->
    <footer>
        <?php if (!empty($_SESSION['nickname'])): ?>
            <p> Bienvenue <?= htmlspecialchars($_SESSION['nickname']); ?> !</p>
        <?php endif; ?>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="logout.php">Se déconnecter</a>
        <?php endif; ?>

        <p>&copy; 2024 Parc Animalier</p>
    </footer>
</body>
</html>
