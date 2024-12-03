<?php
include 'db.php';

// Récupérer tous les biomes
function getBiomes() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM biomes");
    return $stmt->fetchAll();
}

// Récupérer tous les enclos d'un biome spécifique
function getEnclosures($biomeId) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM enclosures WHERE id_biomes = ?");
    $stmt->execute([$biomeId]);
    return $stmt->fetchAll();
}

// Récupérer tous les animaux d'un enclos spécifique
function getAnimalsInEnclosure($enclosureId) {
    global $pdo;
    $stmt = $pdo->prepare("
        SELECT a.name FROM animals a
        JOIN relation_enclos_animals r ON r.id_animal = a.id
        WHERE r.id_enclos = ?
    ");
    $stmt->execute([$enclosureId]);
    return $stmt->fetchAll();
}

// Fonction pour envoyer les données au frontend
if (isset($_GET['biomes'])) {
    // Récupérer les biomes
    echo json_encode(getBiomes());
} elseif (isset($_GET['biomeId'])) {
    // Récupérer les enclos d'un biome
    echo json_encode(getEnclosures($_GET['biomeId']));
} elseif (isset($_GET['enclosureId'])) {
    // Récupérer les animaux d'un enclos
    echo json_encode(getAnimalsInEnclosure($_GET['enclosureId']));
} else {
    echo json_encode(["error" => "Aucune donnée disponible"]);
}
?>
