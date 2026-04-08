<?php 

class RecettesDB{

    private $db_name,$db_host,$db_port,$pdo,$dsn,$db_user,$db_pwd;//les variables concernant le base de donnes 

    

   public function __construct(){
    try{//connexion à la BDD
    $this->db_name="recipe_db" ;$this->db_host="127.0.0.1" ;$this->db_port="3306";
    $this->db_user="root"; $this->db_pwd="Bbff2030";
    $this->dsn='mysql:dbname='.$this->db_name.';host='.$this->db_host.';port='.$this->db_port;
    $this->pdo=new PDO($this->dsn,$this->db_user,$this->db_pwd);



    }catch(\Exception $ex){
        die("Erreur : ".$ex->getMessage());

    }
   }


   //cette methode vas ajouter  des recettes dans notre table de recette  de notre base de  donnes 

   public function createRecette($title,$description,$photo){

    $query="INSERT INTO recipes(title,description,photo) VALUES (:nom,:desc,:photo)";//la requete qu'on a besoin 

    //preparation d'une requete 
    $statement=($this->pdo)->prepare($query);


    //Liason des paramétres 
    $statement->bindValue(":nom",$title);
    $statement->bindValue(":desc",$description);
    $statement->bindValue(":photo",$photo);


    //execution du requete 
    $statement->execute() or die(var_dump($statement->errorInfo()));

    //maintenant on effectue un upload dans le dossieruploads

    $file=$_FILES['image'];

    if($file['error']==0){// s il n'ya pas d'erreur

        // Pour sauvegarder le fichier uploadé, il faut faire une 'copie'
       // du fichier temporaire reçu dans un dossier local.

       //nom du fichiert temporarire
       $temp_file_name=$file['tmp_name'];

       //nom du fichier sauvegarder

       $file_name=$file['name'];

      // Nom (arbitraire) du dossier où l'on enregistre la sauvegarde :
       $dir_name="asset/images_recettes/image_plat/";

        // Vérification d'existence (et éventuelle création) du dossier cible
       if(!is_dir($dir_name)) mkdir($dir_name);

        // Enregistrement du fichier dans le serveur :

        $full_name=$dir_name.$file_name;

        //Enregistrement du fichier dans le serveur : 
       if (move_uploaded_file($temp_file_name, $full_name)) {
           echo "Upload réussi";
       } 
       else {
           echo "Erreur lors de l'upload";
       }


    }else{
        
        die ("yo on a pas reussit a upolader le  fichier");
    }

    return $this->pdo->lastInsertId();

   }




  //cette fonction vas ajouter des ingredients dans la table ingredient de notre base de donnes 

  public function createIngredient($name, $image){

    $file = $_FILES['image'];

    if($file['error'] == 0){

        $temp_file_name = $file['tmp_name'];
        $file_name = $file['name'];

        $dir_name = "asset/images_recettes/image_ingredient/";
        if(!is_dir($dir_name)) mkdir($dir_name);

        $full_name = $dir_name . $file_name;

    
        if(!move_uploaded_file($temp_file_name, $full_name)){
            die("Erreur upload");
        }

    } else {
        die("Erreur fichier");
    }

    // ✅ insertion APRÈS upload
    $query="INSERT INTO ingredients(name,image) VALUES (:nom,:image)";
    $statement=$this->pdo->prepare($query);

    $statement->bindValue(":nom",$name);
    $statement->bindValue(":image",$file_name);

    $statement->execute() or die(var_dump($statement->errorInfo()));

    return $this->pdo->lastInsertId();
}

   //cette function permet d'obtenir le id d'un ingredient 


   public function getIdIngredient($ingredient_name){

    $stmt = $this->pdo->prepare("SELECT id FROM ingredients WHERE name = :name");
    $stmt->bindValue(':name', $ingredient_name);
    $stmt->execute();
    return $stmt->fetchColumn();
   }

   //cette methode permet de recuperer tous les ingredients 
   public function getAllIngredients(){

    $query = "SELECT id, name FROM ingredients";

    $stmt = $this->pdo->prepare($query);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }  


   //cette function ajoute des tags dans notre table tag

   public function createTag($name){

    $query="INSERT INTO tags(name) VALUES (:nom)";//la requête qu'on a  besoin 

    //preparation du requête 
    $statement=$this->pdo->prepare($query);

    //liason des paramétres 
    $statement->bindValue(":nom",$name);


    //execution du requête 
    $statement->execute() or die(var_dump($statement->errorInfo()));

    return $this->pdo->lastInsertId(); // id du recette 


   }


