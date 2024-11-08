<?php
include 'config.php';

function getBiomes() {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM biomes");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

header("Content-Type: application/json");
echo json_encode(getBiomes());
?>
