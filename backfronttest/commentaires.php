<?php
// Démarrage de la session
session_start();

// Chemin du fichier pour stocker les commentaires
$filePath = 'commentaires.txt';

// Si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $comment = htmlspecialchars($_POST['comment']);
    $rating = intval($_POST['rating']);
    $username = $_SESSION['username'] ?? 'Anonyme';

    if (!empty($comment) && $rating >= 1 && $rating <= 5) {
        // Format du commentaire à enregistrer
        $data = [
            'username' => $username,
            'comment' => $comment,
            'rating' => $rating,
            'date' => date('Y-m-d H:i:s'),
        ];

        // Enregistrement du commentaire dans le fichier
        file_put_contents($filePath, json_encode($data) . PHP_EOL, FILE_APPEND);
        $_SESSION['message'] = "Votre commentaire a été ajouté avec succès !";
        header('Location: commentaires.php');
        exit;
    } else {
        $_SESSION['message'] = "Veuillez remplir tous les champs correctement.";
    }
}

// Lecture des commentaires existants
$comments = [];
if (file_exists($filePath)) {
    $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $comments[] = json_decode($line, true);
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laisser un Commentaire</title>
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
                <li><a href="commentaires.php">Commentaires</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <?php if (isset($_SESSION['message'])): ?>
            <p class="message"><?= htmlspecialchars($_SESSION['message']); ?></p>
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>

        <form action="commentaires.php" method="POST">
            <label for="comment">Votre commentaire :</label><br>
            <textarea name="comment" id="comment" rows="5" required></textarea><br>
            <label for="rating">Votre note sur 5 :</label><br>
            <select name="rating" id="rating" required>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select><br><br>
            <button type="submit">Envoyer</button>
        </form>

        <h2>Commentaires des visiteurs :</h2>
        <?php if (!empty($comments)): ?>
            <?php foreach ($comments as $comment): ?>
                <div class="comment">
                    <h3><?= htmlspecialchars($comment['username']); ?> (Note : <?= $comment['rating']; ?>/5)</h3>
                    <p><?= htmlspecialchars($comment['comment']); ?></p>
                    <small>Posté le : <?= $comment['date']; ?></small>
                </div>
                <hr>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucun commentaire pour l'instant. Soyez le premier à en laisser un !</p>
        <?php endif; ?>
    </main>

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