   //cette function permet de recuperer id d'un tag 

   public function getIdTag($name){

    $query = "SELECT id FROM tags WHERE name = :name";
    $stmt = $this->pdo->prepare($query);

    $stmt->bindValue(":name", $name);
    $stmt->execute();

    return $stmt->fetchColumn();
  }


   //cette function permet recuperer tous les tags 
   public function getAllTags(){

    $query = "SELECT id, name FROM tags";
    $stmt = $this->pdo->prepare($query);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
   } 


   //cette fonction permet d'ajouter des recettes et des ingrédients dans notre notre table de liaison entre recettes et ingredients 

   public function addIngredientToRecipe($recipe_id,$ingredient_id){
    
     $query="INSERT INTO recipe_ingredient(recipe_id,ingredient_id)   VALUES(:recipe_id,:ingredient_id)"; //la requete 

     $statement=$this->pdo->prepare($query); //la preparation du requête 

     //liason des paramétres 

     $statement->bindValue(":recipe_id",$recipe_id);
     $statement->bindValue(":ingredient_id",$ingredient_id);

     //execution de  la requête 

     $statement->execute() or  die(var_dump($statement->errorInfo()));


    
   }


   //cette function permet d'inserer des tags et des recettes dans notre table de liaison entre tags et recettes 

   public function addTagRecipe($recipe_id,$tag_id){

    //notre requête
    $query="INSERT INTO recipe_tag(recipe_id,tag_id) VALUES (:recipe_id,:tag_id)";

    //preparation du requête 

    $statement=$this->pdo->prepare($query);

    //liason des paramétres 
    $statement->bindValue(":recipe_id",$recipe_id);
    $statement->bindValue(":tag_id",$tag_id);

    //execution de la requête 
    $statement->execute() or die(var_dump($statement->errorInfo()));
   }


   


   //cette methode permet de generer un formulaire d'ont l'admin vas utiliser pour creer une recette
  public function generateForm(){
     $ingredients = $this->getAllIngredients();
     $tags = $this->getAllTags();

    ?>

    <form method="POST" enctype="multipart/form-data">
    <input type="text" name="title" placeholder="Titre" required>
    <textarea name="description" placeholder="Description" required></textarea>
    <input type="file" name="image" required>

    <h3>Ingrédients</h3>
    <div id="ingredients-container">
        <div class="ingredient-item">
            <input list="ingredients-list" name="ingredients[]" placeholder="Choisir ingrédient">
            <button type="button" onclick="removeIngredient(this)">❌</button>
        </div>
    </div>

    <datalist id="ingredients-list">
        <?php foreach($ingredients as $ing): ?>
            <option value="<?= htmlspecialchars($ing['name']) ?>">
        <?php endforeach; ?>
    </datalist>

    <button type="button" onclick="addIngredient()">+ Ajouter</button>
    <button type="button" onclick="openModal()">+ Nouvel ingrédient</button>


    <h3>Tags</h3>

<div id="tags-container">
    <div class="tag-item">
        <input list="tags-list" name="tags[]" placeholder="Choisir tag">
        <button type="button" onclick="removeTag(this)">❌</button>
    </div>
</div>

<datalist id="tags-list">
    <?php foreach($tags as $tag): ?>
        <option value="<?= htmlspecialchars($tag['name']) ?>">
    <?php endforeach; ?>
</datalist>

<button type="button" onclick="addTag()">+ Ajouter Tag</button>
<button type="button" onclick="openTagModal()">+ Nouveau tag</button>



<button type="submit">Créer recette</button>

    

  
</form>


 <div id="modal" style="display:none; position:fixed; top:20%; left:35%; background:white; padding:20px; border:1px solid black;">
    <h3>Nouvel ingrédient</h3>

    <input type="text" id="newIngredientName" placeholder="Nom">
    <input type="file" id="newIngredientImage">

    <button onclick="saveIngredient()">Ajouter</button>
    <button onclick="closeModal()">Fermer</button>
</div>


<div id="tagModal" style="display:none; position:fixed; top:20%; left:35%; background:white; padding:20px; border:1px solid black;">
    
    <h3>Nouveau tag</h3>

    <input type="text" id="newTagName" placeholder="Nom du tag">

    <button onclick="saveTag()">Ajouter</button>
    <button onclick="closeTagModal()">Fermer</button>

</div>

    


<?php }


}