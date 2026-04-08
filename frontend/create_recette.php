<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once "Template.php";
require_once "rdb/RecettesDB.php";
$db = new RecettesDB();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $photo = $_FILES['image'];
    $recipe_id = $db->createRecette($title, $description, $photo['name']);

    if (!empty($_POST['ingredients'])) {
        foreach ($_POST['ingredients'] as $ingredient_name) {
            $ingredient_id = $db->getIdIngredient($ingredient_name);
            if ($ingredient_id) {
                $db->addIngredientToRecipe($recipe_id, $ingredient_id);
            }
        }
    }

    if (!empty($_POST['tags'])) {
        foreach ($_POST['tags'] as $tag_name) {
            $tag_id = $db->getIdTag($tag_name);
            if ($tag_id) {
                $db->addTagRecipe($recipe_id, $tag_id);
            }
        }
    }
}
?>
<?php ob_start(); ?>
<div class="full-width-image">
    <img src="asset/food4.jpeg" alt="Sunugal">
</div>
<h1>Création des recettes</h1>
<?php $db->generateForm(); ?>
<script src="rdb/Recettes.js"></script>
<?php $content = ob_get_clean(); ?>
<?php Template::render($content); ?>