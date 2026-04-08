<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Inclure la connexion DB et le modèle
require_once "../backend/config/database.php";
require_once "../backend/models/Recipe.php";

use models\Recipe;

// Requête SQL pour récupérer toutes les recettes
$stmt = $pdo->query("SELECT * FROM recipes");

// Map : id -> objet Recipe
$recipes = [];

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    // Vérification si c'est un dessert ou un plat pour le chemin
   $desserts = ['Thiakiri', 'Beignet Coco', 'Jus Bissap', 'Jus Bouye', 'Pastel'];
    
    if (in_array($row['title'], $desserts)) {
       // Dessert
        $photo_path = "asset/images_recettes/image_dessert/" . $row['photo'];
    } else {
        // Plat
        $photo_path = "asset/images_recettes/image_plat/" . $row['photo'];}

    $recipes[] = [
        'id' => $row['id'],
        'name' => $row['title'],
        'description' => $row['description'],
        'photo' => $photo_path
    ];
}

// Renvoie JSON
header('Content-Type: application/json');
echo json_encode($recipes);

/**
 * Explication du code :
 * 1. On commence par activer l'affichage des erreurs pour faciliter le débogage.
 * 2. Ensuite, on inclut les fichiers nécessaires pour la connexion à la base de données et le modèle de recette.
 * 3. On utilise une requête SQL pour récupérer toutes les recettes de la table "recipes".
 * 4. On parcourt les résultats de la requête et on construit un tableau associatif pour chaque recette, en incluant le chemin complet de la photo.
 * 5. Enfin, on renvoie les données au format JSON pour que le frontend puisse les consommer et les afficher.
 */