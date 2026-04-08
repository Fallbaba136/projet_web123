<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require "../backend/config/database.php";
header('Content-Type: application/json');

$title = $_GET['title'] ?? '';
$ingredient = $_GET['ingredient'] ?? '';
$tag = $_GET['tag'] ?? '';

$query = $title ?: $ingredient ?: $tag;

$results = [];

// Recherche par titre
$stmt = $pdo->prepare("SELECT * FROM recipes WHERE title LIKE ?");
$stmt->execute(["%$query%"]);
$results = array_merge($results, $stmt->fetchAll(PDO::FETCH_ASSOC));

// Recherche par ingrédient
$stmt = $pdo->prepare("
    SELECT DISTINCT r.* FROM recipes r
    JOIN recipe_ingredient ri ON r.id = ri.recipe_id
    JOIN ingredients i ON i.id = ri.ingredient_id
    WHERE i.name LIKE ?
");
$stmt->execute(["%$query%"]);
$results = array_merge($results, $stmt->fetchAll(PDO::FETCH_ASSOC));

// Recherche par tag
$stmt = $pdo->prepare("
    SELECT DISTINCT r.* FROM recipes r
    JOIN recipe_tag rt ON r.id = rt.recipe_id
    JOIN tags t ON t.id = rt.tag_id
    WHERE t.name LIKE ?
");
$stmt->execute(["%$query%"]);
$results = array_merge($results, $stmt->fetchAll(PDO::FETCH_ASSOC));

// Supprimer les doublons par id
$unique = [];
$ids = [];
foreach ($results as $r) {
    if (!in_array($r['id'], $ids)) {
        $unique[] = $r;
        $ids[] = $r['id'];
    }
}

echo json_encode($unique);