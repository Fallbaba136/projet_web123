<?php
require "../config/database.php";

$name = $_POST['name'];

if ($name) {
    $stmt = $pdo->prepare("INSERT INTO tags (name) VALUES (?)");
    $stmt->execute([$name]);
    $tag_id = $pdo->lastInsertId();

    echo json_encode([
        "success" => true,
        "id" => $tag_id,
        "name" => $name
    ]);
} else {
    echo json_encode(["success" => false]);
}