<?php

/**
 * Ce fichier sert d'API pour récupérer les détails d'une recette spécifique au format JSON.
 * Il est appelé par le frontend/displayRecipe.
 * php pour afficher les détails d'une recette lorsque l'utilisateur clique sur "Voir la recette" depuis la page d'accueil ou les résultats de recherche.
 * Il prend en paramètre l'id de la recette via la query string (ex: displayRecipe.php?id=1) et retourne un objet JSON contenant les informations de la recette, 
 * ainsi que les ingrédients et les tags associés.
 * Il est également utile pour le développement et les tests, 
 * afin de vérifier que la connexion à la base de données fonctionne et que les données sont correctement récupérées pour une recette spécifique.
 */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require "../backend/config/database.php";
header('Content-Type: application/json');

/**
 * Tout d'abord, on vérifie que l'id de la recette est bien présent dans la query string.
 * Si ce n'est pas le cas, on retourne une erreur JSON et on arrête l'exécution du script. 
 * Ensuite, on récupère les informations de la recette correspondante à l'id fourni en effectuant une requete SQL sur la table recipes. 
 * Si aucune recette n'est trouvée avec cet id, on retourne une erreur JSON et on arrête l'exécution du script.
 */

if (!isset($_GET['id'])) {
    echo json_encode(["error" => "ID manquant"]);
    exit;
}
$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM recipes WHERE id=?");
$stmt->execute([$id]);
$recipe = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$recipe) {
    echo json_encode(["error" => "Recette non trouvée"]);
    exit;
}

/**
 * Ensuite, on récupère les ingrédients et les tags associés à cette recette en effectuant des jointures avec les tables de liaison recipe_ingredient et recipe_tag.
 * On retourne finalement un objet JSON contenant les informations de la recette, 
 * ainsi que les listes d'ingrédients et de tags associés, que le frontend pourra utiliser pour afficher les détails de la recette de manière complète et attrayante.
 */

$stmt = $pdo->prepare("SELECT i.* FROM ingredients i JOIN recipe_ingredient ri ON i.id=ri.ingredient_id WHERE ri.recipe_id=?");
$stmt->execute([$id]);
$ingredients = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare("SELECT t.* FROM tags t JOIN recipe_tag rt ON t.id=rt.tag_id WHERE rt.recipe_id=?");
$stmt->execute([$id]);
$tags = $stmt->fetchAll(PDO::FETCH_ASSOC);

/**
 * Enfin, on encode les données de la recette, des ingrédients et des tags au format JSON et on les retourne au frontend.
 * Le frontend pourra ensuite utiliser ces données pour afficher les détails de la recette de manière complète et attrayante, avec les images, les descriptions, les ingrédients et les tags associés. 
 */

echo json_encode(["recipe" => $recipe, "ingredients" => $ingredients, "tags" => $tags]);