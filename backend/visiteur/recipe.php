<?php
$db_name="database/database.sql";
$db_host="localhost";
$db_port="3306";

$db_user="cisse";
$db_pwd="papemamadouCisse6";


// Connexion à la BDD
try{
    // Agrégation des informations de connexion dans une chaine DSN (Data Source Name)
    $dsn = 'mysql:dbname=' . $db_name . ';host='. $db_host. ';port=' . $db_port;

    // Connexion et récupération de l'objet connecté
    $pdo = new PDO($dsn, $db_user, $db_pwd);
}

// Récupération d'une éventuelle erreur
catch (\Exception $ex){
    // Arrêt de l'exécution du script PHP
    die("Erreur : " . $ex->getMessage()) ;
}

// Si pas d'erreur : poursuite de l'exécution
echo "Connexion OK<br>" ;


//recupere les listes de recettes
$stmt="SELECT *FROM recipes";
$statement=$pdo->prepare($stmt);

//execution de la requete
$statement->execute() or die(var_dump($statement->errorInfo()));


//Sous forme d'un tableau d'objet
$results=$statement->fetchAll(PDO::FETCH_OBJ) ;?>

<!DOCTYPE html>
<html>
<head>
    <title>Liste des recettes</title>
</head>
<body>

<h1>Liste des recettes</h1>

<?php foreach($recipes as $recipe): ?>

    <div style="border:1px solid black; margin:10px; padding:10px;">
        
        <h2><?= $recipe['name'] ?></h2>

        <img src="<?= $recipe['photo'] ?>" width="200">

        <br><br>

        <a href="recipe.php?id=<?= $recipe['id'] ?>">
            Voir la recette
        </a>

    </div>

<?php endforeach; ?>

</body>
</html>


