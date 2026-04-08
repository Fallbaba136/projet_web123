<?php
require "../config/database.php";

$name = $_POST['name'];
$file = $_FILES['image'];
$file_name = $file['name'];

$stmt = $pdo->prepare("INSERT INTO ingredients (name, image) VALUES (?, ?)");
$stmt->execute([$name, $file_name]);
$ingredient_id = $pdo->lastInsertId();

echo json_encode([
    "success" => true,
    "id" => $ingredient_id,
    "name" => $name
]);