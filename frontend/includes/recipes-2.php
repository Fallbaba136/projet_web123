<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>




<?php require "../backend/config/database.php";
require "../backend/models/Recipe.php";?>
<?php require_once "Template.php"; 
use models\Recipe;

/**
 * Ce fichier sert d'API pour récupérer toutes les recettes au format JSON. 
 * Il est appelé par le frontend/index.php pour afficher les recettes sur la page d'accueil.
 * Il peut aussi être utilisé pour le développement et les tests, afin de vérifier que la connexion à la base de données fonctionne et que les données sont correctement récupérées.
 */




//requete SQL
$stmt=$pdo->query("SELECT * FROM recipes");

/**
 * On parcourt les résultats de la requete et on crée un objet Recipe pour chaque ligne.
 * On stocke ces objets dans un tableau associatif $recipes, où la clé est l'id de la recette. 
 * Cela nous permettra de facilement accéder à une recette par son id dans le frontend, par exemple dans le fichier frontend/displayRecipe.php.
 */

//map : id -> objet de Recipe
$recipes=[];

while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
    $recipe=new Recipe(
        $row['id'],
        $row['title'],
        $row['description'],
        $row['photo']
    );
    $recipes[$recipe->id]=$recipe;
}
?>
<?php ob_start(); 

echo json_encode($recipes);

$content=ob_get_clean();
Template::render($content);
?>